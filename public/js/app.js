/**
 * Sistema de Citas Médicas
 * JavaScript principal
 */

document.addEventListener('DOMContentLoaded', () => {

    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');

    if (menuToggle && sidebar) {

        menuToggle.addEventListener('click', () => {

            const isOpen = sidebar.classList.toggle('open');

            menuToggle.setAttribute(
                'aria-expanded',
                isOpen ? 'true' : 'false'
            );

            menuToggle.setAttribute(
                'aria-label',
                isOpen
                    ? 'Cerrar menú'
                    : 'Abrir menú'
            );
        });

    }


    /*
     * Cerrar el menú móvil al seleccionar una opción
     */

    const navigationLinks =
        document.querySelectorAll('.sidebar .nav-link');

    navigationLinks.forEach((link) => {

        link.addEventListener('click', () => {

            if (
                window.innerWidth <= 800 &&
                sidebar
            ) {

                sidebar.classList.remove('open');

                if (menuToggle) {

                    menuToggle.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                    menuToggle.setAttribute(
                        'aria-label',
                        'Abrir menú'
                    );
                }
            }

        });

    });

});