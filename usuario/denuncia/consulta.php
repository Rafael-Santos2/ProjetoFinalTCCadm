<?php
// conexão centralizada
include __DIR__ . '/inc/conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Consultar Denúncia</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        :root {
            --card: #fff;
            --bg: #ffecec;
            --accent: #e74c3c;
            --muted: #bdbdbd;
            --success: #2ecc71;
            --info: #3498db;
            --warning: #f1c40f
        }

        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            background: #fde8e8;
            font-family: 'Poppins', Arial, sans-serif;
            padding: 0;
            /* header included separately */
        }

        /* main content should grow so footer stays at the bottom */
        .consulta-wrap {
            flex: 1 0 auto;
            box-sizing: border-box;
            max-width: 980px;
            margin: 0 auto;
            padding: 20px 18px 40px;
            /* ensure content is visible below header which may be fixed; uses --header-height if available */
            margin-top: calc(var(--header-height, 120px) + 8px);
        }

        .consulta-title {
            text-align: center;
            font-weight: 700;
            margin-bottom: 20px
        }

        .search-box {
            display: flex;
            justify-content: center;
            margin-bottom: 28px
        }

        .search-box input[type="text"] {
            width: 520px;
            max-width: 90%;
            height: 44px;
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: none
        }

        .search-box button {
            margin-left: 12px;
            background: #11b85a;
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 8px
        }

        .result-card {
            background: var(--card);
            border-radius: 18px;
            padding: 22px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
            max-width: 760px;
            margin: 0 auto;
            border: solid 2px #000000;
            overflow: visible;
        }

        .result-header {
            font-weight: 700;
            margin-bottom: 12px
        }

        .data-table {
            width: 100%;
            border-collapse: collapse
        }

        .data-table th {
            color: #9aa0a6;
            text-align: left;
            padding: 10px 8px;
            border-bottom: 1px solid #f0eeee;
            font-weight: 700;
            font-size: 0.85rem
        }

        .data-table td {
            padding: 12px 8px;
            border-bottom: 1px solid #f7f5f5
        }

    /* Responsividade: em telas pequenas, transformar tabela em blocos empilhados */
        @media (max-width: 700px) {
            .result-card { padding: 16px; max-width: 100%; }
            .data-table { width: 100%; border: none; }
            .data-table thead { display: none; }
            .data-table, .data-table tbody, .data-table tr, .data-table td { display: block; width: 100%; }
            .data-table tr { margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border-radius: 10px; overflow: hidden; }
            .data-table td { padding: 12px; border: none; display: flex; justify-content: space-between; align-items: center; }
            .data-table td::before { content: attr(data-label); font-weight: 700; color: #333; margin-right: 8px; display: inline-block; width: 45%; }
            .data-table td span.badge-status { white-space: nowrap; }
            .btn-file { display: inline-block; }
            .search-box input[type="text"] { width: 100%; }
        }

        .badge-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700
        }

        .badge-resolvido {
            background: #2ecc71;
            color: #fff
        }

        .badge-em-andamento {
            background: #f1c40f;
            color: #111
        }

        .badge-recebido {
            background: #3498db;
            color: #fff
        }

        .badge-rejeitado {
            background: #e74c3c;
            color: #fff
        }

        .btn-file {
            background: #e74c3c;
            color: #fff;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
        }

        .btn-file:hover {
            background: #c0392b;
        }

        .back-link {
            display: inline-block;
            margin-top: 18px;
            background: #c0392b;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none
        }

        @media(max-width:700px) {
            .search-box {
                flex-direction: column;
                align-items: center
            }

            .search-box button {
                margin-left: 0;
                margin-top: 10px
            }

            .data-table th,
            .data-table td {
                font-size: 0.9rem
            }
        }
    </style>
</head>

<body>
        <header class="d-flex flex-wrap">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a class="navbar-brand" href="../index.php"><img src="../../assets/Logo infantil.png" alt="Logo do site"></a>

                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
                    <span class="toggler-icon top-bar"></span>
                    <span class="toggler-icon middle-bar"></span>
                    <span class="toggler-icon bottom-bar"></span>
                </button>

                <div class="collapse navbar-collapse" id="menuNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="../index.php"><span class="rainbow1">Página Principal</span></a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="../sobre.php"><span class="rainbow2">Sobre nós</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="../responsavel.php"><span class="rainbow3">Área do Responsável</span></a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="../educativa.php"><span class="rainbow4">Página Educativa</span></a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="../contato.php"><span class="rainbow5">Contato</span></a></li>
                    </ul>
                </div>

                <div class="denunciar">
                    <button onclick="window.history.back()" class="btn btn-denunciar">Voltar</button>
                </div>
            </nav>
    </header>

        <div class="consulta-wrap">
            <h2 class="consulta-title">Consulte seu Protocolo</h2>

            <form method="GET" class="search-box" role="search" aria-label="Buscar protocolo">
                <input type="text" name="protocolo" placeholder="Digite aqui :" value="<?= isset($_GET['protocolo']) ? htmlspecialchars($_GET['protocolo']) : '' ?>" required>
                <button type="submit">🔍</button>
            </form>

            <?php
            if (isset($_GET['protocolo'])) {
                $protocolo = $_GET['protocolo'];
                $sql = "SELECT * FROM denuncias WHERE protocolo = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $protocolo);
                $stmt->execute();
                $resultado = $stmt->get_result();

                if ($resultado->num_rows > 0) {
                    $row = $resultado->fetch_assoc();
                    // escolher classe de status
                    $status = strtolower(trim($row['status']));
                    $badgeClass = 'badge-recebido';
                    if ($status === 'resolvido' || $status === 'resolvido') $badgeClass = 'badge-resolvido';
                    if ($status === 'em andamento' || $status === 'em_andamento') $badgeClass = 'badge-em-andamento';
                    if ($status === 'rejeitado') $badgeClass = 'badge-rejeitado';
                    if ($status === 'recebido') $badgeClass = 'badge-recebido';

                    echo '<div class="result-card">';
                    echo '<div class="result-header">Denúncia Encontrada!</div>';
                    echo '<table class="data-table">';
                    echo '<thead><tr>';
                    echo '<th>Protocolo</th><th>Data de Envio</th><th>Cep do ocorrido</th><th>Cidade</th><th>Bairro</th><th>Status</th>';
                    echo '</tr></thead>';
                    echo '<tbody>';
                    echo '<tr>';
                    echo '<td data-label="Protocolo">' . htmlspecialchars($row['protocolo']) . '</td>';
                    echo '<td data-label="Data de Envio">' . htmlspecialchars($row['data_envio']) . '</td>';
                    echo '<td data-label="CEP">' . htmlspecialchars($row['cep']) . '</td>';
                    echo '<td data-label="Cidade">' . htmlspecialchars($row['cidade']) . '</td>';
                    echo '<td data-label="Bairro">' . htmlspecialchars($row['bairro']) . '</td>';
                    echo '<td data-label="Status"><span class="badge-status ' . $badgeClass . '">' . htmlspecialchars($row['status']) . '</span></td>';
                    echo '</tr>';

                    // second section: details and arquivo (usar data-labels para mobile)
                    echo '<tr>';
                    echo '<td data-label="Rua do ocorrido">' . htmlspecialchars($row['rua']) . '</td>';
                    echo '<td data-label="Tipo de crime">' . htmlspecialchars($row['tipo_crime']) . '</td>';
                    echo '<td data-label="Arquivo" colspan="4">';
                    if (!empty($row['arquivo'])) {
                        $fileUrl = 'uploads/' . rawurlencode($row['arquivo']);
                        echo '<a class="btn-file" href="' . $fileUrl . '" target="_blank">Ver Arquivo</a>';
                    } else {
                        echo '<em>Nenhum arquivo anexado</em>';
                    }
                    echo '</td>';
                    echo '</tr>';

                    echo '</tbody></table>';
                    echo '</div>'; // result-card

                    echo '<a class="back-link" onclick="window.history.back()" href="#">Voltar</a>';
                } else {
                    echo '<p style="text-align:center">Nenhuma denúncia encontrada com esse protocolo.</p>';
                }
            }
            ?>

        </div>

        <footer class="footer">
            <div class="container-footer">
                <!-- LOGOS NO TOPO -->
                <div class="header-footer">
                    <img src="../../assets/Logo infantil.png" alt="Logo Voz Infantil">
                    <img src="../../assets/Logo instituto.png" alt="Logo Instituto Amparo Digital">
                </div>

                <!-- CONTEÚDO PRINCIPAL -->
                <div class="main-footer">
                    <div class="text-footer">
                        <p>
                            O Voz Infantil é um espaço seguro e anônimo para denunciar situações de violência contra
                            crianças e adolescentes, encaminhando tudo para os órgãos responsáveis.
                        </p>
                    </div>

                    <div class="links-footer">
                        <ul>
                            <li><a href="../../assets/Politica_de_Privacidade.pdf" target="_blank" rel="noopener noreferrer">Política de Privacidade</a></li>
                            <li><a href="../../assets/Termos_de_Uso.pdf" target="_blank" rel="noopener noreferrer">Termos de Uso</a></li>
                            <li><a href="../contato.php">Contato</a></li>
                        </ul>
                    </div>

                    <div class="acoes-footer">
                        <h5>Juntos pela proteção das crianças!</h5>
                        <p>Toda criança merece proteção.</p>
                        <a href="denuncia.php" class="btn-denunciar">Denuncie agora</a>
                    </div>
                </div>
            </div>

            <div class="footer-copy">
                <p>&copy; 2025 Voz Infantil – Instituto Amparo Digital</p>
                <span>Toda criança merece proteção.</span>
            </div>
        </footer>
    
    </body>
</html>