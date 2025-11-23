<?php
include __DIR__ . '/inc/conexao.php';

$nome = 'Policial Teste';
$email = 'policia@teste.com';
$senha = '12345'; // senha provisória

$hash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nome, email, senha_hash, role) VALUES (?, ?, ?, 'policia')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nome, $email, $hash);

if ($stmt->execute()) {
    echo "Usuário criado com sucesso!<br>";
    echo "Email: $email<br>";
    echo "Senha: $senha";
} else {
    echo "Erro: " . $stmt->error;
}
?>