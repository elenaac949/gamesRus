document.getElementById('dropdownToggle').addEventListener('click', function() {
    const dropdown = document.getElementById('dropdownForm');
    dropdown.classList.toggle('show');
});

window.addEventListener('click', function(event) {
    if (!event.target.closest('#dropdownToggle') && !event.target.closest('#dropdownForm')) {
        const dropdown = document.getElementById('dropdownForm');
        dropdown.classList.remove('show');
    }
});