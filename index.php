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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - La Rubia</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>🛒 Sistema de Ventas - La Rubia</h2>
        <p>Bienvenido, <strong><?php echo $_SESSION['usuario']; ?></strong> 👋</p>

        <div class="menu">
            <a href="dashboard.php" class="btn">➕ Registrar nueva factura</a>
            <a href="reporte.php" class="btn">📋 Ver reporte del día</a>
            <a href="logout.php" class="btn red">🚪 Cerrar sesión</a>
        </div>
    </div>
</body>
</html>
