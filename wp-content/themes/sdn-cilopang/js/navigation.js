document.addEventListener('DOMContentLoaded', function () {
    var navToggle = document.querySelector('.nav-toggle');
    var primaryNavigation = document.getElementById('primary-navigation');
    var navOverlay = document.getElementById('nav-overlay');
    var navDrawerClose = document.querySelector('.nav-drawer-close');

    function setMobileMenuState(isOpen) {
        if (!primaryNavigation || !navToggle) {
            return;
        }

        primaryNavigation.classList.toggle('is-open', isOpen);
        navToggle.setAttribute('aria-expanded', String(isOpen));
        document.body.classList.toggle('nav-open', isOpen);

        if (navOverlay) {
            navOverlay.classList.toggle('is-open', isOpen);
        }

        if (!isOpen) {
            primaryNavigation.querySelectorAll('.menu-item-has-children.submenu-open').forEach(function (parent) {
                parent.classList.remove('submenu-open');
                var submenuToggle = parent.querySelector('.submenu-toggle');
                if (submenuToggle) {
                    submenuToggle.setAttribute('aria-expanded', 'false');
                }
            });
        }
    }

    if (navToggle && primaryNavigation) {
        setMobileMenuState(false);

        navToggle.addEventListener('click', function () {
            var isOpen = primaryNavigation.classList.contains('is-open');
            setMobileMenuState(!isOpen);
        });
    }

    if (navDrawerClose) {
        navDrawerClose.addEventListener('click', function () {
            setMobileMenuState(false);
        });
    }

    if (navOverlay) {
        navOverlay.addEventListener('click', function () {
            setMobileMenuState(false);
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && primaryNavigation && primaryNavigation.classList.contains('is-open')) {
            setMobileMenuState(false);
        }
    });

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
