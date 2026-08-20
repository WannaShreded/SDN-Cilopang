document.addEventListener('DOMContentLoaded', function () {
    var counters = document.querySelectorAll('.sdn-statistik-number[data-count]');
    if (!counters.length) {
        return;
    }

    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function animateCounter(el) {
        var target = parseInt(el.getAttribute('data-count'), 10) || 0;

        if (prefersReducedMotion) {
            el.textContent = target;
            return;
        }

        var duration = 2200;
        var startTime = null;

        function step(timestamp) {
            if (!startTime) {
                startTime = timestamp;
            }
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.floor(eased * target);

            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = target;
            }
        }

        requestAnimationFrame(step);
    }

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(function (el) {
        observer.observe(el);
    });
});
