<?php
require '../includes/db.php';

$searchValue = isset($_GET['search']) ? $_GET['search'] : '';

// Consulta para la búsqueda
$sql = "SELECT * FROM medicos WHERE id LIKE ? OR cedula LIKE ? OR nombre LIKE ? OR apellido LIKE ?";
$stmt = $pdo->prepare($sql);
$searchParam = "%$searchValue%";
$stmt->execute([$searchParam, $searchParam, $searchParam, $searchParam]);

$medicos = $stmt->fetchAll();

// Generar la salida de la tabla
$output = '';
if (count($medicos) > 0) {
    foreach ($medicos as $medico) {
        $output .= '<tr>';
        $output .= '<td>' . $medico['id'] . '</td>';
        $output .= '<td>' . $medico['cedula'] . '</td>';
        $output .= '<td>' . $medico['nombre'] . '</td>';
        $output .= '<td>' . $medico['apellido'] . '</td>';
        $output .= '<td>' . $medico['estatus'] . '</td>';
        $output .= '<td>';
        $output .= '<a href="view_medico.php?id=' . $medico['id'] . '" class="btn btn-info btn-sm">Ver</a> ';
        $output .= '<a href="edit_medico.php?id=' . $medico['id'] . '" class="btn btn-primary btn-sm">Editar</a> ';
        $output .= '<a href="delete_medico.php?id=' . $medico['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de que quieres eliminar este médico?\')">Eliminar</a>';
        $output .= '</td>';
        $output .= '</tr>';
    }
} else {
    $output .= '<tr><td colspan="6">No se encontraron resultados</td></tr>';
}

echo $output;
?>
