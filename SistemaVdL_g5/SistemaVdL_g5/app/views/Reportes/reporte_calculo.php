<?php
require_once 'app/views/nav.php';
require_once 'app/models/Beneficiario.php';
require_once 'app/models/Calculo.php';

$beneficiarioModel = new Beneficiario();
$beneficiarios = $beneficiarioModel->obtenerBeneficiarios();
$calculoModel = new Calculo();
?>

<div style="margin-left: 180px; padding: 90px 50px 50px 100px; display: flex; flex-direction: column; align-items: center; width: calc(90% - 180px);">
    <h2 style="text-align: center;">Reporte de Cantidad Asignada de Leche por Beneficiario</h2>
    <link rel="stylesheet" href="public/Estilos/styleBenef.css">
    
    <div style="display: flex; justify-content: center; align-items: center; flex-direction: column; width: 100%; max-width: 1000px; margin: 0 auto;">
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 10px; text-align: center;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Edad</th>
                    <th>Cantidad Asignada (ml)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($beneficiarios as $beneficiario): ?>
                    <?php
                        // Calcular la cantidad asignada según la edad
                        $cantidadLeche = $calculoModel->calcularCantidadPorEdad($beneficiario['edad']);
                    ?>
                    <tr>
                        <td><?php echo $beneficiario['id']; ?></td>
                        <td><?php echo $beneficiario['nombres'] . " " . $beneficiario['apellido_paterno'] . " " . $beneficiario['apellido_materno']; ?></td>
                        <td><?php echo $beneficiario['edad']; ?></td>
                        <td><?php echo $cantidadLeche; ?> ml</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
