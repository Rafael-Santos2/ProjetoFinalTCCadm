<?php
/**
 * Script para criar o primeiro usuário administrador
 * Execute apenas UMA VEZ após o deploy
 * REMOVA este arquivo após criar o usuário!
 */

require_once __DIR__ . '/inc/conexao.php';

// Verificar se já existe algum usuário
$check = $conn->query("SELECT COUNT(*) as total FROM usuarios");
if ($check) {
    $row = $check->fetch_assoc();
    if ($row['total'] > 0) {
        die("❌ Erro: Já existem usuários cadastrados. Por segurança, este script só pode ser executado uma vez.");
    }
}

// Dados do primeiro admin
$nome = "Administrador";
$email = "admin@vozinfantil.com"; // ALTERE ESTE EMAIL
$senha = "Admin@2025"; // ALTERE ESTA SENHA!
$role = "admin";

// Hash da senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Inserir usuário
$sql = "INSERT INTO usuarios (nome, email, senha_hash, role, criado_em) VALUES (?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("❌ Erro ao preparar query: " . $conn->error);
}

$stmt->bind_param("ssss", $nome, $email, $senha_hash, $role);

if ($stmt->execute()) {
    echo "✅ <strong>Usuário administrador criado com sucesso!</strong><br><br>";
    echo "📧 <strong>Email:</strong> " . htmlspecialchars($email) . "<br>";
    echo "🔑 <strong>Senha:</strong> " . htmlspecialchars($senha) . "<br><br>";
    echo "⚠️ <strong>IMPORTANTE:</strong><br>";
    echo "1. Anote estas credenciais em local seguro<br>";
    echo "2. Altere a senha após o primeiro login<br>";
    echo "3. <strong>DELETE ESTE ARQUIVO AGORA!</strong><br>";
    echo "   Comando: <code>rm " . __FILE__ . "</code><br><br>";
    echo "🔗 <a href='login.php'>Ir para o Login</a>";
} else {
    echo "❌ Erro ao criar usuário: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Primeiro Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        code {
            background: #eee;
            padding: 2px 6px;
            border-radius: 3px;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #11b85a;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- O PHP acima já exibe o resultado -->
    </div>
</body>
</html>
