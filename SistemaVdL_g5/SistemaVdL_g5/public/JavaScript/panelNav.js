// Resaltar el enlace activo al hacer clic
document.addEventListener('DOMContentLoaded', function () {
    // Obtener todos los enlaces
    const links = document.querySelectorAll('.navbar a');

    // Escuchar clics en los enlaces
    links.forEach(link => {
        link.addEventListener('click', function () {
            // Eliminar la clase activa de todos los enlaces
            links.forEach(item => item.classList.remove('active'));

            // Agregar la clase activa al enlace actual
            this.classList.add('active');
        });
    });
});