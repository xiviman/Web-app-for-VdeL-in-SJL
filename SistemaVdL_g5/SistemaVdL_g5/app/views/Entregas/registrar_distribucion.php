<?php
// Incluir el archivo 'nav.php', que probablemente contiene el menú de navegación de la página
require_once 'app/views/nav.php'; 

// Incluir los modelos necesarios para manejar los datos de beneficiarios e inventario
require_once 'app/models/Beneficiario.php';
require_once 'app/models/Inventario.php';

// Crear una instancia del modelo Beneficiario para obtener la lista de beneficiarios
$beneficiarioModel = new Beneficiario();
$beneficiarios = $beneficiarioModel->obtenerBeneficiarios(); // Llamar al método para obtener beneficiarios desde la base de datos

// Crear una instancia del modelo Inventario para obtener la lista de productos
$inventarioModel = new Inventario();
$productos = $inventarioModel->obtenerInventario(); // Llamar al método para obtener el inventario desde la base de datos
?>

<!-- Comienza el contenedor principal de la página -->
<div style="margin-left: 330px; padding: 80px 50px 50px 50px; display: flex; flex-direction: column; align-items: center; width: calc(80% - 180px);">  <!-- Agregar un padding para espaciar el contenido -->
    <div class="container"> <!-- Contenedor que agrupa el contenido -->
        <h2>Registrar Nueva Entrega</h2> <!-- Título principal de la sección -->
        
        <!-- Enlace al archivo CSS para dar estilo al formulario -->
        <link rel="stylesheet" href="public/Estilos/styleADistri.css">
        
        <!-- Panel que contiene el formulario para registrar una nueva entrega -->
        <div class="form-panel">
            <!-- Inicio del formulario que envía datos mediante el método POST -->
            <form action="index.php?action=guardar_distribucion" method="POST" class="formulario">
                <!-- Campo para seleccionar un beneficiario -->
                <label for="beneficiario_id">Beneficiario<span class="required">*</span></label> <!-- Etiqueta con un asterisco indicando campo obligatorio -->
                <select name="beneficiario_id" id="beneficiario_id" required> <!-- Menú desplegable para elegir el beneficiario -->
                    <?php foreach ($beneficiarios as $beneficiario): ?> <!-- Bucle que recorre la lista de beneficiarios -->
                        <option value="<?php echo $beneficiario['id']; ?>"> <!-- Opción que usa el ID del beneficiario como valor -->
                            <?php echo $beneficiario['nombres'] . " " . $beneficiario['apellido_paterno'] . " " . $beneficiario['apellido_materno']; ?> <!-- Mostrar nombre completo del beneficiario -->
                        </option>
                    <?php endforeach; ?> <!-- Fin del bucle -->
                </select>

                <!-- Campo para seleccionar un producto -->
                <label for="producto_id">Producto<span class="required">*</span></label> <!-- Etiqueta para el campo producto -->
                <select name="producto_id" id="producto_id" required> <!-- Menú desplegable para elegir el producto -->
                    <?php foreach ($productos as $producto): ?> <!-- Bucle que recorre la lista de productos -->
                        <option value="<?php echo $producto['id']; ?>"> <!-- Opción que usa el ID del producto como valor -->
                            <?php echo $producto['producto']; ?> <!-- Mostrar el nombre del producto -->
                        </option>
                    <?php endforeach; ?> <!-- Fin del bucle -->
                </select>

                <!-- Campo para ingresar la cantidad de producto -->
                <label for="cantidad">Cantidad<span class="required">*</span></label> <!-- Etiqueta para el campo cantidad -->
                <input type="number" name="cantidad" id="cantidad" required> <!-- Input para ingresar la cantidad, solo permite números -->

                <!-- Campo para seleccionar la fecha de entrega -->
                <label for="fecha_entrega">Fecha de Entrega<span class="required">*</span></label> <!-- Etiqueta para el campo fecha de entrega -->
                <input type="date" name="fecha_entrega" id="fecha_entrega" required> <!-- Input para seleccionar una fecha -->

                <!-- Botón para enviar el formulario -->
                <button type="submit">Registrar Entrega</button> <!-- Botón que envía los datos del formulario -->
            </form>
        </div>
    </div>
</div>