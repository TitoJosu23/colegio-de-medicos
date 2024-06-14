<?php
session_start();
require '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'admin') {
    header('Location: ../../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['name'];
    $correo = $_POST['email'];
    $rol = $_POST['rol'];

    $stmt = $pdo->prepare('UPDATE users SET nombre = ?, correo = ?, rol = ? WHERE id = ?');
    $stmt->execute([$nombre, $correo, $rol, $id]);

    header('Location: users.php');
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
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
    <?php include '../../includes/sidebar.php'; ?>
    <div id="content">
        <div class="container">
            <h1>Editar Usuario</h1>
            <form action="edit_user.php" method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['nombre']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['correo']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select class="form-control" id="rol" name="rol" required>
                        <option value="admin" <?= ($user['rol'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="visualizador" <?= ($user['rol'] == 'visualizador') ? 'selected' : '' ?>>Visualizador</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        </div>
    </div>
    <?php include '../../includes/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../../assets/js/scripts.js"></script>
</body>
</html>
