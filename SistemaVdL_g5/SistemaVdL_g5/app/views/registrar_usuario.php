<?php
// Incluye el archivo 'nav.php', que puede contener la barra de navegación o el menú de la aplicación.
// Esto asegura que el diseño de la página sea consistente con otras partes del sitio.
require_once 'nav.php';
?>

<div style="padding: 70px;">
    <!-- Crea un contenedor con un estilo de margen interno (padding) de 70px, 
         para dar espacio alrededor del contenido y evitar que esté pegado a los bordes de la página. -->
    
    <h2>Registrar Nuevo Usuario</h2>
    <!-- Título principal de la sección que indica el propósito de la página: registrar un nuevo usuario. -->
    
    <form action="index.php?action=guardar_usuario" method="POST">
        <!-- Inicia un formulario HTML que enviará los datos al archivo 'index.php' mediante el método POST.
             El parámetro 'action=guardar_usuario' en la URL indica la acción que se manejará en el backend. -->
        
        <label>Correo Electrónico:</label>
        <!-- Etiqueta descriptiva para el campo de correo electrónico. -->
        <input type="email" name="email" required>
        <!-- Campo de entrada para el correo electrónico.
             - 'type="email"' asegura que solo se acepten formatos válidos de correo electrónico.
             - 'name="email"' será el nombre de la variable que se enviará al backend.
             - 'required' obliga a que el campo sea completado antes de enviar el formulario. -->
        <br><br>
        <!-- Inserta saltos de línea para separar visualmente los elementos del formulario. -->
        
        <label>Contraseña:</label>
        <!-- Etiqueta descriptiva para el campo de contraseña. -->
        <input type="password" name="password" required>
        <!-- Campo de entrada para la contraseña.
             - 'type="password"' oculta los caracteres mientras se escribe.
             - 'name="password"' será el nombre de la variable que se enviará al backend.
             - 'required' obliga a que el campo sea completado antes de enviar el formulario. -->
        <br><br>
        
        <label>Nombre:</label>
        <!-- Etiqueta descriptiva para el campo del nombre del usuario. -->
        <input type="text" name="nombre" required>
        <!-- Campo de entrada para el nombre del usuario.
             - 'type="text"' permite ingresar texto sin restricciones específicas.
             - 'name="nombre"' será el nombre de la variable que se enviará al backend.
             - 'required' obliga a que el campo sea completado antes de enviar el formulario. -->
        <br><br>
        
        <button type="submit">Registrar</button>
        <!-- Botón que envía los datos del formulario al servidor cuando es presionado.
             - 'type="submit"' asegura que el formulario se procese al hacer clic. -->
    </form>
</div>