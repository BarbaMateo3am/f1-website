<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

include('includes/db.php');

// Obtener el id de la carrera desde la URL
$id_carrera = $_GET['id_carrera'];

// Realizamos la consulta con JOIN para obtener el nombre del piloto
$query = "
    SELECT pc.*, p.nombre, e.nombre_escud, c.nombre_carrera
    FROM posiciones_carrera pc
    JOIN pilotos p ON pc.id_piloto = p.id_piloto
    JOIN escuderias e ON pc.id_escud = e.id_escud
    JOIN carreras c ON pc.id_carrera = c.id_carrera
    WHERE pc.id_carrera = $id_carrera
    ORDER BY pc.posicion asc
";
$result = $db->query($query);

$nombre_carrera = '';
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre_carrera = $row['nombre_carrera'];
    $result->data_seek(0);
} else {
    echo "<p>Esta carrera no está disponible.</p>";
    exit; 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Posiciones de Carrera</title>
    <link rel="stylesheet" href="styles-table.css">
    <style>    
        .top-1 { background-color:rgb(110, 233, 114); color: black; } 
        .top-2 { background-color:rgb(253, 212, 87); color: black; } 
        .top-3 { background-color:rgb(241, 93, 83); color: black; } 
    </style>
</head>
<body>
    <h1>Posiciones de la carrera <?php echo htmlspecialchars($nombre_carrera); ?></h1>
    <table>
        <thead>
            <tr>
                <th>Posición</th>    
                <th>Nombre Piloto</th>
                <th>Escudería</th>
                <th>Tiempo</th>
                <th>Puntos</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rank = 1; // Controla el rango del piloto (1º, 2º, 3º...)
            while ($row = $result->fetch_assoc()) {
                // Determinar clase de estilo según el rango
                $class = '';
                if ($rank === 1) {
                    $class = 'top-1'; // Primer lugar
                } elseif ($rank === 2) {
                    $class = 'top-2'; // Segundo lugar
                } elseif ($rank === 3) {
                    $class = 'top-3'; // Tercer lugar
                }
            ?>
                <tr class="<?php echo $class; ?>">
                    <td><?php echo $row['posicion']; ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><a href="pilotos_escud.php?id_escud=<?php echo $row['id_escud']; ?>"><?php echo htmlspecialchars($row['nombre_escud']); ?></a></td>
                    <td><?php echo $row['tiempo']; ?></td>  
                    <td><?php echo $row['puntos_piloto']; ?></td>
                </tr>
            <?php
                $rank++; // Incrementar el rango después de cada piloto
            } ?>
        </tbody>
    </table>
    <p>Primer lugar = Verde</p>
    <p>Segundo lugar = Amarillo</p>
    <p>Tercer Lugar = Rojo</p>
    <a href="javascript:window.history.back();" class="pagination-link">Volver</a>
</body>
</html>
