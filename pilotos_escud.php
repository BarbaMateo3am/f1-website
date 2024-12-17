<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

include('includes/db.php');


$id_escud = $_GET['id_escud'];

$query = "
        SELECT pp.puntos_totales, pp.id_piloto, p.nombre, e.nombre_escud
        FROM  piloto_puntos pp
        JOIN pilotos p ON pp.id_piloto = p.id_piloto
        JOIN escuderias e ON pp.id_escud = e.id_escud
        WHERE pp.id_escud = $id_escud";


$result = $db->query($query);


// Obtener el nombre de la escudería
$nombre_escud = '';
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Tomar la primera fila
    $nombre_escud = $row['nombre_escud'];
    $result->data_seek(0); // Regresar el cursor al inicio para procesar los datos en la tabla
} else {
    die("No se encontraron pilotos para esta escudería.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pilotos</title>
    <link rel="stylesheet" href="styles-table.css">
</head>
<body>
    <h1>Pilotos de <?php echo htmlspecialchars($nombre_escud); ?></h1>
    <table>
        <thead>
            <tr>
                <th>Piloto</th>
                <th>Puntos</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['puntos_totales']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="javascript:window.history.back();" class="pagination-link">Volver</a>
</body>
</html>
