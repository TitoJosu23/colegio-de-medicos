<?php
session_start();
require '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'admin') {
    header('Location: ../../login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    <div class="container">
        <h1>Eliminar Usuario</h1>
        <div class="alert alert-danger" role="alert">
            <strong>¡Advertencia!</strong> ¿Estás seguro de que quieres eliminar este usuario?
        </div>
        <form method="post">
            <button type="submit" name="confirm" class="btn btn-danger">Aceptar</button>
            <a href="users.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <?php include '../../includes/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../../assets/js/scripts.js"></script>
</body>
</html>
