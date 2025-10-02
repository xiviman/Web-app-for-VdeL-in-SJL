<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Definición del conjunto de caracteres para el documento HTML -->
    <meta charset="UTF-8">
    <!-- Definición de la vista para dispositivos móviles, ajustando la escala según el tamaño de la pantalla -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título de la página, cambia según si la variable $registro está definida y tiene valor verdadero -->
    <title><?php echo isset($registro) && $registro ? 'Registrar Usuario' : 'Inicio de Sesión'; ?></title>

</head>
<body>
    
    <div class="login-container">
        <?php if (isset($registro) && $registro): ?>
            <h2>Registrar Usuario</h2>
            <form action="index.php?action=guardar_usuario" method="POST">
                <input type="email" name="email" placeholder="Correo Electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <input type="text" name="nombre" placeholder="Nombre" required>
                <button type="submit">Registrar</button>
            </form>
            <a href="index.php">Volver a Iniciar Sesión</a>

        <?php else: ?>
            <h2>Iniciar Sesión</h2>
            <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
            <form action="index.php?action=login" method="POST">
                <input type="email" name="email" placeholder="Correo Electrónico" required>  
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit">Ingresar</button>
            </form>
            
            <a href="index.php?action=registrar_usuario">Registrar</a>
        <?php endif; ?>
    </div>
</body>
</html>