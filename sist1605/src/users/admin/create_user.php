<?php
session_start();
require '../../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'admin') {
    header('Location: ../../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['name'];
    $correo = $_POST['email'];
    $contrasena = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];

    $stmt = $pdo->prepare('INSERT INTO users (nombre, correo, contrasena, rol) VALUES (?, ?, ?, ?)');
    $stmt->execute([$nombre, $correo, $contrasena, $rol]);

    header('Location: users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
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
            <h1>Agregar Usuario</h1>
            <form action="create_user.php" method="post">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select class="form-control" id="rol" name="rol" required>
                        <option value="admin">Admin</option>
                        <option value="visualizador">Visualizador</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Agregar Usuario</button>
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
