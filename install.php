<!--
Nombre: Roberto López
Matricula: 2023-1793
-->

<?php
// Datos de conexión
$host = "localhost";
$user = "root";
$pass = "";
$puerto = 3307;
$dbname = "la_rubia";

// Conectar al servidor MySQL (sin seleccionar base de datos aún)
$conn = new mysqli($host, $user, $pass, "", $puerto);

// Verificar conexión
if ($conn->connect_error) {
    die("❌ Conexión fallida: " . $conn->connect_error);
}

// Crear la base de datos si no existe
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "✅ Base de datos '$dbname' creada o ya existente.<br>";
} else {
    die("❌ Error al crear la base de datos: " . $conn->error);
}

// Seleccionar la base de datos
$conn->select_db($dbname);

// Crear tabla de usuarios
$conn->query("CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    clave VARCHAR(255) NOT NULL
)");

// Insertar usuario demo si no existe
$result = $conn->query("SELECT * FROM usuarios WHERE usuario = 'demo'");
if ($result->num_rows === 0) {
    $claveHash = password_hash("tareafacil25", PASSWORD_DEFAULT);
    $conn->query("INSERT INTO usuarios (usuario, clave) VALUES ('demo', '$claveHash')");
    echo "✅ Usuario 'demo' insertado.<br>";
} else {
    echo "ℹ️ El usuario 'demo' ya existe.<br>";
}

// Crear tabla de facturas
$conn->query("CREATE TABLE IF NOT EXISTS facturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_recibo VARCHAR(20),
    fecha DATE,
    codigo_cliente VARCHAR(50),
    nombre_cliente VARCHAR(100),
    comentario TEXT,
    total DECIMAL(10,2)
)");


$conn->query("CREATE TABLE IF NOT EXISTS detalle_factura (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_factura INT,
    nombre_articulo VARCHAR(100),
    cantidad INT,
    precio_unitario DECIMAL(10,2),
    total_articulo DECIMAL(10,2),
    FOREIGN KEY (id_factura) REFERENCES facturas(id)
)");

echo "🎉 Instalación completada correctamente.";
$conn->close();
?>
