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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['fecha'];
    $codigo = $_POST['codigo_cliente'];
    $nombre = $_POST['nombre_cliente'];
    $comentario = $_POST['comentario'];
    $total = $_POST['total'];

    $numero = 'REC-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
    $stmt = $conn->prepare("INSERT INTO facturas (numero_recibo, fecha, codigo_cliente, nombre_cliente, comentario, total) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssd", $numero, $fecha, $codigo, $nombre, $comentario, $total);
    $stmt->execute();
    $id_factura = $stmt->insert_id;

    for ($i = 0; $i < count($_POST['articulo']); $i++) {
        $nombre_art = $_POST['articulo'][$i];
        $cantidad = $_POST['cantidad'][$i];
        $precio = $_POST['precio'][$i];
        $total_art = $cantidad * $precio;

        $stmt = $conn->prepare("INSERT INTO detalle_factura (id_factura, nombre_articulo, cantidad, precio_unitario, total_articulo) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isidd", $id_factura, $nombre_art, $cantidad, $precio, $total_art);
        $stmt->execute();
    }

    $mensaje = "✅ Factura guardada correctamente. Número: $numero";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Factura - La Rubia</title>
    <link rel="stylesheet" href="css/estilos.css">
    <script>
        function calcularTotal() {
            let total = 0;
            const cantidades = document.querySelectorAll(".cantidad");
            const precios = document.querySelectorAll(".precio");
            for (let i = 0; i < cantidades.length; i++) {
                const cant = parseFloat(cantidades[i].value) || 0;
                const precio = parseFloat(precios[i].value) || 0;
                total += cant * precio;
            }
            document.getElementById("total").value = total.toFixed(2);
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>🧾 Registrar nueva factura</h2>
        <p>Bienvenido, <strong><?php echo $_SESSION['usuario']; ?></strong> | <a href="logout.php">Cerrar sesión</a> | <a href="index.php">← Volver al menú</a></p>

        <?php if (isset($mensaje)) echo "<p style='color:green;'>$mensaje</p>"; ?>

        <form method="POST" oninput="calcularTotal()">
            <label>Fecha:</label>
            <input type="date" name="fecha" required><br>

            <label>Código Cliente:</label>
            <input type="text" name="codigo_cliente" required>

            <label>Nombre Cliente:</label>
            <input type="text" name="nombre_cliente" required><br>

            <h3>Artículos</h3>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                </tr>
                <?php for ($i = 0; $i < 3; $i++): ?>
                <tr>
                    <td><input type="text" name="articulo[]" required></td>
                    <td><input type="number" name="cantidad[]" class="cantidad" min="1" required></td>
                    <td><input type="number" name="precio[]" class="precio" step="0.01" min="0" required></td>
                </tr>
                <?php endfor; ?>
            </table><br>

            <label>Comentario:</label>
            <input type="text" name="comentario"><br>

            <label>Total a pagar:</label>
            <input type="text" name="total" id="total" readonly><br><br>

            <button type="submit" class="btn">💾 Guardar factura</button>
        </form>
    </div>
</body>
</html>
