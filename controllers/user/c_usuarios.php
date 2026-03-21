<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../db_conn.php';
require_once __DIR__ . '/../db_functions.php';
require_once __DIR__ . '/../validations/v_inputData.php';
require_once __DIR__ . '/../flash.php';

# Comprobamos si existe una sesión activa y en caso de que no sea así la creamos.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

# Comprobamos si existe una variable de SESSION y que sea ADMIN, y sino, redirigimos a index.php
if (!isset($_SESSION['user_data']) || ($_SESSION['user_data']['id_user'] != 1)) {
    header("Location: ../../index.php");
    exit;
}

try {

    //************************* VALIDACION FORMULARIO "REGISTRAR NUEVO USUARIO"*************************** */

    # Comprobamos si la información llega a través del método POST y del formulario con submit "registrarse"
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registro_usuario'])) {

        /* ---------- SANITIZACIÓN ---------- */
        # En primer lugar obtenemos los datos del formulario saneados
        $nombre = htmlspecialchars($_POST['user_name']);
        $apellido = htmlspecialchars($_POST['user_lastname']);
        $email = filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL);
        $telefono = filter_input(INPUT_POST, 'user_tel', FILTER_SANITIZE_NUMBER_INT);
        $usuario = htmlspecialchars($_POST['user_login_name']);
        $pass = $_POST['user_password'];

  
        /* ---------- VALIDACIONES ---------- */
        $errores_validacion = validar_registro($nombre, $apellido, $email, $telefono,  $usuario, $pass);

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

            header("Location: ../../views/user/usuarios.php");
            exit();
        }

        # Intentamos realizar un registro sencillo en "users_data" con los campos a registrar sólo en ella
        try {
            # Declaramos la variable que registrará si se ha producido una excepción durante el proceso que
            # comprueba si el usuario que se está intentando registrar YA existe en la base de datos.
            $errores = [];

            # SI el resultado de check_email es TRUE (ya existe el email)
            if (check_email($email, $mysqli_connection)) {
                # Esablecemos un mensaje de error
                $errores['email'] = "- Ya existe un usuario registrado con ese email";
            }

            # SI el resultado de check_usuario es TRUE (ya existe el usuario)
            if (check_usuario($usuario, $mysqli_connection)) {
                # Esablecemos un mensaje de error
                $errores['usuario'] = "- Ya existe un usuario registrado con ese nombre de usuario";
            }

            if (!empty($errores)) {

                $_SESSION['mensaje_error'] = "";

                # Recorremos el array $errores e ingresamos su contenido al mensaje de sesión que mostraremos en pantalla
                foreach ($errores as $clave => $error) {
                    $_SESSION['mensaje_error'] .= $error . '<br>';
                }
                setFlash('old', $_POST); // guardamos todos los inputs

                # Redirigimos al usuario a la página de registro
                header("Location: ../../views/user/usuarios.php");
                exit();
            }

            $pass_hash = password_hash($pass, PASSWORD_BCRYPT);

            registrar_usuario($mysqli_connection, [
                'nombre'           => $nombre,
                'apellido'        => $apellido,
                'email'            => $email,
                'telefono'         => $telefono,
                'usuario'          => $usuario,
                'contrasena'         => $pass_hash
            ]);

            $_SESSION['mensaje_exito'] = "ÉXITO: El usuario se ha registrado correctamente";
            header("Location: ../../views/user/usuarios.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['mensaje_error'] = "Error interno al registrar el usuario.";
            header("Location: ../../views/errors/error500.html");
            exit();
        }
    }


    /************************* VALIDACION FORMULARIO "MODIFICAR USUARIO"*************************** */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar_usuario'])) {

        try {

            /* ===============================
            VALIDACIÓN BÁSICA
            =============================== */

            $id_usuario = (int) $_POST['id_usuario'];

            $nombre    = htmlspecialchars(trim($_POST['nombre'] ?? ''));
            $apellido = htmlspecialchars(trim($_POST['apellido'] ?? ''));
            $email     = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $telefono  = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_NUMBER_INT);
            $errores = validar_actualizacion_registro(
                $nombre,
                $apellido,
                $email,
                $telefono
            );
            
            if (!empty($errores)) {
                $_SESSION['mensaje_error'] = implode('<br>', $errores);
                header("Location: ../../views/user/usuarios.php");
                exit;
            }

            /* ===============================
            VALIDAR EMAIL
            =============================== */

            $estadoEmail = check_email_modificar(
                $email,
                $id_usuario,
                $mysqli_connection
            );

            if ($estadoEmail === 'EMAIL_OTRO_USUARIO') {
                $_SESSION['mensaje_error'] =
                    "Ya existe otro usuario registrado con ese email.";
                header("Location: ../../views/user/usuarios.php");
                exit;
            }

            /* ===============================
            TRANSACCIÓN
            =============================== */

            $mysqli_connection->begin_transaction();

            /* ---------- UPDATE users_data ---------- */
            $stmtData = $mysqli_connection->prepare(
                "UPDATE usuarios_data
                SET nombre = ?, apellido = ?, email = ?, telefono = ?
                WHERE id_usuario = ?"
            );

            if (!$stmtData) {
                throw new Exception($mysqli_connection->error);
            }

            $stmtData->bind_param(
                "ssssi",
                $nombre,
                $apellido,
                $email,
                $telefono,
                $id_usuario
            );

            if (!$stmtData->execute()) {
                throw new Exception($stmtData->error);
            }

            $stmtData->close();

            /* ---------- COMMIT ---------- */
            $mysqli_connection->commit();

            $_SESSION['mensaje_exito'] =
                "El usuario se ha modificado correctamente";

            header("Location: ../../views/user/usuarios.php");
            exit;
        } catch (Exception $e) {

            if ($mysqli_connection->errno) {
                $mysqli_connection->rollback();
            }

            error_log("Error modificar usuario: " . $e->getMessage());
            header('Location: ../../views/errors/error500.html');
            exit;
        }
    }


    /************************* VALIDACION FORMULARIO "BORRAR USUARIO"*************************** */

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['borrar_usuario'])) {

        $id_usuario = (int)($_POST['id_usuario'] ?? 0);

        if (borrar_usuario($id_usuario, $mysqli_connection)) {
            $_SESSION['mensaje_exito'] = "El usuario se ha borrado correctamente";

            header("Location: ../../views/user/usuarios.php?delete=ok");
            exit();
        } else {
            # Se redirige al usuario a la página de error 500
            header('Location: ../../views/errors/error500.html');
            exit();
        }
    }
} catch (Exception $e) {
    error_log("Error usuarios controller: " . $e->getMessage());
    header("Location: ../../views/errors/error500.html");
    exit();
} finally {
    if (isset($mysqli_connection) && $mysqli_connection) {
        $mysqli_connection->close();
    }
}
