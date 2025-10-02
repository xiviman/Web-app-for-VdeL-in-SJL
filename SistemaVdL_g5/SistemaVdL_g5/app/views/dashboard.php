<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['user_name']; ?>!</h1>
    <p>Esta es la página principal después de iniciar sesión.</p>
    <a href="index.php?action=logout">Cerrar Sesión</a>
</body>
</html>
