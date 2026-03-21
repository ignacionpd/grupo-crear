<?php

# Declaramos como constantes las expresiones regulares que van a filtrar o comprobar los datos
define("NOMBRE_REGEX", '/^(?=.{2,20}$)[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+){0,2}$/u');
define("APELLIDO_REGEX", "/^[A-Za-zÁÉÍÓÚáéíóúÑñ]{2,20}(?: [A-Za-zÁÉÍÓÚáéíóúÑñ]{2,20})?$/u");
define(constant_name: "DNI_REGEX", value:"/^\d{8}$/");
define(constant_name: "CUIT_REGEX", value:"/^\d{11}$/");
define(constant_name: "TELEFONO_REGEX", value:"/^\d{8,11}$/");
define("DIRECCION_REGEX",  "/^(?=.{8,50}$)[A-Za-z0-9º\-,]+( [A-Za-z0-9º\-,]+){0,5}$/u");
define("TEXTO_REGEX",  "/^[A-Za-zÁÉÍÓÚÜáéíóúüÑñ0-9 _\-\.,º]{10,250}$/");
define("USUARIO_REGEX", "/^[a-zA-Z0-9]{5,10}$/");
define("CONTRASENA_REGEX", "/^(?=.*[A-Z])(?=.*\d)(?=.*[.,_\-])[a-zA-Z\d.,_\-]{6,10}$/");


/****************************** CONTACTO ***************************/
#Definimos la función validar_contacto para el envío de formulario de la vista CONTACTO.php
function validar_contacto($nombre, $apellido, $telefono, $email, $texto){
    # Declarar un array asociativo
    $errores = [];

    # Validación del nombre haciendo uso de la constante NOMBRE_REGEX
    if(!preg_match(NOMBRE_REGEX, $nombre)){
        $errores['nombre'] = "- El nombre deberá contener entre 2 y 20 letras y se podrá hacer uso de dos espacio (no contínuos) en caso de introducir un nombre compuesto";
    }

     # Validación de los apellidos haciendo uso de la constante NOMBRE_REGEX
    if(!preg_match(NOMBRE_REGEX, $apellido)){
        $errores['apellido'] = "- El/los apellidos deberán contener entre 2 y 20 letras y se podrá hacer uso de un único espacio en caso de introducir un nombre compuesto";
    }

    # Validación del teléfono
    if(!preg_match(TELEFONO_REGEX, $telefono)){
        $errores['telefono'] = "- El teléfono debe contener entre 8 y 11 dígitos";
    }

    # Validación del correo electrónico
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errores['email'] = "- El email no tiene un formato válido";
    }

    # Validación del texto haciendo uso de la constante TEXTO_REGEX
    if(!preg_match(TEXTO_REGEX, $texto)){
        $errores['texto'] = "- El texto deberá contener entre 10 y 250 caracteres. Sólo se aceptan los siguientes símbolos especiales: . , _ - º ";
    }

    return $errores;

}

/***************************** USUARIOS ***************************/
# Definimos la función para ingresar USUARIO NUEVO
function validar_registro($nombre, $apellido, $email, $telefono, $usuario, $pass){
    # Declarar un array asociativo
    $errores = [];

    # Validación del nombre haciendo uso de la constante NOMBRE_REGEX
    if(!preg_match(NOMBRE_REGEX, $nombre)){
        $errores['nombre'] = "- El nombre deberá contener entre 2 y 20 letras y se podrá hacer uso de dos espacio (no contínuos) en caso de introducir un nombre compuesto";
    }

     # Validación de los apellidos haciendo uso de la constante APELLIDO_REGEX
    if(!preg_match(APELLIDO_REGEX, $apellido)){
        $errores['apellido'] = "- El/los apellidos deberán contener entre 2 y 20 letras y se podrá hacer uso de un único espacio en caso de introducir un nombre compuesto";
    }

    # Validación del correo electrónico
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errores['email'] = "- El formato del correo electrónico no es válido";
    }

    if(!preg_match(TELEFONO_REGEX, $telefono)){
        $errores['telefono'] = "- El teléfono debe contener entre 8 y 11 dígitos";
    }

    # Validación del nombre de usuario haciendo uso de la constante NOMBRE_REGEX
    if(!preg_match(USUARIO_REGEX, $usuario)){
        $errores['usuario'] = "- El nombre de usuario deberá contener entre 6 y 10 caracteres alfanuméricos";
    }

    # Validación de la contraseña haciendo uso de la constante CONTRASENA_REGEX
    if(!preg_match(CONTRASENA_REGEX, $pass)){
        $errores['pass'] = "- La contraseña deberá contener entre 6 y 10 caracteres e incluir de forma obligatoria una letra mayúscula, un número y un símbolo entre los siguientes (.,_-)";
    }

    return $errores;

}

// Definimos la función para validar los datos ingresados en "MODIFICAR USUARIO"
function validar_actualizacion_registro($nombre, $apellido, $email, $telefono){
    # Declarar un array asociativo
    $errores = [];

    # Validación del nombre haciendo uso de la constante NOMBRE_REGEX
    if(!preg_match(NOMBRE_REGEX, $nombre)){
        $errores['nombre'] = "- El nombre deberá contener entre 2 y 20 letras y se podrá hacer uso de hasta 2 espacios (no contínuos) en caso de introducir un nombre compuesto";
    }

     # Validación de los apellidos haciendo uso de la constante NOMBRE_REGEX
    if(!preg_match(APELLIDO_REGEX, $apellido)){
        $errores['apellido'] = "- El/Los apellidos deberán contener entre 2 y 20 letras y se podrá hacer uso de un único espacio en caso de introducir un nombre compuesto";
    }

    # Validación del correo electrónico
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errores['email'] = "- El formato del correo electrónico no es válido";
    }

    if(!preg_match(TELEFONO_REGEX, $telefono)){
        $errores['telefono'] = "- El teléfono debe contener entre 8 y 11 dígitos";
    }
  
    return $errores;

}


/**************************** EMPLEADOS ***********************************/
# Definimos la función para validar datos OBLIGATORIOS de EMPLEADO NUEVO
function validar_registro_empleado_oblig($nombre, $apellido, $dni, $cuit, $telefono){
    # Declarar un array asociativo
    $errores = [];

    # Validación del nombre haciendo uso de la constante NOMBRE_REGEX
    if(!preg_match(NOMBRE_REGEX, $nombre)){
        $errores['nombre'] = "- El nombre deberá contener entre 2 y 20 letras y se podrá hacer uso de dos espacio (no contínuos) en caso de introducir un nombre compuesto";
    }

     # Validación de el/los apellidos haciendo uso de la constante NOMBRE_REGEX
    if(!preg_match(NOMBRE_REGEX, $apellido)){
        $errores['apellido'] = "- El/los apellidos deberán contener entre 2 y 20 letras y se podrá hacer uso de un único espacio en caso de introducir un nombre compuesto";
    }

    # Validación del DNI haciendo uso de la constante DNI_REGEX
    if(!preg_match(DNI_REGEX, $dni)){
        $errores['dni'] = "- El DNI debe contener 8 caracteres";
    }

    # Validación del CUIT haciendo uso de la constante CUIT_REGEX
    if(!preg_match(CUIT_REGEX, $cuit)){
        $errores['cuit'] = "- El CUIT debe contener 11 dígitos (sin guíones)";
    }

    # Validación del TELEFONO haciendo uso de la constante TELEFONO_REGEX
    if(!preg_match(TELEFONO_REGEX, $telefono)){
        $errores['telefono'] = "- El teléfono debe contener entre 8 y 11 dígitos";
    }

    return $errores;
}

# Definimos la función para validar datos OPCIONALES de EMPLEADO NUEVO
function validar_registro_empleado_opc($direccion, $email, $contacto){
    # Declarar un array asociativo
    $errores = [];

    # -----> Como estos datos son OPCIONALES en el formulario, puede que alguno esté vacío, y sino , se verificará:
    # Validación de la dirección haciendo uso de la constante DIRECCION_REGEX
    if($direccion){
        if (!preg_match(DIRECCION_REGEX, $direccion)){
        $errores['direccion'] = "- La dirección deberá contener entre 8 y 50 caracteres, y puede tener hasta 5 espacios (no consecutivos) y sólo podrá contener los símbolos 'º', '-' y ','";
        }
    }

    # Validación del correo electrónico
    if($email) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errores['email'] = "- El formato del correo electrónico no es válido";
        }
    }

    # Validación del texto haciendo uso de la constante TEXTO_REGEX
    if($contacto) {
        if(!preg_match(TEXTO_REGEX, $contacto)){
            $errores['contacto'] = "- El texto deberá contener entre 10 y 250 caracteres. Sólo se aceptan los siguientes símbolos especiales: . , _ - º ";
        }
    }

    return $errores;
}
function validar_fecha_nacimiento(?string $fecha_input): array
{
    if (empty($fecha_input)) {
        return [
            'ok' => false,
            'error' => '- La fecha de nacimiento es obligatoria.'
        ];
    }

    $fecha = DateTime::createFromFormat('Y-m-d', $fecha_input);
    $errores = DateTime::getLastErrors();

    if (
        $fecha === false ||
        ($errores !== false && (
            $errores['warning_count'] > 0 ||
            $errores['error_count'] > 0
        ))
    ) {
        return [
            'ok' => false,
            'error' => '- La fecha introducida no es válida.'
        ];
    }

    $hoy = new DateTime();

    if ($fecha > $hoy) {
        return [
            'ok' => false,
            'error' => '- La fecha de nacimiento no puede ser futura.'
        ];
    }

    $edad = $fecha->diff($hoy)->y;

    if ($edad < 18) {
        return [
            'ok' => false,
            'error' => '- Debes ser mayor de edad para registrarte.'
        ];
    }

    return [
        'ok' => true,
        'fecha' => $fecha->format('Y-m-d')
    ];
}


/********************************** LOGIN ********************************/
# Definimos la función validar_login() para validar los datos ingresados -> NO CHEQUEA SI EXISTE EN LA BD, sólo los SANEA y verifica si cumple con los requisitos
function validar_login($usuario, $pass){
    # Declarar un array asociativo
    $errores = [];

    # Validación del correo electrónico
    if(!preg_match(USUARIO_REGEX, $usuario)){
        $errores['usuario'] = "- El nombre de usuario es incorrecto";
    }

    # Validación de la contraseña haciendo uso de la constante CONTRASENA_REGEX
    if(!preg_match(CONTRASENA_REGEX, $pass)){
        $errores['pass'] = "- La contraseña es inválida";
    }

    return $errores;
}


/******************************** PERFIL ********************************/
# Validación de ACTUALIZACION de datos del PERFIL
function validar_perfil($nombre, $apellido, $email, $telefono) {

    $errores = [];

    if (!preg_match(NOMBRE_REGEX, $nombre)) {
        $errores['nombre'] = "- El nombre deberá contener entre 2 y 20 letras y se podrá hacer uso de dos espacios (no consecutivos) en caso de introducir un nombre compuesto";
    }

    if (!preg_match(NOMBRE_REGEX, $apellido)) {
        $errores['apellido'] = "- El/los apellidos deberán contener entre 2 y 20 letras y se podrá hacer uso de un único espacio en caso de introducir un nombre compuesto";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "- El email no tiene un formato válido";
    }

    if (!preg_match(TELEFONO_REGEX, $telefono)) {
        $errores['telefono'] = "- El teléfono debe contener 8 y 11 dígitos";
    }

    return $errores;
}

// Validar ACTUALIZACION de CONSTRASEÑA
function validar_contrasena($password, $password2) {
    
    $error = "";

    # Validación de la contraseña haciendo uso de la constante CONTRASENA_REGEX
    if(!preg_match(CONTRASENA_REGEX, $password)){

        $error = "La contraseña deberá contener entre 6 y 10 caracteres e incluir de forma obligatoria una letra mayúscula, un número y un símbolo entre los siguientes (.,_-)";
    
    }else if(empty($password) || empty($password2)){ // Verificar Contraseñas vacías
        
        $error = "Debes completar ambos campos de contraseña";
        
    }else {

        // Verificar contraseñas distintas
        if ($password !== $password2) {
            $error = "Las contraseñas no coinciden";
        }
    }

    return $error;
}

?>