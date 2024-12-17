<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

include('includes/db.php');

$query = "
SELECT p.pos_escud, e.nombre_escud, e.id_escud, p.puntos_escud
          FROM pos_escud p
          JOIN escuderias e ON p.id_escud = e.id_escud
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
        .top-1 { background-color:rgb(110, 233, 114); color: black; } 
        .top-2 { background-color:rgb(253, 212, 87); color: black; } 
        .top-3 { background-color:rgb(241, 93, 83); color: black; } 
    </style>
</head>
<body>
    <h1>Escudería</h1>
    <table>
        <thead>
            <tr>
                <th>Posición</th>
                <th>Escudería</th>
                <th>Puntos</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $rank = 1;
            while ($row = $result->fetch_assoc()) {
                $class = '';
                if ($rank === 1) {
                    $class = 'top-1';
                } elseif ($rank === 2) {
                    $class = 'top-2';
                } elseif ($rank === 3) {
                    $class = 'top-3'; //
                }
            ?>
                <tr class="<?php echo $class; ?>">
                    <td><?php echo htmlspecialchars($row['pos_escud']); ?></td>
                    <td><a href="pilotos_escud.php?id_escud=<?php echo $row['id_escud']; ?>"><?php echo htmlspecialchars($row['nombre_escud']); ?></a></td>
                    <td><?php echo $row['puntos_escud']; ?></td>
                </tr>
            <?php
                $rank++;
            } ?>
        </tbody>
    </table>
    <a href="javascript:window.history.back();" class="pagination-link">Volver</a>
</body>
</html>

