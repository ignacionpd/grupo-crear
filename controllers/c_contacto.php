<?php
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/contacto-errors.log');
error_reporting(E_ALL & ~E_NOTICE);
// Incluir/vincular los parámetros de conexión a Gmail y la librería PHPMailer
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/validations/v_inputData.php';
require_once __DIR__ . '/flash.php';


# Comprobamos si existe una sesión activa y en caso de que no sea así la creamos.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

# Comprobamos si la información llega a través del método POST y del formulario con submit "contactarse"
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contactarse'])) {
    # En primer lugar obtenemos los datos del formulario saneados
    $nombre = htmlspecialchars($_POST['input_name']);
    $apellido = htmlspecialchars($_POST['input_lastname']);
    $telefono = filter_input(INPUT_POST, 'input_tel', FILTER_SANITIZE_NUMBER_INT);
    $email = filter_input(INPUT_POST, 'input_email', FILTER_VALIDATE_EMAIL);
    $direccion = htmlspecialchars($_POST['input_adress']);
    $texto = htmlspecialchars($_POST['input_text']);

    # Validar el formulario a través de la función validar_registro() del controlador "v_inputData"
    $errores_validacion = validar_contacto($nombre, $apellido, $telefono, $email,  $texto);

    # Comprobar si se han generado errores de validacion o no
    if (!empty($errores_validacion)) {
        # Si hay errores de validación vamos a guardarlos en una cadena para mostrarselos al usuario
        $mensaje_error = "";

        # Recorremos el array de errores_validación para concatenar los mensajes en la variable $mensaje_error
        foreach ($errores_validacion as $clave => $mensaje) {
            $mensaje_error .= $mensaje . "<br>";
        }

        # Asignamos la cadena de errores a $_SESSION['mensaje_error']
        $_SESSION['mensaje_error'] = $mensaje_error;
        setFlash('old', $_POST); // guardamos todos los inputs

        header("Location: ../views/contacto.php");
        exit();
    }

    $mail = new PHPMailer(true);
    $cfg = require __DIR__ . '/config.php';

    try {

        $mail->isSMTP();
        //$mail->SMTPDebug = 2;
        //$mail->Debugoutput = 'error_log';

        $mail->Host       = $cfg['smtp_host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $cfg['smtp_user'];
        $mail->Password   = $cfg['smtp_pass'];

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $cfg['smtp_port'];
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom(
            $cfg['smtp_user'],
            'Formulario de contacto'
        );

        $mail->addAddress($cfg['to_email']);
        $mail->addReplyTo($email, $nombre . ' ' . $apellido);

        // Contenido del correo
        $mail->isHTML(true);

        $mail->Subject =
            'Formulario de contacto - ' . $nombre . ' ' . $apellido;

        $mail->Body = "
        <h2>Nueva solicitud de contacto</h2>

        <p>
            <strong>Nombre:</strong> $nombre
        </p>

        <p>
            <strong>Apellido:</strong> $apellido
        </p>

        <p>
            <strong>Teléfono:</strong> $telefono
        </p>

        <p>
            <strong>Dirección:</strong> $direccion
        </p>

        <p>
            <strong>Email:</strong> $email
        </p>

        <hr>

        <p>
            <strong>Mensaje:</strong>
        </p>

        <p>
            " . nl2br($texto) . "
        </p>
    ";

        $mail->send();


        # Configuramos un mensaje de éxito para el usuario y le redirigimos a la página de registro.
        $_SESSION['mensaje_exito'] = "EXITO: La solcitud de contacto se ha registrado correctamente";

        header("Location: ../views/contacto.php?mensaje=ok");

        exit();

        # SI durante el proceso surge una excepción    
    } catch (Exception $e) {
        error_log(
            'Error en contacto.php: ' .
                $e->getMessage() .
                ' | ErrorInfo: ' .
                $mail->ErrorInfo
        );

        $_SESSION['mensaje_error'] =
            'No se pudo enviar el mensaje. Inténtalo de nuevo más tarde.';

        header('Location: ../views/errors/error500.html');
        exit();
    }
}
