AOS.init({
    duration: 1200, // Animation duration (in milliseconds)
    once: true      // Animation happens only once when scrolled
});

document.addEventListener("DOMContentLoaded", () => {
    const preloader = document.getElementById("preloader");
    setTimeout(() => {
        preloader.style.opacity = 0;
        preloader.style.transition = "opacity 1s ease";
        setTimeout(() => {
            preloader.style.display = "none";
        }, 1000); // Matches the fade-out duration
    }, 3000); // Total time for the animation (spinning + text reveal)
});
