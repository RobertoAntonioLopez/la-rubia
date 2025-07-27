<!--
Nombre: Roberto López
Matricula: 2023-1793
-->

<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    $stmt = $conn->prepare("SELECT clave FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($clave_hash);
        $stmt->fetch();
        if (password_verify($clave, $clave_hash)) {
            $_SESSION['usuario'] = $usuario;
            header("Location: index.php");
            exit();
        } else {
            $error = "❌ Contraseña incorrecta.";
        }
    } else {
        $error = "❌ Usuario no encontrado.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - La Rubia</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="login-box">
        <h2>Iniciar sesión</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required><br>
            <input type="password" name="clave" placeholder="Contraseña" required><br>
            <button type="submit" class="btn">Ingresar</button>
        </form>
    </div>
</body>
</html>
