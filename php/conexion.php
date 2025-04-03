<?php
$host = 'localhost';
$dbname = 'ventas_computacion';
$username = 'root'; // Cambia esto si usas otro usuario
$password = '';     // Cambia esto si tienes una contraseña

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>