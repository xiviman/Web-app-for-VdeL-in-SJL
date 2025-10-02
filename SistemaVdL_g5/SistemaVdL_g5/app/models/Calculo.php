<?php
// Incluye el archivo de configuración para la conexión a la base de datos
require_once 'config/database.php';

// Definición de la clase Calculo que manejará el cálculo de la cantidad de leche
class Calculo {
    // Definir las variables para la conexión a la base de datos
    private $conn;
    private $table = 'criterios_calculo'; // Nombre de la tabla en la base de datos que contiene los criterios de cálculo

    // Constructor de la clase
    public function __construct() {
        // Crear una nueva instancia de la clase Database y conectar a la base de datos
        $database = new Database();
        $this->conn = $database->connect(); // Asignar la conexión a la variable $conn
    }

    // Método para calcular la cantidad de leche según la edad del beneficiario
    public function calcularCantidadPorEdad($edad) {
        // Consulta SQL para obtener la cantidad de leche basada en el rango de edad
        $query = "SELECT cantidad_leche FROM " . $this->table . " WHERE :edad BETWEEN edad_min AND edad_max LIMIT 1";
        
        // Preparar la consulta SQL para su ejecución
        $stmt = $this->conn->prepare($query);
        
        // Vincular el parámetro ':edad' con el valor de la variable $edad
        $stmt->bindParam(':edad', $edad);
        
        // Ejecutar la consulta preparada
        $stmt->execute();
        
        // Obtener el resultado de la consulta como un array asociativo
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si el resultado existe, devolver la cantidad de leche; de lo contrario, devolver 0
        return $result ? $result['cantidad_leche'] : 0; // Si no hay criterio, asigna 0
    }
}
?>