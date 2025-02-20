console.log("theme.js loaded")

document.addEventListener("DOMContentLoaded", function () {
    const userTheme = localStorage.getItem("theme");
    const systemTheme = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";

    // Appliquer le thème enregistré ou celui du système
    if (userTheme) {
        document.documentElement.classList.toggle("dark", userTheme === "dark");
    } else {
        document.documentElement.classList.toggle("dark", systemTheme === "dark");
    }

    // Ajouter un event listener pour basculer le mode manuellement
    const themeToggle = document.querySelector("#theme-toggle");
    if (themeToggle) {
        themeToggle.addEventListener("click", function () {
            document.documentElement.classList.toggle("dark");
            const newTheme = document.documentElement.classList.contains("dark") ? "dark" : "light";
            localStorage.setItem("theme", newTheme);
        });
    }
});
