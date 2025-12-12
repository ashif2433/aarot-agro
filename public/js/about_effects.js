document.addEventListener("DOMContentLoaded", () => {
    const sections = document.querySelectorAll('.fade-section');

    function reveal() {
        sections.forEach(sec => {
            const secTop = sec.getBoundingClientRect().top;
            if (secTop < window.innerHeight - 100) {
                sec.classList.add("visible");
            }
        });
    }

    window.addEventListener("scroll", reveal);
    reveal();
});
