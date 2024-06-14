<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestión de Agremiados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
        }
        .content {
            flex: 1;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: 250px;
        }
        .welcome-message {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #003366;
            padding: 20px;
            border: 2px solid #003366;
            border-radius: 10px;
            background-color: #f0f8ff;
        }
        @media (max-width: 768px) {
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <div class="content">
        <div class="welcome-message">
            <p>Bienvenido, <?= htmlspecialchars($user['nombre']) ?> (<?= htmlspecialchars($user['rol']) ?>)</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
