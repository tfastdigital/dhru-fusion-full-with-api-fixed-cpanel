<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
mysqli_report(MYSQLI_REPORT_OFF);

$db_host = "localhost";
$db_user = "dkmunssk_dhru10";
$db_pass = "dkmunssk_dhru10";
$db_name = "dkmunssk_dhru10";

echo "<h1>Dhru Fusion Database Importer (v4)</h1>";
echo "<p>PHP (web): " . PHP_VERSION . " [" . php_sapi_name() . "]</p>";

function split_sql_statements($sql)
{
    $statements = [];
    $buffer = "";
    $inSingle = false;
    $inDouble = false;
    $len = strlen($sql);
    for ($i = 0; $i < $len; $i++) {
        $ch = $sql[$i];
        $prev = $i > 0 ? $sql[$i - 1] : "";
        if ($ch === "'" && !$inDouble && $prev !== "\\") {
            $inSingle = !$inSingle;
        } elseif ($ch === '"' && !$inSingle && $prev !== "\\") {
            $inDouble = !$inDouble;
        }
        if ($ch === ";" && !$inSingle && !$inDouble) {
            $trim = trim($buffer);
            if ($trim !== "") {
                $statements[] = $trim;
            }
            $buffer = "";
            continue;
        }
        $buffer .= $ch;
    }
    $trim = trim($buffer);
    if ($trim !== "") {
        $statements[] = $trim;
    }
    return $statements;
}

function collect_insert_schema($content, &$schemaMap)
{
    $pattern = "/INSERT\\s+(?:IGNORE\\s+)?INTO\\s+`([^`]+)`\\s*\\(([^\\)]+)\\)/i";
    if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $m) {
            $table = $m[1];
            $rawCols = $m[2];
            $parts = explode(",", $rawCols);
            foreach ($parts as $col) {
                $col = trim($col);
                $col = trim($col, "` \t\n\r\0\x0B");
                if ($col === "") {
                    continue;
                }
                $schemaMap[$table][$col] = true;
            }
        }
    }
}

function collect_update_schema($content, &$schemaMap)
{
    $pattern = "/UPDATE\\s+`?([a-zA-Z0-9_]+)`?\\s+SET\\s+(.+?)(?:\\s+WHERE\\s+|;)/is";
    if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $m) {
            $table = $m[1];
            $setPart = $m[2];
            $schemaMap[$table]["id"] = true;
            if (preg_match_all("/`?([a-zA-Z0-9_]+)`?\\s*=/", $setPart, $cm)) {
                foreach ($cm[1] as $col) {
                    $schemaMap[$table][$col] = true;
                }
            }
        }
    }
}

function collect_table_refs($content, &$schemaMap)
{
    if (preg_match_all("/DELETE\\s+FROM\\s+`?([a-zA-Z0-9_]+)`?/i", $content, $m1)) {
        foreach ($m1[1] as $table) {
            $schemaMap[$table]["id"] = true;
        }
    }
    if (preg_match_all("/ALTER\\s+TABLE\\s+`?([a-zA-Z0-9_]+)`?/i", $content, $m2)) {
        foreach ($m2[1] as $table) {
            $schemaMap[$table]["id"] = true;
        }
    }
}

function infer_column_type($column)
{
    $c = strtolower($column);
    if ($c === "id" || substr($c, -3) === "_id") {
        return "BIGINT";
    }
    if (strpos($c, "status") !== false || strpos($c, "active") !== false || strpos($c, "flag") !== false) {
        return "TINYINT";
    }
    if (strpos($c, "date") !== false || strpos($c, "time") !== false) {
        return "DATETIME";
    }
    if (strpos($c, "amount") !== false || strpos($c, "price") !== false || strpos($c, "credit") !== false || strpos($c, "tax") !== false) {
        return "DECIMAL(20,6)";
    }
    if (strpos($c, "email") !== false || strpos($c, "username") !== false || strpos($c, "phone") !== false || strpos($c, "key") !== false) {
        return "VARCHAR(255)";
    }
    return "LONGTEXT";
}

function ensure_table_exists($conn, $table, $columns)
{
    $check = $conn->query("SHOW TABLES LIKE '" . $conn->real_escape_string($table) . "'");
    if ($check && $check->num_rows > 0) {
        return true;
    }
    $defs = [];
    $hasId = isset($columns["id"]);
    foreach ($columns as $column => $v) {
        $type = infer_column_type($column);
        if ($column === "id") {
            $defs[] = "`id` BIGINT NOT NULL AUTO_INCREMENT";
        } else {
            $defs[] = "`" . $column . "` " . $type . " NULL";
        }
    }
    if ($hasId) {
        $defs[] = "PRIMARY KEY (`id`)";
    } else {
        $defs[] = "`_auto_id` BIGINT NOT NULL AUTO_INCREMENT";
        $defs[] = "PRIMARY KEY (`_auto_id`)";
    }
    $sql = "CREATE TABLE IF NOT EXISTS `" . $table . "` (" . implode(", ", $defs) . ") ENGINE=MyISAM DEFAULT CHARSET=utf8";
    return (bool) $conn->query($sql);
}

function extract_primary_table($sql)
{
    if (preg_match("/INSERT\\s+(?:IGNORE\\s+)?INTO\\s+`?([a-zA-Z0-9_]+)`?/i", $sql, $m)) {
        return $m[1];
    }
    if (preg_match("/UPDATE\\s+`?([a-zA-Z0-9_]+)`?/i", $sql, $m)) {
        return $m[1];
    }
    if (preg_match("/DELETE\\s+FROM\\s+`?([a-zA-Z0-9_]+)`?/i", $sql, $m)) {
        return $m[1];
    }
    if (preg_match("/ALTER\\s+TABLE\\s+`?([a-zA-Z0-9_]+)`?/i", $sql, $m)) {
        return $m[1];
    }
    return null;
}

function execute_sql_file($conn, $file, &$okCount, &$errCount)
{
    if (!is_file($file)) {
        return;
    }
    $content = file_get_contents($file);
    $statements = split_sql_statements($content);
    echo "Importando: " . basename($file) . " (" . count($statements) . " queries)<br>";
    foreach ($statements as $sql) {
        if (!$conn->query($sql)) {
            $error = $conn->error;
            $retried = false;
            if (stripos($error, "doesn't exist") !== false) {
                $table = extract_primary_table($sql);
                if ($table) {
                    ensure_table_exists($conn, $table, ["id" => true]);
                    $retried = true;
                }
            }
            if (preg_match("/Unknown column '([^']+)'/i", $error, $m)) {
                $table = extract_primary_table($sql);
                if ($table) {
                    $column = $m[1];
                    $conn->query("ALTER TABLE `" . $table . "` ADD COLUMN `" . $column . "` LONGTEXT NULL");
                    $retried = true;
                }
            }
            if ($retried && $conn->query($sql)) {
                $okCount++;
                continue;
            }
            if (stripos($error, "Duplicate entry") !== false) {
                $okCount++;
                echo "<span style='color:#d98c00'>Aviso (ignorado): " . htmlspecialchars($error, ENT_QUOTES, "UTF-8") . "</span><br>";
                continue;
            }
            $errCount++;
            echo "<span style='color:#d33'>Erro: " . htmlspecialchars($error, ENT_QUOTES, "UTF-8") . "</span><br>";
            continue;
        }
        $okCount++;
    }
}

$conn = new mysqli($db_host, $db_user, $db_pass);
if ($conn->connect_error) {
    die("<h2 style='color:#d33'>Falha na conexão: " . htmlspecialchars($conn->connect_error, ENT_QUOTES, "UTF-8") . "</h2>");
}

echo "<p>Conectado ao MySQL com sucesso.</p>";
$conn->query("CREATE DATABASE IF NOT EXISTS `" . $db_name . "`");
$conn->select_db($db_name);
$conn->query("SET NAMES utf8");
$conn->query("SET sql_mode=''");
$conn->query("SET FOREIGN_KEY_CHECKS=0");
echo "<p>Banco selecionado: " . htmlspecialchars($db_name, ENT_QUOTES, "UTF-8") . "</p>";

$sqlDirs = [
    __DIR__ . "/installer_/install/sql/data/",
    __DIR__ . "/installer_/old/install/sql/data/"
];

$sqlFiles = [];
foreach ($sqlDirs as $dir) {
    if (is_dir($dir)) {
        foreach (glob($dir . "*.sql") as $f) {
            $sqlFiles[basename($f)] = $f;
        }
    }
}

if (count($sqlFiles) === 0) {
    die("<h2 style='color:#d33'>Nenhum arquivo SQL encontrado em installer_/install/sql/data/</h2>");
}

echo "<p>Arquivos SQL encontrados: " . count($sqlFiles) . "</p>";

$extraFiles = [
    __DIR__ . "/installer_/old/install/sql_dump/decimal.sql",
    __DIR__ . "/installer_/old/install/sql_dump/sampledata.sql",
    __DIR__ . "/installer_/old/install/sql_dump/update_date_new.sql"
];

$allFilesForSchema = array_values($sqlFiles);
foreach ($extraFiles as $ef) {
    if (is_file($ef)) {
        $allFilesForSchema[] = $ef;
    }
}

$schemaMap = [];
foreach ($allFilesForSchema as $file) {
    $content = file_get_contents($file);
    collect_insert_schema($content, $schemaMap);
    collect_update_schema($content, $schemaMap);
    collect_table_refs($content, $schemaMap);
}

foreach ($schemaMap as $table => $columns) {
    ensure_table_exists($conn, $table, $columns);
}

$ok = 0;
$err = 0;
foreach ($sqlFiles as $file) {
    execute_sql_file($conn, $file, $ok, $err);
}

foreach ($extraFiles as $file) {
    execute_sql_file($conn, $file, $ok, $err);
}

$adminPass = md5(md5("admin") . "9486");
$conn->query("CREATE TABLE IF NOT EXISTS `tbl_admin` (`id` BIGINT NOT NULL AUTO_INCREMENT, `username` VARCHAR(255) NULL, `password` VARCHAR(255) NULL, `firstname` VARCHAR(255) NULL, `lastname` VARCHAR(255) NULL, `email` VARCHAR(255) NULL, `group_id` BIGINT NULL, `status` TINYINT NULL, `template` VARCHAR(255) NULL, `theme` VARCHAR(255) NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8");
$conn->query("INSERT INTO `tbl_admin` (`id`,`username`,`password`,`firstname`,`lastname`,`email`,`group_id`,`status`,`template`,`theme`) VALUES (1,'admin','" . $conn->real_escape_string($adminPass) . "','Admin','Admin','admin@admin.com',1,0,'default2','light') ON DUPLICATE KEY UPDATE `password`='" . $conn->real_escape_string($adminPass) . "'");

$tables = 0;
$r = $conn->query("SHOW TABLES");
if ($r) {
    $tables = $r->num_rows;
}

$conn->query("SET FOREIGN_KEY_CHECKS=1");
$conn->close();

echo "<h2>Finalizado</h2>";
echo "<p>Queries OK: " . $ok . "</p>";
echo "<p>Queries com erro: " . $err . "</p>";
echo "<p>Total de tabelas no banco: " . $tables . "</p>";
echo "<p>Admin: admin / admin</p>";
echo "<p>Se quiser instalação totalmente limpa do zero, apague o banco e rode este importador uma vez.</p>";
