<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Listado de Médicos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper" class="bg-light border-right">
            <div class="sidebar-heading">Menú </div>
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#downloadModal">Descargar Listado</a>
                <!-- Otros elementos del sidebar -->
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <h1 class="mt-4">Listado de Médicos</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($medicos as $medico): ?>
                        <tr>
                            <td><?= $medico['id'] ?></td>
                            <td><?= $medico['cedula'] ?></td>
                            <td><?= $medico['nombre'] ?></td>
                            <td><?= $medico['apellido'] ?></td>
                            <td><?= $medico['estatus'] ?></td>
                            <td>
                                <a href="view_medico.php?id=<?= $medico['id'] ?>" class="btn btn-info">Ver</a>
                                <a href="edit_medico.php?id=<?= $medico['id'] ?>" class="btn btn-primary">Editar</a>
                                <a href="delete_medico.php?id=<?= $medico['id'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este médico?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="create_medico.php" class="btn btn-success">Agregar Médico</a>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-labelledby="downloadModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="downloadModalLabel">Descargar Listado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="downloadForm" action="agremiados/download.php" method="get">
                        <p>Seleccione el formato de descarga:</p>
                        <button type="submit" name="format" value="excel" class="btn btn-success">Descargar en Excel</button>
                        <button type="submit" name="format" value="pdf" class="btn btn-danger">Descargar en PDF</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>
</html>
