document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.querySelector('#toggle-btn');
    const sidebar = document.querySelector('#sidebar');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
        });
    }
});