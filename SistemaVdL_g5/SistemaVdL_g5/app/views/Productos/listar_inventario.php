<?php
// Incluir el archivo 'nav.php' que contiene el menú de navegación
require_once 'app/views/nav.php'; 

// Incluir el archivo 'app/models/Inventario.php' donde se encuentra el modelo de inventario
require_once 'app/models/Inventario.php';

// Crear una instancia del modelo Inventario para poder acceder a sus métodos
$inventarioModel = new Inventario();
// Llamar al método 'obtenerInventario' para obtener todos los productos del inventario
$productos = $inventarioModel->obtenerInventario();
?>

<!-- Contenedor principal centrado con márgenes para separar de los bordes de la página -->
<div style="margin-left: 180px; padding: 60px 50px 50px 100px; display: flex; flex-direction: column; align-items: center; width: calc(90% - 180px);">
    <div style="width: 90%; max-width: 1000px; text-align: center;">
        <!-- Título de la página de inventario -->
        <h2>Inventario de Productos</h2>

        <!-- Incluir el archivo CSS para el estilo de la página -->
        <link rel="stylesheet" href="public/Estilos/styleBenef.css">
        
        <!-- Tabla donde se mostrarán los productos del inventario -->
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 10px;">
            <thead>
                <tr>
                    <!-- Encabezados de las columnas de la tabla -->
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Umbral de Alerta</th>
                    <th>Fecha de Actualización</th>
                    <th>Estado</th>
                    <th>Acciones</th> <!-- Nueva columna de acciones (para eliminar producto) -->
                </tr>
            </thead>
            <tbody>
                <!-- Iterar sobre cada producto del inventario para mostrar sus datos en la tabla -->
                <?php foreach ($productos as $producto): ?>
                <tr>
                    <!-- Mostrar el ID del producto -->
                    <td><?php echo $producto['id']; ?></td>
                    <!-- Mostrar el nombre del producto -->
                    <td><?php echo $producto['producto']; ?></td>
                    <!-- Mostrar la cantidad del producto -->
                    <td><?php echo $producto['cantidad']; ?></td>
                    <!-- Mostrar el umbral de alerta del producto -->
                    <td><?php echo $producto['umbral_alerta']; ?></td>
                    <!-- Mostrar la fecha de última actualización del producto -->
                    <td><?php echo $producto['fecha_actualizacion']; ?></td>
                    <td>
                        <!-- Mostrar el estado del producto en función de si la cantidad es inferior al umbral de alerta -->
                        <?php if ($producto['cantidad'] <= $producto['umbral_alerta']): ?>
                            <span style="color: red;">Inventario Bajo</span> <!-- Color rojo si el inventario es bajo -->
                        <?php else: ?>
                            <span style="color: green;">Suficiente</span> <!-- Color verde si el inventario es suficiente -->
                        <?php endif; ?>
                    </td>
                    <td>
                        <!-- Botón para eliminar el producto, con un icono de eliminar -->
                        <a href="index.php?action=eliminar_producto&id=<?php echo $producto['id']; ?>" 
                            class="eliminar-boton" onclick="return confirm('¿Estás seguro de eliminar este producto?');">
                            <img src="img/usuario_eliminar.png" alt="Eliminar">
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Estilo CSS específico para los enlaces de eliminar producto -->
<style>
/* Estilo para el enlace de eliminar producto */
a[href*='eliminar_producto'] {
    display: inline-block; /* Mostrar el enlace como un bloque en línea */
    background-color: #ffc1c1; /* Fondo rojo pastel claro */
    border: 2px solid #ff8a8a; /* Borde más oscuro que el fondo */
    border-radius: 5px; /* Bordes redondeados */
    padding: 5px 10px; /* Espaciado interno para el enlace */
    transition: background-color 0.3s, transform 0.2s; /* Transición suave para el fondo y la transformación */
    text-decoration: none; /* Eliminar el subrayado del enlace */
}

/* Estilo al pasar el cursor sobre el enlace de eliminar producto */
a[href*='eliminar_producto']:hover {
    background-color: #ff8a8a; /* Fondo más oscuro cuando se pasa el cursor */
    cursor: pointer; /* Cambiar el cursor al pasar por encima */
    transform: scale(1.05); /* Agrandar ligeramente el enlace */
}

/* Estilo para la imagen dentro del enlace de eliminar */
a[href*='eliminar_producto'] img {
    vertical-align: middle; /* Alineación vertical de la imagen */
    width: 20px; /* Ancho de la imagen */
    height: 20px; /* Alto de la imagen */
}
</style>
