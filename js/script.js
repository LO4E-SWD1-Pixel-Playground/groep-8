document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;


    function showSlide(index) {
        slides.forEach((slide, i) => {
            if (i === index) {
                slide.style.display = 'block';
                slide.style.visibility = 'visible';
            } else {
                slide.style.display = 'none';
            }
        });
    }

 
    slides.forEach(slide => {
        slide.style.display = 'none';
    });

    showSlide(currentSlide);

   
    setInterval(function() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }, 3000);
});

