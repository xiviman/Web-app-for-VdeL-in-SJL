<?php
// config/database.php

class Database {
    private $host = 'localhost';
    private $db_name = 'vdlcomite8'; // tu base de datos  el nombre 
    private $username = 'root'; // el usuario
    private $password = ''; // la contraseña
    private $conn;

    // Método para obtener la conexión a la base de datos
    public function connect() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           
        } catch (PDOException $exception) {
           
        }

        return $this->conn;
    }
}
?>
