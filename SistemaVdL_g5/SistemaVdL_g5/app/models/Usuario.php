<?php
// app/models/Usuario.php

// Se incluye el archivo que contiene la clase Database, que maneja la conexión a la base de datos.
require_once 'config/database.php';

// Definición de la clase Usuario, que se encarga de manejar la lógica de los usuarios.
class Usuario {
    // Declaración de la propiedad privada $conn para almacenar la conexión a la base de datos.
    private $conn;
    
    // Se declara la propiedad privada $table para almacenar el nombre de la tabla de usuarios en la base de datos.
    private $table = 'usuarios';

    // Constructor de la clase Usuario. Este método se ejecuta automáticamente cuando se crea una instancia de la clase.
    public function __construct() {
        // Se crea una nueva instancia de la clase Database para manejar la conexión.
        $database = new Database();
        
        // Se obtiene la conexión a la base de datos mediante el método connect() de la clase Database.
        $this->conn = $database->connect();
    }

    // Método para verificar las credenciales del usuario, recibe el correo y la contraseña.
    public function verificarCredenciales($email, $password) {
        // Se crea una consulta SQL que selecciona todos los datos del usuario con el email proporcionado.
        // Se usa un parámetro de enlace :email para evitar inyecciones SQL.
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";

        // Se prepara la consulta SQL utilizando la conexión establecida.
        $stmt = $this->conn->prepare($query);
        
        // Se vincula el valor del parámetro :email con el valor del argumento $email.
        $stmt->bindParam(':email', $email);

        // Se ejecuta la consulta preparada.
        if ($stmt->execute()) {
            // Se obtiene el primer resultado de la consulta como un array asociativo.
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si se encuentra un usuario y la contraseña proporcionada coincide con la almacenada en la base de datos.
            if ($user && password_verify($password, $user['password'])) {
                // Si las credenciales son correctas, se devuelve el array del usuario.
                return $user;
            }
        }

        // Si las credenciales no son correctas, se retorna false.
        return false;
    }
}
?>