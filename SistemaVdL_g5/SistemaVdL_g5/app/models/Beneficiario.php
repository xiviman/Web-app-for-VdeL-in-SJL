<?php
// app/models/Beneficiario.php

// Incluye el archivo de configuración de la base de datos para establecer la conexión.
require_once 'config/database.php';

// Define la clase Beneficiario para gestionar los beneficiarios en la base de datos.
class Beneficiario {
    private $conn; // Variable para almacenar la conexión a la base de datos.
    private $table = 'beneficiarios'; // Nombre de la tabla en la base de datos.

    // El constructor establece la conexión a la base de datos cuando se crea un objeto de la clase.
    public function __construct() {
        $database = new Database(); // Crea una instancia de la clase Database.
        $this->conn = $database->connect(); // Establece la conexión a la base de datos.
    }

    // Método para obtener todos los beneficiarios de la base de datos.
    public function obtenerBeneficiarios() {
        // Consulta SQL para seleccionar todos los registros de la tabla 'beneficiarios'.
        $query = "SELECT * FROM " . $this->table;

        // Prepara la consulta SQL para ejecutarla.
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta.
        $stmt->execute();
        // Devuelve todos los resultados de la consulta como un array asociativo.
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    


    // Método para guardar un nuevo beneficiario en la base de datos.
    public function guardarBeneficiario($data) {
        $query = "INSERT INTO " . $this->table . " (nombres, apellido_paterno, apellido_materno, dni, 
        fecha_nacimiento, edad, condicion, direccion, nombre_apoderado) VALUES (:nombres, :apellido_paterno, 
        :apellido_materno, :dni, :fecha_nacimiento, :edad, :condicion, :direccion, :nombre_apoderado)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    // Método para eliminar un beneficiario por su ID.
    public function eliminarBeneficiario($id) {
        // Consulta SQL para eliminar un beneficiario de la base de datos.
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        // Prepara la consulta SQL.
        $stmt = $this->conn->prepare($query);
        // Asocia el parámetro :id con el valor del ID del beneficiario.
        $stmt->bindParam(':id', $id);
        // Ejecuta la consulta de eliminación.
        $result = $stmt->execute();
    
        if ($result) {
            // Si la eliminación es exitosa, reinicia el contador de AUTO_INCREMENT de la tabla.
            $this->resetAutoIncrement();
        }
    
        // Devuelve el resultado de la eliminación (true si fue exitosa, false si no).
        return $result;
    }
    
    // Método privado para reiniciar el contador de AUTO_INCREMENT de la tabla.
    private function resetAutoIncrement() {
        // Consulta SQL para reiniciar el contador de AUTO_INCREMENT a 1.
        $query = "ALTER TABLE " . $this->table . " AUTO_INCREMENT = 1";
        // Ejecuta la consulta para restablecer el contador.
        $this->conn->query($query);
    }
    
    // Método para obtener un beneficiario por su ID.
    public function obtenerBeneficiarioPorId($id) {
        // Consulta SQL para seleccionar un beneficiario específico por su ID.
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        // Prepara la consulta SQL.
        $stmt = $this->conn->prepare($query);
        // Asocia el parámetro :id con el valor del ID del beneficiario.
        $stmt->bindParam(':id', $id);
        // Ejecuta la consulta.
        $stmt->execute();
        // Devuelve el resultado como un array asociativo.
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Método para actualizar la información de un beneficiario en la base de datos.
    public function actualizarBeneficiario($id, $data) {
        // Consulta SQL para actualizar los datos de un beneficiario por su ID.
        $query = "UPDATE " . $this->table . " SET 
                    nombres = :nombres, 
                    apellido_paterno = :apellido_paterno, 
                    apellido_materno = :apellido_materno, 
                    dni = :dni, 
                    fecha_nacimiento = :fecha_nacimiento, 
                    edad = :edad, 
                    condicion = :condicion, 
                    direccion = :direccion, 
                    nombre_apoderado = :nombre_apoderado 
                  WHERE id = :id";
    
        // Prepara la consulta SQL.
        $stmt = $this->conn->prepare($query);
    
        // Enlaza los parámetros uno por uno.
        $stmt->bindParam(':nombres', $data['nombres']);
        $stmt->bindParam(':apellido_paterno', $data['apellido_paterno']);
        $stmt->bindParam(':apellido_materno', $data['apellido_materno']);
        $stmt->bindParam(':dni', $data['dni']);
        $stmt->bindParam(':fecha_nacimiento', $data['fecha_nacimiento']);
        $stmt->bindParam(':edad', $data['edad']);
        $stmt->bindParam(':condicion', $data['condicion']);
        $stmt->bindParam(':direccion', $data['direccion']);
        $stmt->bindParam(':nombre_apoderado', $data['nombre_apoderado']);
        $stmt->bindParam(':id', $id);
    
        // Ejecuta la consulta de actualización.
        return $stmt->execute();
    }
    

    // Método para contar la cantidad total de beneficiarios en la base de datos.
    public function contarBeneficiarios() {
        // Consulta SQL para contar todos los beneficiarios en la tabla.
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        // Prepara la consulta SQL.
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta.
        $stmt->execute();
        // Obtiene el resultado de la consulta.
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Devuelve el total de beneficiarios.
        return $result['total'];
    }

    // Método para contar beneficiarios por grupos de edad (0-6 años, 7-13 años, etc.).
    public function contarBeneficiariosPorEdad() {
        // Consulta SQL para contar los beneficiarios por rangos de edad.
        $query = "SELECT
                    SUM(CASE WHEN edad BETWEEN 0 AND 6 THEN 1 ELSE 0 END) AS 'Niños de 0 a 6',
                    SUM(CASE WHEN edad BETWEEN 7 AND 13 THEN 1 ELSE 0 END) AS 'Niños de 7 a 13',
                    SUM(CASE WHEN edad BETWEEN 19 AND 45 THEN 1 ELSE 0 END) AS 'Madres Gestantes',                 
                    SUM(CASE WHEN edad >= 60 THEN 1 ELSE 0 END) AS 'Adultos Mayores'
                  FROM " . $this->table;
        // Prepara la consulta SQL.
        $stmt = $this->conn->prepare($query);
        // Ejecuta la consulta.
        $stmt->execute();
        // Devuelve los resultados como un array asociativo.
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    
    // Método para buscar beneficiarios por nombre o DNI.
    public function buscarBeneficiarios($searchTerm) {
    // Consulta SQL para buscar por nombre o DNI.
    $query = "SELECT * FROM " . $this->table . " 
              WHERE nombres LIKE :search 
              OR apellido_paterno LIKE :search 
              OR apellido_materno LIKE :search 
              OR dni LIKE :search";

    // Prepara la consulta SQL.
    $stmt = $this->conn->prepare($query);

    // Agrega comodines al término de búsqueda para realizar una búsqueda parcial.
    $search = "%" . $searchTerm . "%";
    $stmt->bindParam(':search', $search);

    // Ejecuta la consulta.
    $stmt->execute();

    // Devuelve los resultados como un array asociativo.
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    
}
?>