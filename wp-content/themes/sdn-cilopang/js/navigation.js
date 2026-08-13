document.addEventListener('DOMContentLoaded', function () {
    var navToggle = document.querySelector('.nav-toggle');
    var primaryNavigation = document.getElementById('primary-navigation');

    if (navToggle && primaryNavigation) {
        navToggle.addEventListener('click', function () {
            var isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', String(!isExpanded));
            primaryNavigation.classList.toggle('is-open');
        });
    }

    if (!primaryNavigation) {
        return;
    }

    var submenuParents = primaryNavigation.querySelectorAll('.menu-item-has-children');

    submenuParents.forEach(function (parent, index) {
        var subMenu = parent.querySelector('.sub-menu');

        if (!subMenu) {
            return;
        }

        var button = document.createElement('button');
        button.type = 'button';
        button.className = 'submenu-toggle';
        button.setAttribute('aria-expanded', 'false');
        button.setAttribute('aria-controls', 'submenu-' + index);
        button.innerHTML = '<span class="screen-reader-text">Toggle submenu</span><span class="submenu-toggle__bar"></span>';

        subMenu.id = subMenu.id || 'submenu-' + index;

        var anchor = parent.querySelector(':scope > a');
        if (anchor) {
            anchor.insertAdjacentElement('afterend', button);
        }

        button.addEventListener('click', function (event) {
            event.preventDefault();
            var expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', String(!expanded));
            parent.classList.toggle('submenu-open');
        });
    });
});