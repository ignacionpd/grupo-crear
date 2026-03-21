        document.addEventListener("DOMContentLoaded", () => {

            const slides = document.querySelectorAll(".carousel-slide");

            console.log("Slides encontrados:", slides.length);

            if (slides.length === 0) {
                console.error("NO se encontraron slides");
                return;
            }

            const nextBtn = document.querySelector(".carousel-btn.next");
            const prevBtn = document.querySelector(".carousel-btn.prev");

            let current = 0;
            let interval;

            function showSlide(index) {
                slides.forEach(slide => slide.classList.remove("active"));
                slides[index].classList.add("active");
            }

            function nextSlide() {
                current = (current + 1) % slides.length;
                showSlide(current);
            }

            function prevSlide() {
                current = (current - 1 + slides.length) % slides.length;
                showSlide(current);
            }

            function startAuto() {
                interval = setInterval(nextSlide, 2000);
            }

            function resetAuto() {
                clearInterval(interval);
                startAuto();
            }

            nextBtn?.addEventListener("click", () => {
                nextSlide();
                resetAuto();
            });

            prevBtn?.addEventListener("click", () => {
                prevSlide();
                resetAuto();
            });

            showSlide(current);
            startAuto();
        });