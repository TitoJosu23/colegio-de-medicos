<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$id = $_GET['id'];

// Obtener información del médico
$stmt = $pdo->prepare('SELECT * FROM medicos WHERE id = ?');
$stmt->execute([$id]);
$medico = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener información adicional
$stmt = $pdo->prepare('SELECT * FROM info WHERE id = ?');
$stmt->execute([$id]);
$info = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener información de pagos
$stmt = $pdo->prepare('SELECT * FROM pagos WHERE medico_id = ?');
$stmt->execute([$id]);
$pagos = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Médico</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            background-color: #bffffc !important;
            margin:0 auto;
            display: flex;
            min-height: 100vh;
        }
        #sidebar {
            width: 250px;
            background-color: #f8f9fa;
            flex-shrink: 0;
            padding: 15px;
        }
        #content {
            marging: 0 auto;
            width: 100%;
            padding: 20px;
            background-color: #bffffc;
        }
        .box{
            width: 400px;
            text-align: center;
            margin: 0 auto;
            margin-top: 10px;
            display:block; !important
        }
        .row{
            margin:0 auto;
            background-color:#white;
            border-style: solid;
            border-radius: 10px;
            width: 30%;
        }

    </style>
</head>
<body>
    <?php include '../includes/sidebar.php'; ?>
    <div id="content">
        <h1 class="text-center mt-5">Ver Médico</h1>
        <div class="row mt-4">
            <div class="box">
                <h2 class="mt-4"><u>Información Personal</u></h2>
                <p><strong>ID:</strong> <?= htmlspecialchars($medico['id']) ?></p>
                <p><strong>Cédula:</strong> <?= htmlspecialchars($medico['cedula']) ?></p>
                <p><strong>Nombre:</strong> <?= htmlspecialchars($medico['nombre']) ?></p>
                <p><strong>Apellido:</strong> <?= htmlspecialchars($medico['apellido']) ?></p>
                <p><strong>Estatus:</strong> <?= htmlspecialchars($medico['estatus']) ?></p>
            </div>
            <div class="right-row box">
                <h2><u>Información Adicional</u></h2>
                <?php if ($info) : ?>
                    <p><strong>Fecha de Nacimiento:</strong> <?= htmlspecialchars($info['fecha_nacimiento']) ?></p>
                    <p><strong>Fecha de Inscripción:</strong> <?= htmlspecialchars($info['fecha_inscripcion']) ?></p>
                    <p><strong>Matrícula MPPS:</strong> <?= htmlspecialchars($info['matricula_mpps']) ?></p>
                    <p><strong>Especialidad 1:</strong> <?= htmlspecialchars($info['especialidad_1']) ?></p>
                    <p><strong>Fecha Registro Especialidad 1:</strong> <?= htmlspecialchars($info['especialidad_1_fecha']) ?></p>
                    <p><strong>Número Especialidad 1:</strong> <?= htmlspecialchars($info['especialidad_1_numero']) ?></p>
                    <p><strong>Folio Especialidad 1:</strong> <?= htmlspecialchars($info['especialidad_1_folio']) ?></p>
                    <?php if ($info['especialidad_2']) : ?>
                        <p><strong>Especialidad 2:</strong> <?= htmlspecialchars($info['especialidad_2']) ?></p>
                        <p><strong>Fecha Registro Especialidad 2:</strong> <?= htmlspecialchars($info['especialidad_2_fecha']) ?></p>
                        <p><strong>Número Especialidad 2:</strong> <?= htmlspecialchars($info['especialidad_2_numero']) ?></p>
                        <p><strong>Folio Especialidad 2:</strong> <?= htmlspecialchars($info['especialidad_2_folio']) ?></p>
                    <?php endif; ?>
                <?php else : ?>
                    <p>No se encontró información adicional.</p>
                <?php endif; ?>
            </div>
            <div class="box">
                <h2><u>Pagos</u></h2>
                <?php if ($pagos) : ?>
                    <p><strong>Cuota Pagada de Colegio:</strong> <?= htmlspecialchars($pagos['cuota_colegio']) ?></p>
                    <p><strong>Cuota Pagada de FMV:</strong> <?= htmlspecialchars($pagos['cuota_fmv']) ?></p>
                    <p><strong>Pago de Montepío:</strong> <?= htmlspecialchars($pagos['pago_montepio']) ?></p>
                <?php else : ?>
                    <p>No se encontró información de pagos.</p>
                <?php endif; ?>
            </div>
        </div>
        
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>
</html>
