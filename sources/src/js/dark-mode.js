document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.getElementById("darkModeToggle");
    const body = document.body;
  
    // Vérifier et appliquer la préférence enregistrée
    if (localStorage.getItem("theme") === "dark") {
      body.classList.add("dark-mode");
      if (toggleButton) toggleButton.textContent = "☀️ Mode clair";
    } else {
      body.classList.remove("dark-mode");
      if (toggleButton) toggleButton.textContent = "🌙 Mode sombre";
    }
  
    // Au clic, basculer entre mode sombre et clair
    if (toggleButton) {
      toggleButton.addEventListener("click", function () {
        if (body.classList.contains("dark-mode")) {
          body.classList.remove("dark-mode");
          localStorage.setItem("theme", "light");
          toggleButton.textContent = "🌙 Mode sombre";
        } else {
          body.classList.add("dark-mode");
          localStorage.setItem("theme", "dark");
          toggleButton.textContent = "☀️ Mode clair";
        }
      });
    }
  });
  