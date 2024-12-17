<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

include('includes/db.php');

// Obtener los resultados de la tabla pos_escud y los nombres de las escuderías
$query = "
        SELECT c.nombre_carrera, p.nombre, e.nombre_escud, g.tiempo
        FROM ganador_carrera g
        JOIN pilotos p ON g.id_piloto = p.id_piloto
        JOIN escuderias e ON g.id_escud = e.id_escud 
        JOIN carreras c ON g.id_carrera = c.id_carrera
";

$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Escudería</title>
    <link rel="stylesheet" href="styles-table.css">
</head>
<body>
    <h1>Ganadores por carrera</h1>
    <table>
        <thead>
            <tr>
                <th>Carrera</th>
                <th>Piloto</th>
                <th>Escuderia</th>
                <th>Tiempo</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['nombre_carrera']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['nombre_escud']; ?></td>
                    <td><?php echo $row['tiempo']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="javascript:window.history.back();" class="pagination-link">Volver</a>
</body>
</html>