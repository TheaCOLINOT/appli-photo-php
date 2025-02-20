document.addEventListener("DOMContentLoaded", () => {
	document.querySelectorAll(".navbar__button").forEach(function(button) {
	  button.addEventListener("click", () => {
		const menu = button.parentElement.querySelector("ul");
  
		if (menu.classList.contains("active")) {
		  // Fermeture du menu
		  // Fixer la hauteur actuelle pour initier la transition
		  menu.style.height = menu.scrollHeight + "px";
		  // Forcer le reflow pour que le navigateur prenne en compte la hauteur
		  menu.offsetHeight; 
		  // Puis, réduire la hauteur à 0
		  menu.style.height = "0";
		  menu.classList.remove("active");
		} else {
		  // Ouverture du menu
		  menu.classList.add("active");
		  // Définir la hauteur sur scrollHeight pour l'ouverture
		  menu.style.height = menu.scrollHeight + "px";
		  // Une fois la transition terminée, on réinitialise la hauteur à "auto"
		  menu.addEventListener("transitionend", function removeHeight() {
			// Vérifier que le menu est toujours ouvert (pour éviter des comportements indésirables)
			if (menu.classList.contains("active")) {
			  menu.style.height = "auto";
			}
			menu.removeEventListener("transitionend", removeHeight);
		  });
		}
	  });
	});
  });
  