<?php
// app/models/Inventario.php

// Incluye el archivo de configuración para la conexión a la base de datos
require_once 'config/database.php';

// Definición de la clase Inventario que manejará los métodos relacionados con los productos del inventario
class Inventario {
    // Declaración de la propiedad privada para la conexión a la base de datos
    private $conn;
    
    // Nombre de la tabla en la base de datos que contiene los productos
    private $table = 'inventario';

    // Constructor de la clase, se ejecuta automáticamente al crear una instancia de la clase
    public function __construct() {
        // Crear una nueva instancia de la clase Database y conectar a la base de datos
        $database = new Database();
        
        // Asignar la conexión a la propiedad $conn
        $this->conn = $database->connect();
    }

    // Método para obtener todos los productos en el inventario
    public function obtenerInventario() {
        // Consulta SQL para seleccionar todos los productos de la tabla 'inventario'
        $query = "SELECT * FROM " . $this->table;
        
        // Preparar la consulta SQL
        $stmt = $this->conn->prepare($query);
        
        // Ejecutar la consulta preparada
        $stmt->execute();
        
        // Retornar todos los resultados como un array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para guardar un nuevo producto en el inventario
    public function guardarProducto($data) {
        // Consulta SQL para insertar un nuevo producto en la tabla 'inventario'
        $query = "INSERT INTO " . $this->table . " (producto, cantidad, umbral_alerta) 
                  VALUES (:producto, :cantidad, :umbral_alerta)";
        
        // Preparar la consulta SQL
        $stmt = $this->conn->prepare($query);
        
        // Ejecutar la consulta pasando los datos como parámetros
        return $stmt->execute($data);
    }

    // Método para actualizar la cantidad de un producto en el inventario
    public function actualizarCantidad($id, $cantidad) {
        // Consulta SQL para actualizar la cantidad de un producto dado su ID
        $query = "UPDATE " . $this->table . " SET cantidad = :cantidad WHERE id = :id";
        
        // Preparar la consulta SQL
        $stmt = $this->conn->prepare($query);
        
        // Vincular los parámetros :id y :cantidad con los valores pasados a la función
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':cantidad', $cantidad);
        
        // Ejecutar la consulta y retornar el resultado (true o false)
        return $stmt->execute();
    }

    // Método para obtener un producto específico por su ID
    public function obtenerProductoPorId($id) {
        // Consulta SQL para seleccionar un producto por su ID
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        
        // Preparar la consulta SQL
        $stmt = $this->conn->prepare($query);
        
        // Vincular el parámetro :id con el valor del ID proporcionado
        $stmt->bindParam(':id', $id);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Retornar el resultado como un array asociativo (el producto encontrado)
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para contar el total de productos en el inventario
    public function contarProductos() {
        // Consulta SQL para contar el número total de productos en la tabla 'inventario'
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        
        // Preparar la consulta SQL
        $stmt = $this->conn->prepare($query);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener el resultado de la consulta y retornar el total de productos
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Método para eliminar un producto del inventario
    public function eliminarProducto($id) {
        try {
            // Verificar si hay una transacción activa
            if ($this->conn->inTransaction()) {
                // Si hay una transacción activa, revertirla
                $this->conn->rollBack();
            }
    
            // Iniciar una nueva transacción
            $this->conn->beginTransaction();
    
            // Consulta SQL para eliminar un producto de la tabla 'inventario' por su ID
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            
            // Preparar la consulta SQL
            $stmt = $this->conn->prepare($query);
            
            // Vincular el parámetro :id con el ID del producto a eliminar
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            // Ejecutar la consulta
            $stmt->execute();
    
            // Consulta SQL para reorganizar los IDs de los productos después de la eliminación
            $reorganizeQuery = "SET @count = 0; 
                                UPDATE " . $this->table . " 
                                SET id = (@count := @count + 1) 
                                ORDER BY id";
            
            // Ejecutar la consulta para reorganizar los IDs
            $this->conn->exec($reorganizeQuery);
    
            // Consulta SQL para reiniciar el valor de AUTO_INCREMENT en la tabla
            $resetQuery = "ALTER TABLE " . $this->table . " AUTO_INCREMENT = 1";
            
            // Ejecutar la consulta para reiniciar AUTO_INCREMENT
            $this->conn->exec($resetQuery);
    
            // Confirmar (hacer commit) la transacción
            $this->conn->commit();
            return true;
    
        } catch (Exception $e) {
            // Si ocurre un error durante el proceso, revertir la transacción
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            // Registrar el error para depuración
            error_log("Error en eliminarProducto: " . $e->getMessage());
            return false;
        }
    }
}
?>