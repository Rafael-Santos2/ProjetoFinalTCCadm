<?php

// Habilitar exibição de erros para debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar ou resumir a sessão
session_start();

// Verificar se é refresh (GET) após envio bem-sucedido: mostra a página de sucesso novamente
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && isset($_SESSION['ultimo_protocolo'])) {
    mostrarusuarioucesso($_SESSION['ultimo_protocolo']);
    exit;
}

// Verificar se o arquivo de conexão existe (uso centralizado em inc/)
$conexao_path = __DIR__ . '/inc/conexao.php';
if (!file_exists($conexao_path)) {
    die("Erro: Arquivo de conexão não encontrado em: " . $conexao_path);
}

// include conexão (padrão único centralizado)
include $conexao_path;

// Função para gerar protocolo aleatório
function gerarProtocolo($tamanho = 10)
{
    return strtoupper(substr(md5(uniqid((string) rand(), true)), 0, $tamanho));
}


// POST válido: sempre gerar um novo protocolo para esta submissão
$protocolo = gerarProtocolo();

// CSRF: validação opcional (só bloqueia se ambos existirem e divergirem)
if (isset($_SESSION['csrf_token']) && isset($_POST['csrf_token'])) {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        http_response_code(403);
        echo "<h3>Falha de segurança</h3><p>Token CSRF inválido.</p>";
        exit;
    }
}

$cep = isset($_POST['cep']) ? trim($_POST['cep']) : '';
$estado = isset($_POST['estado']) ? trim($_POST['estado']) : '';
$cidade = isset($_POST['cidade']) ? trim($_POST['cidade']) : '';
$bairro = isset($_POST['bairro']) ? trim($_POST['bairro']) : '';
$rua = isset($_POST['rua']) ? trim($_POST['rua']) : '';
$numero = isset($_POST['numero']) ? trim($_POST['numero']) : '';
$tipo_crime = isset($_POST['tipo_crime']) ? trim($_POST['tipo_crime']) : '';
$complemento = isset($_POST['complemento']) ? trim($_POST['complemento']) : '';

// Upload de arquivo (opcional)
$arquivo = "";
if (isset($_FILES['arquivo']) && isset($_FILES['arquivo']['error']) && $_FILES['arquivo']['error'] == 0) {
    // salvar na pasta uploads na raiz do projeto
    $pasta = __DIR__ . '/../../uploads/';
    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }
    // Validação básica de tipo e tamanho (mais seguro)
    $allowedMime = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'audio/mpeg',
        'audio/wav',
        'audio/ogg',
        'video/mp4',
        'video/mpeg',
        'video/quicktime',
        'video/webm'
    ];
    $maxBytes = 50 * 1024 * 1024; // 50 MB limite total

    $tipo = mime_content_type($_FILES['arquivo']['tmp_name']);
    $tamanho = (int)$_FILES['arquivo']['size'];
    if (!in_array($tipo, $allowedMime, true)) {
        echo "<p>Tipo de arquivo não permitido.</p>";
    } elseif ($tamanho > $maxBytes) {
        echo "<p>Arquivo muito grande. Tamanho máximo permitido: 50MB.</p>";
    } else {
        $nomeArquivo = uniqid() . '-' . basename($_FILES['arquivo']['name']);
        $destino = $pasta . $nomeArquivo;
        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino)) {
            $arquivo = $nomeArquivo; // armazenamos apenas o nome do arquivo no banco
        } else {
            // falha no upload: manter $arquivo vazio
            $arquivo = "";
        }
    }
}

// Insere no banco (não mexer na lógica/SQL conforme solicitado)
$sql = "INSERT INTO denuncias 
(protocolo, cep, estado, cidade, bairro, rua, numero, tipo_crime, complemento, arquivo)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// $conn deve ser provido pelo arquivo de conexão incluído
if (!isset($conn) || $conn === null) {
    die('Erro: conexão ao banco indisponível. Verifique o arquivo de conexão.');
}

// Preparar statement
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Erro na preparação da query: ' . $conn->error);
}

$stmt->bind_param("ssssssssss", $protocolo, $cep, $estado, $cidade, $bairro, $rua, $numero, $tipo_crime, $complemento, $arquivo);

// Função para mostrar a página de sucesso
function mostrarusuarioucesso($protocolo)
{
?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Denúncia Enviada</title>
        <link rel="stylesheet" href="../../css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="shortcut icon" href="../../assets/Logo infantil.png" type="image/x-icon">
        <style>
            .success-page {
                max-width: 600px;
                margin: calc(var(--header-height, 100px) + 12px) auto;
                padding: 30px;
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }

            .protocolo {
                font-size: 24px;
                color: #11b85a;
                margin: 20px 0;
                padding: 10px;
                background: #f8f9fa;
                border-radius: 4px;
            }

            .btn-process {
                background-color: #9fff96ff;
                color: #000000;
                text-decoration: none;
                border-radius: 5px;
                transition: 0.3s ease;
                cursor: pointer;
                border: solid 2px #058401ff;
                display: inline-block;
            }

            .btn-process:hover {
                background-color: #64000aff;
                color: #ffffff;
            }

            @media (max-width:480px) {
                .success-page {
                    margin: calc(var(--header-height, 80px) + 8px) 12px;
                    padding: 18px;
                }

                .protocolo {
                    font-size: 18px;
                }

                .btn-process,
                .btn-denunciar {
                    display: block;
                    width: 100%;
                    margin: 8px 0;
                }
            }
        </style>
    </head>

    <body>
        <div class="success-page">
            <h2>Denúncia enviada com sucesso!</h2>
            <p>Seu protocolo é:</p>
            <div class="protocolo"><strong><?php echo $protocolo; ?></strong></div>
            <p>Guarde este número para consultar sua denúncia.</p>
            <a href="denuncia.php" class="btn btn-denunciar mt-3">Voltar</a>
            <a href="consulta.php" class="btn btn-process mt-3">Consultar Denúncia</a>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
}

// Tentar executar a query
try {
    if ($stmt->execute()) {
        // Guardar protocolo para eventuais refresh/consulta imediata
        $_SESSION['ultimo_protocolo'] = $protocolo;
        // PRG: Redirecionar para evitar reenvio de POST e manter o protocolo no refresh
        header('Location: ' . basename(__FILE__));
        exit;
    } else {
        throw new Exception("Erro ao executar a query: " . $stmt->error);
    }
} catch (Exception $e) {
    // Erro - mostrar página de erro formatada
?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Erro no Envio</title>
        <link rel="stylesheet" href="../../css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <style>
            .error-page {
                max-width: 600px;
                margin: calc(var(--header-height, 100px) + 12px) auto;
                padding: 30px;
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }

            .error-details {
                margin: 20px 0;
                padding: 10px;
                background: #f8d7da;
                border-radius: 4px;
                color: #721c24;
            }

            @media (max-width:480px) {
                .error-page {
                    margin: calc(var(--header-height, 80px) + 8px) 12px;
                    padding: 18px;
                }

                .error-details {
                    font-size: 14px;
                }

                .btn-denunciar {
                    display: block;
                    width: 100%;
                    margin-top: 8px;
                }
            }
        </style>
    </head>

    <body>
        <div class="error-page">
            <h2>Erro ao enviar denúncia</h2>
            <div class="error-details">
                <p><?php echo $e->getMessage(); ?></p>
            </div>
            <a href="denuncia.php" class="btn btn-denunciar mt-3">Voltar e Tentar Novamente</a>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
}

// Fechar conexões
$stmt->close();
$conn->close();
?>