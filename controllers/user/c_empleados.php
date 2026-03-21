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
    /* =========================
    POST: REGISTRAR EMPLEADO
    ========================= */
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registro_empleado'])) {

        /* ---------- SANITIZACIÓN ---------- */
        $nombre = htmlspecialchars($_POST['user_name']);
        $apellido = htmlspecialchars($_POST['user_lastname']);
        $dni = filter_input(INPUT_POST, 'user_dni', FILTER_SANITIZE_NUMBER_INT);
        $cuit = filter_input(INPUT_POST, 'user_cuit', FILTER_SANITIZE_NUMBER_INT);
        $telefono = filter_input(INPUT_POST, 'user_tel', FILTER_SANITIZE_NUMBER_INT);
        $direccion = htmlspecialchars($_POST['user_adress']);
        $email = filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL);
        $contacto = trim($_POST['user_contact'] ?? '');
        $validacion_fecha = validar_fecha_nacimiento($_POST['user_date'] ?? null);

        $errores_validacion_oblig = validar_registro_empleado_oblig($nombre, $apellido, $dni, $cuit, $telefono);
        $errores_validacion_opc = validar_registro_empleado_opc($direccion, $email, $contacto);

        if (!empty($errores_validacion_oblig) || !empty($errores_validacion_opc) || !$validacion_fecha['ok']) {
            $mensaje_error = "";
            foreach ($errores_validacion_oblig as $clave => $mensaje) {
                $mensaje_error .= $mensaje . "<br>";
            }
            foreach ($errores_validacion_opc as $clave => $mensaje) {
                $mensaje_error .= $mensaje . "<br>";
            }
            if (!$validacion_fecha['ok']) {
                $mensaje_error .= $validacion_fecha['error'];
            }
            $_SESSION['mensaje_error'] = $mensaje_error;
            setFlash('old', $_POST); // Guardar los datos del formulario
            header("Location: ../../views/user/empleados.php");
            exit();
        }

        // Intentamos registrar al empleado
        if (check_dni($dni, $mysqli_connection)) {
            $_SESSION['mensaje_error'] = "Ya existe un usuario registrado con ese DNI";
            setFlash('old', $_POST); // Guardar los datos del formulario
            header("Location: ../../views/user/empleados.php");
            exit();
        }
        if (check_cuit($cuit, $mysqli_connection)) {
            $_SESSION['mensaje_error'] = "Ya existe un usuario registrado con ese CUIT";
            setFlash('old', $_POST); // Guardar los datos del formulario
            header("Location: ../../views/user/empleados.php");
            exit();
        }

        // Registro del nuevo empleado
        registrar_empleado($mysqli_connection, [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'dni' => $dni,
            'cuit' => $cuit,
            'fecha_nacimiento' => $validacion_fecha['fecha'],
            'telefono' => $telefono,
            'direccion' => $direccion,
            'email' => $email,
            'contacto' => $contacto
        ]);

        $_SESSION['mensaje_exito'] = "ÉXITO: El empleado se ha registrado correctamente";
        header("Location: ../../views/user/empleados.php");
        exit();
    }

    /* =========================
    POST: MODIFICAR EMPLEADO
    ========================= */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar_empleado'])) {
        $id_empleado = (int)$_POST['id_empleado'];
        $nombre = htmlspecialchars($_POST['user_name']);
        $apellido = htmlspecialchars($_POST['user_lastname']);
        $dni = filter_input(INPUT_POST, 'user_dni', FILTER_SANITIZE_NUMBER_INT);
        $cuit = filter_input(INPUT_POST, 'user_cuit', FILTER_SANITIZE_NUMBER_INT);
        $telefono = filter_input(INPUT_POST, 'user_tel', FILTER_SANITIZE_NUMBER_INT);
        $direccion = htmlspecialchars($_POST['user_adress']);
        $email = filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL);
        $contacto = trim($_POST['user_contact'] ?? '');
        $validacion_fecha = validar_fecha_nacimiento($_POST['user_date'] ?? null);

        $errores_oblig = validar_registro_empleado_oblig($nombre, $apellido, $dni, $cuit, $telefono);
        $errores_opc = validar_registro_empleado_opc($direccion, $email, $contacto);

        if (!empty($errores_oblig) || !empty($errores_opc) || !$validacion_fecha['ok']) {
            $mensaje_error = '';
            foreach ($errores_oblig as $m) {
                $mensaje_error .= $m . '<br>';
            }
            foreach ($errores_opc as $m) {
                $mensaje_error .= $m . '<br>';
            }
            if (!$validacion_fecha['ok']) {
                $mensaje_error .= $validacion_fecha['error'];
            }
            $_SESSION['mensaje_error'] = $mensaje_error;
            setFlash('old', $_POST); // Guardar los datos del formulario
            header("Location: ../../views/user/empleados.php");
            exit;
        }

        // Comprobar DNI: Si el DNI en el input es del mismo empleado (no modifica) o si ya hay otro registrado con ese número
        $estadoDni = check_dni_update($dni, $id_empleado, $mysqli_connection);

        if ($estadoDni === 'DNI_OTRO_EMPLEADO') {
            $_SESSION['mensaje_error'] = "Ya existe un empleado registrado con ese DNI";
            setFlash('old', $_POST); // Guardar los datos del formulario
            header("Location: ../../views/user/empleados.php");
            exit();
        }
        
        // Comprobar CUIT: Si el CUIT en el input es del mismo empleado (no modifica) o si ya hay otro registrado con ese número
        $estadoCuit = check_cuit_update($cuit, $id_empleado, $mysqli_connection);

        if ($estadoCuit === 'CUIT_OTRO_EMPLEADO') {
            $_SESSION['mensaje_error'] = "Ya existe un empleado registrado con ese CUIT";
            setFlash('old', $_POST); // Guardar los datos del formulario
            header("Location: ../../views/user/empleados.php");
            exit();
        }

        // Actualización del empleado
        actualizar_empleado($mysqli_connection, [
            'id_empleado' => $id_empleado,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'dni' => $dni,
            'cuit' => $cuit,
            'fecha_nacimiento' => $validacion_fecha['fecha'],
            'telefono' => $telefono,
            'direccion' => $direccion,
            'email' => $email,
            'contacto' => $contacto
        ]);

        $_SESSION['mensaje_exito'] = "El usuario se ha modificado correctamente";
        header("Location: ../../views/user/empleados.php");
        exit;
    }

    /* =========================
    POST: BORRAR EMPLEADO
    ========================= */
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['borrar_empleado'])) {
        $id_empleado = (int)($_POST['id_empleado'] ?? 0);

        if (borrar_empleado($id_empleado, $mysqli_connection)) {
            $_SESSION['mensaje_exito'] = "El empleado se ha borrado correctamente";
            header("Location: ../../views/user/empleados.php");
            exit();
        } else {
            header('Location: ../../views/errors/error500.html');
            exit();
        }
    }
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    header("Location: ../../views/errors/error500.html");
    exit();
} finally {
    if (isset($mysqli_connection) && $mysqli_connection) {
        $mysqli_connection->close();
    }
}

// =========================
// POST: RESET FORMULARIO
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_form'])) {
    unset($_SESSION['datos']);
    // Redirigir a la MISMA página
    header("Location: ../../views/user/empleados.php");
    exit;
}
?>