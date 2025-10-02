<?php
// Incluye los archivos necesarios para acceder a las funcionalidades de navegación y modelos de la base de datos
require_once 'nav.php'; // Este archivo incluye la barra de navegación del sitio web
require_once 'app/models/Beneficiario.php'; // Modelo de 'Beneficiario' que maneja las operaciones relacionadas con los beneficiarios
require_once 'app/models/Distribucion.php'; // Modelo de 'Distribucion' que maneja las operaciones relacionadas con la distribución de productos
require_once 'app/models/Inventario.php'; // Modelo de 'Inventario' que maneja las operaciones relacionadas con los productos disponibles

// Crear una instancia del modelo Inventario, para interactuar con la tabla de inventarios
$inventario = new Inventario();
// Llamamos a la función 'contarProductos' para obtener el total de productos disponibles en el inventario
$totalProductos = $inventario->contarProductos();

// Crear una instancia del modelo Distribucion, para interactuar con la tabla de distribuciones
$distribucion = new Distribucion();
// Llamamos a la función 'contarEntregas' para obtener el total de entregas realizadas
$totalEntregas = $distribucion->contarEntregas();

// Crear una instancia del modelo Beneficiario, para interactuar con la tabla de beneficiarios
$beneficiario = new Beneficiario();
// Llamamos a la función 'contarBeneficiarios' para obtener el total de beneficiarios registrados
$totalBeneficiarios = $beneficiario->contarBeneficiarios();

// Llamamos a la función 'contarBeneficiariosPorEdad' para obtener la distribución de beneficiarios por edad
$distribucionPorEdad = $beneficiario->contarBeneficiariosPorEdad();

// Llamamos a la función 'obtenerEntregasPorMes' para obtener el número de entregas realizadas por mes
$entregasPorMes = $distribucion->obtenerEntregasPorMes();

?>

<!-- Contenedor principal para el contenido de la página -->
<div class="content"> <!-- Contenedor que envuelve todo el contenido de la página -->

    <!-- Dashboard: Contenedor de los paneles con estadísticas generales -->
    <div class="dashboard"> <!-- Panel que contiene los indicadores principales de la aplicación -->
        
        <!-- Panel de Beneficiarios -->
        <div class="panel panel-beneficiarios">
            <i class="fas fa-users"></i> <!-- Icono de usuarios (beneficiarios) -->
            <h3>Beneficiarios</h3> <!-- Título del panel -->
            <p><?php echo $totalBeneficiarios; ?> registrados</p> <!-- Muestra el total de beneficiarios obtenidos desde el modelo -->
        </div>
        
        <!-- Panel de Productos -->
        <div class="panel panel-productos">
            <i class="fas fa-boxes"></i> <!-- Icono de productos -->
            <h3>Productos</h3> <!-- Título del panel -->
            <p><?php echo $totalProductos; ?> disponibles</p> <!-- Muestra el total de productos disponibles en inventario -->
        </div>

        <!-- Panel de Entregas -->
        <div class="panel panel-entregas">
            <i class="fas fa-truck"></i> <!-- Icono de camión para representar las entregas -->
            <h3>Entregas</h3> <!-- Título del panel -->
            <p><?php echo $totalEntregas; ?> realizadas</p> <!-- Muestra el total de entregas realizadas -->
        </div>
    </div>

    <!-- Gráficos -->
    <div class="charts"> <!-- Contenedor de los gráficos para mostrar las estadísticas visualmente -->

        <!-- Panel para el gráfico de distribución de beneficiarios -->
        <div class="panel chart-panel">
            <h3>Distribución de Beneficiarios</h3> <!-- Título del gráfico -->
            <canvas id="doughnutChartBeneficiarios"></canvas> <!-- Elemento 'canvas' donde se dibujará el gráfico de dona -->
        </div>

        <!-- Panel para el gráfico de entregas por mes -->
        <div class="panel chart-panel">
            <h3>Entregas por Mes</h3> <!-- Título del gráfico -->
            <canvas id="barChartEntregas"></canvas> <!-- Elemento 'canvas' donde se dibujará el gráfico de barras -->
        </div>
    </div>

</div>

<!-- Inclusión de la librería Chart.js para crear los gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Carga la librería Chart.js desde un CDN -->

<script>
// Datos de distribución de beneficiarios obtenidos de PHP y convertidos a formato JSON para usar en JavaScript
    const distribucionPorEdad = <?php echo json_encode($distribucionPorEdad); ?>; // Transforma el array PHP en un objeto JavaScript

    // Inicialización del gráfico de dona para la distribución de beneficiarios
    const ctxBeneficiarios = document.getElementById('doughnutChartBeneficiarios').getContext('2d'); // Obtiene el contexto del canvas donde se dibujará el gráfico de dona
    const doughnutChartBeneficiarios = new Chart(ctxBeneficiarios, { // Crea un nuevo gráfico de dona
        type: 'doughnut', // Tipo de gráfico (dona)
        data: { // Los datos que se mostrarán en el gráfico
            labels: ['Niños de 0 a 6', 'Niños de 7 a 13', 'Madres Gestantes', 'Adultos Mayores'], // Las etiquetas de cada segmento del gráfico
            datasets: [{
                label: 'Número de Beneficiarios', // Etiqueta para el conjunto de datos
                data: [
                    distribucionPorEdad['Niños de 0 a 6'], // Número de beneficiarios en el grupo de edad 0-6 años
                    distribucionPorEdad['Niños de 7 a 13'], // Número de beneficiarios en el grupo de edad 7-13 años
                    distribucionPorEdad['Madres Gestantes'], // Número de beneficiarios en la categoría de madres gestantes
                    distribucionPorEdad['Adultos Mayores'] // Número de beneficiarios en la categoría de adultos mayores
                ],
                backgroundColor: ['#FFB6C1', '#B0E0E6', '#D8B7DD', '#B0E57C'], // Colores para cada segmento de la dona
                borderColor: '#fff', // Color del borde de cada segmento
                borderWidth: 1 // Ancho del borde de cada segmento
            }]
        },
        options: { // Opciones para personalizar el gráfico
            responsive: true, // Hace que el gráfico sea responsivo, ajustándose a distintos tamaños de pantalla
            plugins: {
                tooltip: { // Configura la funcionalidad del tooltip (información emergente)
                    callbacks: {
                        label: function(tooltipItem) {
                            let percentage = tooltipItem.raw; // Valor del segmento
                            let total = tooltipItem.dataset.data.reduce((a, b) => a + b, 0); // Suma de los valores de todos los segmentos
                            let percentageText = total > 0 ? Math.round((percentage / total) * 100) + '%' : '%'; // Calcula el porcentaje
                            return tooltipItem.label + ': ' + percentage + ' (' + percentageText + ')'; // Muestra el porcentaje en el tooltip
                        }
                    }
                },
                legend: {
                    position: 'top', // Posiciona la leyenda en la parte superior
                },
                hover: {
                    onHover: function(event, chartElement) {
                        const tooltip = chartElement[0] ? chartElement[0]._model : null; // Obtiene el modelo del tooltip cuando se pasa el ratón
                        if (tooltip) {
                            tooltip.backgroundColor = 'rgba(255, 99, 132, 0.6)'; // Cambia el color del fondo del tooltip cuando el ratón está encima
                            chart.update(); // Actualiza el gráfico
                        }
                    }
                }
            }
        }
    });


// Datos de entregas por mes obtenidos de PHP y convertidos a formato JSON para usar en JavaScript
const entregasPorMes = <?php echo json_encode($entregasPorMes); ?>; // Convierte el array de entregas por mes en un objeto JavaScript

// Inicializamos un array con 12 elementos para representar los 12 meses del año
let dataPorMes = Array(12).fill(0); // Rellena el array con ceros inicialmente

// Asignamos las entregas de la base de datos a los meses correspondientes
entregasPorMes.forEach(item => {
    // item.mes es el número del mes (1-12), y item.total es el total de entregas en ese mes
    dataPorMes[item.mes - 1] = item.total; // Asigna el número de entregas al mes correspondiente
});

const ctxEntregas = document.getElementById('barChartEntregas').getContext('2d'); // Obtiene el contexto del canvas donde se dibujará el gráfico de barras
const barChartEntregas = new Chart(ctxEntregas, { // Crea el gráfico de barras
    type: 'bar', // Tipo de gráfico (barras)
    data: { // Datos que se mostrarán en el gráfico
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'], // Etiquetas de los meses
        datasets: [{
            label: 'Entregas Mensuales', // Etiqueta para el conjunto de datos
            data: dataPorMes, // Datos de entregas por mes
            backgroundColor: 'rgba(75, 192, 192, 0.6)', // Color de fondo de las barras
            borderColor: 'rgba(75, 192, 192, 1)', // Color del borde de las barras
            borderWidth: 1 // Ancho del borde de las barras
        }]
    },
    options: { // Opciones para personalizar el gráfico
        responsive: true, // Hace que el gráfico sea responsivo
        scales: { // Configuración de las escalas (ejes)
            y: {
                beginAtZero: true, // Comienza el eje Y en 0
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.dataset.label + ': ' + tooltipItem.raw + ' entregas'; // Muestra el número de entregas en el tooltip
                    }
                }
            }
        }
    }
});
</script>

<style>
    :root {
        --bg-primary: #fdf1f1; /* Color de fondo principal de la página */
        --navbar-bg: #789DBC; /* Color de fondo para la barra de navegación */
        --header-bg: #E8A0BF; /* Color de fondo para los encabezados */
        --text-light: #FFFFFF; /* Color de texto claro, usado en fondos oscuros */
        --text-dark: #4F4F4F; /* Color de texto oscuro, usado para el texto principal */
        --highlight: #A5D6A7; /* Color de resaltado, usado en ciertos paneles */
        --hover-highlight: #90CAF9; /* Color al pasar el cursor por encima de ciertos elementos */
        --icon-active: #1E88E5; /* Color para los iconos activos */
        --shadow-color: rgba(0, 0, 0, 0.1); /* Color de sombra, se usa en varios elementos */
    }

    body {
        margin: 0; /* Elimina márgenes por defecto */
        font-family: 'Roboto', sans-serif; /* Establece la fuente principal del sitio */
        background-color: var(--bg-primary); /* Aplica el color de fondo principal */
        color: var(--text-dark); /* Establece el color del texto principal */
    }

    .content {
        padding: 10px; /* Espaciado interno alrededor del contenido */
        display: flex; /* Utiliza el modelo de caja flexible */
        flex-direction: column; /* Alinea los elementos en columna */
        align-items: center; /* Centra los elementos horizontalmente */
        position: relative; /* Posicionamiento relativo para poder usar valores de posicionamiento */
        min-height: 10vh; /* Asegura que la altura mínima de la página cubra toda la ventana */
    }

    /* Dashboard */
    .dashboard {
        display: flex; /* Utiliza el modelo de caja flexible */
        justify-content: center; /* Centra los paneles de manera horizontal */
        gap: 20px; /* Espaciado entre los paneles */
        width: 100%; /* El ancho será el 100% disponible */
        max-width: 900px; /* Limita el ancho máximo a 900px */
        margin-top: 90px; /* Espaciado superior */
        z-index: 1; /* Establece un nivel de apilamiento mayor para que se muestre sobre otros elementos */
    }

    .panel {
        flex: 1; /* Los paneles ocupan un espacio flexible igual */
        background-color: var(--navbar-bg); /* Fondo de cada panel con el color de la barra de navegación */
        border-radius: 10px; /* Bordes redondeados de los paneles */
        padding: 20px; /* Espaciado interno dentro del panel */
        text-align: center; /* Centra el texto dentro del panel */
        box-shadow: 0px 4px 8px var(--shadow-color); /* Sombra del panel */
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* Animación suave para el cambio de tamaño y sombra */
        color: var(--text-light); /* Establece el color del texto dentro de los paneles */
    }

    .panel i {
        font-size: 40px; /* Tamaño de los iconos dentro del panel */
        margin-bottom: 10px; /* Espaciado inferior del icono */
        color: var(--icon-active); /* Color de los iconos activos */
    }

    .panel h3 {
        margin: 10px 0; /* Espaciado superior e inferior para los encabezados */
        font-size: 1.5em; /* Tamaño de fuente para los encabezados */
    }

    .panel p {
        font-size: 1.2em; /* Tamaño de fuente para los párrafos dentro del panel */
    }

    .panel:hover {
        transform: scale(1.05); /* Escala ligeramente el panel cuando se pasa el cursor */
        box-shadow: 0px 6px 15px var(--shadow-color); /* Aumenta el tamaño de la sombra al pasar el cursor */
    }

    .panel-beneficiarios {
        background-color: var(--header-bg); /* Color de fondo específico para el panel de beneficiarios */
        border: 2px solid var(--highlight); /* Borde del panel con el color de resaltado */
    }

    .panel-productos {
        background-color: var(--highlight); /* Color de fondo específico para el panel de productos */
        border: 2px solid var(--highlight); /* Borde del panel con el color de resaltado */
    }

    .panel-entregas {
        background-color: var(--hover-highlight); /* Color de fondo específico para el panel de entregas */
        border: 2px solid var(--highlight); /* Borde del panel con el color de resaltado */
    }

    .project-info {
        margin-top: 20px; /* Espaciado superior del panel de información del proyecto */
        padding: 10px; /* Espaciado interno del panel */
        background-color: var(--bg-primary); /* Color de fondo de la sección */
        text-align: center; /* Centra el texto dentro del panel */
        font-size: 1.2em; /* Tamaño de fuente para el texto */
        width: 80%; /* Ancho del panel al 80% del contenedor padre */
        max-width: 800px; /* Limita el ancho máximo del panel a 800px */
    }

    /* Gráficos */
    /* Estilo para los títulos de los gráficos */
    .chart-panel h3 {
        color: var(--text-dark); /* Establece el color oscuro para los títulos de los gráficos */
    }
    .charts {
        display: flex; /* Utiliza el modelo de caja flexible para los gráficos */
        justify-content: center; /* Centra los gráficos de manera horizontal */
        gap: 30px; /* Espaciado entre los gráficos */
        margin-top: 40px; /* Espaciado superior de los gráficos */
    }

    .chart-panel {
        width: 400px; /* Ancho de cada panel de gráfico */
        max-width: 100%; /* El panel puede ocupar el 100% del contenedor disponible */
        background-color: var(--text-light); /* Color de fondo de los paneles de gráficos */
        border-radius: 10px; /* Bordes redondeados en los paneles */
        padding: 20px; /* Espaciado interno en los paneles */
        box-shadow: 0px 4px 8px var(--shadow-color); /* Sombra en los paneles de gráficos */
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* Animación suave al pasar el cursor */
    }

    .chart-panel:hover {
        transform: scale(1.05); /* Escala el panel de gráfico al pasar el cursor */
        box-shadow: 0px 6px 15px var(--shadow-color); /* Aumenta la sombra del panel de gráfico */
    }
</style>