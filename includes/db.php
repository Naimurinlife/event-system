<?php
// $host = 'sql300.infinityfree.com';
// $dbname = 'if0_38217120_event_system';
// $user = 'if0_38217120';
// $pass = 'gAiATm9z9jrnRf'; // Default XAMPP password is empty

$host = 'localhost';
$dbname = 'event_system';
$user = 'root';
$pass = ''; // Default XAMPP password is empty

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}
?>



