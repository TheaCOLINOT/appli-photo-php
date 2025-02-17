document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".navbar__button").forEach(function(t) {
    t.addEventListener("click", () => {
      const e = t.parentElement.querySelector("ul");
      e.classList.contains("active") ? (e.style.height = e.scrollHeight + "px", e.offsetHeight, e.style.height = "0", e.classList.remove("active")) : (e.classList.add("active"), e.style.height = e.scrollHeight + "px", e.addEventListener("transitionend", function n() {
        e.classList.contains("active") && (e.style.height = "auto"), e.removeEventListener("transitionend", n);
      }));
    });
  });
});
console.log("theme.js loaded");
document.addEventListener("DOMContentLoaded", function() {
  const t = localStorage.getItem("theme"), e = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
  t ? document.documentElement.classList.toggle("dark", t === "dark") : document.documentElement.classList.toggle("dark", e === "dark"), document.querySelector("#theme-toggle").addEventListener("click", function() {
    document.documentElement.classList.toggle("dark");
    const n = document.documentElement.classList.contains("dark") ? "dark" : "light";
    localStorage.setItem("theme", n);
  });
});
