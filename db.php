<?php
$servername = "127.0.0.1";
$username = "c141_leen";
$password = "wb1201390";
$dbname = "c141footballhub";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "---";
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>
