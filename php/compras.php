<?php
session_start();
require_once '../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];
    $usuario_id = $_SESSION['usuario_id'];

    try {
        // Verificar stock
        $stmt = $pdo->prepare("SELECT stock FROM productos WHERE id = :id");
        $stmt->execute(['id' => $producto_id]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($producto['stock'] >= $cantidad) {
            // Registrar compra
            $insert = $pdo->prepare("INSERT INTO compras (id_usuario, id_producto, cantidad) VALUES (:id_usuario, :id_producto, :cantidad)");
            $insert->execute([
                'id_usuario' => $usuario_id,
                'id_producto' => $producto_id,
                'cantidad' => $cantidad
            ]);

            // Actualizar stock
            $update = $pdo->prepare("UPDATE productos SET stock = stock - :cantidad WHERE id = :id");
            $update->execute(['cantidad' => $cantidad, 'id' => $producto_id]);

            echo "<script>alert('Compra realizada exitosamente');</script>";
        } else {
            echo "<script>alert('No hay suficiente stock disponible');</script>";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

// Mostrar compras del usuario
$stmt = $pdo->prepare("SELECT c.id, p.nombre, c.cantidad, c.fecha_compra FROM compras c JOIN productos p ON c.id_producto = p.id WHERE c.id_usuario = :id_usuario");
$stmt->execute(['id_usuario' => $usuario_id]);
$compras = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Compras</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Mis Compras</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Fecha</th>
        </tr>
        <?php foreach ($compras as $compra): ?>
        <tr>
            <td><?= $compra['id'] ?></td>
            <td><?= htmlspecialchars($compra['nombre']) ?></td>
            <td><?= $compra['cantidad'] ?></td>
            <td><?= $compra['fecha_compra'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="catalogo.php">Volver al Catálogo</a>
</body>
</html>