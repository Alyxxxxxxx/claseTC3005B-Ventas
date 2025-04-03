<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.html');
    exit;
}

require_once '../php/conexion.php';

$stmt = $pdo->query("SELECT * FROM productos");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Catálogo de Productos</h1>
    <a href="compras.php">Ver Compras</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acción</th>
        </tr>
        <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?= $producto['id'] ?></td>
            <td><?= htmlspecialchars($producto['nombre']) ?></td>
            <td><?= htmlspecialchars($producto['descripcion']) ?></td>
            <td>$<?= number_format($producto['precio'], 2) ?></td>
            <td><?= $producto['stock'] ?></td>
            <td>
                <form action="compras.php" method="POST">
                    <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                    <input type="number" name="cantidad" min="1" max="<?= $producto['stock'] ?>" value="1" required>
                    <button type="submit">Comprar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>