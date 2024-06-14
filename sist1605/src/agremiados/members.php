<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Parámetros para ordenar
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$order = isset($_GET['order']) && $_GET['order'] === 'asc' ? 'asc' : 'desc';

// Inicializar la variable $medicos
$medicos = [];

// Definir la consulta SQL con orden dinámico
$sql = "SELECT * FROM medicos ORDER BY $sort $order";

// Realizar la consulta y obtener los resultados
$stmt = $pdo->query($sql);
$medicos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Listado de Médicos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            margin-top: 3% !important;
            width: 70%;
            margin: 0 auto;
            display: flex;
        }
        .sidebar {
            width: 250px;
            flex-shrink: 0;
            background-color: #f8f9fa;
            height: 100vh;
            position: fixed;
        }
        .content {
            margin-left: 250px;
            flex-grow: 1;
            padding: 20px;
        }
        #searchForm{
            width: 50%;
            margin-left:50%;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content {
                margin-left: 0;
            }
        }
        .sort-icons {
            display: inline-block;
            width: 20px;
            text-align: center;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    <div class="content">
        <h1>Listado de Médicos</h1>
        <form id="searchForm">
            <div class="input-group mb-3">
                <input type="text" id="search" name="search" class="form-control" placeholder="Buscar por ID, nombre, apellido o cédula">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            ID
                            <span class="sort-icons">
                                <a href="?sort=id&order=asc">&#9650;</a>
                                <a href="?sort=id&order=desc">&#9660;</a>
                            </span>
                        </th>
                        <th>
                            Cédula
                            <span class="sort-icons">
                                <a href="?sort=cedula&order=asc">&#9650;</a>
                                <a href="?sort=cedula&order=desc">&#9660;</a>
                            </span>
                        </th>
                        <th>
                            Nombre
                            <span class="sort-icons">
                                <a href="?sort=nombre&order=asc">&#9650;</a>
                                <a href="?sort=nombre&order=desc">&#9660;</a>
                            </span>
                        </th>
                        <th>
                            Apellido
                            <span class="sort-icons">
                                <a href="?sort=apellido&order=asc">&#9650;</a>
                                <a href="?sort=apellido&order=desc">&#9660;</a>
                            </span>
                        </th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="medicosTable">
                    <?php foreach ($medicos as $medico): ?>
                    <tr>
                        <td><?= $medico['id'] ?></td>
                        <td><?= $medico['cedula'] ?></td>
                        <td><?= $medico['nombre'] ?></td>
                        <td><?= $medico['apellido'] ?></td>
                        <td><?= $medico['estatus'] ?></td>
                        <td>
                            <a href="view_medico.php?id=<?= $medico['id'] ?>" class="btn btn-info btn-sm">Ver</a>
                            <?php if ($_SESSION['rol'] === 'admin'): ?>
                                <a href="edit_medico.php?id=<?= $medico['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                            <?php endif; ?>
                            <?php if ($_SESSION['rol'] === 'admin'): ?>
                                <a href="delete_medico.php?id=<?= $medico['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este médico?')">Eliminar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if ($_SESSION['rol'] === 'admin'): ?>
            <a href="create_medico.php" class="btn btn-success">Agregar Médico</a>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#searchForm').on('submit', function(event) {
            event.preventDefault();
            var searchValue = $('#search').val();
            $.ajax({
                url: 'search_medicos.php',
                type: 'GET',
                data: { search: searchValue },
                success: function(response) {
                    $('#medicosTable').html(response);
                    if ($('#medicosTable').find('tr').length === 0) {
                        $('#medicosTable').html('<tr><td colspan="6">No se encontraron resultados</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
    </script>
</body>
</html>
