<?php

// Función para conectar a la base de datos
function connect_to_db() {
    $host = 'localhost';
    $dbname = 'your_database_name';
    $username = 'your_username';
    $password = 'your_password';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
}

// Función para obtener información de un usuario por su ID
function get_user_by_id($pdo, $user_id) {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    return $stmt->fetch();
}

// Otras funciones útiles pueden agregarse aquí según sea necesario

?>
