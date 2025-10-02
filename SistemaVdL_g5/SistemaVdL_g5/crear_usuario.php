<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config/database.php';

$database = new Database();
$conn = $database->connect();

// Datos del usuario
$email = 'omuchac16@gmail.com';
$password = password_hash('123456789', PASSWORD_DEFAULT);
$nombre = 'Nombre del Usuario';

// Inserción del usuario en la base de datos
$query = "INSERT INTO usuarios (email, password, nombre) VALUES (:email, :password, :nombre)";
$stmt = $conn->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':nombre', $nombre);

if ($stmt->execute()) {
    echo "Usuario creado correctamente con contraseña encriptada.";
} else {
    echo "Error al crear el usuario.";
    print_r($stmt->errorInfo()); // Muestra detalles del error
}
?>
