import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('nav a');
    console.log(navLinks);

    navLinks.forEach(link => {
        if (link.pathname === currentPath) {
            link.classList.add('active');
        }
    });
});