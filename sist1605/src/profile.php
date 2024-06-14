<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];

    // Validar y actualizar la información del usuario
    $stmt = $pdo->prepare('UPDATE users SET nombre = ?, correo = ? WHERE id = ?');
    $stmt->execute([$nombre, $correo, $user_id]);

    // Actualizar la información de la sesión
    $_SESSION['nombre'] = $nombre;
    $_SESSION['correo'] = $correo;

    // Redirigir a la misma página para mostrar los cambios
    header('Location: profile.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $contrasena = $_POST['password'];
    $new_password = $_POST['new_password'];
    $repeat_password = $_POST['repeat_password'];

    // Verificar que las contraseñas nuevas coincidan
    if ($new_password === $repeat_password) {
        // Obtener la contraseña actual del usuario
        $stmt = $pdo->prepare('SELECT contrasena FROM users WHERE id = ?');
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar la contraseña actual
        if (password_verify($contrasena, $user['contrasena'])) {
            // Actualizar la contraseña
            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('UPDATE users SET contrasena = ? WHERE id = ?');
            $stmt->execute([$new_password_hashed, $user_id]);

            // Redirigir a la misma página para mostrar los cambios
            header('Location: profile.php?password_changed=1');
            exit();
        } else {
            $error = "La contraseña actual es incorrecta.";
        }
    } else {
        $error = "Las contraseñas nuevas no coinciden.";
    }
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die('Usuario no encontrado.');
}

// Asegúrate de que el campo 'rol' existe en el resultado
$rol = isset($user['rol']) ? $user['rol'] : 'Rol no definido';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <!-- Aquí está el sidebar -->
            </div>
            <div class="col-lg-10">
                <div class="mt-4">
                    <h1>Mi Perfil</h1>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <?php if (isset($_GET['password_changed'])): ?>
                        <div class="alert alert-success">Contraseña cambiada exitosamente.</div>
                    <?php endif; ?>
                    <form method="post">
                        <input type="hidden" name="update_profile" value="1">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?= htmlspecialchars($user['nombre']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo Electrónico:</label>
                            <input type="email" id="correo" name="correo" class="form-control" value="<?= htmlspecialchars($user['correo']) ?>" disabled required>
                        </div>
                        <div class="form-group">
                            <label for="rol">Rol:</label>
                            <input type="text" id="rol" class="form-control" value="<?= htmlspecialchars($rol) ?>" disabled>
                        </div>
                        <button type="button" class="btn btn-secondary" id="editEmailButton">Actualizar Datos</button>
                        <button type="submit" class="btn btn-primary" id="saveChangesButton" style="display:none;">Guardar Cambios</button>
                    </form>
                    <button id="togglePasswordChange" class="btn btn-secondary mt-4">Cambiar Contraseña</button>
                    <div id="passwordChangeForm" class="mt-4" style="display: none;">
                        <form method="post">
                            <input type="hidden" name="change_password" value="1">
                            <div class="form-group">
                                <label for="password">Contraseña Actual:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">Nueva Contraseña:</label>
                                <input type="password" id="new_password" name="new_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="repeat_password">Repetir Nueva Contraseña:</label>
                                <input type="password" id="repeat_password" name="repeat_password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
        document.getElementById('togglePasswordChange').addEventListener('click', function() {
            var form = document.getElementById('passwordChangeForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        });

        document.getElementById('editEmailButton').addEventListener('click', function() {
            var emailField = document.getElementById('correo');
            var saveButton = document.getElementById('saveChangesButton');
            emailField.disabled = !emailField.disabled;
            saveButton.style.display = emailField.disabled ? 'none' : 'block';
        });
    </script>
</body>
</html>
