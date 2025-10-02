<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaso de Leche</title>
    <link rel="icon" type="image/png" href="img/vacalola.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --bg-primary: #F2E9E4; /* Fondo principal */
            --navbar-bg: #789DBC; /* Fondo del panel de navegación */
            --header-bg: #E8A0BF; /* Fondo del panel superior */
            --text-light: #FFFFFF;
            --text-dark: #4F4F4F;
            --highlight: #A5D6A7; /* Fondo al activar un módulo */
            --hover-highlight: #90CAF9; /* Fondo al pasar el cursor */
            --icon-active: #1E88E5; /* Icono activo */
            --btn-bg: transparent; /* Botón toggle transparente */
            --btn-hover: #80B1E8; /* Color de fondo al pasar el mouse */
            --btn-active: #5582C8; /* Color de fondo al hacer clic */
            --shadow-color: rgba(0, 0, 0, 0.1); /* Sombra para el botón */
        }

        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar {
            background-color: var(--navbar-bg);
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            box-shadow: 5px 0 15px var(--shadow-color);
            z-index: 120; /* Aseguramos que el navbar esté siempre por encima del contenido */
        }

        .navbar img {
            display: block;
            margin: 0 auto 20px;
            max-width: 80%;
            height: auto;
            border-radius: 10px;
        }

        .navbar a {
            display: flex;
            align-items: center;
            color: var(--text-light);
            text-decoration: none;
            padding: 12px 20px;
            font-size: 16px;
            margin-bottom: 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navbar a i {
            margin-right: 12px;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .navbar a:hover {
            background: var(--hover-highlight);
            color: var(--icon-active);
            transform: translateX(10px);
            box-shadow: 0 3px 15px var(--shadow-color);
        }

        .navbar a.active {
            background: var(--highlight);
            color: var(--icon-active);
            font-weight: bold;
        }

        .navbar a.active i {
            color: var(--icon-active);
        }

        /* Contenido */
        .content {
            margin-left: 260px; /* Ajustamos para que el contenido no se superponga al navbar */
            padding: 20px;
            margin-top: 10px;
            color: var(--text-dark);
            flex-grow: 1; /* El contenido ocupa el espacio restante */
            display: flex;
            justify-content: center; /* Centrar el contenido horizontalmente */
            align-items: center; /* Centrar el contenido verticalmente */
            text-align: center; /* Centrar el texto */
        }

        /* Barra superior */
        .header-bar {
            position: fixed;
            top: 0;
            left: 260px; /* Aseguramos que la barra superior esté a la derecha del navbar */
            width: calc(100% - 260px); /* Ocupa el resto del ancho */
            background-color: var(--header-bg);
            color: var(--text-light);
            text-align: center;
            padding: 20px 0;
            font-size: 24px;
            font-weight: 500;
            z-index: 102; /* Aseguramos que la barra superior esté por encima de todo */
            box-shadow: 0 2px 10px var(--shadow-color);
        }

        /* Barra inferior */
        .footer-bar {
            position: fixed;
            bottom: 0;
            left: 260px; /* Aseguramos que la barra inferior esté a la derecha del navbar */
            width: calc(100% - 260px); /* Ocupa el resto del ancho */
            background-color: var(--navbar-bg);
            color: var(--text-light);
            text-align: center;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 400;
            z-index: 101; /* Aseguramos que la barra inferior esté por encima del contenido pero debajo de la barra superior */
            box-shadow: 0 -2px 10px var(--shadow-color);
        }
    </style>
</head>
<body>

    <div class="navbar">
        <img src="img/vacalola.png" alt="Logo">
        <a href="index.php?action=menu" class="<?= $_GET['action'] == 'menu' ? 'active' : '' ?>">
            <i class="fas fa-home"></i> Menú Principal
        </a>
        <a href="index.php?action=beneficiarios" class="<?= $_GET['action'] == 'beneficiarios' ? 'active' : '' ?>">
            <i class="fas fa-users"></i> Beneficiarios
        </a>
        <a href="index.php?action=listar_distribuciones" class="<?= $_GET['action'] == 'listar_distribuciones' ? 'active' : '' ?>">
            <i class="fas fa-clipboard-list"></i> Ver Distribución
        </a>
        <a href="index.php?action=registrar_distribucion" class="<?= $_GET['action'] == 'registrar_distribucion' ? 'active' : '' ?>">
            <i class="fas fa-plus-square"></i> Registrar Distribución
        </a>
        <a href="index.php?action=listar_inventario" class="<?= $_GET['action'] == 'listar_inventario' ? 'active' : '' ?>">
            <i class="fas fa-boxes"></i> Ver Inventario
        </a>
        <a href="index.php?action=agregar_producto" class="<?= $_GET['action'] == 'agregar_producto' ? 'active' : '' ?>">
            <i class="fas fa-box"></i> Agregar Producto
        </a>
        <a href="index.php?action=reporte_calculo" class="<?= $_GET['action'] == 'reporte_calculo' ? 'active' : '' ?>">
            <i class="fas fa-chart-line"></i> Reporte Cálculo
        </a>
        <a href="index.php?action=logout" class="<?= $_GET['action'] == 'logout' ? 'active' : '' ?>">
            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
        </a>
    </div>

    <div class="header-bar">
        Bienvenida Sra: Olivia Mucha
    </div>

    <div class="footer-bar">
        Derechos Reservados © 2024
    </div>

</body>
</html>
