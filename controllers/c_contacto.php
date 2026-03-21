<?php
# Vinculamos los archivos necesarios
require_once 'db_conn.php';
require_once 'db_functions.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/validations/v_inputData.php';
require_once __DIR__ . '/flash.php';


# Comprobamos si existe una sesión activa y en caso de que no sea así la creamos.
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

# Comprobamos si la información llega a través del método POST y del formulario con submit "contactarse"
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contactarse'])){
    # En primer lugar obtenemos los datos del formulario saneados
    $nombre = htmlspecialchars($_POST['input_name']);
    $apellido = htmlspecialchars($_POST['input_lastname']);
    $telefono = filter_input(INPUT_POST, 'input_tel', FILTER_SANITIZE_NUMBER_INT);
    $email = filter_input(INPUT_POST, 'input_email', FILTER_SANITIZE_EMAIL);
    $direccion = htmlspecialchars($_POST['input_adress']);
    $texto = htmlspecialchars($_POST['input_text']);

    # Validar el formulario a través de la función validar_registro() del controlador "v_inputData"
    $errores_validacion = validar_contacto($nombre, $apellido, $telefono, $email,  $texto);
     
    # Comprobar si se han generado errores de validacion o no
    if(!empty($errores_validacion)){
        # Si hay errores de validación vamos a guardarlos en una cadena para mostrarselos al usuario
        $mensaje_error = "";

        # Recorremos el array de errores_validación para concatenar los mensajes en la variable $mensaje_error
        foreach($errores_validacion as $clave => $mensaje){
            $mensaje_error .= $mensaje . "<br>";
        }

        # Asignamos la cadena de errores a $_SESSION['mensaje_error']
        $_SESSION['mensaje_error'] = $mensaje_error;
        setFlash('old', $_POST); // guardamos todos los inputs

        header("Location: ../views/contacto.php");
        exit();
    }

    # Intentamos realizar un registro sencillo en "users_data" con los campos a registrar sólo en ella
    try{

                # Se prepara la sentecia SQL para realizar la inserción
                $fecha_solicitud = date('Y-m-d');
                $insert_stmt_solicitud_contacto = $mysqli_connection -> prepare("INSERT INTO solicitudes_contacto(nombre, apellido, telefono, email, direccion, texto, fecha_solicitud) VALUES (?, ?, ?, ?, ?, ?, ?)");
                
                # SI la sentencia NO se ha podido preparar
                if(!$insert_stmt_solicitud_contacto){
                    # Se guarda el error de preparación de la sentencia
                    error_log("No se pudo preparar la sentencia " . $mysqli_connection -> error);
                    
                    # Se redirige al usuario a la página de error 500
                    header('Location: ../views/errors/error500.html');
                    exit();
                # SI la sentencia se ha podido preparar   
                }else{
                    # Vinculamos los valores introducidos por el usuario a los valores de la sentencia de inserción
                    $insert_stmt_solicitud_contacto->bind_param("sssssss", $nombre, $apellido, $telefono, $email, $direccion, $texto, $fecha_solicitud);    

                    # SI la sentencia se ha podido ejecutar
                    if(!$insert_stmt_solicitud_contacto -> execute()){
                    # Se guarda el error de ejecución de la sentencia
                    error_log("No se pudo ejecutar la sentencia " . $mysqli_connection -> error);
                    
                    # Se redirige al usuario a la página de error 500
                    header('Location: ../views/errors/error500.html');
                    exit();

                # SI la sentencia se ha podido preparar   
                    }else{

                    # Cerramos la sentencia
                    $insert_stmt_solicitud_contacto -> close();
                        
                        # Configuramos un mensaje de éxito para el usuario y le redirigimos a la página de registro.
                        $_SESSION['mensaje_exito'] = "EXITO: La solcitud de contacto se ha registrado correctamente";
                        header("Location: ../views/contacto.php?mensaje=ok");
                        exit();
                        
                   
                    }
                }
    # SI durante el proceso surge una excepción    
    }catch(Exception $e){
        # Registramos la excepción en el error_log
        error_log("Error en c_contacto.php" . $e -> getMessage());
        # Redirigimos al usuario a la página de error 500
        header('Location: ../views/errors/error500.html');
    
    # Independientemente de si se genera una excepción o no al final siempre se realizará el siguiente código
    }finally{
        # Cerramos la consulta si aún sigue abierta
        if(isset($insert_stmt_solicitud_contacto) && ($insert_stmt_solicitud_contacto)){
            $insert_stmt_solicitud_contacto -> close();
        }

        # Cerramos la conexión a la base de datos si aún sigue abierta
        if(isset($mysqli_connection) && ($mysqli_connection)){
            $mysqli_connection -> close();
        }

    }
}


?>