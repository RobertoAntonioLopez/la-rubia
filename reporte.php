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

$hoy = date('Y-m-d');


$stmt = $conn->prepare("SELECT id, numero_recibo, fecha, nombre_cliente, total FROM facturas WHERE fecha = ?");
$stmt->bind_param("s", $hoy);
$stmt->execute();
$result = $stmt->get_result();

$facturas = [];
$total_del_dia = 0;
while ($row = $result->fetch_assoc()) {
    $facturas[] = $row;
    $total_del_dia += $row['total'];
}

$cantidad_facturas = count($facturas);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reporte Diario - La Rubia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #fdfdfd;
        }

        h2 {
            color: #2c3e50;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f0f0f0;
        }

        .stats {
            background-color: #ecf0f1;
            padding: 15px;
            border-radius: 10px;
            width: fit-content;
            margin-top: 10px;
        }

        .volver {
            margin-bottom: 15px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h2>📋 Reporte de ventas del día</h2>
    <p>Bienvenido, <?php echo $_SESSION['usuario']; ?> | <a href="logout.php">Cerrar sesión</a></p>
    <p class="volver"><a href="dashboard.php">← Volver a facturación</a></p>

    <div class="stats">
        <p><strong>Fecha:</strong> <?php echo date('d/m/Y'); ?></p>
        <p><strong>Total de facturas:</strong> <?php echo $cantidad_facturas; ?></p>
        <p><strong>Total cobrado:</strong> RD$<?php echo number_format($total_del_dia, 2); ?></p>
    </div>

    <?php if ($cantidad_facturas > 0): ?>
    <table>
        <tr>
            <th>Recibo</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Total</th>
        </tr>
        <?php foreach ($facturas as $fact): ?>
        <tr>
            <td><a href="ver_factura.php?id=<?php echo $fact['id']; ?>"><?php echo $fact['numero_recibo']; ?></a></td>
            <td><?php echo $fact['nombre_cliente']; ?></td>
            <td><?php echo date('d/m/Y', strtotime($fact['fecha'])); ?></td>
            <td>RD$<?php echo number_format($fact['total'], 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>No se han registrado facturas hoy.</p>
    <?php endif; ?>
</body>
</html>
