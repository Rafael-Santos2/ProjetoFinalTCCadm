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
    error_reporting(E_ERROR | E_PARSE);
}

function getConnection() {
    static $conn = null;

    if ($conn === null) {
        try {
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, (int)DB_PORT);

            if ($conn->connect_error) {
                error_log("Erro de conexão MySQL: " . $conn->connect_error);
                
                if (ENVIRONMENT === 'development') {
                    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
                } else {
                    die("Erro ao conectar ao banco de dados. Por favor, tente novamente mais tarde.");
                }
            }

            $conn->set_charset("utf8mb4");
        } catch (Exception $e) {
            error_log("Exceção na conexão MySQL: " . $e->getMessage());
            
            if (ENVIRONMENT === 'development') {
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            } else {
                die("Erro ao conectar ao banco de dados. Por favor, tente novamente mais tarde.");
            }
        }
    }

    return $conn;
}

$conn = getConnection();
?>