<?php
// Incluye el archivo que contiene el modelo 'Inventario'.
require_once 'app/models/Inventario.php';

// Define la clase controlador 'InventarioController' que gestiona las acciones relacionadas con el inventario.
class InventarioController {

    // Método para eliminar un producto del inventario.
    public function eliminarProducto() {
        // Obtener el ID del producto desde los parámetros de la URL.
        $id = $_GET['id'];

        // Verificar si el ID del producto está definido y es un número válido.
        if (isset($id) && is_numeric($id)) {
            // Crear una instancia del modelo 'Inventario' para interactuar con los datos del inventario.
            $inventarioModel = new Inventario();

            // Llamar al método 'eliminarProducto' del modelo, pasándole el ID del producto a eliminar.
            $resultado = $inventarioModel->eliminarProducto($id);

            // Si la eliminación fue exitosa, redirigir a la página principal del inventario.
            if ($resultado) {
                header('Location: index.php?action=inventario'); // Redirige al listado del inventario.
                exit; // Termina el script después de redirigir.
            } else {
                // Si ocurre un error durante la eliminación, mostrar un mensaje de error.
                echo "Error al eliminar el producto.";
            }
        } else {
            // Si el ID no es válido, mostrar un mensaje de error.
            echo "ID de producto no válido.";
        }
    }
}