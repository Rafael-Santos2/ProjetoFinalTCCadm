<?php
/**
 * Arquivo de configuração centralizado
 * Compatível com Railway, Localhost e ambientes de produção
 */

function getEnvVar($key, $default = '') {
    return getenv($key) ?: $_ENV[$key] ?? $default;
}


/*
 * O Railway usa estas variáveis:
 * MYSQLHOST
 * MYSQLUSER
 * MYSQLPASSWORD
 * MYSQLDATABASE
 * MYSQLPORT
 */

define('DB_HOST', getEnvVar('MYSQLHOST', 'localhost'));
define('DB_USER', getEnvVar('MYSQLUSER', 'root'));
define('DB_PASS', getEnvVar('MYSQLPASSWORD', ''));
define('DB_NAME', getEnvVar('MYSQLDATABASE', 'voz_infantil'));
define('DB_PORT', getEnvVar('MYSQLPORT', '3306'));

define('BASE_URL', getEnvVar('BASE_URL', 'http://localhost'));
define('ENVIRONMENT', getEnvVar('ENVIRONMENT', 'development'));

if (ENVIRONMENT === 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

function getConnection() {
    static $conn = null;

    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, (int)DB_PORT);

        if ($conn->connect_error) {
            die("Erro ao conectar ao banco de dados.");
        }

        $conn->set_charset("utf8mb4");
    }

    return $conn;
}

$conn = getConnection();
?>