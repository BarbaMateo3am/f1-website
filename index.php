<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" href="styles-index.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal - Formula 1</title>
</head>
<body>
<div id="navbar" class="navbar">
    <a href="carreras.php">Carreras</a>
    <a href="escuderia.php">Escuderías</a>
    <a href="pilotos.php">Pilotos</a>
    <a href="logout.php">Cerrar Sesión</a>
    <img src="design/pngwing.com.png" alt="Logo" class="navbar-logo">
</div>

<script>
    const navbar = document.getElementById('navbar');

    navbar.addEventListener('mouseenter', () => {
        navbar.classList.add('expanded');
    });

    navbar.addEventListener('mouseleave', () => {
        navbar.classList.remove('expanded');
    });
</script>


<div class="content">
    <h1>Bienvenido a la Página de Formula 1</h1>
</div>

</body>
</html>

