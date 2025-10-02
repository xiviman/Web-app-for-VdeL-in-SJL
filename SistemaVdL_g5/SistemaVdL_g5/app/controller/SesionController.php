<?php
// app/controllers/SesionController.php

// Incluye el modelo 'Usuario' que se utiliza para manejar datos de usuarios.
require_once 'app/models/Usuario.php';

// Define la clase 'SesionController' para gestionar acciones relacionadas con la sesión del usuario.
class SesionController {

    // Método para manejar el inicio de sesión del usuario.
    public function login() {
        // Verifica si la solicitud es de tipo POST (el formulario fue enviado).
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recupera el email y la contraseña enviados desde el formulario.
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Crea una instancia del modelo 'Usuario' para interactuar con la base de datos.
            $usuario = new Usuario();

            // Llama al método 'verificarCredenciales' para comprobar si el usuario existe y las credenciales son correctas.
            $user = $usuario->verificarCredenciales($email, $password);

            // Si las credenciales son válidas, inicia una sesión para el usuario.
            if ($user) {
                session_start(); // Inicia la sesión.
                $_SESSION['user_id'] = $user['id']; // Guarda el ID del usuario en la sesión.
                $_SESSION['user_name'] = $user['nombre']; // Guarda el nombre del usuario en la sesión.
                header("Location: /dashboard"); // Redirige al panel principal.
                exit; // Finaliza la ejecución del script después de la redirección.
            } else {
                // Si las credenciales no son correctas, muestra un mensaje de error.
                echo "Credenciales incorrectas";
            }
        }
    }

    // Método para manejar el cierre de sesión del usuario.
    public function logout() {
        session_start(); // Inicia o reanuda la sesión actual.
        session_unset(); // Limpia todas las variables de la sesión.
        session_destroy(); // Destruye la sesión actual.
        header("Location: /login"); // Redirige al usuario a la página de inicio de sesión.
        exit; // Finaliza la ejecución del script después de la redirección.
    }
}
?>