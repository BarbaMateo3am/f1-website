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
        /* Colores para la semaforización */
        /* Intentamos mover esto al css pero por alguna razon no devolvia los colores */
        .top-1 { background-color: #4CAF50; color: white; } /* Verde */
        .top-2 { background-color: #FFC107; color: black; } /* Amarillo */
        .top-3 { background-color: #F44336; color: white; } /* Rojo */
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

