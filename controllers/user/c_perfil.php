<?php
require_once '../../config/config.php';
require_once __DIR__ . '/../db_conn.php';
require_once __DIR__ . '/../db_functions.php';
require_once __DIR__ . '/../validations/v_inputData.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_data'])) {
    header("Location: ../../index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_perfil'])) {

    try {

        /* ===============================
           DATOS BÁSICOS
        =============================== */

        $id_usuario = (int) $_SESSION['user_data']['id_user'];
        $nombre    = htmlspecialchars(trim($_POST['user_name'] ?? ''));
        $apellido = htmlspecialchars(trim($_POST['user_lastname'] ?? ''));
        $email     = filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL);
        $telefono  = filter_input(INPUT_POST, 'user_tel', FILTER_SANITIZE_NUMBER_INT);

        /* ===============================
          VALIDACIONES
        =============================== */

        $errores = validar_perfil(
            $nombre,
            $apellido,
            $email,
            $telefono
        );

        if (!empty($errores)) {
            $_SESSION['mensaje_error'] = implode('<br>', $errores);
            header("Location: ../../views/user/perfil.php");
            exit;
        }

        /* ===============================
         VALIDAR EMAIL (3 ESTADOS)
        =============================== */

        $estadoEmail = check_email_modificar(
            $email,
            $id_usuario,
            $mysqli_connection
        );

        if ($estadoEmail === 'EMAIL_OTRO_USUARIO') {
            $_SESSION['mensaje_error'] =
                "Ese email ya está registrado por otro usuario.";
            header("Location: ../../views/user/perfil.php");
            exit;
        }

        /* ===============================
           UPDATE PERFIL
        =============================== */

        $stmt = $mysqli_connection->prepare(
            "UPDATE usuarios_data
             SET nombre = ?, apellido = ?, email = ?, telefono = ?
             WHERE id_usuario = ?"
        );

        if (!$stmt) {
            throw new Exception("Error al preparar la actualización: " . $mysqli_connection->error);
        }

        $stmt->bind_param(
            "ssssi",
            $nombre,
            $apellido,
            $email,
            $telefono,
            $id_usuario
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la actualización: " . $stmt->error);
        }

        $stmt->close();

        $_SESSION['mensaje_exito'] =
            "Perfil actualizado correctamente.";

        header("Location: ../../views/user/perfil.php");
        exit;
    } catch (Exception $e) {

        error_log("Error actualizar perfil usuario: " . $e->getMessage());
        header('Location: ../../views/errors/error500.html');
        exit;
    } finally {

        if (isset($mysqli_connection)) {
            $mysqli_connection->close();
        }
    }
}



/** *************** FORMULARIO CAMBIO DE PASSWORD *************/

// Verificar envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_contrasena'])) {

    $password  = $_POST['password']  ?? '';
    $password2 = $_POST['password2'] ?? '';

    // Verificar si la contraseña ingresada es válida y coincide con la repetición
    $error_validacion_password = validar_contrasena($password, $password2);

    // Si el campo $error no está vacío, cargamos su contenido en la $_SESSION['mensaje_error']
    if (!empty($error_validacion_password)) {
        $_SESSION['mensaje_error'] = $error_validacion_password;
        header("Location: ../../views/user/perfil.php");
        exit;
    }

    try {

        $id_usuario = $_SESSION['user_data']['id_user'];
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "
        UPDATE usuarios_login
        SET contrasena = ?
        WHERE id_usuario = ?
        ";

        $stmt = $mysqli_connection->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error al preparar la consulta cambiar_contrasena.");
        }

        $stmt->bind_param("si", $hash, $id_usuario);

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la actualización cambiar_contrasena.");
        }

        $stmt->close();

        $_SESSION['mensaje_exito'] = "La contraseña se ha actualizado correctamente.";
        header("Location: ../../views/user/perfil.php");
        exit;
    } catch (Exception $e) {
        error_log("Error al cambiar contraseña: " . $e->getMessage());
        $_SESSION['mensaje_error'] = "No se pudo actualizar la contraseña.";
        header("Location: ../../views/user/perfil.php");
        exit;
    }
};
