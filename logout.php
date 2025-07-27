<!--
Nombre: Roberto López
Matricula: 2023-1793
-->

<?php
session_start();
session_destroy();
header("Location: login.php");
exit();
?>
