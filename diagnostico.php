<?php
/**
 * Teste de diagnóstico para Railway
 * Acesse este arquivo diretamente para ver onde está o problema
 */

echo "<h1>Diagnóstico do Sistema</h1>";
echo "<hr>";

// 1. Versão do PHP
echo "<h2>1. Versão do PHP</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "<hr>";

// 2. Variáveis de Ambiente
echo "<h2>2. Variáveis de Ambiente do Banco</h2>";
echo "MYSQLHOST: " . (getenv('MYSQLHOST') ?: 'NÃO DEFINIDO') . "<br>";
echo "MYSQLUSER: " . (getenv('MYSQLUSER') ?: 'NÃO DEFINIDO') . "<br>";
echo "MYSQLPASSWORD: " . (getenv('MYSQLPASSWORD') ? '***DEFINIDO***' : 'NÃO DEFINIDO') . "<br>";
echo "MYSQLDATABASE: " . (getenv('MYSQLDATABASE') ?: 'NÃO DEFINIDO') . "<br>";
echo "MYSQLPORT: " . (getenv('MYSQLPORT') ?: 'NÃO DEFINIDO') . "<br>";
echo "BASE_URL: " . (getenv('BASE_URL') ?: 'NÃO DEFINIDO') . "<br>";
echo "ENVIRONMENT: " . (getenv('ENVIRONMENT') ?: 'NÃO DEFINIDO') . "<br>";
echo "<hr>";

// 3. Teste de conexão
echo "<h2>3. Teste de Conexão com Banco de Dados</h2>";
try {
    $host = getenv('MYSQLHOST') ?: 'localhost';
    $user = getenv('MYSQLUSER') ?: 'root';
    $pass = getenv('MYSQLPASSWORD') ?: '';
    $db = getenv('MYSQLDATABASE') ?: 'voz_infantil';
    $port = (int)(getenv('MYSQLPORT') ?: '3306');
    
    echo "Tentando conectar em: $host:$port com usuário: $user<br>";
    
    $conn = new mysqli($host, $user, $pass, $db, $port);
    
    if ($conn->connect_error) {
        echo "<span style='color:red'>❌ ERRO: " . $conn->connect_error . "</span><br>";
    } else {
        echo "<span style='color:green'>✅ SUCESSO: Conectado ao banco '$db'</span><br>";
        
        // Testar se a tabela usuarios existe
        $result = $conn->query("SHOW TABLES LIKE 'usuarios'");
        if ($result && $result->num_rows > 0) {
            echo "<span style='color:green'>✅ Tabela 'usuarios' existe</span><br>";
            
            // Contar usuários
            $count = $conn->query("SELECT COUNT(*) as total FROM usuarios")->fetch_assoc();
            echo "Total de usuários: " . $count['total'] . "<br>";
        } else {
            echo "<span style='color:orange'>⚠️ Tabela 'usuarios' NÃO existe</span><br>";
        }
        
        $conn->close();
    }
} catch (Exception $e) {
    echo "<span style='color:red'>❌ EXCEÇÃO: " . $e->getMessage() . "</span><br>";
}
echo "<hr>";

// 4. Arquivos importantes
echo "<h2>4. Verificação de Arquivos</h2>";
$files = [
    'config.php',
    'admin/index.php',
    'admin/inc/conexao.php',
    'admin/inc/header.php',
    'admin/inc/footer.php'
];

foreach ($files as $file) {
    if (file_exists(__DIR__ . '/' . $file)) {
        echo "<span style='color:green'>✅ $file existe</span><br>";
    } else {
        echo "<span style='color:red'>❌ $file NÃO existe</span><br>";
    }
}
echo "<hr>";

echo "<h2>5. Extensões PHP Carregadas</h2>";
$extensions = ['mysqli', 'pdo_mysql', 'mbstring', 'json'];
foreach ($extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<span style='color:green'>✅ $ext</span><br>";
    } else {
        echo "<span style='color:red'>❌ $ext NÃO carregado</span><br>";
    }
}

echo "<hr>";
echo "<p><strong>Se todos os itens acima estão OK, o problema pode estar nos includes dos arquivos PHP.</strong></p>";
echo "<p><a href='/admin/index.php'>Tentar acessar /admin/index.php</a></p>";
?>
