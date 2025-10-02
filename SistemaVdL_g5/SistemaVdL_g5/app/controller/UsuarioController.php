<?php
// Incluye el modelo Usuario para interactuar con la base de datos de usuarios.
require_once 'app/models/Usuario.php';

// Define la clase UsuarioController que gestiona acciones relacionadas con los usuarios.
class UsuarioController {

    // Método para manejar el inicio de sesión del usuario.
    public function login() {
        // Verifica si la solicitud es de tipo POST (formulario enviado).
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtiene el email y la contraseña ingresados por el usuario.
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Crea una instancia del modelo Usuario.
            $usuario = new Usuario();

            // Verifica si las credenciales ingresadas coinciden con algún usuario registrado.
            $user = $usuario->verificarCredenciales($email, $password);

            // Si las credenciales son correctas:
            if ($user) {
                // Inicia sesión y almacena información del usuario en variables de sesión.
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];

                // Redirige a la página de beneficiarios después del inicio de sesión.
                header("Location: index.php?action=beneficiarios");
            } else {
                // Si las credenciales no son válidas, establece un mensaje de error.
                $error = "Credenciales incorrectas";

                // Muestra nuevamente la vista de inicio de sesión con el mensaje de error.
                include 'app/views/login.php';
            }
        } else {
            // Si la solicitud no es de tipo POST, muestra la vista de inicio de sesión.
            include 'app/views/login.php';
        }
    }

    // Método para mostrar el formulario de registro.
    public function register() {
        $registro = true; // Activa el formulario de registro en la vista.
        include 'app/views/login.php'; // Carga la vista que incluye el formulario de registro.
    }

    // Método para manejar el guardado de un nuevo registro de usuario.
    public function guardarRegistro() {
        // Verifica si la solicitud es de tipo POST (formulario enviado).
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crea una instancia del modelo Usuario.
            $usuarioModel = new Usuario();

            // Hashea la contraseña ingresada por el usuario para mayor seguridad.
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Almacena los datos del nuevo usuario en un arreglo.
            $usuarioData = [
                'email' => $_POST['email'],
                'password' => $password,
                'nombre' => $_POST['nombre']
            ];

            // Llama al método guardarUsuario del modelo para registrar al nuevo usuario en la base de datos.
            $usuarioModel->guardarUsuario($usuarioData);

            // Redirige a la página principal después de guardar el registro.
            header("Location: index.php");
        }
    }

    // Método para manejar el cierre de sesión del usuario.
    public function logout() {
        // Elimina todas las variables de sesión activas.
        session_unset();

        // Destruye la sesión actual.
        session_destroy();

        // Redirige al usuario a la página principal después de cerrar sesión.
        header("Location: index.php");
    }
}