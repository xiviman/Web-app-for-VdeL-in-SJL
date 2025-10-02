<?php
// Incluye el archivo que contiene el modelo de datos 'Distribucion'.
require_once 'app/models/Distribucion.php';

// Define la clase controlador 'DistribucionController' que gestiona las acciones relacionadas con distribuciones.
class DistribucionController {

    // Método para eliminar una distribución existente.
    public function eliminar() {
        // Crea una instancia del modelo 'Distribucion' para interactuar con los datos.
        $distribucionModel = new Distribucion();
        // Llama al método 'eliminarDistribucion' del modelo, pasando el ID de la distribución proporcionado por la URL.
        $distribucionModel->eliminarDistribucion($_GET['id']);
        // Redirige al usuario a la lista de distribuciones después de eliminar.
        header("Location: index.php?action=distribuciones");
    }
}