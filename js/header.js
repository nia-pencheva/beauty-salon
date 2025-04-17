document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger-menu');
    const navMenu = document.querySelector('.nav-menu');
    const menuSections = document.querySelectorAll('.nav-menu__section');

    // Function to handle mobile menu structure
    function handleMobileMenu() {
        if (window.innerWidth < 768) {
            // Unwrap nav-menu__section elements on mobile
            menuSections.forEach(section => {
                while (section.firstChild) {
                    section.parentNode.insertBefore(section.firstChild, section);
                }
                section.parentNode.removeChild(section);
            });
        }
    }

    // Initial check on page load
    handleMobileMenu();

    // Toggle menu on hamburger click
    hamburger.addEventListener('click', function() {
        navMenu.classList.toggle('active');
        hamburger.classList.toggle('active');
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!navMenu.contains(event.target) && !hamburger.contains(event.target)) {
            navMenu.classList.remove('active');
            hamburger.classList.remove('active');
        }
    });
});