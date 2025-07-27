<!--
Nombre: Roberto López
Matricula: 2023-1793
-->
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

if (!isset($_GET['id'])) {
    die("Factura no especificada.");
}

$id = $_GET['id'];

// Obtener datos de la factura
$stmt = $conn->prepare("SELECT * FROM facturas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$factura = $result->fetch_assoc();

if (!$factura) {
    die("Factura no encontrada.");
}

// Obtener los artículos
$stmt = $conn->prepare("SELECT * FROM detalle_factura WHERE id_factura = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$articulos = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura <?php echo $factura['numero_recibo']; ?> - La Rubia</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .recibo {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
            font-family: monospace;
        }

        .recibo h2, .recibo h3 {
            text-align: center;
            margin: 0;
        }

        .recibo table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }

        .recibo table, .recibo td, .recibo th {
            border: 1px solid #ccc;
        }

        .recibo td, .recibo th {
            padding: 5px;
            text-align: left;
        }

        .print-btn {
            text-align: center;
            margin-top: 20px;
        }

        @media print {
            .print-btn, .volver {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="recibo">
        <h2>La Rubia</h2>
        <h3>Factura Nº <?php echo $factura['numero_recibo']; ?></h3>
        <p><strong>Fecha:</strong> <?php echo $factura['fecha']; ?><br>
        <strong>Cliente:</strong> <?php echo $factura['nombre_cliente']; ?> (<?php echo $factura['codigo_cliente']; ?>)<br>
        <strong>Comentario:</strong> <?php echo $factura['comentario']; ?></p>

        <table>
            <tr>
                <th>Artículo</th>
                <th>Cant.</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
            <?php while ($row = $articulos->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['nombre_articulo']; ?></td>
                <td><?php echo $row['cantidad']; ?></td>
                <td>RD$<?php echo number_format($row['precio_unitario'], 2); ?></td>
                <td>RD$<?php echo number_format($row['total_articulo'], 2); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <p><strong>Total a pagar:</strong> RD$<?php echo number_format($factura['total'], 2); ?></p>
    </div>

    <div class="print-btn">
        <button onclick="window.print()" class="btn">🖨️ Imprimir recibo</button>
    </div>

    <p class="volver" style="text-align:center; margin-top:10px;">
        <a href="reporte.php">← Volver al reporte</a>
    </p>
</body>
</html>
