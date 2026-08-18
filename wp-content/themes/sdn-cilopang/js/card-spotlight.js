document.addEventListener('DOMContentLoaded', function () {
    if (window.matchMedia('(max-width: 800px)').matches) {
        return;
    }

    var photoSelectors = [
        '.sdn-guru-photo',
        '.section-fasilitas .sdn-fasilitas-photo',
        '.section-ekstrakurikuler .sdn-ekstrakurikuler-photo'
    ];

    var photos = document.querySelectorAll(photoSelectors.join(','));

    photos.forEach(function (photo) {
        photo.classList.add('sdn-spotlight');

        photo.addEventListener('mousemove', function (e) {
            var rect = photo.getBoundingClientRect();
            var x = e.clientX - rect.left;
            var y = e.clientY - rect.top;
            photo.style.setProperty('--sdn-spot-x', x + 'px');
            photo.style.setProperty('--sdn-spot-y', y + 'px');
        });
    });
});
