// Seleccionamos las variables y los inputs del formulario
const user_profile_form = document.querySelector('#user_profile_form');
const userName = document.querySelector("#user_name");
const userLastName = document.querySelector("#user_lastname");
const userEmail = document.querySelector('#user_email');
const userTel = document.querySelector('#user_tel');

// Definimos las funciones que nos permitirán realizar la validación de los inputs
function validateName(user_name) {
    const regex = /^(?=.{2,20}$)[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+){0,2}$/u;

    const message = "El nombre deberá contener entre 2 y 20 letras y se podrá hacer uso de hasta dos espacios no consecutivos";

    return regex.test(user_name) ? true : message;
}

function validateLastName(user_lastname) {
    const regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,20}(?: [A-Za-zÁÉÍÓÚáéíóúÑñ]{2,20})?$/u;

    const message = "El/los apellidos deberán contener entre 2 y 20 letras y se podrá hacer uso de un único espacio";

    return regex.test(user_lastname) ? true : message;
}

function validateEmail(user_email) {
    let regex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;

    const message = "El correo electrónico similar a: xxxxx@xxx.xxx";

    return regex.test(user_email) ? true : message;
}

function validateTel(user_tel) {
    let regex = /^\d{8,11}$/;

    const message = "El telefono deberá contener entre 8 y 11 dígitos";

    return regex.test(user_tel) ? true : message;
}

// Función ON BLUR de todos los elementos
function validateOnBlur(inputElement, validator) {
    if (!inputElement) return;

    inputElement.addEventListener('blur', function () {
        const value = inputElement.value.trim();
        const result = validator(value);
        const smallElement = inputElement.nextElementSibling;

        if (result !== true) {
            smallElement.textContent = result;
            smallElement.classList.add("error-visible");
            inputElement.classList.add("input-error");
        } else {
            smallElement.textContent = "";
            smallElement.classList.remove("error-visible");
            inputElement.classList.remove("input-error");
        }
    });
}

validateOnBlur(userName, validateName);
validateOnBlur(userLastName, validateLastName);
validateOnBlur(userEmail, validateEmail);
validateOnBlur(userTel, validateTel);

if (user_profile_form) {

    user_profile_form.addEventListener('submit', function (e) {

        const isNameValid = validateName(userName.value.trim());
        const isLastNameValid = validateLastName(userLastName.value.trim());
        const isEmailValid = validateEmail(userEmail.value.trim());
        const isTelValid = validateTel(userTel.value.trim());

        if (
            isNameValid !== true ||
            isLastNameValid !== true ||
            isEmailValid !== true ||
            isTelValid !== true
        ) {
            alert("Por favor, complete los campos que son obligatorios")
            e.preventDefault();
        };

    })
};

/****************** FORMULARIO CAMBIO CONTRASEÑA ******************/

const passwordInput = document.querySelector("#password");
const password2Input = document.querySelector("#password2");
const passwordForm = document.querySelector("#user_password_form");

function validatePassword(user_password) {
    let regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[.,_\-])[a-zA-Z\d.,_\-]{6,10}$/

    const message = "La contraseña deberá contener entre 6 y 10 caracteres e incluir de forma obligatoria una letra mayúscula, un número y un símbolo entre los siguientes (.,_-)";

    return regex.test(user_password) ? true : message;
}

function validatePasswordMatch(password1, password2) {

    if (password2 === "") {
        return "Debe repetir la contraseña";
    }

    if (password1 !== password2) {
        return "Las contraseñas no coinciden";
    }

    return true;
}


// Función ONBLUR para el PRIMER campo
function validatePasswordOnBlur(inputElement, validator) {
    if (!inputElement) return;

    inputElement.addEventListener("blur", function () {

        const value = inputElement.value.trim();
        const result = validator(value);
        const smallElement = inputElement.nextElementSibling;

        if (result !== true) {
            smallElement.textContent = result;
            smallElement.classList.add("error-visible");
            inputElement.classList.add("input-error");
        } else {
            smallElement.textContent = "";
            smallElement.classList.remove("error-visible");
            inputElement.classList.remove("input-error");
        }
    });
}

validatePasswordOnBlur(passwordInput, validatePassword);


// Validación al SEGUNDO campo
if (password2Input) {

    password2Input.addEventListener("blur", function () {

        const result = validatePasswordMatch(
            passwordInput.value.trim(),
            password2Input.value.trim()
        );

        const smallElement = password2Input.nextElementSibling;

        if (result !== true) {
            smallElement.textContent = result;
            smallElement.classList.add("error-visible");
            password2Input.classList.add("input-error");
        } else {
            smallElement.textContent = "";
            smallElement.classList.remove("error-visible");
            password2Input.classList.remove("input-error");
        }
    });
}

// Validación SUBMIT
if (passwordForm) {

    passwordForm.addEventListener("submit", function (e) {

        const pass1 = passwordInput.value.trim();
        const pass2 = password2Input.value.trim();

        const isPassValid = validatePassword(pass1);
        const isMatchValid = validatePasswordMatch(pass1, pass2);

        if (
            isPassValid !== true ||
            isMatchValid !== true
        ) {
            alert("Por favor, revise los campos de contraseña");
            e.preventDefault();
        }

    });
}


