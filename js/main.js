document.addEventListener('DOMContentLoaded', () => {
    // 1. Menú móvil responsive
    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.getElementById('nav-links');

    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });

    // Cerrar menú al hacer clic en un enlace
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('active');
        });
    });

    // 2. Envío del formulario de contacto con Fetch API
    const contactForm = document.getElementById('contactForm');
    const formResponse = document.getElementById('formResponse');
    const btnSubmit = document.getElementById('btnSubmit');

    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        btnSubmit.disabled = true;
        btnSubmit.textContent = 'Enviando...';
        formResponse.className = 'form-response';
        formResponse.textContent = '';

        const formData = new FormData(contactForm);

        try {
            const response = await fetch('php/procesar_contacto.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.status === 'success') {
                formResponse.classList.add('success');
                formResponse.textContent = data.message;
                contactForm.reset();
            } else {
                formResponse.classList.add('error');
                formResponse.textContent = data.message;
            }
        } catch (error) {
            formResponse.classList.add('error');
            formResponse.textContent = 'Error de conexión con el servidor. Inténtalo más tarde.';
        } finally {
            btnSubmit.disabled = false;
            btnSubmit.textContent = 'Enviar Mensaje';
        }
    });
});