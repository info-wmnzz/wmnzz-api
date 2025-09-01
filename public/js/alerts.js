document.addEventListener('DOMContentLoaded', function () {
    const flash = document.querySelector('.flash-message');
    if (flash) {
        setTimeout(() => {
            flash.style.opacity = '0';
            setTimeout(() => {
                flash.style.display = 'none';
            }, 600);
        }, 3000);
    }
});
