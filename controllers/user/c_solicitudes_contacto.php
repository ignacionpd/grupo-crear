<?php
require_once __DIR__ . '/../db_conn.php';
require_once __DIR__ . '/../../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_data'])) {
    header("Location: ../index.php");
    exit();
}

try {

    /* ==============================
       BORRAR
    ============================== */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrar_solicitud'])) {

        $id_solicitud = (int)($_POST['id_solicitud'] ?? 0);

        if ($id_solicitud <= 0) {
            $_SESSION['mensaje_error'] = "ID inválido.";
            header("Location: ../views/user/solicitudes.php");
            exit();
        }

        $stmt = $mysqli_connection->prepare(
            "DELETE FROM solicitudes_contacto WHERE id_solicitud = ?"
        );
        $stmt->bind_param("i", $id_solicitud);

        if ($stmt->execute()) {
            $_SESSION['mensaje_exito'] = "Solicitud eliminada";
        } else {
            $_SESSION['mensaje_error'] = "Error al eliminar";
        }

        $stmt->close();
        header("Location: ../../views/user/solicitudes.php");
        exit();
    }

    /* ==============================
       GUARDAR CAMBIOS
    ============================== */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_cambios'])) {

        $id_solicitud  = (int)($_POST['id_solicitud'] ?? 0);
        $estado        = trim($_POST['estado'] ?? '');
        $fecha_cierre  = trim($_POST['fecha_cierre'] ?? '');
        $observaciones = trim($_POST['observaciones'] ?? '');

        $id_usuario_editor = (int)($_SESSION['user_data']['id_user'] ?? 0);

        if ($id_solicitud <= 0) {
            $_SESSION['mensaje_error'] = "ID inválido.";
            header("Location: ../../views/user/solicitudes.php");
            exit();
        }

        if (!in_array($estado, ['Pendiente', 'Respondido'])) {
            $_SESSION['mensaje_error'] = "Estado inválido";
            header("Location: ../../views/user/solicitudes.php");
            exit();
        }

        if (strlen($observaciones) > 250) {
            $_SESSION['mensaje_error'] = "Observaciones: máximo 250 caracteres.";
            header("Location: ../../views/user/solicitudes.php");
            exit();
        }

        $obs = ($observaciones === '') ? '' : $observaciones;

        if ($estado === 'Pendiente') {

            $stmt = $mysqli_connection->prepare(
                "UPDATE solicitudes_contacto
             SET estado = 'Pendiente',
                 fecha_cierre = NULL,
                 observaciones = ?,
                 id_usuario = NULL
             WHERE id_solicitud = ?"
            );

            
            $stmt->bind_param("si", $obs, $id_solicitud);
        } else {

            $stmt = $mysqli_connection->prepare(
                "UPDATE solicitudes_contacto
             SET estado = 'Respondido',
                 fecha_cierre = COALESCE(NULLIF(?, ''), CURRENT_DATE),
                 observaciones = ?,
                 id_usuario = ?
             WHERE id_solicitud = ?"
            );

            $stmt->bind_param("ssii", $fecha_cierre, $obs, $id_usuario_editor, $id_solicitud);
        }

        if ($stmt->execute()) {
            $_SESSION['mensaje_exito'] = "Solicitud actualizada correctamente.";
        } else {
            $_SESSION['mensaje_error'] = "Error al actualizar";
        }

        $stmt->close();

        header("Location: ../../views/user/solicitudes.php");
        exit();
    }

    header("Location: ../../views/user/solicitudes.php");
    exit();
} catch (Exception $e) {
    error_log("Error solicitudes controller: " . $e->getMessage());
    $_SESSION['mensaje_error'] = "Error interno.";
    header("Location: ../../views/user/solicitudes.php");
    exit();
} finally {
    if (isset($mysqli_connection) && $mysqli_connection) {
        $mysqli_connection->close();
    }
}
