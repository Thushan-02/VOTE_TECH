document.addEventListener('DOMContentLoaded', () => {

    // script for image slider start
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const indicators = document.querySelectorAll('.indicator');


    function showSlide(index) {
        const slidesContainer = document.querySelector('.slides');
        const slideWidth = slides[0].clientWidth;

        slidesContainer.style.transform = `translateX(${-slideWidth * index}px)`;

        indicators.forEach((indicator, i) => {
            indicator.classList.toggle('active', i === index);
        });
    }

    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            currentSlide = index;
            showSlide(currentSlide);
        });
    });

    setInterval(() => {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }, 3000);

    // slider script end
});
