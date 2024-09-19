document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');

    menuToggle.addEventListener('click', function() {
        navLinks.classList.toggle('active'); // Toggle the 'active' class on the navigation links
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('eventForm');
    const confirmation = document.getElementById('confirmation');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        // Form handling logic here (AJAX or traditional)
        confirmation.style.display = 'block';
        form.reset(); // Clear form
    });
});
