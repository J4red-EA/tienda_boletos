// validaciones.js

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactoForm');
    // Si no encuentras el formulario, no hagas nada más (útil si el script se carga en todas las páginas)
    if (!form) {
        return;
    }

    const nombreInput = document.getElementById('nombre');
    const emailInput = document.getElementById('email');
    const asuntoInput = document.getElementById('asunto');
    const mensajeInput = document.getElementById('mensaje');

    // Elementos para mostrar errores
    const errorNombre = document.getElementById('error-nombre');
    const errorEmail = document.getElementById('error-email');
    const errorAsunto = document.getElementById('error-asunto');
    const errorMensaje = document.getElementById('error-mensaje');
    const formMessages = document.getElementById('form-messages');

    form.addEventListener('submit', function(event) {
        // Prevenir el envío del formulario para realizar la validación
        let isValid = validateForm();
        if (!isValid) {
            event.preventDefault(); // Detener el envío solo si no es válido
            formMessages.textContent = 'Por favor, corrige los errores del formulario.';
            formMessages.style.display = 'block';
            formMessages.className = 'mensaje error';
            console.log('Formulario inválido.');
        } else {
            // El formulario es válido, se enviará de forma natural.
            // Puedes limpiar el mensaje general si estaba visible por un intento anterior.
            formMessages.style.display = 'none';
            formMessages.textContent = '';
            console.log('Formulario válido, enviando...');
            // No necesitas form.submit() aquí si no hay preventDefault(),
            // pero si por alguna razón tuvieras preventDefault() al inicio y luego
            // decides enviar tras validación asíncrona, sí lo necesitarías.
            // Para este caso síncrono, simplemente no prevenir el default si es válido es suficiente.
        }
    });

    function validateForm() {
        let valid = true;
        // Ocultar mensajes generales al revalidar, solo si no hay errores específicos aún.
        // Esto evita que se oculte si ya hay un error general de un intento previo.
        if (!document.querySelector('.error-text:not(:empty)')) {
            formMessages.style.display = 'none';
            formMessages.textContent = '';
        }


        // Validar Nombre
        if (nombreInput.value.trim() === '') {
            errorNombre.textContent = 'El nombre es obligatorio.';
            nombreInput.style.borderColor = 'red';
            valid = false;
        } else {
            errorNombre.textContent = '';
            nombreInput.style.borderColor = '';
        }

        // Validar Email
        if (emailInput.value.trim() === '') {
            errorEmail.textContent = 'El correo electrónico es obligatorio.';
            emailInput.style.borderColor = 'red';
            valid = false;
        } else if (!isValidEmail(emailInput.value.trim())) {
            errorEmail.textContent = 'Ingresa un correo electrónico válido.';
            emailInput.style.borderColor = 'red';
            valid = false;
        } else {
            errorEmail.textContent = '';
            emailInput.style.borderColor = '';
        }

        // Validar Asunto
        if (asuntoInput.value.trim() === '') {
            errorAsunto.textContent = 'El asunto es obligatorio.';
            asuntoInput.style.borderColor = 'red';
            valid = false;
        } else {
            errorAsunto.textContent = '';
            asuntoInput.style.borderColor = '';
        }

        // Validar Mensaje
        if (mensajeInput.value.trim() === '') {
            errorMensaje.textContent = 'El mensaje es obligatorio.';
            mensajeInput.style.borderColor = 'red';
            valid = false;
        } else {
            errorMensaje.textContent = '';
            mensajeInput.style.borderColor = '';
        }

        return valid;
    }

    function isValidEmail(email) {
        // Expresión regular simple para validación de email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Opcional: Limpiar errores al empezar a escribir en un campo
    const inputs = [nombreInput, emailInput, asuntoInput, mensajeInput];
    inputs.forEach(input => {
        if (input) { // Asegurarse de que el input existe
            input.addEventListener('input', () => {
                const errorSpanId = `error-${input.id}`;
                const errorSpan = document.getElementById(errorSpanId);

                if (input.style.borderColor === 'red') { // Si tenía un error
                    input.style.borderColor = ''; // Limpiar borde
                }
                if (errorSpan) {
                    errorSpan.textContent = ''; // Limpiar mensaje de error específico
                }

                // Verificar si aún quedan otros errores visibles
                const anyErrorVisible = inputs.some(i => {
                    const errSpan = document.getElementById(`error-${i.id}`);
                    return errSpan && errSpan.textContent !== '';
                });

                if (!anyErrorVisible && formMessages) {
                    formMessages.style.display = 'none';
                    formMessages.textContent = '';
                }
            });
        }
    });
});