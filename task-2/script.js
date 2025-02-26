document.addEventListener("scroll", function () {
    let aboutSection = document.querySelector(".text2"); 
    let position = aboutSection.getBoundingClientRect().top; 
    let screenHeight = window.innerHeight; 

    if (position < screenHeight - 100) { 
        document.querySelector(".first").classList.add("animate");
        setTimeout(() => document.querySelector(".second").classList.add("animate"), 200);
        setTimeout(() => document.querySelector(".third").classList.add("animate"), 400);
    }
});

window.addEventListener("scroll", function () {
    document.querySelectorAll(".container").forEach(container => {
        if (container.getBoundingClientRect().top < window.innerHeight - 100) {
            container.style.opacity = "1";
            container.style.transform = "translateY(0)";
        }
    });
});