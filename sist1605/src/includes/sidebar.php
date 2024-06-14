<!-- sidebar.php -->
<div class="col-md-3 col-lg-2 d-md-block text-white sidebar">
    <div class="text-center mb-4">
        <a href="index.php">
            <img src="../img/logo.png" alt="Logo" class="img-fluid w-50">
        </a>
        <p class="mt-2">Colegio de Medicos del Estado Guarico</p>
    </div>
    <button class="dropdown-btn">Agremiados</button>
    <div class="dropdown-container">
        <a href="agremiados/members.php">Ver Listado</a>
        <?php if ($_SESSION['rol'] === 'admin'): ?>
            <a href="../agremiados/create_medico.php">Agregar Agremiado</a>
        <?php endif; ?>
        <a href="agremiados/download.php" data-toggle="modal" data-target="#downloadModal">Descargar Listado</a>
    </div>
    <?php if ($_SESSION['rol'] === 'admin'): ?>
        <a href="users/admin/users.php">Usuarios</a>
    <?php endif; ?>
    <a href="profile.php">Mi Perfil</a>
    <a href="logout.php">Cerrar Sesión</a>
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

<style>
    .sidebar {
        background-color:#000020;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 20px;
        width: 250px;
    }
    .sidebar a {
        color: white;
        text-decoration: none;
        display: block;
        padding: 10px 15px;
    }
    .sidebar a:hover {
        background-color: #00509e;
    }
    .sidebar .dropdown-btn {
        background: none;
        border: none;
        color: white;
        text-align: left;
        width: 100%;
        padding: 10px 15px;
        font-size: 16px;
        cursor: pointer;
    }
    .sidebar .dropdown-container {
        display: none;
        padding-left: 15px;
    }
    .sidebar .dropdown-container a {
        padding: 10px 15px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dropdownBtns = document.querySelectorAll('.dropdown-btn');
        dropdownBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === 'block') {
                    dropdownContent.style.display = 'none';
                } else {
                    dropdownContent.style.display = 'block';
                }
            });
        });
    });
</script>
