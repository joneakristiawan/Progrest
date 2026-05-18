document.addEventListener("DOMContentLoaded", () => {
    const containers = document.querySelectorAll('.project-container');

    containers.forEach(container => {
        const line = container.querySelector('.project-line');

        const height = container.getBoundingClientRect().height - 44;
        line.style.height = `${height}px`;
    });
});