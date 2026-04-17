import './bootstrap';
import 'simplebar';
import 'iconify-icon';
import Quill from 'quill';
import ApexCharts from 'apexcharts';

window.Quill = Quill;
window.ApexCharts = ApexCharts;

/**
 * Theme: Skotwind - Tailwind CSS Admin Layout & UI Kit Template
 * Author: MyraStudio
 * Module/App: App js
 */

// Global helper: Generate URL-friendly slug from text
window.generateSlug = function(title) {
    if (!title) return '';
    return title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-|-$/g, '');
};

class App {
    constructor() {
        this.html = document.getElementsByTagName('html')[0];
        this.config = {};
        this.defaultConfig = window.config || {};
        this.sidenav = null;
        this.overlay = null;
    }

    initComponents() {
        // Initialize KTUI components if available
        if (window.KTComponents) {
            window.KTComponents.init();
        }
    }

    initSidenav() {
        const self = this;
        const pageUrl = window.location.href.split(/[?#]/)[0];

        // Set active state for current page
        document.querySelectorAll("ul.kt-accordion-menu .kt-accordion-menu-item .kt-accordion-menu-link").forEach((element) => {
            if (element.href === pageUrl) {
                element.classList.add("active");

                let parentMenuItem = element.closest(".kt-accordion-menu-item");
                let parentMenu = element.parentElement?.parentElement?.parentElement?.parentElement;

                if (parentMenu && parentMenu.classList.contains("kt-accordion-menu-item")) {
                    const collapseElement = parentMenu.querySelector(".kt-accordion-menu-toggle");
                    if (collapseElement) {
                        parentMenu.classList.add("active");
                        const nextE = collapseElement.nextElementSibling;
                        if (nextE && nextE.classList.contains('kt-accordion-menu-content')) {
                            nextE.classList.remove("hidden");
                        }
                    }
                }
            }
        });

        // Handle accordion menu toggles
        this.initAccordionToggles();
    }

    initAccordionToggles() {
        document.querySelectorAll('.kt-accordion-menu-toggle').forEach((toggle) => {
            // Remove any existing listeners by cloning the element
            const newToggle = toggle.cloneNode(true);
            toggle.parentNode.replaceChild(newToggle, toggle);

            // Add fresh listener
            newToggle.addEventListener('click', (e) => {
                e.preventDefault();
                const content = newToggle.nextElementSibling;
                const parent = newToggle.closest('.kt-accordion-menu-item');

                if (content && content.classList.contains('kt-accordion-menu-content')) {
                    content.classList.toggle('hidden');
                    parent.classList.toggle('active');
                }
            });
        });
    }

    initDrawer() {
        const self = this;
        this.sidenav = document.getElementById('sidenavDrawer');
        this.overlay = document.getElementById('sidenavOverlay');

        // Handle drawer toggles - support both with and without value
        document.querySelectorAll('[data-kt-drawer-toggle]').forEach((toggle) => {
            // Remove any existing listeners by cloning
            const newToggle = toggle.cloneNode(true);
            toggle.parentNode.replaceChild(newToggle, toggle);

            // Add fresh listener
            newToggle.addEventListener('click', (e) => {
                e.preventDefault();
                self.toggleSidenav();
            });
        });

        // Close sidenav when clicking overlay
        if (this.overlay) {
            const newOverlay = this.overlay.cloneNode(true);
            this.overlay.parentNode.replaceChild(newOverlay, this.overlay);
            this.overlay = newOverlay;

            this.overlay.addEventListener('click', () => {
                self.closeSidenav();
            });
        }

        // Close sidenav on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && self.sidenav?.classList.contains('show')) {
                self.closeSidenav();
            }
        });

        // Handle window resize - close sidenav on larger screens
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                if (window.innerWidth >= 1024) {
                    self.closeSidenav();
                }
            }, 100);
        });
    }

    toggleSidenav() {
        if (this.sidenav?.classList.contains('show')) {
            this.closeSidenav();
        } else {
            this.openSidenav();
        }
    }

    openSidenav() {
        if (this.sidenav) {
            this.sidenav.classList.add('show');
        }
        if (this.overlay) {
            this.overlay.classList.add('show');
        }
        document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
    }

    closeSidenav() {
        if (this.sidenav) {
            this.sidenav.classList.remove('show');
        }
        if (this.overlay) {
            this.overlay.classList.remove('show');
        }
        document.body.classList.remove('overflow-hidden');
    }

    initDropdowns() {
        // Handle dropdown toggles
        document.querySelectorAll('[data-kt-dropdown-toggle]').forEach((toggle) => {
            // Remove any existing listeners by cloning
            const newToggle = toggle.cloneNode(true);
            toggle.parentNode.replaceChild(newToggle, toggle);

            newToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                const parent = newToggle.closest('[data-kt-dropdown]');
                const menu = parent?.querySelector('[data-kt-dropdown-menu]');

                // Close all other dropdowns
                document.querySelectorAll('[data-kt-dropdown-menu]').forEach((dropdown) => {
                    if (dropdown !== menu) {
                        dropdown.classList.remove('open');
                    }
                });

                if (menu) {
                    menu.classList.toggle('open');
                }
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('[data-kt-dropdown]')) {
                document.querySelectorAll('[data-kt-dropdown-menu]').forEach((dropdown) => {
                    dropdown.classList.remove('open');
                });
            }
        });
    }

    init() {
        this.initComponents();
        this.initSidenav();
        this.initDrawer();
        this.initDropdowns();
    }
}

// Initialize app when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    const app = new App();
    app.init();
    window.app = app;
});

// Re-initialize on Livewire navigation (for SPA-like behavior)
if (typeof window.Livewire !== 'undefined') {
    document.addEventListener('livewire:navigated', () => {
        if (window.app) {
            window.app.init();
        } else {
            const app = new App();
            app.init();
            window.app = app;
        }
    });
}

// Also listen for livewire:load event
document.addEventListener('livewire:load', () => {
    if (window.app) {
        window.app.init();
    }
});
