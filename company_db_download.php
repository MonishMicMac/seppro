<?php
// company_db_download.php

// =========================================================
// SECURITY LAYER 1: STRICT HEADERS & ENVIRONMENT
// =========================================================
header("X-Frame-Options: DENY"); 
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
error_reporting(0); // Hide server paths from attackers
session_start();

// ---------------------------------------------------------
// DEFINE YOUR MASTER PASSCODE HERE (Make it strong!)
// ---------------------------------------------------------
define('VAULT_TOKEN', 'MicandMacClientCompanyDBSEPPRO@Backup#2026!'); 

// SECURITY LAYER 2: Strict Whitelist of Allowed Databases (Prevents SQL Injection)
$target_databases = [
    'adsouq_masterblaster',
    'bio_pheonix',
    'chit_funds',
    'gage_demo_new',
    'gage_master',
    'gage_ourangles',
    'gage_ourangles_test',
    'gage_sethubhaskara',
    'gage_sethubhaskara_test',
    'gmc',
    'gm_chit_funds',
    'Vsh_hospital'
];

// =========================================================
// AUTHENTICATION LOGIC (Login & Logout)
// =========================================================
if (isset($_POST['vault_token_submit'])) {
    $entered_token = $_POST['secure_token'];
    
    // hash_equals prevents cryptographic timing attacks
    if (hash_equals(VAULT_TOKEN, $entered_token)) {
        $_SESSION['vault_access_granted'] = true;
    } else {
        $login_error = "Invalid Security Token. Access Denied.";
        sleep(2); // Anti-brute force delay
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ?");
    exit;
}

// =========================================================
// THE LOCKED SCREEN (If not authenticated)
// =========================================================
if (empty($_SESSION['vault_access_granted']) || $_SESSION['vault_access_granted'] !== true) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Secure DB Vault - Authentication</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { background-color: #1a1a1a; color: #fff; font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: #2d2d2d; padding: 40px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.5); text-align: center; width: 350px; border-top: 5px solid #d9534f; }
        input[type="password"] { width: 90%; padding: 12px; margin: 20px 0; border: 1px solid #444; border-radius: 4px; background: #1a1a1a; color: #fff; text-align: center; letter-spacing: 2px; }
        button { background: #d9534f; color: white; border: none; padding: 12px 25px; cursor: pointer; border-radius: 4px; font-weight: bold; width: 100%; transition: 0.3s; }
        button:hover { background: #c9302c; }
        .error { color: #ff6b6b; margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>🔒 Secure DB Vault</h2>
        <p style="font-size: 14px; color: #aaa;">Restricted Area. Enter Master Token.</p>
        <?php if (isset($login_error)) echo "<div class='error'>$login_error</div>"; ?>
        <form method="post">
            <input type="password" name="secure_token" placeholder="Enter Vault Token" required autocomplete="off" autofocus>
            <button type="submit" name="vault_token_submit">AUTHENTICATE</button>
        </form>
    </div>
</body>
</html>
<?php
    exit; // STOP SCRIPT EXECUTION HERE. The database logic is completely unreachable without the token.
}


// =========================================================
// DATABASE EXPORT LOGIC (Executes ONLY if Auth passed)
// =========================================================
if (isset($_POST['download_specific_db'])) {
    
    $db_to_download = $_POST['db_name'];
    
    // SECURITY LAYER 3: Validate against Whitelist
    if (!in_array($db_to_download, $target_databases, true)) {
        die("Security Violation: Invalid Database Requested.");
    }

    // SECURITY LAYER 4: Silently include credentials without printing anything
    ob_start();
    include("connect_download_db.php"); 
    ob_end_clean();

    // Set memory limits for massive databases
    date_default_timezone_set('Asia/Kolkata');
    ini_set('max_execution_time', 0); 
    ini_set('memory_limit', '2048M');
    
    // Connect explicitly to the requested database
    // Using a new link (true) to override whatever previous connections existed
    $conn = mysql_connect($hostname, $username, $password, true);
    if (!$conn || !mysql_select_db($db_to_download, $conn)) {
        die("Database Connection Failed. Check your connect_download_db.php credentials.");
    }
    mysql_set_charset('utf8', $conn);

    // CRITICAL: Clean all output buffers to prevent SQL file corruption
    while (ob_get_level()) { ob_end_clean(); }

    // Force browser to start downloading immediately
    $filename = $db_to_download . '_secure_backup_' . date('Y-m-d_H-i-s') . '.sql';
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // WRITE PHPMYADMIN FORMAT HEADERS
    echo "-- Secure phpMyAdmin-like SQL Dump\n";
    echo "-- Generated: " . date("F d, Y \a\\t h:i A") . "\n";
    echo "-- Database: `$db_to_download`\n\n";
    echo "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
    echo "SET time_zone = \"+00:00\";\n\n";
    echo "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\n";
    echo "/*!40101 SET NAMES utf8 */;\n\n";

    $tables = array();
    $tables_result = mysql_query('SHOW TABLES', $conn);
    while ($row = mysql_fetch_row($tables_result)) {
        $tables[] = $row[0];
    }
    
    foreach ($tables as $table) {
        echo "-- --------------------------------------------------------\n\n";
        echo "--\n-- Table structure for table `$table`\n--\n\n";
        
        echo "DROP TABLE IF EXISTS `$table`;\n";
        $create_result = mysql_query("SHOW CREATE TABLE `$table`", $conn);
        $row2 = mysql_fetch_row($create_result);
        echo $row2[1] . ";\n\n";
        
        echo "--\n-- Dumping data for table `$table`\n--\n\n";
        
        // STREAM DATA (unbuffered)
        $data_result = mysql_unbuffered_query("SELECT * FROM `$table`", $conn);
        
        if ($data_result) {
            $num_fields = mysql_num_fields($data_result);
            $field_names = array();
            for ($i = 0; $i < $num_fields; $i++) {
                $field_names[] = "`" . mysql_field_name($data_result, $i) . "`";
            }
            $columns_string = implode(', ', $field_names);

            $row_count = 0;
            $batch_size = 400; // Group 400 rows into one INSERT
            
            while ($row = mysql_fetch_row($data_result)) {
                if ($row_count == 0) {
                    echo "INSERT INTO `$table` ($columns_string) VALUES\n";
                } else {
                    echo ",\n"; 
                }

                echo "(";
                for ($j = 0; $j < $num_fields; $j++) {
                    if (isset($row[$j])) {
                        $clean_data = mysql_real_escape_string($row[$j], $conn);
                        echo "'" . $clean_data . "'";
                    } else {
                        echo 'NULL'; 
                    }
                    if ($j < ($num_fields - 1)) {
                        echo ', ';
                    }
                }
                echo ")";

                $row_count++;
                if ($row_count == $batch_size) {
                    echo ";\n";
                    $row_count = 0;
                }
                flush(); 
            }
            if ($row_count > 0) {
                echo ";\n";
            }
        }
        echo "\n\n";
    }
    exit; // HALT execution after downloading
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Secure DB Vault - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Arial, sans-serif; margin: 0; padding: 0; }
        .navbar { background: #2d2d2d; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 4px solid #d9534f; }
        .navbar h2 { margin: 0; font-size: 20px; font-weight: normal; }
        .logout-btn { background: #d9534f; color: white; text-decoration: none; padding: 8px 15px; border-radius: 4px; font-size: 14px; font-weight: bold; transition: 0.3s;}
        .logout-btn:hover { background: #c9302c; }
        .container { max-width: 900px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .info-box { background: #eef5f9; border-left: 4px solid #3c8dbc; padding: 15px; margin-bottom: 30px; color: #333; line-height: 1.5;}
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; color: #333; }
        tr:hover { background-color: #f1f1f1; }
        .download-btn { background: #3c8dbc; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; font-weight: bold; transition: 0.3s; }
        .download-btn:hover { background: #2a6b8f; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>🔒 Multi-Company DB Vault</h2>
        <a href="?logout=true" class="logout-btn">LOCK VAULT (LOGOUT)</a>
    </div>

    <div class="container">
        <div class="info-box">
            <strong>Authentication Successful.</strong> Select a database below to securely generate and stream a complete <code>.sql</code> backup directly to your device.<br>
            <span style="color: #d9534f; font-weight: bold;">Note:</span> Large databases (1GB+) will begin downloading immediately but may take several minutes to finish. Do not close this window during a download.
        </div>

        <table>
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th width="60%">Authorized Databases</th>
                    <th width="30%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $counter = 1;
                foreach ($target_databases as $db) { 
                ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><strong style="color: #2d2d2d; font-size: 16px;"><?php echo htmlspecialchars($db); ?></strong></td>
                        <td>
                            <form method="post" action="" style="margin: 0;">
                                <input type="hidden" name="db_name" value="<?php echo htmlspecialchars($db); ?>">
                                <button type="submit" name="download_specific_db" class="download-btn">
                                    Download Backup
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>