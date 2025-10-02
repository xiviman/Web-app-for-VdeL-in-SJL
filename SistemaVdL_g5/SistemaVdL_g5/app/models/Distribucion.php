<?php
// app/models/Distribucion.php

// Incluir el archivo de configuración de la base de datos para establecer la conexión
require_once 'config/database.php';

// Definición de la clase Distribucion, que manejará las operaciones sobre las distribuciones
class Distribucion {
    // Propiedad privada para almacenar la conexión a la base de datos
    private $conn;
    // Propiedad privada que define el nombre de la tabla en la base de datos
    private $table = 'distribuciones';

    // Constructor de la clase
    public function __construct() {
        // Crear una instancia de la clase Database para conectarse a la base de datos
        $database = new Database();
        // Almacenar la conexión a la base de datos en la propiedad $conn
        $this->conn = $database->connect();
    }

    // Método para obtener todas las distribuciones
    public function obtenerDistribuciones() {
        // Consulta SQL para obtener información de las distribuciones, incluyendo los datos del beneficiario y el producto
        $query = "SELECT d.id, b.nombres, b.apellido_paterno, b.apellido_materno, i.producto, d.cantidad, d.fecha_entrega 
                  FROM " . $this->table . " d
                  JOIN beneficiarios b ON d.beneficiario_id = b.id
                  JOIN inventario i ON d.producto_id = i.id";
        // Preparar la consulta SQL
        $stmt = $this->conn->prepare($query);
        // Ejecutar la consulta
        $stmt->execute();
        // Devolver los resultados de la consulta como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para guardar una nueva distribución en la base de datos
    public function guardarDistribucion($data) {
        // Consulta SQL para insertar una nueva distribución en la tabla
        $query = "INSERT INTO " . $this->table . " (beneficiario_id, producto_id, cantidad, fecha_entrega) 
                  VALUES (:beneficiario_id, :producto_id, :cantidad, :fecha_entrega)";
        // Preparar la consulta SQL para su ejecución
        $stmt = $this->conn->prepare($query);
        // Vincular los parámetros de la consulta con los valores de $data
        $stmt->bindParam(':beneficiario_id', $data['beneficiario_id']);
        $stmt->bindParam(':producto_id', $data['producto_id']);
        $stmt->bindParam(':cantidad', $data['cantidad']);
        $stmt->bindParam(':fecha_entrega', $data['fecha_entrega']);
        // Ejecutar la consulta y devolver el resultado (verdadero si se ejecutó correctamente, falso en caso contrario)
        return $stmt->execute();
    }

    // Método para contar el número total de entregas en la tabla de distribuciones
    public function contarEntregas() {
        // Consulta SQL para contar el número total de registros en la tabla de distribuciones
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        // Preparar la consulta SQL
        $stmt = $this->conn->prepare($query);
        // Ejecutar la consulta
        $stmt->execute();
        // Obtener el resultado de la consulta
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Devolver el número total de entregas
        return $result['total'];
    }

    // Método para obtener el número de entregas por mes
    public function obtenerEntregasPorMes() {
        // Consulta SQL para obtener el número de entregas por mes, agrupado por mes de entrega
        $query = "SELECT MONTH(fecha_entrega) AS mes, COUNT(*) AS total 
                  FROM " . $this->table . " 
                  GROUP BY MONTH(fecha_entrega)";
        // Preparar la consulta SQL
        $stmt = $this->conn->prepare($query);
        // Ejecutar la consulta
        $stmt->execute();
        // Devolver los resultados de la consulta como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para eliminar una distribución específica por su ID
    public function eliminarDistribucion($id) {
        try {
            // Verifica si la conexión está dentro de una transacción activa
            if ($this->conn->inTransaction()) {
                // Si está en una transacción, se deshace (rollback)
                $this->conn->rollBack();
            }
    
            // Inicia una transacción en la base de datos
            $this->conn->beginTransaction();
    
            // Consulta SQL para eliminar una distribución de la tabla según el ID
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            // Preparar la consulta SQL
            $stmt = $this->conn->prepare($query);
            // Vincular el parámetro ':id' con el valor del ID proporcionado
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            // Ejecutar la consulta de eliminación
            $stmt->execute();
    
            // Consulta para reorganizar los IDs de la tabla después de la eliminación
            $reorganizeQuery = "SET @count = 0; 
                                UPDATE " . $this->table . " 
                                SET id = (@count := @count + 1) 
                                ORDER BY id";
            // Ejecutar la consulta para reorganizar los IDs
            $this->conn->exec($reorganizeQuery);
    
            // Consulta para reiniciar el AUTO_INCREMENT de la tabla, asegurando que el próximo ID sea el siguiente en la secuencia
            $resetQuery = "ALTER TABLE " . $this->table . " AUTO_INCREMENT = 1";
            // Ejecutar la consulta para reiniciar el AUTO_INCREMENT
            $this->conn->exec($resetQuery);
    
            // Confirmar (commit) la transacción para hacer permanentes los cambios
            $this->conn->commit();
            // Retornar verdadero indicando que la eliminación fue exitosa
            return true;
    
        } catch (Exception $e) {
            // Si ocurre un error, revertir (rollBack) la transacción si está activa
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            // Registrar el error para fines de depuración
            error_log("Error en eliminarDistribucion: " . $e->getMessage());
            // Retornar falso indicando que hubo un error
            return false;
        }
    }
}
?>