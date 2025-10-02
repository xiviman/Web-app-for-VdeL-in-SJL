<?php
require_once 'app/views/nav.php'; // Incluir el menú de navegación
require_once 'app/models/Beneficiario.php';
$beneficiarioModel = new Beneficiario();

$search = $_GET['search'] ?? '';

if ($search) {
    // Filtrar beneficiarios por búsqueda
    $beneficiarios = $beneficiarioModel->buscarBeneficiarios($search);
} else {
    $beneficiarios = $beneficiarioModel->obtenerBeneficiarios();
}
?>

<div style="margin-left: 180px; padding: 80px 50px 50px 50px; display: flex; flex-direction: column; align-items: center; width: calc(100% - 180px);">
    <h2>Lista de Beneficiarios</h2>


<!-- Fila con los botones de añadir beneficiario, buscar y imprimir -->
<div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px;">
    <!-- Botón para añadir beneficiario -->
    <a href="index.php?action=crear_beneficiario" class="add-button">
        <img src="img/anadir.png" alt="Añadir Beneficiario" style="width: 20px; height: 20px; vertical-align: middle;">
    </a>

    <!-- Formulario de búsqueda -->
    <form action="index.php" method="GET" style="display: flex; align-items: center;" class="search-form">
        <input type="hidden" name="action" value="beneficiarios">
        <input type="text" name="search" placeholder="Buscar beneficiario" value="<?= htmlspecialchars($search) ?>" class="search-input">
        <button type="submit" class="search-button">
            <img src="img/buscar.png" alt="Buscar" class="search-icon">
        </button>
        <?php if ($search): ?>
            <a href="index.php?action=beneficiarios" class="reset-button">
                <img src="img/deshacer.png" alt="Regresar" class="reset-icon">
            </a>
        <?php endif; ?>
    </form>

    <!-- Botón para imprimir -->
    <button onclick="imprimir()" class="print-button">
        <img src="img/imprimir.png" alt="Imprimir" class="print-icon">
    </button>
</div>


    <link rel="stylesheet" href="public/Estilos/styleBenef.css">

    <table border="1" cellpadding="10" cellspacing="0" style="margin-top: 10px; width: 80%; max-width: 1200px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>DNI</th>
                <th>Fecha de Nacimiento</th>
                <th>Edad</th>
                <th>Condición</th>
                <th>Dirección</th>
                <th>Apoderado</th>
                <th class="acciones-col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($beneficiarios as $beneficiario): ?>
            <tr>
                <td><?php echo $beneficiario['id']; ?></td>
                <td><?php echo $beneficiario['nombres']; ?></td>
                <td><?php echo $beneficiario['apellido_paterno']; ?></td>
                <td><?php echo $beneficiario['apellido_materno']; ?></td>
                <td><?php echo $beneficiario['dni']; ?></td>
                <td><?php echo $beneficiario['fecha_nacimiento']; ?></td>
                <td><?php echo $beneficiario['edad']; ?></td>
                <td><?php echo $beneficiario['condicion']; ?></td>
                <td><?php echo $beneficiario['direccion']; ?></td>
                <td><?php echo $beneficiario['nombre_apoderado']; ?></td>
                <td class="acciones-col">
                    <!-- Botón para editar -->
                    <a href="index.php?action=editar_beneficiario&id=<?php echo $beneficiario['id']; ?>">
                        <img src="img/editar_info.png" alt="Editar" style="width: 20px; height: 20px;">
                    </a>
                    <!-- Botón para eliminar -->
                    <a href="index.php?action=eliminar_beneficiario&id=<?php echo $beneficiario['id']; ?>">
                        <img src="img/usuario_eliminar.png" alt="Eliminar" style="width: 20px; height: 20px;">
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    // Función de impresión
    function imprimir() {
        // Crear un nuevo contenido para la impresión
        var imprimirContenido = `
            <div id="info-imprimir" style="position: relative;">
                <h2>Lista de Beneficiarios</h2>
                <p>Sra. Olinda Mucha, Coordinadora del Programa</p>
                <p>Fecha y Hora: ${new Date().toLocaleString()}</p>
                ${document.querySelector('table').outerHTML}
                <img src="img/vacalola.png" alt="Logo" style="position: absolute; top: 10px; right: 10px; width: 50px; height: 50px;">
            </div>
        `;
        
        // Guardar el contenido original y reemplazarlo temporalmente
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = imprimirContenido;

        // Remover columna de acciones para impresión
        document.querySelectorAll('#info-imprimir .acciones-col').forEach(function(col) {
            col.style.display = 'none';
        });

        // Imprimir el contenido
        window.print();
        
        // Restaurar el contenido original
        document.body.innerHTML = originalContent;
    }
</script>

<style>
    /* Estilos para la impresión */
    @media print {
        body * {
            visibility: hidden;
        }
        #info-imprimir, #info-imprimir * {
            visibility: visible;
        }
        #info-imprimir {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }
        #info-imprimir table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        #info-imprimir table, #info-imprimir th, #info-imprimir td {
            border: 1px solid #000;
        }
        #info-imprimir th, #info-imprimir td {
            padding: 10px;
            text-align: left;
        }
        /* Estilo para el logo */
        #info-imprimir img {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 50px;
            height: 50px;
            opacity: 0.5;
        }
    }
</style>
