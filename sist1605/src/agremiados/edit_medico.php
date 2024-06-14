<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $estatus = $_POST['estatus'];
    $fecha_nacimiento = !empty($_POST['fecha_nacimiento']) ? date('Y-m-d', strtotime($_POST['fecha_nacimiento'])) : NULL;
    $fecha_inscripcion = !empty($_POST['fecha_inscripcion']) ? date('Y-m-d', strtotime($_POST['fecha_inscripcion'])) : NULL;
    $matricula_mpps = $_POST['matricula_mpps'];
    $especialidad_1 = $_POST['especialidad_1'];
    $especialidad_1_fecha = !empty($_POST['especialidad_1_fecha']) ? date('Y-m-d', strtotime($_POST['especialidad_1_fecha'])) : NULL;
    $especialidad_1_numero = $_POST['especialidad_1_numero'];
    $especialidad_1_folio = $_POST['especialidad_1_folio'];
    $especialidad_2 = $_POST['especialidad_2'];
    $especialidad_2_fecha = !empty($_POST['especialidad_2_fecha']) ? date('Y-m-d', strtotime($_POST['especialidad_2_fecha'])) : NULL;
    $especialidad_2_numero = $_POST['especialidad_2_numero'];
    $especialidad_2_folio = $_POST['especialidad_2_folio'];
    $cuota_colegio = $_POST['cuota_colegio'];
    $cuota_fmv = $_POST['cuota_fmv'];
    $pago_montepio = $_POST['pago_montepio'];

    $stmt = $pdo->prepare('UPDATE medicos SET cedula = ?, nombre = ?, apellido = ?, estatus = ? WHERE id = ?');
    $stmt->execute([$cedula, $nombre, $apellido, $estatus, $id]);

    $stmt = $pdo->prepare('UPDATE info SET fecha_nacimiento = ?, fecha_inscripcion = ?, matricula_mpps = ?, especialidad_1 = ?, especialidad_1_fecha = ?, especialidad_1_numero = ?, especialidad_1_folio = ?, especialidad_2 = ?, especialidad_2_fecha = ?, especialidad_2_numero = ?, especialidad_2_folio = ? WHERE medico_id = ?');
    $stmt->execute([$fecha_nacimiento, $fecha_inscripcion, $matricula_mpps, $especialidad_1, $especialidad_1_fecha, $especialidad_1_numero, $especialidad_1_folio, $especialidad_2, $especialidad_2_fecha, $especialidad_2_numero, $especialidad_2_folio, $id]);

    $stmt = $pdo->prepare('UPDATE pagos SET cuota_colegio = ?, cuota_fmv = ?, pago_montepio = ? WHERE medico_id = ?');
    $stmt->execute([$cuota_colegio, $cuota_fmv, $pago_montepio, $id]);

    header('Location: members.php');
    exit();
}

$stmt = $pdo->prepare('SELECT * FROM medicos WHERE id = ?');
$stmt->execute([$id]);
$medico = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT * FROM info WHERE medico_id = ?');
$stmt->execute([$id]);
$info = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT * FROM pagos WHERE medico_id = ?');
$stmt->execute([$id]);
$pagos = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Médico</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
        }
        #sidebar {
            width: 250px;
            background-color: #f8f9fa;
            flex-shrink: 0;
            padding: 15px;
        }
        #content {
            flex-grow: 1;
            padding: 20px;
            background-color: #fff;
        }
    </style>
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    <div class="container">
        <h1>Editar Médico</h1>
        <form method="post" action="edit_medico.php?id=<?= $id ?>">
            <input type="hidden" name="id" value="<?= $medico['id'] ?>">
            <div class="form-group">
                <label for="cedula">Cédula</label>
                <input type="text" class="form-control" id="cedula" name="cedula" value="<?= htmlspecialchars($medico['cedula']) ?>" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($medico['nombre']) ?>" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?= htmlspecialchars($medico['apellido']) ?>" required>
            </div>
            <div class="form-group">
                <label for="estatus">Estatus</label>
                <select class="form-control" id="estatus" name="estatus" required>
                    <option value="Definitivo" <?= $medico['estatus'] == 'Definitivo' ? 'selected' : '' ?>>Definitivo</option>
                    <option value="Provisional" <?= $medico['estatus'] == 'Provisional' ? 'selected' : '' ?>>Provisional</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= htmlspecialchars($info['fecha_nacimiento'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="fecha_inscripcion">Fecha de Inscripción</label>
                <input type="date" class="form-control" id="fecha_inscripcion" name="fecha_inscripcion" value="<?= htmlspecialchars($info['fecha_inscripcion'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="matricula_mpps">Matrícula MPPS</label>
                <input type="text" class="form-control" id="matricula_mpps" name="matricula_mpps" value="<?= htmlspecialchars($info['matricula_mpps'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="especialidad_1">Especialidad 1</label>
                <input type="text" class="form-control" id="especialidad_1" name="especialidad_1" value="<?= htmlspecialchars($info['especialidad_1'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="especialidad_1_fecha">Fecha Registro Especialidad 1</label>
                <input type="date" class="form-control" id="especialidad_1_fecha" name="especialidad_1_fecha" value="<?= htmlspecialchars($info['especialidad_1_fecha'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="especialidad_1_numero">Número Especialidad 1</label>
                <input type="text" class="form-control" id="especialidad_1_numero" name="especialidad_1_numero" value="<?= htmlspecialchars($info['especialidad_1_numero'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="especialidad_1_folio">Folio Especialidad 1</label>
                <input type="text" class="form-control" id="especialidad_1_folio" name="especialidad_1_folio" value="<?= htmlspecialchars($info['especialidad_1_folio'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="especialidad_2">Especialidad 2</label>
                <input type="text" class="form-control" id="especialidad_2" name="especialidad_2" value="<?= htmlspecialchars($info['especialidad_2'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="especialidad_2_fecha">Fecha Registro Especialidad 2</label>
                <input type="date" class="form-control" id="especialidad_2_fecha" name="especialidad_2_fecha" value="<?= htmlspecialchars($info['especialidad_2_fecha'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="especialidad_2_numero">Número Especialidad 2</label>
                <input type="text" class="form-control" id="especialidad_2_numero" name="especialidad_2_numero" value="<?= htmlspecialchars($info['especialidad_2_numero'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="especialidad_2_folio">Folio Especialidad 2</label>
                <input type="text" class="form-control" id="especialidad_2_folio" name="especialidad_2_folio" value="<?= htmlspecialchars($info['especialidad_2_folio'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="cuota_colegio">Cuota Colegio</label>
                <input type="text" class="form-control" id="cuota_colegio" name="cuota_colegio" value="<?= htmlspecialchars($pagos['cuota_colegio'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="cuota_fmv">Cuota FMV</label>
                <input type="text" class="form-control" id="cuota_fmv" name="cuota_fmv" value="<?= htmlspecialchars($pagos['cuota_fmv'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="pago_montepio">Pago Montepío</label>
                <input type="text" class="form-control" id="pago_montepio" name="pago_montepio" value="<?= htmlspecialchars($pagos['pago_montepio'] ?? '') ?>">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
