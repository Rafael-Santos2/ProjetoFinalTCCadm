<?php
session_start();
// incluir conexão centralizada
include __DIR__ . '/inc/conexao.php';
if (!isset($_SESSION['usuario_id'])) {
  header('Location: login.php');
  exit;
}

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
  echo "ID inválido";
  exit;
}

// processa alteração de status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['novo_status'])) {
  $novo = $_POST['novo_status'];
  $obs = $_POST['observacao'] ?? null;

  // atualiza status
  $sql = "UPDATE denuncias SET status = ? WHERE id = ?";
  $s = $conn->prepare($sql);
  $s->bind_param("si", $novo, $id);
  $s->execute();
  $s->close();

  // grava log
  $sql2 = "INSERT INTO denuncias_log (denuncia_id, usuario_id, acao, observacao) VALUES (?, ?, ?, ?)";
  $l = $conn->prepare($sql2);
  $acao = "status: $novo";
  $l->bind_param("iiss", $id, $_SESSION['usuario_id'], $acao, $obs);
  $l->execute();
  $l->close();

  header("Location: ver.php?id=$id");
  exit;
}

// busca a denuncia
$sql = "SELECT * FROM denuncias WHERE id = ?";
$s = $conn->prepare($sql);
$s->bind_param("i", $id);
$s->execute();
$res = $s->get_result();
if ($res->num_rows === 0) {
  echo "Denúncia não encontrada";
  exit;
}
$row = $res->fetch_assoc();
$s->close();

// pega logs
$logs = $conn->prepare("SELECT l.*, u.nome FROM denuncias_log l LEFT JOIN usuarios u ON l.usuario_id = u.id WHERE l.denuncia_id = ? ORDER BY l.criado_em DESC");
$logs->bind_param("i", $id);
$logs->execute();
$logsRes = $logs->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- link css -->
  <link rel="stylesheet" href="../css/style.css">

  <!-- link js -->
  <script src="../js/script.js"></script>

  <!-- link do bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <style>
    /* garante que a página ocupe toda a altura disponível */
    html,
    body,
    main {
      height: 100%;
      margin: 0;
      box-sizing: border-box;
    }

    /* faz a linha ocupar a viewport inteira verticalmente */
    .full-height-row {
      min-height: 100vh;
    }

    /* cada coluna recebe mínimo da altura da viewport para que o fundo preencha a tela */
    .col-fill {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* mantém um leve espaço interno das bordas para o conteúdo */
    .col-content {
      padding: 1.5rem;
      /* ajuste do espaçamento interno */
      flex: 1 1 auto;
    }

    .claro {
      background-color: #FCF6F6;
    }

    .escuro {
      background-color: #F5DADA;
    }

    .spacer {
      height: 40px;
    }

    .spacer-small {
      height: 20px;
    }

    .spacer_header {
      height: calc(var(--header-height, 80px) + 8px);
      /* ajuste conforme a altura do header */
    }

    footer {
      display: none;
    }

    /* responsividade para telas menores - empilhar colunas */
    @media (max-width: 768px) {
      .full-height-row { display: block; }
      .col-fill { min-height: auto; width: 100%; }
      .col-content { padding: 1rem; }
      .spacer_header { height: calc(var(--header-height, 60px) + 8px); }
    }
  </style>

  <title>Ver denúncia</title>

</head>

<body>

  <?php include __DIR__ . '/inc/header.php'; ?>

  <div class="spacer_header"></div>

  <main>
    <div class="container-fluid">
      <!-- agora usamos align-items-stretch para colunas com mesma altura -->
      <div class="row gx-3 gy-4 full-height-row">

        <!-- coluna esquerda -->
        <div class="col-md-5 col-fill escuro">
          <div class="col-content">
            <h3 class="mt-3">Informações da denúncia</h3>
            <h4>Denúncia #<?= $row['id'] ?> — <?= htmlspecialchars($row['protocolo']) ?></h4>
            <p><b>Status atual:</b> <br> <?= htmlspecialchars($row['status']) ?></p>
            <div class="spacer"></div>
            <div class="d-flex">
              <div class="pe-4">
                <div><b>CEP:</b></div>
                <div><?= htmlspecialchars($row['cep']) ?></div>
              </div>
              <div>
                <div><b>Estado:</b></div>
                <div><?= htmlspecialchars($row['estado']) ?></div>
              </div>
            </div>
            <div class="spacer-small"></div>
            <div class="d-flex">
              <div class="pe-4">
                <div><b>Cidade:</b></div>
                <div><?= htmlspecialchars($row['cidade']) ?></div>
              </div>
              <div>
                <div><b>Bairro:</b></div>
                <div><?= htmlspecialchars($row['bairro']) ?></div>
              </div>
            </div>
            <div class="spacer-small"></div>
            <div class="d-flex">
              <div class="pe-4">
                <div><b>Rua:</b></div>
                <div><?= htmlspecialchars($row['rua']) ?></div>
              </div>
              <div>
                <div><b>Número:</b></div>
                <div><?= htmlspecialchars($row['numero']) ?></div>
              </div>
            </div>
            <div class="spacer-small"></div>
            <div class="pe-4">
              <div><b>Complemento:</b></div>
              <div><?= htmlspecialchars($row['complemento']) ?></div>
            </div>
            <div class="spacer-small"></div>
            <div class="pe-4">
              <div><b>Tipo de Crime:</b></div>
              <div><?= htmlspecialchars($row['tipo_crime']) ?></div>
            </div>
            <div class="spacer-small"></div>
            <div class="pe-4">
              <div><b>Arquivo Anexado:</b></div>
              <div>
                <?php if (!empty($row['arquivo'])): ?>
                  <?php $fileUrl = '../uploads/' . rawurlencode($row['arquivo']); ?>
                  <a class="btn btn-danger mt-2" href="<?= $fileUrl ?>" target="_blank">Ver Arquivo</a>
                <?php else: ?>
                  <em>Nenhum arquivo anexado</em>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <!-- coluna direita -->
        <div class="col-md-7 col-fill claro">
          <div class="col-content">
            <h3 class="mt-3">Alterar status da denúncia</h3>
            <form method="post">
              <div class="mb-3">
                <label class="form-label"><b>Novo status:</b></label>
                <select name="novo_status" class="form-select" required>
                  <option value="recebido">Recebido</option>
                  <option value="em andamento">Em andamento</option>
                  <option value="resolvido">Resolvido</option>
                  <option value="rejeitado">Rejeitado</option>
                </select>
                <label>Observação (opcional):</label><br>
                <textarea name="observacao" rows="4" cols="50"></textarea><br><br>
                <button type="submit" class="btn btn-success mt-3">Atualizar status</button>
              </div>
            </form>

            <div class="spacer">
              <h3>Logs da denúncia</h3>
              <?php if ($logsRes->num_rows === 0): ?>
                <p>Nenhum log encontrado.</p>
              <?php else: ?>
                <ul class="list-group">
                  <?php while ($l = $logsRes->fetch_assoc()): ?>
                    <li class="list-group-item">[<?= $l['criado_em'] ?>] <?= htmlspecialchars($l['acao']) ?> — por <?= htmlspecialchars($l['nome'] ?? 'Sistema') ?> <?= $l['observacao'] ? ' — Obs: ' . htmlspecialchars($l['observacao']) : '' ?></li>
                  <?php endwhile; ?>
                </ul>
              <?php endif; ?>
            </div>
          </div>
        </div>

      </div> <!-- .row -->
    </div> <!-- .container-fluid -->
  </main>

  <?php include __DIR__ . '/inc/footer.php'; ?>
</body>

</html>