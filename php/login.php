<?php
session_start();
require_once '../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
        $stmt->execute(['usuario' => $usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($contraseña, $user['contraseña'])) {
            $_SESSION['usuario_id'] = $user['id'];
            header('Location: catalogo.php');
            exit;
        } else {
            echo "<script>alert('Usuario o contraseña incorrectos');</script>";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>