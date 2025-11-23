<?php
session_start();
// incluir conexão centralizada
include __DIR__ . '/inc/conexao.php';

// se já logado, redireciona
if (isset($_SESSION['usuario_id'])) {
    header('Location: dashboard.php');
    exit;
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $sql = "SELECT id, nome, senha_hash, role FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 1) {
        $u = $res->fetch_assoc();
        if (password_verify($senha, $u['senha_hash'])) {
            // autentica
            $_SESSION['usuario_id'] = $u['id'];
            $_SESSION['usuario_nome'] = $u['nome'];
            $_SESSION['usuario_role'] = $u['role'];
            header('Location: dashboard.php');
            exit;
        } else {
            $msg = 'Credenciais inválidas';
        }
    } else {
        $msg = 'Credenciais inválidas';
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Policial</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --backcard: #fde4e4;
            --principal: #ffe4e4
        }

        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            background: var(--principal)
        }

        .login-page {
            /* garantir espaço suficiente abaixo do header (caso seja fixed) */
            padding-top: calc(var(--header-height, 80px) + 12px);
            min-height: calc(100vh - calc(var(--header-height, 80px) + 12px));
            display: grid;
            grid-template-columns: 40% 60%;
            align-items: stretch
        }

        .login-image {
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0
        }

        .login-image img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .login-card {
            background: var(--backcard);
            display: flex;
            align-items: center;
            justify-content: center
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            padding: 40px;
            margin-top: -80px;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 24px;
            font-size: 26px;
            font-weight: 700;
        }

        .form-control {
            height: 44px;
            border-radius: 8px;
            width: 350px;
            max-width: 100%;
            box-sizing: border-box;
        }

        .btn-login {
            background: #11b85a;
            color: #fff;
            border: none;
            padding: 10px 26px;
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(17, 184, 90, 0.18);
            transition: 0.3s ease;
        }

        .btn-login:hover {
            background: #0a632fff;
            color: #fff;
        }

        .msg-error {
            color: #c0392b;
            text-align: center;
            margin-bottom: 12px
        }

        @media (max-width:900px) {
            .login-box {
                padding: 20px;
                margin-top: 30px;
            }

            .login-page {
                grid-template-columns: 1fr;
            }

            .login-image {
                padding: 0px
            }
        }

        /* ajustes finos para pequenos dispositivos */
        @media (max-width:420px) {
            .login-box {
                padding: 20px;
                margin-top: 30px;
            }

            .login-box h2 {
                font-size: 20px;
            }

            .form-control {
                height: 44px;
                width: 100%;
            }

            .btn-login {
                width: 100%;
                padding: 12px;
            }

            header .navbar-brand img {
                max-width: 120px;
            }

            .denunciar {
                margin-right: 8px;
            }
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/inc/header.php'; ?>
    <main class="login-page">
        <section class="login-image">
            <img src="../assets/seguranca.png" alt="seguranca">
        </section>

        <section class="login-card">
            <div class="login-box">
                <h2>Login Policial</h2>
                <?php if ($msg) echo '<div class="msg-error">' . htmlspecialchars($msg) . '</div>'; ?>
                <form method="post" class="mt-2">
                    <div class="mb-3">
                        <label class="form-label">Digite seu usuário</label>
                        <input class="form-control" type="email" name="email" placeholder="Digite o usuario" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Digite sua senha</label>
                        <input class="form-control" type="password" name="senha" placeholder="Digite a senha" required>
                    </div>
                    <div class="text-center mt-4">
                        <button class="btn-login" type="submit">Entrar</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <?php include __DIR__ . '/inc/footer.php'; ?>
</body>

</html>