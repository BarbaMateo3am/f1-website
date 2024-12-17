<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

include('includes/db.php');

// Definir cuántas carreras mostrar por página
$carreras_por_pagina = 12;

// Obtener el número total de carreras
$query_total = "SELECT COUNT(*) as total FROM carreras";
$result_total = $db->query($query_total);
$row_total = $result_total->fetch_assoc();
$total_carreras = $row_total['total'];

// Calcular el número total de páginas
$total_paginas = ceil($total_carreras / $carreras_por_pagina);

// Obtener la página actual (por defecto será la página 1)
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Asegurarse de que la página actual esté dentro del rango válido
if ($pagina_actual < 1) {
    $pagina_actual = 1;
} elseif ($pagina_actual > $total_paginas) {
    $pagina_actual = $total_paginas;
}

// Calcular el índice de inicio para la consulta SQL
$inicio = ($pagina_actual - 1) * $carreras_por_pagina;

// Obtener las carreras para la página actual
$query = "SELECT * FROM carreras LIMIT $inicio, $carreras_por_pagina";
$result = $db->query($query);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carreras</title>
    <link rel="stylesheet" href="styles-table.css">
</head>

<body>
    <div class="container">
        <h1>Carreras</h1>
        <table>
            <thead>
                <tr>
                    <th>Nro Carrera</th>
                    <th>Nombre Carrera</th>
                    <th>País</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id_carrera']; ?></td>
                        <td><a href="posiciones.php?id_carrera=<?php echo $row['id_carrera']; ?>"><?php echo $row['nombre_carrera']; ?></a></td>
                        <td><?php echo $row['pais']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="pagination">
            <!-- Flecha "Anterior" -->
            <a href="carreras.php?pagina=<?php echo max(1, $pagina_actual - 1); ?>" class="pagination-link">&#8592; Anterior</a>
            
            <!-- Mostrar las páginas -->
            <span>Página <?php echo $pagina_actual; ?> de <?php echo $total_paginas; ?></span>

            <!-- Flecha "Siguiente" -->
            <a href="carreras.php?pagina=<?php echo min($total_paginas, $pagina_actual + 1); ?>" class="pagination-link">Siguiente &#8594;</a>

            <!-- Botón "Ver ganadores por carrera" -->
            <a href="ganadores_carrera.php" class="pagination-link right-button">Ver ganadores por carrera</a>
        </div>
        <a href="index.php" class="pagination-link">Volver</a>
    </div>
</body>
</html>

