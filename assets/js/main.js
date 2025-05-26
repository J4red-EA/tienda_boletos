$(document).ready(function () {
    const sliderContainer = $('.slider-container'); // Renombrado para mayor claridad
    const images = $('.slider-container img');
    const totalImages = images.length;
    let currentIndex = 0;
    let intervalo;

    // Si no hay imágenes, no hacer nada para evitar errores.
    if (totalImages === 0) {
        console.warn("Carrusel: No se encontraron imágenes en .slider-container.");
        return;
    }

    // 1. Establecer el ancho total del .slider-container
    // Esto hace que el contenedor sea lo suficientemente ancho para todas las imágenes en línea.
    // (totalImages * 100% del ancho del #carrusel)
    sliderContainer.css('width', `${totalImages * 100}%`);

    // 2. Establecer el ancho de cada imagen individual
    // Cada imagen será (100 / totalImages)% del ancho del sliderContainer.
    // Esto hace que cada imagen ocupe una "ranura" del tamaño del viewport #carrusel.
    images.css('width', `${100 / totalImages}%`);

    function updateSliderPosition() { // Renombrado para mayor claridad
        // Calcula el porcentaje de desplazamiento:
        // Queremos mover el sliderContainer por 'currentIndex' número de diapositivas.
        // Cada diapositiva tiene un ancho de (100 / totalImages)% del ancho total del sliderContainer.
        const offsetPercentage = -currentIndex * (100 / totalImages);
        sliderContainer.css('transform', `translateX(${offsetPercentage}%)`);
    }

    function startAutoSlide() { // Renombrado para mayor claridad
        clearInterval(intervalo); // Limpia cualquier intervalo anterior
        intervalo = setInterval(() => {
            currentIndex = (currentIndex + 1) % totalImages;
            updateSliderPosition();
        }, 4000); // cada 4 segundos
    }

    $('#next').click(function () {
        currentIndex = (currentIndex + 1) % totalImages;
        updateSliderPosition();
        startAutoSlide(); // Reinicia el temporizador del auto-slide
    });

    $('#prev').click(function () {
        currentIndex = (currentIndex - 1 + totalImages) % totalImages;
        updateSliderPosition();
        startAutoSlide(); // Reinicia el temporizador del auto-slide
    });

    // Posiciona el carrusel en la primera imagen al cargar
    // y comienza el auto-slide si hay imágenes.
    updateSliderPosition(); // Asegura que la primera imagen se muestre inicialmente
    if (totalImages > 1) { // Solo iniciar auto-slide si hay más de una imagen
      startAutoSlide();
    }
});