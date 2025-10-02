<?php
require_once 'app/views/nav.php'; // Incluir el menú de navegación
require_once 'app/models/Beneficiario.php';

// Obtener los datos del beneficiario actual
$beneficiarioModel = new Beneficiario();
$beneficiario = $beneficiarioModel->obtenerBeneficiarioPorId($_GET['id']);
?>

<div style="margin-left: 180px; padding: 60px 50px 50px 90px; display: flex; flex-direction: column; align-items: center; width: calc(90% - 180px);">
    <div class="container">
        <h2>Editar Beneficiario</h2>
        <link rel="stylesheet" href="public/Estilos/styleditB.css">
        <div class="panel">
        <form action="index.php?action=actualizar_beneficiario&id=<?php echo $beneficiario['id']; ?>" method="POST">
    <div class="form-column">
        <label>Nombres:<span class="required">*</span></label>
        <input type="text" name="nombres" value="<?php echo $beneficiario['nombres']; ?>" required>

        <label>Apellido Paterno:<span class="required">*</span></label>
        <input type="text" name="apellido_paterno" value="<?php echo $beneficiario['apellido_paterno']; ?>" required>

        <label>Apellido Materno:<span class="required">*</span></label>
        <input type="text" name="apellido_materno" value="<?php echo $beneficiario['apellido_materno']; ?>" required>

        <label>DNI:<span class="required">*</span></label>
        <input type="text" name="dni" value="<?php echo $beneficiario['dni']; ?>" required>
    </div>
    <div class="form-column">
        <label>Fecha de Nacimiento:<span class="required">*</span></label>
        <input type="date" name="fecha_nacimiento" value="<?php echo $beneficiario['fecha_nacimiento']; ?>" required>

        <label>Edad:<span class="required">*</span></label>
        <input type="number" name="edad" value="<?php echo $beneficiario['edad']; ?>" required>

        <label>Condición:<span class="required">*</span></label>
        <select name="condicion" required>
            <option value="Madres Gestantes" <?php echo $beneficiario['condicion'] == 'Madres Gestantes' ? 'selected' : ''; ?>>Madres Gestantes</option>
            <option value="Madres Lactantes" <?php echo $beneficiario['condicion'] == 'Madres Lactantes' ? 'selected' : ''; ?>>Madres Lactantes</option>
            <option value="Niños de 0 a 6" <?php echo $beneficiario['condicion'] == 'Niños de 0 a 6' ? 'selected' : ''; ?>>Niños de 0 a 6</option>
            <option value="Adulto Mayor" <?php echo $beneficiario['condicion'] == 'Adulto Mayor' ? 'selected' : ''; ?>>Adulto Mayor</option>
            <option value="Discapacitados" <?php echo $beneficiario['condicion'] == 'Discapacitados' ? 'selected' : ''; ?>>Discapacitados</option>
        </select>

        <label>Dirección:<span class="required">*</span></label>
        <input type="text" name="direccion" value="<?php echo $beneficiario['direccion']; ?>" required>
    </div>

    <button type="submit">Actualizar Beneficiario</button>
    </form>

    </div>
    </div>
</div>
