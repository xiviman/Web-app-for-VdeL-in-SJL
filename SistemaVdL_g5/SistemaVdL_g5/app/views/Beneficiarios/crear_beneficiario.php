<?php
require_once 'app/views/nav.php'; // Incluir el archivo de navegación para mostrar el menú en la página
?>

<div style="margin-left: 180px; padding: 90px 50px 50px 115px; display: flex; flex-direction: column; align-items: center; width: calc(90% - 180px);"> 
    <div class="container" style="width: 90%; max-width: 700px;"> <!-- Contenedor principal centrado con un máximo de 800px de ancho -->
        <h2>Añadir Nuevo Beneficiario</h2> <!-- Título que describe la acción de la página -->
        <link rel="stylesheet" href="public/Estilos/styleABene.css"> <!-- Enlaza el archivo CSS para estilos específicos de la página de Beneficiarios -->
        <div class="panel"> <!-- Panel contenedor para los elementos del formulario -->
            <form action="index.php?action=guardar_beneficiario" method="POST"> <!-- Formulario para enviar los datos a 'index.php' con la acción 'guardar_beneficiario' usando el método POST -->
                <div class="form-column"> <!-- División para agrupar los campos del formulario -->
                    <label>Nombres:<span class="required">*</span></label> <!-- Etiqueta para el campo de Nombres, con un asterisco que indica que es obligatorio -->
                    <input type="text" name="nombres" required> <!-- Campo de entrada de texto para los nombres, marcado como obligatorio -->
                    
                    <label>Apellido Paterno:<span class="required">*</span></label> <!-- Etiqueta para el campo de Apellido Paterno -->
                    <input type="text" name="apellido_paterno" required> <!-- Campo de entrada de texto para el apellido paterno, obligatorio -->
                    
                    <label>Apellido Materno:<span class="required">*</span></label> <!-- Etiqueta para el campo de Apellido Materno -->
                    <input type="text" name="apellido_materno" required> <!-- Campo de entrada de texto para el apellido materno, obligatorio -->
                    
                    <label>DNI:<span class="required">*</span></label> <!-- Etiqueta para el campo de DNI -->
                    <input type="text" name="dni" required> <!-- Campo de entrada de texto para el DNI, obligatorio -->
                    
                    <label>Fecha de Nacimiento:<span class="required">*</span></label> <!-- Etiqueta para el campo de Fecha de Nacimiento -->
                    <input type="date" name="fecha_nacimiento" required> <!-- Campo de entrada para seleccionar la fecha de nacimiento, obligatorio -->
                </div>

                <div class="form-column"> <!-- Segunda división para agrupar los campos del formulario -->
                    <label>Edad:<span class="required">*</span></label> <!-- Etiqueta para el campo de Edad -->
                    <input type="number" name="edad" required> <!-- Campo de entrada para ingresar la edad, obligatorio -->
                    
                    <label>Condición:<span class="required">*</span></label> <!-- Etiqueta para el campo de Condición del beneficiario -->
                    <select name="condicion" required> <!-- Menú desplegable para seleccionar la condición del beneficiario, obligatorio -->
                        <option value="Seleccione">Seleccione</option> <!-- Opción por defecto para que el usuario seleccione una condición -->
                        <option value="Madres Gestantes">Madres Gestantes</option> <!-- Opción para seleccionar "Madres Gestantes" -->
                        <option value="Niños de 0 a 6">Niños de 0 a 6</option> <!-- Opción para seleccionar "Niños de 0 a 6" -->
                        <option value="Niños de 7 a 13">Niños de 7 a 13</option> <!-- Opción para seleccionar "Niños de 7 a 13" -->
                        <option value="Adulto Mayor">Adulto Mayor</option> <!-- Opción para seleccionar "Adulto Mayor" -->
                    </select>
                    
                    <label>Dirección:<span class="required">*</span></label> <!-- Etiqueta para el campo de Dirección -->
                    <input type="text" name="direccion" required> <!-- Campo de entrada de texto para la dirección, obligatorio -->
                    
                    <label>Apoderado:</label> <!-- Etiqueta para el campo de Apoderado, que no es obligatorio -->
                    <input type="text" name="nombre_apoderado"> <!-- Campo de entrada de texto para el nombre del apoderado, no obligatorio -->
                    
                    <!-- Botón para enviar el formulario con un ícono -->
                    <button type="submit">
                        <img src="img/guardarbenef.png" alt="Guardar" width="20" height="20"> Guardar Beneficiario <!-- Imagen con ícono de guardar y texto que indica la acción -->
                    </button>
                </div>
            </form>
        </div> <!-- Fin del panel -->
    </div>
</div>
