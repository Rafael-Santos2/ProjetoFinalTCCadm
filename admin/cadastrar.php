<?php
session_start();

// Verificar se já está logado e se é admin
include __DIR__ . '/inc/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

// Verificar se tem permissão (apenas admin pode cadastrar novos usuários)
if ($_SESSION['usuario_role'] !== 'admin') {
    die('Acesso negado. Apenas administradores podem cadastrar novos usuários.');
}

$msg = '';
$msg_tipo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $role = $_POST['role'] ?? 'policia';

    // Validações
    if (empty($nome) || empty($email) || empty($senha)) {
        $msg = 'Todos os campos são obrigatórios';
        $msg_tipo = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = 'Email inválido';
        $msg_tipo = 'error';
    } elseif (strlen($senha) < 6) {
        $msg = 'A senha deve ter pelo menos 6 caracteres';
        $msg_tipo = 'error';
    } else {
        // Verificar se o email já existe
        $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();
        
        if ($result->num_rows > 0) {
            $msg = 'Este email já está cadastrado';
            $msg_tipo = 'error';
        } else {
            // Criar usuário
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (nome, email, senha_hash, role, criado_em) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $nome, $email, $senha_hash, $role);
            
            if ($stmt->execute()) {
                $msg = 'Usuário cadastrado com sucesso!';
                $msg_tipo = 'success';
                // Limpar campos após sucesso
                $nome = $email = $senha = '';
            } else {
                $msg = 'Erro ao cadastrar usuário: ' . $stmt->error;
                $msg_tipo = 'error';
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar Novo Usuário</title>
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

        .form-select {
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

        .btn-secondary {
            background: #6c757d;
            color: #fff;
            border: none;
            padding: 10px 26px;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #5a6268;
            color: #fff;
        }

        .msg-error {
            color: #c0392b;
            text-align: center;
            margin-bottom: 12px;
            background: #f8d7da;
            padding: 10px;
            border-radius: 8px;
        }

        .msg-success {
            color: #155724;
            text-align: center;
            margin-bottom: 12px;
            background: #d4edda;
            padding: 10px;
            border-radius: 8px;
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

        @media (max-width:420px) {
            .login-box {
                padding: 20px;
                margin-top: 30px;
            }

            .login-box h2 {
                font-size: 20px;
            }

            .form-control,
            .form-select {
                height: 44px;
                width: 100%;
            }

            .btn-login,
            .btn-secondary {
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
                <h2>Cadastrar Novo Usuário</h2>
                <?php if ($msg): ?>
                    <div class="<?= $msg_tipo === 'success' ? 'msg-success' : 'msg-error' ?>">
                        <?= htmlspecialchars($msg) ?>
                    </div>
                <?php endif; ?>
                <form method="post" class="mt-2">
                    <div class="mb-3">
                        <label class="form-label">Nome Completo</label>
                        <input class="form-control" type="text" name="nome" placeholder="Digite o nome completo" value="<?= htmlspecialchars($nome ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email" name="email" placeholder="Digite o email" value="<?= htmlspecialchars($email ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input class="form-control" type="password" name="senha" placeholder="Digite a senha (mínimo 6 caracteres)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Usuário</label>
                        <select class="form-select" name="role" required>
                            <option value="policia">Policial</option>
                            <option value="admin">Administrador</option>
                            <option value="operador">Operador</option>
                        </select>
                    </div>
                    <div class="text-center mt-4">
                        <button class="btn-login" type="submit">Cadastrar</button>
                        <a href="dashboard.php" class="btn-secondary mt-2">Voltar ao Dashboard</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <?php include __DIR__ . '/inc/footer.php'; ?>
</body>

</html>
