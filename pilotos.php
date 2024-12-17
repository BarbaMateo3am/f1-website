<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

include('includes/db.php');


$valid_columns = ['puntos_totales', 'podios'];
$sort_column = isset($_GET['sort']) && in_array($_GET['sort'], $valid_columns) ? $_GET['sort'] : 'puntos_totales';

$query = "
SELECT p.id_piloto, p.nombre, e.nombre_escud, pp.puntos_totales ,COUNT(CASE WHEN po.posicion IN (1, 2, 3) THEN 1 END) as 'podios', pp.id_escud
        FROM pilotos p
        JOIN piloto_puntos pp ON p.id_piloto = pp.id_piloto
        JOIN escuderias e ON pp.id_escud = e.id_escud
        JOIN posiciones_carrera po ON po.id_piloto = p.id_piloto
        GROUP BY po.id_piloto, e.nombre_escud
        ORDER BY $sort_column DESC
";

$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Escudería</title>
    <link rel="stylesheet" href="styles-table.css">
    <style>
        /* Intentamos mover esto al css pero por alguna razon no devolvia los colores */
        .top-1 { background-color:rgb(110, 233, 114); color: black; } 
        .top-2 { background-color:rgb(253, 212, 87); color: black; } 
        .top-3 { background-color:rgb(241, 93, 83); color: black; } 
    </style>
</head>
<body>
    <h1>Pilotos</h1>
    <table>
        <thead>
        <tr>
            <th>Piloto</th>
            <th>Escuderia</th>
            <th>
            <a href="?sort=puntos_totales">Puntos</a>
            </th>
            <th>
            <a href="?sort=podios">Podios</a>
            </th>
        </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                $class = '';
                if ($row['podios']>=10) {
                    $class = 'top-1';
                } elseif ($row['podios'] <10 && $row['podios']>=5) {
                    $class = 'top-2';
                } elseif ($row['podios']<5) {
                    $class = 'top-3';
                }
            ?>
                <tr class="<?php echo $class; ?>">
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><a href="pilotos_escud.php?id_escud=<?php echo $row['id_escud']; ?>"><?php echo htmlspecialchars($row['nombre_escud']); ?></a></td>
                    <td><?php echo $row['puntos_totales']; ?></td>
                    <td><?php echo $row['podios']; ?></td>
                </tr>
            <?php
        } ?>
        </tbody>

    </table>
    <p>+10 podios = Verde</p>
    <p>Entre 10 y 5 podios = Amarillo</p>
    <p>-5 podios= Rojo</p>
    <a href="index.php" class="pagination-link">Volver</a>
</body>
</html>