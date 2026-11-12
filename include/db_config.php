<?php
// SECURITY: Block direct access to this file
if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die("Access Denied");
}

if (!function_exists('loadEnvFileConfig')) {
    function loadEnvFileConfig($envPath = null) {
        if ($envPath === null) {
            $envPath = dirname(dirname(__FILE__)) . '/.env';
        }
        if (file_exists($envPath)) {
            $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line) || strpos($line, '#') === 0) continue;
                if (strpos($line, '=') !== false) {
                    list($name, $value) = explode('=', $line, 2);
                    $name = trim($name);
                    $value = trim(trim($value), '"\'');
                    $_ENV[$name] = $value;
                    putenv("$name=$value");
                }
            }
        }
    }
}

loadEnvFileConfig();

$dbHost = getenv('DB_HOST') ? getenv('DB_HOST') : (isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : 'seppro_db');
$dbUser = getenv('DB_USER') ? getenv('DB_USER') : (isset($_ENV['DB_USER']) ? $_ENV['DB_USER'] : 'root');
$dbPass = getenv('DB_PASS') ? getenv('DB_PASS') : (isset($_ENV['DB_PASS']) ? $_ENV['DB_PASS'] : '$3pp60@2016');
$dbName = getenv('DB_NAME') ? getenv('DB_NAME') : (isset($_ENV['DB_NAME']) ? $_ENV['DB_NAME'] : 'adsouq_masterblaster');
$dbMaster = getenv('DB_MASTER_NAME') ? getenv('DB_MASTER_NAME') : (isset($_ENV['DB_MASTER_NAME']) ? $_ENV['DB_MASTER_NAME'] : 'adsouq_masterblaster');

if (!defined('DB_HOST')) define('DB_HOST', $dbHost);
if (!defined('DB_USER')) define('DB_USER', $dbUser);
if (!defined('DB_PASS')) define('DB_PASS', $dbPass);
if (!empty($_SESSION["DBNAME"])) {
    if (!defined('DB_NAME')) define('DB_NAME', trim($_SESSION["DBNAME"]));
} else {
    if (!defined('DB_NAME')) define('DB_NAME', $dbName);
}
if (!defined('DB_MASTER_NAME')) define('DB_MASTER_NAME', $dbMaster);

