document.addEventListener('DOMContentLoaded', function () {
    var selectors = [
        '.post-card-image',
        '.sdn-guru-photo img',
        '.sdn-fasilitas-photo img',
        '.sdn-ekstrakurikuler-photo img',
        '.guru-detail-image',
        '.profile-image img',
        '.post-featured-image'
    ];
    var images = document.querySelectorAll(selectors.join(','));
    images.forEach(function (img) {
        img.classList.add('sdn-reveal');
        if (img.complete && img.naturalWidth !== 0) {
            img.classList.add('is-loaded');
        } else {
            img.addEventListener('load', function () {
                img.classList.add('is-loaded');
            });
            img.addEventListener('error', function () {
                img.classList.add('is-loaded');
            });
        }
    });
});
