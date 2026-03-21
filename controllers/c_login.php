<?php
# Vinculamos los archivos necesarios
require_once 'db_conn.php';
require_once 'db_functions.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/validations/v_inputData.php';

# Comprobar si existe una sesión activa y en caso de que no así la crearemos
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

# Comprobar si la información llega desde POST y dedse nuestro formulario con submit (iniciar_sesion)
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['iniciar_sesion'])){
    # Obtener los datos del fomulario saneados
    $usuario = htmlspecialchars($_POST['user_login_name']);
    $pass = $_POST['user_password'];

    # Validar el formulario a través de la función validar_login() -> SOLO SANITIZACION de los datos ingresados Y VERIFICACION SI CUMPLE CON LOS REQUISITOS
    $errores_validacion = validar_login($usuario, $pass);

    # Comprobar si se han generado errores de validacion o no
    if(!empty($errores_validacion)){
        # Si hay errores los guardamos en una cadena de caracteres que mostraremos al usuario
        $mensaje_error = "";

        foreach($errores_validacion as $clave => $mensaje){
            $mensaje_error .= $mensaje . "<br>";
        }

        # Asignamos la cadena de caracteres con los erres a $_SESSION['mensaje_error']
        $_SESSION['mensaje_error'] = $mensaje_error;
        header("Location: ../views/user/login.php");
        exit();
    }

    // Intetamos realizar el inicio de sesión chequeando en la BD si existe el USUARIO y si coincide la CONTRASEÑA
    try{

        $user = get_user_by_username($usuario, $mysqli_connection);

        if(!$user){
            # Redirigimos a la página de error que tengamos configurada
            $_SESSION['mensaje_error'] = "No se encontró un usuario con ese nombre";
            header("Location: ../views/user/login.php");
            exit();
        
          # Verificar si la contraseña faciltiada por el usuario en el formulario coincide con la de la BBDD
        }else if(password_verify($pass, $user['contrasena'])){
                
                # Establecer las variables de sesión y redirigir al usuario 
                $_SESSION['user_data'] = [
                    'id_user' => $user['id_usuario'],
                    'user' => $user['usuario']
                ];

                header('Location: ../index.php?login=ok');
                exit();
            
        }else{
                # Si la contraseña no coincide, establecemos un mensaje de error
                $_SESSION['mensaje_error'] = "La contraseña no coincide";
                header("Location: ../views/user/login.php");
                exit();
        }


    }catch(Exception $e){
        error_log("Error durante el proceso de inicio de sesión: " . $e -> getMessage());
        $_SESSION['mensaje_error'] = "Error interno durante el proceso de inicio de sesión";
        header("Location: ../views/errors/error500.html");
        exit();
    
    }finally{
        # Cerrar la conexión a la base de datos si aún sigue abierta
        if(isset($mysqli_connection) && ($mysqli_connection)){
            $mysqli_connection -> close();
        }
    }


}



?>