// INDEX (Sections)
const elements = document.querySelectorAll('.efecto_vertical, .efecto_horizontal');

function mostrarElementos() {
    const altura = window.innerHeight * 0.8;

    elements.forEach(element =>{
        const elementTop = element.getBoundingClientRect().top;

        if (elementTop < altura) {
            element.classList.add('show');
        }else {
            element.classList.remove('show');
        }
    })
}

window.addEventListener('scroll', mostrarElementos)