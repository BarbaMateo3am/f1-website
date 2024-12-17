<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'newf1web'; //CAMBIAR A F1WEB

$db = new mysqli($host, $user, $password, $dbname);

if ($db->connect_error) {
    die("Conexión fallida: " . $db->connect_error);
}
?>
