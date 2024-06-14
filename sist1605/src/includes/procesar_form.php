<?php
session_start();
require '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $id = $_POST['id'];
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $estatus = $_POST['estatus'];
    
    // Convertir las fechas al formato adecuado (YYYY-MM-DD) antes de almacenarlas en la base de datos
    $fecha_nacimiento = DateTime::createFromFormat('d/m/Y', $_POST['fecha_nacimiento'])->format('Y-m-d');
    $fecha_inscripcion = DateTime::createFromFormat('d/m/Y', $_POST['fecha_inscripcion'])->format('Y-m-d');
    $especialidad_1_fecha = !empty($_POST['especialidad_1_fecha']) ? DateTime::createFromFormat('d/m/Y', $_POST['especialidad_1_fecha'])->format('Y-m-d') : null;
    $especialidad_2_fecha = !empty($_POST['especialidad_2_fecha']) ? DateTime::createFromFormat('d/m/Y', $_POST['especialidad_2_fecha'])->format('Y-m-d') : null;

    $matricula_mpps = $_POST['matricula_mpps'];
    $especialidad_1 = $_POST['especialidad_1'];
    $especialidad_1_numero = $_POST['especialidad_1_numero'];
    $especialidad_1_folio = $_POST['especialidad_1_folio'];
    $especialidad_2 = $_POST['especialidad_2'];
    $especialidad_2_numero = $_POST['especialidad_2_numero'];
    $especialidad_2_folio = $_POST['especialidad_2_folio'];
    $cuota_colegio = $_POST['cuota_colegio'];
    $cuota_fmv = $_POST['cuota_fmv'];
    $pago_montepio = $_POST['pago_montepio'];

    // Validar los datos recibidos (puedes agregar más validaciones según tus necesidades)

    // Insertar o actualizar los datos en la tabla 'medicos'
    $stmt_medicos = $pdo->prepare('INSERT INTO medicos (id, cedula, nombre, apellido, estatus) VALUES (?, ?, ?, ?, ?)
                                   ON DUPLICATE KEY UPDATE cedula = VALUES(cedula), nombre = VALUES(nombre), apellido = VALUES(apellido), estatus = VALUES(estatus)');
    $stmt_medicos->execute([$id, $cedula, $nombre, $apellido, $estatus]);

    // Verificar si ya existe un registro en la tabla 'info'
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM info WHERE id = ?');
    $stmt->execute([$id]);
    $exists_info = $stmt->fetchColumn();

    if ($exists_info) {
        // Actualizar el registro existente en la tabla 'info'
        $stmt_info = $pdo->prepare('UPDATE info SET fecha_nacimiento = ?, fecha_inscripcion = ?, matricula_mpps = ?, especialidad_1 = ?, especialidad_1_fecha = ?, especialidad_1_numero = ?, especialidad_1_folio = ?, especialidad_2 = ?, especialidad_2_fecha = ?, especialidad_2_numero = ?, especialidad_2_folio = ? WHERE id = ?');
        $stmt_info->execute([$fecha_nacimiento, $fecha_inscripcion, $matricula_mpps, $especialidad_1, $especialidad_1_fecha, $especialidad_1_numero, $especialidad_1_folio, $especialidad_2, $especialidad_2_fecha, $especialidad_2_numero, $especialidad_2_folio, $id]);
    } else {
        // Insertar los datos en la tabla 'info'
        $stmt_info = $pdo->prepare('INSERT INTO info (id, fecha_nacimiento, fecha_inscripcion, matricula_mpps, especialidad_1, especialidad_1_fecha, especialidad_1_numero, especialidad_1_folio, especialidad_2, especialidad_2_fecha, especialidad_2_numero, especialidad_2_folio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt_info->execute([$id, $fecha_nacimiento, $fecha_inscripcion, $matricula_mpps, $especialidad_1, $especialidad_1_fecha, $especialidad_1_numero, $especialidad_1_folio, $especialidad_2, $especialidad_2_fecha, $especialidad_2_numero, $especialidad_2_folio]);
    }

    // Verificar si ya existe un registro en la tabla 'pagos'
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM pagos WHERE medico_id = ?');
    $stmt->execute([$id]);
    $exists_pagos = $stmt->fetchColumn();

    if ($exists_pagos) {
        // Actualizar el registro existente en la tabla 'pagos'
        $stmt_pagos = $pdo->prepare('UPDATE pagos SET cuota_colegio = ?, cuota_fmv = ?, pago_montepio = ? WHERE medico_id = ?');
        $stmt_pagos->execute([$cuota_colegio, $cuota_fmv, $pago_montepio, $id]);
    } else {
        // Insertar los datos en la tabla 'pagos'
        $stmt_pagos = $pdo->prepare('INSERT INTO pagos (medico_id, cuota_colegio, cuota_fmv, pago_montepio) VALUES (?, ?, ?, ?)');
        $stmt_pagos->execute([$id, $cuota_colegio, $cuota_fmv, $pago_montepio]);
    }

    // Redirigir al usuario a alguna página después de procesar los datos
    header('Location: ../index.php');
    exit(); // Asegurarse de que el script se detenga después de redirigir
} else {
    // Si se accede directamente a este archivo sin enviar datos desde el formulario, redirigir al inicio
    header('Location: ../index.php');
    exit();
}
?>
