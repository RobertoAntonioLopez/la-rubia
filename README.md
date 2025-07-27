nombre: Sistema de Ventas - La Rubia
descripcion: >
  Sistema web sencillo para registrar facturas y generar reportes diarios. Desarrollado para una tarea académica en ITLA.

autor:
    nombre: Roberto García
    carrera: Ingeniería en Software
    institucion: ITLA
    Matricula:2023-1793

funcionalidades:
  - Inicio de sesión seguro (usuario por defecto: demo, clave: tareafacil25)
  - Registro de facturas con cliente, artículos, comentarios y total
  - Visualización e impresión de facturas
  - Reporte diario de ventas: cantidad de facturas y monto total
  - Estilo moderno, limpio y fácil de usar

estructura:
  raiz: Tarea8/
  archivos:
    - css/estilos.css
    - conexion.php
    - install.php
    - index.php
    - login.php
    - logout.php
    - dashboard.php
    - reporte.php
    - ver_factura.php
    - README.md

instalacion:
  pasos:
    - Clonar o descargar el repositorio
    - Mover carpeta a htdocs (ej: C:\xampp\htdocs\Tarea8\)
    - Ejecutar install.php desde el navegador (http://localhost/Tarea8/install.php)
    - Iniciar sesión con usuario demo
    - Usar las funcionalidades desde index.php

usuario_demo:
  usuario: demo
  clave: tareafacil25

navegacion:
  - index.php: menú principal
  - dashboard.php: registrar nueva factura
  - reporte.php: ver reporte diario
  - ver_factura.php?id=ID: ver/imprimir factura específica

tecnologias:
  - PHP
  - MySQL
  - HTML5
  - CSS3
  - JavaScript básico

licencia: Proyecto académico – uso educativo únicamente.
