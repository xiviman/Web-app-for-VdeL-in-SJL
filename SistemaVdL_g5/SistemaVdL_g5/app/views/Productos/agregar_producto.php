<?php
require_once 'app/views/nav.php'; // Incluir el menú de navegación
?>

<div style="margin-left: 330px; padding: 80px 50px 50px 50px; display: flex; flex-direction: column; align-items: center; width: calc(80% - 180px);">
    <div class="container">
        <!-- Título principal de la sección donde se agrega un nuevo producto -->
        <h2>Agregar Nuevo Producto al Inventario</h2> 
         <!-- Enlace al archivo de estilos CSS para personalizar la apariencia de la página -->
        <link rel="stylesheet" href="public/Estilos/styleADistri.css">

        <!-- Panel para el formulario -->
        <div class="form-panel"> <!-- Contenedor para el formulario -->
            <!-- Formulario que enviará los datos a "index.php" con la acción 
             "guardar_producto" mediante el método POST -->
            <form action="index.php?action=guardar_producto" method="POST" class="formulario"> 
                <!-- Etiqueta para el campo del producto, con un asterisco indicando que es obligatorio -->
                <label for="producto">Producto<span class="required">*</span></label> 
                <!-- Campo de texto donde se ingresará el nombre del producto, es obligatorio -->
                <input type="text" name="producto" id="producto" required> 
                <!-- Etiqueta para el campo de cantidad inicial del producto, con asterisco indicando que es obligatorio -->
                <label for="cantidad">Cantidad Inicial<span class="required">*</span></label> 
                <!-- Campo numérico para ingresar la cantidad inicial del producto, es obligatorio -->
                <input type="number" name="cantidad" id="cantidad" required> 

                <!-- Etiqueta para el campo del umbral de alerta, con asterisco indicando que es obligatorio -->
                <label for="umbral_alerta">Umbral de Alerta<span class="required">*</span></label> 
                <!-- Campo numérico para ingresar el umbral de alerta del producto, es obligatorio -->
                <input type="number" name="umbral_alerta" id="umbral_alerta" required> 
                <!-- Botón para enviar el formulario con la acción de guardar el producto -->
                <button type="submit">Guardar Producto</button> 
            </form> <!-- Fin del formulario -->
        </div> <!-- Fin del contenedor del formulario -->
    </div> <!-- Fin del contenedor principal -->
</div> <!-- Fin del contenedor con el estilo de padding -->