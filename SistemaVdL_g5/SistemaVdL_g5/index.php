<?php
session_start();
require_once 'config/database.php';
require_once 'app/models/Usuario.php';
require_once 'app/models/Beneficiario.php';
require_once 'app/models/Distribucion.php';
require_once 'app/models/Inventario.php';
require_once 'app/models/Calculo.php';
require_once 'app/controller/BeneficiarioController.php';




$action = $_GET['action'] ?? '';

// Si el usuario solicita cerrar sesión
if ($action === 'logout') {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Mostrar el formulario de inicio de sesión si no está autenticado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $usuario = new Usuario();
        $user = $usuario->verificarCredenciales($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            header("Location: index.php?action=menu"); //redirecionar al menu principal
            exit;
        } else {
            $error = "Credenciales incorrectas";
        }
    }

    // Formulario de inicio de sesión
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicio de Sesión</title>
        <link rel="stylesheet" href="public/Estilos/styleIndex.css">
        <link rel="icon" type="image/png" href="img\vacalola.png">
        <style>
            body {
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background-image: url('./img/Imagen.jpg'); /* Reemplaza con tu enlace de imagen */
                background-size: cover; /* Para que la imagen cubra todo el fondo */
                background-position: center; /* Para centrar la imagen */
            }

            .login-container {
                background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco con transparencia */
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
                width: 320px;
                text-align: center;
                transition: transform 0.3s, box-shadow 0.3s; /* Efecto al pasar el mouse */
            }

            .login-container:hover {
                transform: scale(1.02); /* Efecto de aumento */
                box-shadow: 0px 0px 25px rgba(0, 0, 0, 0.3);
            }

            .login-container h2 {
                margin-bottom: 20px;
                color: #712f82; /* Color de texto */
            }

            .login-container input[type="email"],
            .login-container input[type="password"] {
                width: 100%; /* Anchura completa */
                max-width: 300px; /* Ancho máximo para mantener el diseño */
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #963ead;
                border-radius: 5px;
                transition: border-color 0.3s; /* Transición suave */
            }

            .login-container input[type="email"]:focus,
            .login-container input[type="password"]:focus {
                border-color: #c2c2d1; /* Color al enfocar */
                outline: none; /* Sin borde de enfoque */
            }

            .login-container button {
                width: 100%;
                max-width: 300px; /* Ancho máximo para mantener el diseño */
                padding: 10px;
                background-color: #d795e8; /* Color del botón */
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-weight: bold; /* Texto en negrita */
                transition: background-color 0.3s, transform 0.3s; /* Transiciones para hover */
            }

            .login-container button:hover {
                background-color: #712f82; /* Color al pasar el mouse */
                transform: translateY(-2px); /* Efecto de elevación */
            }

            .error-message {
                color: red;
                margin-top: 10px;
            }
        </style>
    </head> 

    <body>
        <div class="login-container">
            <h2>Iniciar Sesión</h2>
            <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
            <form action="index.php" method="POST">
                <input type="email" name="email" placeholder="Correo Electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit">Ingresar</button>
            </form>
        </div>
    </body>

    </html>
<?php
    exit;
}

if ($action === 'beneficiarios') {
    include 'app/views/Beneficiarios/beneficiarios.php';
    exit;
}

if ($action === 'crear_beneficiario') {
    include 'app/views/Beneficiarios/crear_beneficiario.php';
    exit;
}

if ($action === 'guardar_beneficiario' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $beneficiarioModel = new Beneficiario();
    $beneficiarioModel->guardarBeneficiario($_POST);
    header("Location: index.php?action=beneficiarios");
    exit;
}

if ($action === 'eliminar_beneficiario' && isset($_GET['id'])) {
    $beneficiarioModel = new Beneficiario();
    $beneficiarioModel->eliminarBeneficiario($_GET['id']);
    header("Location: index.php?action=beneficiarios");
    exit;
}

if ($action === 'editar_beneficiario' && isset($_GET['id'])) {
    include 'app/views/Beneficiarios/editar_beneficiario.php';
    exit;
}

if ($action === 'actualizar_beneficiario' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $beneficiarioModel = new Beneficiario();
    $beneficiarioModel->actualizarBeneficiario($_GET['id'], $_POST);
    header("Location: index.php?action=beneficiarios");
    exit;
}
if ($action === 'registrar_distribucion') {
    include 'app/views/Entregas/registrar_distribucion.php';
    exit;
}

if ($action === 'guardar_distribucion' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $distribucionModel = new Distribucion();
    $inventarioModel = new Inventario();

    // Guardar la distribución
    $distribucionModel->guardarDistribucion($_POST);

    // Actualizar cantidad en el inventario
    $productoId = $_POST['producto_id'];
    $cantidadDistribuida = $_POST['cantidad'];

    // Obtener el producto del inventario y actualizar su cantidad
    $producto = $inventarioModel->obtenerProductoPorId($productoId);
    $nuevaCantidad = $producto['cantidad'] - $cantidadDistribuida;
    $inventarioModel->actualizarCantidad($productoId, $nuevaCantidad);

    header("Location: index.php?action=listar_distribuciones");
    exit;
}

if ($action === 'listar_distribuciones') {
    include 'app/views/Entregas/listar_distribuciones.php';
    exit;
}

if ($action === 'agregar_producto') {
    include 'app/views/Productos/agregar_producto.php';
    exit;
}

if ($action === 'guardar_producto' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $inventarioModel = new Inventario();
    $inventarioModel->guardarProducto($_POST);
    header("Location: index.php?action=listar_inventario");
    exit;
}

if ($action === 'listar_inventario') {
    include 'app/views/Productos/listar_inventario.php';
    exit;
}

if ($action === 'reporte_calculo') {
    include 'app/views/Reportes/reporte_calculo.php';
    exit;
}

if ($action === 'menu') {
    include 'app/views/menu.php';
    exit;
}
if ($action === 'eliminar_distribucion' && isset($_GET['id'])) {
    $distribucionModel = new Distribucion();
    $distribucionModel->eliminarDistribucion($_GET['id']);
    header("Location: index.php?action=listar_distribuciones");
    exit;
}
// Verifica si la acción es eliminar un producto
if ($action === 'eliminar_producto' && isset($_GET['id'])) {
    $inventarioModel = new Inventario();
    $resultado = $inventarioModel->eliminarProducto($_GET['id']); // Llamar al método eliminarProducto del modelo
    header("Location: index.php?action=listar_inventario"); // Redirigir al listado de inventario
    exit;
}

if ($action === 'buscar_beneficiarios') {
    $controller = new BeneficiarioController();
    $controller->buscar();
    exit;
}





header("Location: index.php?action=beneficiarios");
exit;

