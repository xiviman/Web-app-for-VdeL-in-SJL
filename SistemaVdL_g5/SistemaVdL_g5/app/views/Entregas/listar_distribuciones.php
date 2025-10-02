<?php
// Incluir el archivo de navegación para mostrar el menú en la página
require_once 'app/views/nav.php'; 

// Incluir el modelo 'Distribucion.php' para trabajar con la base de datos y las funciones relacionadas con las distribuciones
require_once 'app/models/Distribucion.php';

// Inicializar el objeto del modelo Distribucion para poder usar sus métodos
$distribucionModel = new Distribucion();

// Manejo de eliminación de distribución: se verifica si existe una acción 'eliminar_distribucion' en la URL y un ID de distribución
if (isset($_GET['action']) && $_GET['action'] === 'eliminar_distribucion' && isset($_GET['id'])) {
    // Convertir el ID recibido a un número entero para mayor seguridad (previene inyecciones SQL)
    $id = intval($_GET['id']); 

    // Llamar al método 'eliminarDistribucion' del modelo, pasando el ID para eliminar la distribución correspondiente
    $resultado = $distribucionModel->eliminarDistribucion($id);

    // Si la eliminación fue exitosa, mostrar un mensaje de éxito usando un script de JavaScript
    if ($resultado) {
        echo "<script>alert('Distribución eliminada con éxito.');</script>";
    } else {
        // Si hubo un error al eliminar, mostrar un mensaje de error
        echo "<script>alert('Error al eliminar la distribución.');</script>";
    }

    // Redirigir al usuario de vuelta al listado de distribuciones para evitar múltiples eliminaciones al recargar la página
    echo "<script>window.location.href = 'index.php';</script>";
    exit; // Terminar la ejecución del script para evitar que continúe cargando el resto del código
}

// Obtener la lista de distribuciones usando el método 'obtenerDistribuciones' del modelo
$distribuciones = $distribucionModel->obtenerDistribuciones();
?>

<!-- Contenedor principal con un padding para separar el contenido del borde de la página -->
<div style="margin-left: 180px; padding: 40px 50px 50px 50px; display: flex; flex-direction: column; align-items: center; width: calc(100% - 180px);">
    <div style="width: 90%; max-width: 1000px; text-align: center;">
        <!-- Título que indica que estamos mostrando un listado de entregas realizadas -->
        <h2>Listado de Entregas Realizadas</h2>

        <!-- Enlace al archivo de estilo CSS para darle formato a la tabla -->
        <link rel="stylesheet" href="public/Estilos/styleBenef.css">

        <!-- Crear una tabla para mostrar los datos de las distribuciones -->
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 10px; text-align: left;">
            <thead>
                <tr>
                    <!-- Encabezados de las columnas de la tabla -->
                    <th>ID</th>
                    <th>Beneficiario</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Fecha de Entrega</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Usar un bucle 'foreach' para iterar sobre las distribuciones obtenidas y mostrar cada una en una fila de la tabla -->
                <?php foreach ($distribuciones as $distribucion): ?>
                <tr>
                    <!-- Mostrar el ID de la distribución -->
                    <td><?php echo $distribucion['id']; ?></td>

                    <!-- Mostrar el nombre completo del beneficiario concatenando los nombres y apellidos -->
                    <td><?php echo $distribucion['nombres'] . " " . $distribucion['apellido_paterno'] . " " . $distribucion['apellido_materno']; ?></td>

                    <!-- Mostrar el nombre del producto -->
                    <td><?php echo $distribucion['producto']; ?></td>

                    <!-- Mostrar la cantidad entregada -->
                    <td><?php echo $distribucion['cantidad']; ?></td>

                    <!-- Mostrar la fecha de entrega -->
                    <td><?php echo $distribucion['fecha_entrega']; ?></td>

                    <td>
                        <!-- Crear un enlace para eliminar la distribución, con una confirmación antes de proceder -->
                        <a href="index.php?action=eliminar_distribucion&id=<?php echo $distribucion['id']; ?>" 
                           onclick="return confirm('¿Estás seguro de eliminar esta entrega?');">
                           <!-- Mostrar una imagen de eliminar (ícono de basurero) -->
                           <img src="img/usuario_eliminar.png" alt="Eliminar" style="width: 20px; height: 20px;">
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Bloque de estilos CSS para personalizar la apariencia de los enlaces de eliminación -->
        <style>
            /* Estilo específico para los enlaces de eliminar beneficiario o distribución */
            a[href*='eliminar_distribucion'] {
                display: inline-block;
                background-color: #ffc1c1; /* Color de fondo rojo pastel claro */
                border: 2px solid #ff8a8a; /* Borde con color rojo más oscuro */
                border-radius: 5px; /* Bordes redondeados */
                padding: 5px 10px; /* Espaciado interno */
                transition: background-color 0.3s, transform 0.2s; /* Transición suave para cambio de color y tamaño */
                text-decoration: none; /* Sin subrayado en el enlace */
            }

            /* Estilo cuando el usuario pasa el mouse por encima del enlace */
            a[href*='eliminar_distribucion']:hover {
                background-color: #ff8a8a; /* Color de fondo rojo pastel más oscuro */
                cursor: pointer; /* Cambiar el cursor cuando pasa por encima */
                transform: scale(1.05); /* Aumentar ligeramente el tamaño del enlace */
            }

            /* Estilo para la imagen dentro del enlace */
            a[href*='eliminar_distribucion'] img {
                vertical-align: middle; /* Alineación vertical de la imagen */
                width: 20px; /* Ancho de la imagen */
                height: 20px; /* Altura de la imagen */
            }
        </style>
    </div>
</div>
