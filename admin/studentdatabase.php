<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "bsit_portaldb";

try {
    $conn = mysqli_connect($host, $user, $pass, $db);
} 
catch (mysqli_sql_exception $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>