<?php
session_start();
require_once '../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    $contraseña = password_hash($contraseña, PASSWORD_DEFAULT); 

    try {
        $stmt = $pdo->prepare("SELECT MAX(`usuario`) FROM `usuarios` WHERE `usuario` = '".$usuario."'");
        $stmt->execute();
        $user = $stmt->fetchColumn();
        echo "<script>console.log(".$user.")</script>";

        if($user > 0){
            echo "<script>alert('Usuario repetido');
                        window.open('../registro.html','_self');
            </script>";
        }
        else{
            $stmt = $pdo->prepare("SELECT COUNT(`usuario`) FROM `usuarios`");
            $stmt->execute();
            $user = $stmt->fetchColumn();
            $user = $user+1;

            $stmt = $pdo->prepare("INSERT INTO `usuarios` VALUES('".$user."', '".$nombre."', '".$usuario."', '".$contraseña."')");
            $stmt->execute();
            echo "<script>alert('Registro realizado');
            window.open('../','_self');
                </script>";
        }

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>