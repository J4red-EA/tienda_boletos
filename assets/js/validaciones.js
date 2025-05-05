document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const email = document.querySelector("#email");
    const tarjeta = document.querySelector("#tarjeta");

    form.addEventListener("submit", function (e) {
        let valido = true;

        const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regexEmail.test(email.value)) {
            alert("Correo inválido");
            valido = false;
        }

        const regexTarjeta = /^\d{16}$/;
        if (!regexTarjeta.test(tarjeta.value)) {
            alert("Número de tarjeta inválido (16 dígitos)");
            valido = false;
        }

        if (!valido) {
            e.preventDefault();
        }
    });
});