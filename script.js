document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".btn").forEach(btn => {
        btn.addEventListener("click", () => btn.classList.add("clicked"));
    });
});