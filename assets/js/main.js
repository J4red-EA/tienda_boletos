$(document).ready(function () {
    const slider = $('.slider-container');
    const images = $('.slider-container img');
    const totalImages = images.length;
    let currentIndex = 0;
    let intervalo;

    function updateSlider() {
        const offset = -currentIndex * 100;
        slider.css('transform', `translateX(${offset}%)`);
    }

    function avanzarAutomaticamente() {
        intervalo = setInterval(() => {
            currentIndex = (currentIndex + 1) % totalImages;
            updateSlider();
        }, 4000); // cada 4 segundos
    }

    $('#next').click(function () {
        currentIndex = (currentIndex + 1) % totalImages;
        updateSlider();
        reiniciarAutoSlide();
    });

    $('#prev').click(function () {
        currentIndex = (currentIndex - 1 + totalImages) % totalImages;
        updateSlider();
        reiniciarAutoSlide();
    });

    function reiniciarAutoSlide() {
        clearInterval(intervalo);
        avanzarAutomaticamente();
    }

    // Inicial
    slider.css('width', `${totalImages * 100}%`);
    images.css('width', `${100}%`);
    avanzarAutomaticamente();
});