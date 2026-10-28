import * as bootstrap from 'bootstrap';
import 'admin-lte';
import { OverlayScrollbars } from 'overlayscrollbars';

window.bootstrap = bootstrap; // handy for inline modals/tooltips in Blade

// Sidebar scrollbar (the official demo pages do this inline)
document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('.sidebar-wrapper');
    if (sidebar) {
        OverlayScrollbars(sidebar, {
            scrollbars: { theme: 'os-theme-light', autoHide: 'leave', clickScroll: true },
        });
    }
});