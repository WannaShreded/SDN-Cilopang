document.addEventListener('DOMContentLoaded', function () {
    // Find all section elements and slide elements
    var sections = document.querySelectorAll('.section');
    var slides = document.querySelectorAll('.sdn-slide-left, .sdn-slide-right');

    if ((!sections || sections.length === 0) && (!slides || slides.length === 0)) return;

    // Add base class to all sections for existing fade-in-up behavior
    sections.forEach(function (el) {
        el.classList.add('fade-in-up');
    });

    // IntersectionObserver options
    var observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
    };

    var observer = new IntersectionObserver(function (entries, obs) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                // Stop observing this element after it becomes visible
                obs.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe each section
    sections.forEach(function (el) {
        observer.observe(el);
    });

    // Observe slide elements (photo left / text right)
    slides.forEach(function (el) {
        observer.observe(el);
    });
});