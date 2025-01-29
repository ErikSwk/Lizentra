document.addEventListener("DOMContentLoaded", function () {
    // Hamburger-Menü
    const hamBurger = document.querySelector(".toggle-btn");
    hamBurger.addEventListener("click", function () {
        document.querySelector("#sidebar").classList.toggle("expand");
    });

    // Lizenz Hinzufügen Modal
    const modalHinzufügen = document.getElementById("addLizenz");
    const hinzufügenBtn = document.getElementById("hinzufügen");
    const hinzufügenAbbrechenBtn = document.getElementById("hinzufügenAbbrechenBtn");
    const hinzufügenModalBtn = document.getElementById("hinzufügenModal");
    const hinzufügenXBtn = document.getElementById("hinzufügenXBtn");

    hinzufügenBtn.onclick = function () {
        modalHinzufügen.style.display = "block";
    };

    hinzufügenAbbrechenBtn.onclick = function () {
        modalHinzufügen.style.display = "none";
    };

    hinzufügenModalBtn.onclick = function () {
        modalHinzufügen.style.display = "none";
    };

    hinzufügenXBtn.onclick = function () {
        modalHinzufügen.style.display = "none";
    };

    // Schließen bei Klick außerhalb des Modals
    window.addEventListener("click", (event) => {
        if (event.target === pcModal) {
            pcModal.style.display = "none";
            console.log("PC Hinzufügen Modal geschlossen (außerhalb geklickt).");
        }
    });
});



