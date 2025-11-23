<?php
// Habilitar exibição de erros para debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verificar se o arquivo de conexão existe
$conexao_path = __DIR__ . '/inc/conexao.php';
if (!file_exists($conexao_path)) {
  die("Erro: Arquivo de conexão não encontrado em: " . $conexao_path);
}

// include conexão centralizada
include $conexao_path;

// proteção: só acessa se logado e role adequada
if (!isset($_SESSION['usuario_id'])) {
  header('Location: login.php');
  exit;
}

// opcional: verificação de role
$allowed_roles = ['policia', 'admin', 'operador'];
if (!in_array($_SESSION['usuario_role'], $allowed_roles)) {
  echo "Acesso negado";
  exit;
}

// busca denúncias (paginável)
try {
  $statusFiltro = $_GET['status'] ?? '';

  // Verifica se a conexão está ativa
  if (!isset($conn) || $conn === null) {
    throw new Exception('Erro: conexão ao banco indisponível');
  }

  // Verifica se a tabela existe
  $checkTable = $conn->query("SHOW TABLES LIKE 'denuncias'");
  if ($checkTable->num_rows === 0) {
    throw new Exception('Erro: tabela denuncias não encontrada');
  }

  // Verifica a estrutura da tabela
  $checkColumns = $conn->query("SHOW COLUMNS FROM denuncias");
  $columns = [];
  while ($col = $checkColumns->fetch_assoc()) {
    $columns[] = $col['Field'];
  }

  // Construir query baseada nas colunas existentes
  $selectColumns = ['id', 'protocolo', 'cidade', 'tipo_crime'];
  if (in_array('status', $columns)) $selectColumns[] = 'status';
  if (in_array('data_envio', $columns)) $selectColumns[] = 'data_envio';

  $sql = "SELECT " . implode(', ', $selectColumns) . " FROM denuncias";

  if ($statusFiltro && in_array('status', $columns)) {
    $sql .= " WHERE status = ?";
  }

  if (in_array('data_envio', $columns)) {
    $sql .= " ORDER BY data_envio DESC";
  }

  $sql .= " LIMIT 200";

  $stmt = $conn->prepare($sql);
  if ($stmt === false) {
    throw new Exception('Erro na preparação da query: ' . $conn->error);
  }

  if ($statusFiltro && in_array('status', $columns)) {
    $stmt->bind_param("s", $statusFiltro);
  }

  if (!$stmt->execute()) {
    throw new Exception('Erro ao executar a query: ' . $stmt->error);
  }

  $res = $stmt->get_result();
} catch (Exception $e) {
  die('Erro: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Denúncias</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">

  <style>
    /* garantir que o texto do botão 'Voltar' apareça preto por padrão */
    .denunciar .btn-denunciar {
      color: #000 !important;
      transition: 0.3s ease;
    }

    .denunciar .btn-denunciar:hover {
      color: #fff !important;
    }

    /* Painel principal semelhante ao protótipo (rosa claro) */
    .dashboard-container {
      /* garantir espaço suficiente abaixo do header (caso o header seja fixed) */
      padding: calc(var(--header-height, 80px) + 12px) 16px 22px 16px;
      max-width: 1200px;
      margin: 20px auto;
      box-sizing: border-box;
    }

    .panel-pink {
      background: #fde8e8;
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
      margin-bottom: 20px;
    }

    .panel-title {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      margin-bottom: 12px;
    }

    .panel-title h1 {
      margin: 0;
      font-size: 26px;
      text-align: left;
      flex: 1;
    }

    /* Tabela com bordas arredondadas e cabeçalho destacado */
    .table-main {
      background: transparent;
      border-radius: 12px;
      overflow: hidden;
    }

    .table-main table {
      border-collapse: separate;
      border-spacing: 0;
      width: 100%;
      background: transparent;
    }

    .table-main thead th {
      background: rgba(0, 0, 0, 0.04);
      font-weight: 800;
      color: #2b2b2b;
      padding: 14px 12px;
      text-transform: uppercase;
      letter-spacing: 1px;
      border-bottom: none;
      font-size: 12px;
    }

    .table-main tbody td {
      background: rgba(255, 255, 255, 0.35);
      padding: 12px 10px;
      vertical-align: middle;
      border-top: 1px solid rgba(0, 0, 0, 0.03);
      font-size: 14px;
    }

    .table-main tbody tr:first-child td:first-child {
      border-top-left-radius: 10px;
    }

    .table-main tbody tr:first-child td:last-child {
      border-top-right-radius: 10px;
    }

    /* Estilos de badge (reaproveitar do consulta) */
    .badge-resolvido {
      background: #2ecc71;
      color: #fff;
      padding: 6px 10px;
      border-radius: 999px;
      font-weight: 700;
    }

    .badge-em-andamento {
      background: #f1c40f;
      color: #111;
      padding: 6px 10px;
      border-radius: 999px;
      font-weight: 700;
    }

    .badge-recebido {
      background: #3498db;
      color: #fff;
      padding: 6px 10px;
      border-radius: 999px;
      font-weight: 700;
    }

    .badge-rejeitado {
      background: #e74c3c;
      color: #fff;
      padding: 6px 10px;
      border-radius: 999px;
      font-weight: 700;
    }

    /* Botões personalizados */
    .btn-action {
      background: #caa0f7;
      color: #fff;
      border-radius: 12px;
      padding: 6px 12px;
      border: none;
      text-decoration: none;
      display: inline-block;
      font-weight: 700;
    }

    /* ===== Responsividade refinada ===== */
    /* Tablet */
    @media (max-width: 992px) {
      .panel-title h1 {
        font-size: 20px;
      }

      .dashboard-container {
        padding: 18px 14px;
      }

      .table-main thead th,
      .table-main tbody td {
        padding: 10px 8px;
      }
    }

    /* Mobile landscape and small tablets */
    @media (max-width: 768px) {
      .panel-title {
        flex-direction: column;
        align-items: stretch;
        gap: 8px;
      }

      .panel-title h1 {
        text-align: left;
        font-size: 18px;
      }

      .panel-title form {
        width: 100%;
      }

      .panel-title .form-select {
        width: 100%;
      }

      .dashboard-container {
        padding: calc(var(--header-height, 80px) + 8px) 12px 12px 12px;
        margin: 10px auto;
      }

      .table-main thead {
        display: none;
      }

      /* escondemos cabeçalho para layout de linhas empilhadas */
      .table-main tbody tr {
        display: block;
        margin-bottom: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        border-radius: 10px;
        overflow: hidden;
      }

      .table-main tbody td {
        display: flex;
        justify-content: space-between;
        padding: 12px;
        border-top: none;
      }

      .table-main tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #333;
        margin-right: 8px;
      }

      .table-main tbody td>.badge-resolvido,
      .table-main tbody td>.badge-em-andamento,
      .table-main tbody td>.badge-recebido,
      .table-main tbody td>.badge-rejeitado {
        white-space: nowrap;
      }

      .btn-action {
        width: 100%;
        display: block;
        text-align: center;
      }
    }

    /* Small mobile */
    @media (max-width: 420px) {
      .panel-title h1 {
        font-size: 16px;
      }

      .dashboard-container {
        padding: calc(var(--header-height, 80px) + 16px) 8px 10px 8px;
      }

      h2{
        font-size: 18px;
      }
      header .usuario-logado {
        display: none;
      }

      /* simplificar header em telas muito pequenas */
      .denunciar {
        margin-right: 8px;
      }

      .table-main tbody td {
        font-size: 13px;
        padding: 10px;
      }
    }
  </style>
</head>

<body>
  <?php include __DIR__ . '/inc/header.php'; ?>
  <div class="dashboard-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Painel de Denúncias</h2>
      <div>
        <span class="me-3">Logado como: <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong></span>
        <a href="logout.php" class="btn btn-outline-danger">Sair</a>
      </div>
    </div>

    <div class="panel-pink">
      <div class="panel-title">
        <h1>Tabela de Denúncias</h1>
        <div style="min-width:220px; text-align:right;">
          <!-- filtro à direita do título -->
          <form method="get" class="d-flex align-items-center gap-2 justify-content-end">
            <label class="form-label mb-0 me-2">Filtrar:</label>
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="">-- Todos --</option>
              <option value="recebido" <?= $statusFiltro == 'recebido' ? 'selected' : '' ?>>Recebido</option>
              <option value="em andamento" <?= $statusFiltro == 'em andamento' ? 'selected' : '' ?>>Em andamento</option>
              <option value="resolvido" <?= $statusFiltro == 'resolvido' ? 'selected' : '' ?>>Resolvido</option>
              <option value="rejeitado" <?= $statusFiltro == 'rejeitado' ? 'selected' : '' ?>>Rejeitado</option>
            </select>
          </form>
        </div>
      </div>

      <div class="table-main">
        <table>
          <thead>
            <tr>
              <th style="width:8%;">ID</th>
              <th style="width:28%;">PROTOCOLO</th>
              <th style="width:18%;">CIDADE</th>
              <th style="width:18%;">TIPO</th>
              <?php if (in_array('status', $columns)): ?>
                <th style="width:12%;">STATUS</th>
              <?php endif; ?>
              <?php if (in_array('data_envio', $columns)): ?>
                <th style="width:12%;">DATA</th>
              <?php endif; ?>
              <th style="width:12%;">AÇÕES</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($res->num_rows === 0): ?>
              <tr>
                <td colspan="7" class="text-center py-3">Nenhuma denúncia encontrada</td>
              </tr>
            <?php else: ?>
              <?php while ($row = $res->fetch_assoc()): ?>
                <tr>
                  <td data-label="ID"><strong><?= str_pad($row['id'], 2, '0', STR_PAD_LEFT) ?></strong></td>
                  <td data-label="PROTOCOLO"><?= htmlspecialchars(strtoupper($row['protocolo'])) ?></td>
                  <td data-label="CIDADE"><?= htmlspecialchars($row['cidade']) ?></td>
                  <td data-label="TIPO"><?= htmlspecialchars($row['tipo_crime']) ?></td>
                  <?php if (in_array('status', $columns)): ?>
                    <td data-label="STATUS">
                      <?php
                      $s = strtolower(trim($row['status'] ?? ''));
                      if ($s === 'resolvido') echo '<span class="badge-resolvido">Resolvido</span>';
                      elseif ($s === 'em andamento' || $s === 'em_andamento') echo '<span class="badge-em-andamento">Em andamento</span>';
                      elseif ($s === 'rejeitado') echo '<span class="badge-rejeitado">Rejeitado</span>';
                      elseif ($s === 'recebido') echo '<span class="badge-recebido">Recebido</span>';
                      else echo '<span class="badge-recebido">' . htmlspecialchars($row['status']) . '</span>';
                      ?>
                    </td>
                  <?php endif; ?>
                  <?php if (in_array('data_envio', $columns)): ?>
                    <td data-label="DATA"><?= !empty($row['data_envio']) ? date('Y-m-d', strtotime($row['data_envio'])) : '-' ?></td>
                  <?php endif; ?>
                  <td data-label="AÇÕES">
                    <a href="ver.php?id=<?= $row['id'] ?>" class="btn-action">ver/editar status</a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php include __DIR__ . '/inc/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>