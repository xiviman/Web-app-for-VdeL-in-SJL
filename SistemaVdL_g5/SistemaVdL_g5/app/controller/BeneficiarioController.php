<?php
// Incluye el archivo que contiene el modelo de datos 'Beneficiario'.
require_once 'app/models/Beneficiario.php';

// Define la clase controlador 'BeneficiarioController' que gestiona las acciones relacionadas con beneficiarios.
class BeneficiarioController {

    // Método para mostrar la vista principal de beneficiarios.
    public function index() {
        // Incluye la vista 'beneficiarios.php' para mostrar la lista de beneficiarios.
        include 'app/views/Beneficiarios/beneficiarios.php';
    }

    // Método para mostrar el formulario de creación de un beneficiario.
    public function crear() {
        // Incluye la vista 'crear_beneficiario.php' para capturar los datos de un nuevo beneficiario.
        include 'app/views/Beneficiarios/crear_beneficiario.php';
    }

    // Método para guardar un nuevo beneficiario en la base de datos.
    public function guardar() {
        // Crea una instancia del modelo 'Beneficiario' para interactuar con los datos.
        $beneficiarioModel = new Beneficiario();
        // Llama al método 'guardarBeneficiario' del modelo y le pasa los datos enviados por el formulario.
        $beneficiarioModel->guardarBeneficiario($_POST);
        // Redirige al usuario a la lista de beneficiarios después de guardar.
        header("Location: index.php?action=beneficiarios");
    }

    // Método para eliminar un beneficiario existente.
    public function eliminar() {
        // Crea una instancia del modelo 'Beneficiario'.
        $beneficiarioModel = new Beneficiario();
        // Llama al método 'eliminarBeneficiario' del modelo con el ID del beneficiario proporcionado por la URL.
        $beneficiarioModel->eliminarBeneficiario($_GET['id']);
        // Redirige al usuario a la lista de beneficiarios después de eliminar.
        header("Location: index.php?action=beneficiarios");
    }

    // Método para mostrar el formulario de edición de un beneficiario.
    public function editar() {
        // Incluye la vista 'editar_beneficiario.php' para capturar los datos actualizados del beneficiario.
        include 'app/views/Beneficiarios/editar_beneficiario.php';
    }

    // Método para actualizar un beneficiario existente en la base de datos.
    public function actualizar() {
        // Crea una instancia del modelo 'Beneficiario'.
        $beneficiarioModel = new Beneficiario();
        // Llama al método 'actualizarBeneficiario' del modelo, pasando el ID del beneficiario y los datos enviados por el formulario.
        $beneficiarioModel->actualizarBeneficiario($_GET['id'], $_POST);
        // Redirige al usuario a la lista de beneficiarios después de actualizar.
        header("Location: index.php?action=beneficiarios");
    }
    // Método para buscar beneficiarios por nombre o DNI.
    public function buscar() {
    $beneficiarioModel = new Beneficiario();
    $beneficiarios = []; // Inicializa el array de beneficiarios

    // Verifica si se ha enviado un término de búsqueda.
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $searchTerm = $_GET['search'];
        $beneficiarios = $beneficiarioModel->buscarBeneficiarios($searchTerm);
    } else {
        // Si no hay término de búsqueda, muestra todos los beneficiarios.
        $beneficiarios = $beneficiarioModel->obtenerBeneficiarios();
    }

    // Incluye la vista con los resultados de búsqueda.
    include 'app/views/Beneficiarios/beneficiarios.php';
}



     
}
