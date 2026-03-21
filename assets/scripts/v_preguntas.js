document.addEventListener("DOMContentLoaded", () => {

    const links = document.querySelectorAll(".faq-link");
    const dropdown = document.querySelector(".faq-dropdown");
    const header = document.querySelector(".mi_encabezado");
    const faqHeader = document.querySelector(".faq-header");
    const root = document.documentElement;

    /* =========================
       ACTUALIZAR ALTURA HEADER
    ========================== */

    function updateHeaderHeight() {
        const height = header.offsetHeight;
        root.style.setProperty("--header-height", height + "px");
    }

    updateHeaderHeight();
    window.addEventListener("resize", updateHeaderHeight);

    const userMenu = document.querySelector(".navigationBarListUser");
    if (userMenu) {
        userMenu.addEventListener("transitionend", updateHeaderHeight);
    }

    /* =========================
       OFFSET TOTAL PARA SCROLL
    ========================== */

    function getTotalOffset() {
        return header.offsetHeight + faqHeader.offsetHeight;
    }

    /* =========================
       CLICK LINKS FAQ
    ========================== */

    links.forEach(link => {

        link.addEventListener("click", function (e) {

            e.preventDefault();

            links.forEach(l => l.classList.remove("active"));
            this.classList.add("active");

            const target = document.querySelector(this.getAttribute("href"));

            const offset = getTotalOffset();

            const top =
                target.getBoundingClientRect().top +
                window.scrollY -
                offset;

            window.scrollTo({
                top: top,
                behavior: "smooth"
            });

            if (dropdown && dropdown.open) {
                dropdown.open = false;
            }

        });

    });

    /* =========================
       CERRAR DROPDOWN AL CLICK FUERA
    ========================== */

    document.addEventListener("click", function (e) {
        if (dropdown && dropdown.open && !dropdown.contains(e.target)) {
            dropdown.open = false;
        }
    });

});



/* document.addEventListener("DOMContentLoaded", () => {

    const links = document.querySelectorAll(".faq-link");
    const dropdown = document.querySelector(".faq-dropdown");
    const header = document.querySelector(".mi_encabezado");
    const faqHeader = document.querySelector(".faq-header");

    function getTotalOffset() {
        return header.offsetHeight + faqHeader.offsetHeight;
    }

    function updateFaqTop() {
        faqHeader.style.top = header.offsetHeight + "px";
    }

    updateFaqTop();
    window.addEventListener("resize", updateFaqTop);

    links.forEach(link => {

        link.addEventListener("click", function (e) {

            e.preventDefault();

            links.forEach(l => l.classList.remove("active"));
            this.classList.add("active");

            const target = document.querySelector(this.getAttribute("href"));

            const offset = getTotalOffset();

            const top =
                target.getBoundingClientRect().top +
                window.scrollY -
                offset;

            window.scrollTo({
                top: top,
                behavior: "smooth"
            });

            if (dropdown && dropdown.open) {
                dropdown.open = false;
            }

        });

    });

    document.addEventListener("click", function (e) {
        const dropdown = document.querySelector(".faq-dropdown");

        if (dropdown && dropdown.open && !dropdown.contains(e.target)) {
            dropdown.open = false;
        }
    });

    const root = document.documentElement;

    function updateHeaderHeight() {
        const height = header.offsetHeight;
        root.style.setProperty("--header-height", height + "px");
    }

    // Inicial
    updateHeaderHeight();

    // Cuando cambia tamaño
    window.addEventListener("resize", updateHeaderHeight);

    // Si el navbar user se abre/cierra (transition)
    const userMenu = document.querySelector(".navigationBarListUser");

    if (userMenu) {
        userMenu.addEventListener("transitionend", updateHeaderHeight);
    }


});
 */