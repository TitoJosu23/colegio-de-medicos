<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

if ($_SESSION['rol'] !== 'admin') {
    // Si el usuario no es administrador, redirigirlo a alguna página adecuada
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar pagos relacionados
    $stmt = $pdo->prepare("DELETE FROM pagos WHERE medico_id = ?");
    $stmt->execute([$id]);

    // Eliminar al médico
    $stmt = $pdo->prepare("DELETE FROM medicos WHERE id = ?");
    $stmt->execute([$id]);

    // Redirigir a la página de listado de médicos con un mensaje de éxito
    header('Location: members.php?message=delete_success');
    exit();
} else {
    // Si no se proporcionó un ID, redirigir con un mensaje de error
    header('Location: members.php?message=id_missing');
    exit();
}
?>
