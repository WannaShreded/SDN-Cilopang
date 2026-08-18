document.addEventListener('DOMContentLoaded', function () {
    // Find all section elements
    var sections = document.querySelectorAll('.section');
    if (!sections || sections.length === 0) return;

    // Add base class to all sections
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
});