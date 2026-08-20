document.addEventListener('DOMContentLoaded', function() {
    const guruCarousel = new Swiper('.guru-carousel', {
        slidesPerView: 1.3, // Default HP: kasih intip dikit slide berikutnya
        spaceBetween: 16,
        loop: false,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            // Tablet kecil
            640: {
                slidesPerView: 2.3,
                spaceBetween: 20,
            },
            // Tablet besar
            768: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            // Desktop
            1024: {
                slidesPerView: 4,
                spaceBetween: 24,
            },
            // Desktop lebar
            1280: {
                slidesPerView: 5,
                spaceBetween: 24,
            }
        }
    });
});