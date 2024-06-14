<?php
// Iniciar la sesión si aún no se ha iniciado
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si se recibieron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo para procesar el formulario
    include_once '../includes/procesar_form.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crear Médico</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="../assets/css/create_medico.css">
    <style>
        body {
            display: flex;
        }
        #sidebar {
            width: 250px;
        }
        #content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    <div id="content">
        <h1 class='text-center'>Crear Médico</h1>
        <form method="post" action="">
            <!-- Sección de Información General -->
            <div class="section">
                <h3>Información General</h3>
                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text" class="form-control" id="id" name="id" required>
                </div>
                <div class="form-group">
                    <label for="cedula">Cédula</label>
                    <input type="text" class="form-control" id="cedula" name="cedula" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                </div>
                <div class="form-group">
                    <label for="estatus">Estatus</label>
                    <select class="form-control" id="estatus" name="estatus" required>
                        <option value="Definitivo">Definitivo</option>
                        <option value="Provisional">Provisional</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <input type="text" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                </div>
                <div class="form-group">
                    <label for="fecha_inscripcion">Fecha de Inscripción</label>
                    <input type="text" class="form-control" id="fecha_inscripcion" name="fecha_inscripcion" required>
                </div>
                <div class="form-group">
                    <label for="matricula_mpps">Matrícula MPPS</label>
                    <input type="text" class="form-control" id="matricula_mpps" name="matricula_mpps">
                </div>
            </div>
            <!-- Botones para abrir las secciones de Especialidad y Pagos -->
            <div class="form-group">
                <label>Haga clic en una palabra para añadir detalles:</label><br>
                <span class="btn btn-link" id="btnEspecialidad">Especialidad</span><br>
                <span class="btn btn-link" id="btnPagos">Pagos</span>
            </div>
            <!-- Sección de Especialidad (inicialmente oculta) -->
            <div class="section" id="seccionEspecialidad" style="display: none;">
                <h3>Especialidad(es)</h3>
                <div class="form-group">
                    <label for="especialidad_1">Especialidad 1</label>
                    <input type="text" class="form-control" id="especialidad_1" name="especialidad_1">
                </div>
                <div class="form-group">
                    <label for="especialidad_1_fecha">Fecha Registro Especialidad 1</label>
                    <input type="text" class="form-control" id="especialidad_1_fecha" name="especialidad_1_fecha">
                </div>
                <div class="form-group">
                    <label for="especialidad_1_numero">Número Especialidad 1</label>
                    <input type="text" class="form-control" id="especialidad_1_numero" name="especialidad_1_numero">
                </div>
                <div class="form-group">
                    <label for="especialidad_1_folio">Folio Especialidad 1</label>
                    <input type="text" class="form-control" id="especialidad_1_folio" name="especialidad_1_folio">
                </div>
                <div class="form-group">
                    <label for="especialidad_2">Especialidad 2</label>
                    <input type="text" class="form-control" id="especialidad_2" name="especialidad_2">
                </div>
                <div class="form-group">
                    <label for="especialidad_2_fecha">Fecha Registro Especialidad 2</label>
                    <input type="text" class="form-control" id="especialidad_2_fecha" name="especialidad_2_fecha">
                </div>
                <div class="form-group">
                    <label for="especialidad_2_numero">Número Especialidad 2</label>
                    <input type="text" class="form-control" id="especialidad_2_numero" name="especialidad_2_numero">
                </div>
                <div class="form-group">
                    <label for="especialidad_2_folio">Folio Especialidad 2</label>
                    <input type="text" class="form-control" id="especialidad_2_folio" name="especialidad_2_folio">
                </div>
            </div>
            <!-- Sección de Pagos (inicialmente oculta) -->
            <div class="section" id="seccionPagos" style="display: none;">
                <h3>Pagos</h3>
                <div class="form-group">
                    <label for="cuota_colegio">Cuota Pagada de Colegio</label>
                    <input type="text" class="form-control" id="cuota_colegio" name="cuota_colegio">
                </div>
                <div class="form-group">
                    <label for="cuota_fmv">Cuota Pagada de FMV</label>
                    <input type="text" class="form-control" id="cuota_fmv" name="cuota_fmv">
                </div>
                <div class="form-group">
                    <label for="pago_montepio">Pago de Montepío</label>
                    <input type="text" class="form-control" id="pago_montepio" name="pago_montepio">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function(){
            // Configurar el selector de fecha de nacimiento
            $("#fecha_nacimiento").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0"
            });

            // Configurar el selector de fecha de inscripción
            $("#fecha_inscripcion").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0"
            });

            // Configurar el selector de fecha de especialidad 1
            $("#especialidad_1_fecha").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0"
            });

            // Configurar el selector de fecha de especialidad 2
            $("#especialidad_2_fecha").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0"
            });
        });

        $(document).ready(function(){
            $("#btnEspecialidad").click(function(){
                $("#seccionEspecialidad").toggle();
            });

            $("#btnPagos").click(function(){
                $("#seccionPagos").toggle();
            });
        });
    </script>
</body>
</html>
