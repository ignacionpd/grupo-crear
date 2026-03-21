<?php

# Vinculamos la ruta absoluta al directorio config.php desde db_conn.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/db_conn.php';


/****************** SOLICITUDES *******************/

/* ==========================
   OBTENER TODAS LAS SOLICITUDES
========================== */
function obtener_solicitudes(mysqli $mysqli_connection): array
{

    $sql = "
        SELECT s.id_solicitud, s.nombre, s.apellido, s.telefono,
        s.email, s.direccion, s.texto, s.fecha_solicitud, s.estado, s.observaciones
        FROM solicitudes_contacto s
        WHERE estado = 'Pendiente'
        ORDER BY s.id_solicitud
    ";

    $result = $mysqli_connection->query($sql);

    if (!$result) {
        throw new Exception($mysqli_connection->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

/******************** USUARIOS ***************************/

# Registrar USUARIO NUEVO
function registrar_usuario(mysqli $db, array $data): void
{
    try {
        $db->begin_transaction();

        /* ---------------- INSERT users_data ---------------- */
        $stmt = $db->prepare(
            "INSERT INTO usuarios_data 
            (nombre, apellido, email, telefono)
            VALUES (?, ?, ?, ?)"
        );

        if (!$stmt) {
            throw new Exception("Error al preparar sentencia en usuarios_data: " . $db->error);
        }

        $stmt->bind_param(
            "ssss",
            $data['nombre'],
            $data['apellido'],
            $data['email'],
            $data['telefono']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar sentencia en usuarios_data: " . $stmt->error);
        }

        $id_usuario = $db->insert_id;
        $stmt->close();

        /* ---------------- INSERT users_login ---------------- */
        $stmt = $db->prepare(
            "INSERT INTO usuarios_login 
            (id_usuario, usuario, contrasena)
            VALUES (?, ?, ?)"
        );

        if (!$stmt) {
            throw new Exception("Error al preparar sentencia en usuarios_login: " . $db->error);
        }

        $stmt->bind_param(
            "iss",
            $id_usuario,
            $data['usuario'],
            $data['contrasena']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar sentencia en usuarios_login: " . $stmt->error);
        }

        $stmt->close();

        $db->commit();
    } catch (Exception $e) {
        $db->rollback();
        error_log("Error al ejecutar la función registrar_usuario: " . $e->getMessage());
        throw $e; //
    }
}

# BORRAR USUARIO
function borrar_usuario(int $id_usuario, mysqli $db): bool
{
    try {
        $db->begin_transaction();

        $stmt = $db->prepare(
            "DELETE FROM usuarios_data WHERE id_usuario = ?"
        );
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta borrar_usuario: " . $db->error);
        }

        $stmt->bind_param("i", $id_usuario);

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta borrar_usuario: " . $stmt->error);
        }

        $stmt->close();

        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollback();
        error_log("Error borrar_usuario: " . $e->getMessage());
        return false;
    }
}


// CHECK DE EMAIL SOLO EN REGISTRO de NUEVO DE USUARIO
function check_email(string $email, mysqli $mysqli_connection): bool
{
    $select_stmt = null;

    try {
        $select_stmt = $mysqli_connection->prepare(
            "SELECT 1 FROM usuarios_data WHERE email = ? LIMIT 1"
        );

        if (!$select_stmt) {
            throw new Exception("No se pudo preparar la sentencia: " . $mysqli_connection->error);
        }

        $select_stmt->bind_param("s", $email);

        if (!$select_stmt->execute()) {
            throw new Exception("No se puede ejecutar la sentencia: " . $select_stmt->error);
        }

        $select_stmt->store_result();

        return ($select_stmt->num_rows > 0);
    } catch (Exception $e) {
        error_log("Error en la función check_email: " . $e->getMessage());
        throw $e;
    } finally {
        if ($select_stmt !== null) {
            $select_stmt->close();
        }
    }
}

// CHECK USUARIO SI ya EXISTE EN LA BD INGRESADO EN EL FORM DE REGISTRO 
function check_usuario(string $usuario, mysqli $mysqli_connection): bool
{
    $select_stmt = null;

    try {
        $select_stmt = $mysqli_connection->prepare(
            "SELECT 1 FROM usuarios_login WHERE usuario = ? LIMIT 1"
        );

        if (!$select_stmt) {
            throw new Exception("No se pudo preparar la sentencia: " . $mysqli_connection->error);
        }

        $select_stmt->bind_param("s", $usuario);

        if (!$select_stmt->execute()) {
            throw new Exception("No se puede ejecutar la sentencia: " . $select_stmt->error);
        }

        $select_stmt->store_result();

        return ($select_stmt->num_rows > 0);
    } catch (Exception $e) {
        error_log("Error en la función check_usuario: " . $e->getMessage());
        throw $e;
    } finally {
        if ($select_stmt !== null) {
            $select_stmt->close();
        }
    }
}

//Función que carga todos los USUARIOS existentes dentro de la vista USUARIOS.php 
function obtener_todos_los_usuarios(mysqli $mysqli): array
{
    $usuarios = [];
    $stmt = null;

    try {

        // Preparamos la consulta en una variable
        $sql = "
            SELECT 
                ud.id_usuario,
                ud.nombre,
                ud.apellido,
                ud.email,
                ud.telefono,
                ul.usuario
            FROM usuarios_data ud
            INNER JOIN usuarios_login ul ON ud.id_usuario = ul.id_usuario
            WHERE ud.id_usuario >= 2
            ORDER BY ud.nombre ASC
        ";

        // Se prepara la consulta a la BD con la consulta preparada $sql
        $stmt = $mysqli->prepare($sql);

        // Si la consulta no se pudo hacer, se arroja la excepción
        if (!$stmt) {
            throw new Exception("Error en prepare(): " . $mysqli->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Error en execute(): " . $stmt->error);
        }

        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Error al obtener resultados");
        }

        $usuarios = $result->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {

        error_log(
            "[ADMIN][obtener_todos_los_usuarios] " . $e->getMessage()
        );

        # Se redirige al usuario a la página de error505.html
        header('Location: ../views/error/error500.html');
        exit();
    } finally {

        if ($stmt !== null) {
            $stmt->close();
        }
    }

    return $usuarios;
}


/***************************** EMPLEADOS *********************************/

// Función para MOSTRAR en pantalla TODOS los EMPLEADOS 
function obtener_todos_los_empleados(mysqli $mysqli): array
{
    $empleados = [];
    $stmt = null;

    try {

        // Preparamos la consulta en una variable
        $sql = "
            SELECT 
                em.id_empleado,
                em.nombre,
                em.apellido,
                em.dni,
                em.cuit,
                em.fecha_nacimiento,
                em.telefono,
                em.direccion,
                em.email,
                em.contacto_emergencia
            FROM empleados em
            ORDER BY em.nombre ASC
        ";

        // Se prepara la consulta a la BD con la consulta preparada $sql
        $stmt = $mysqli->prepare($sql);

        // Si la consulta no se pudo hacer, se arroja la excepción
        if (!$stmt) {
            throw new Exception("Error en prepare(): " . $mysqli->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Error en execute(): " . $stmt->error);
        }

        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Error al obtener resultados");
        }

        $empleados = $result->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {

        error_log(
            "[ADMIN][obtener_todos_los_empleados] " . $e->getMessage()
        );

        # Se redirige al usuario a la página de error505.html
        header('Location: ../views/error/error500.html');
        exit();
    } finally {

        if ($stmt !== null) {
            $stmt->close();
        }
    }

    return $empleados;
}

// Función para REGISTRAR EMPLEADO NUEVO
function registrar_empleado(mysqli $db, array $data): void
{
    try {

        /* ---------------- INSERT empleados ("registro_oblig" (nombre, apellido, dani y cuit, fecha de nacimiento y teléfono) ---------------- */
        $stmt = $db->prepare(
            "INSERT INTO empleados 
            (nombre, apellido, dni, cuit, fecha_nacimiento, telefono, direccion, email, contacto_emergencia)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        if (!$stmt) {
            throw new Exception("Error al preparar sentencia en empleados: " . $db->error);
        }

        $stmt->bind_param(
            "sssssssss",
            $data['nombre'],
            $data['apellido'],
            $data['dni'],
            $data['cuit'],
            $data['fecha_nacimiento'],
            $data['telefono'],
            $data['direccion'],
            $data['email'],
            $data['contacto'],
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar sentencia en empleados: " . $stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {

        error_log("Error al ejecutar la función registrar_empleado: " . $e->getMessage());
        throw $e; //
    }
}

// Función para chequear SI YA EXISTE EL DNI EN LA BD
function check_dni(string $dni, mysqli $mysqli_connection): bool
{
    $select_stmt = null;

    try {
        $select_stmt = $mysqli_connection->prepare(
            "SELECT * FROM empleados WHERE dni = ? LIMIT 1"
        );

        if (!$select_stmt) {
            throw new Exception("No se pudo preparar la sentencia: " . $mysqli_connection->error);
        }

        $select_stmt->bind_param("s", $dni);

        if (!$select_stmt->execute()) {
            throw new Exception("No se puede ejecutar la sentencia: " . $select_stmt->error);
        }

        $select_stmt->store_result();

        return ($select_stmt->num_rows > 0);
    } catch (Exception $e) {
        error_log("Error en la función check_dni: " . $e->getMessage());
        throw $e;
    } finally {
        if ($select_stmt !== null) {
            $select_stmt->close();
        }
    }
}

// Función para chequear SI YA EXISTE EL CUIT EN LA BD
function check_cuit(string $cuit, mysqli $mysqli_connection): bool
{
    $select_stmt = null;

    try {
        $select_stmt = $mysqli_connection->prepare(
            "SELECT * FROM empleados WHERE cuit = ? LIMIT 1"
        );

        if (!$select_stmt) {
            throw new Exception("No se pudo preparar la sentencia: " . $mysqli_connection->error);
        }

        $select_stmt->bind_param("s", $cuit);

        if (!$select_stmt->execute()) {
            throw new Exception("No se puede ejecutar la sentencia: " . $select_stmt->error);
        }

        $select_stmt->store_result();

        return ($select_stmt->num_rows > 0);
    } catch (Exception $e) {
        error_log("Error en la función check_cuit: " . $e->getMessage());
        throw $e;
    } finally {
        if ($select_stmt !== null) {
            $select_stmt->close();
        }
    }
}

// ACTUALIZACION DE EMPLEADO - DNI: Función para chequear SI YA EXISTE EL DNI EN LA BD o si es de la misma persona que se actualiza (no cambia DNI)
function check_dni_update(string $dni, $id_empleado, mysqli $mysqli_connection): string
{
    $select_stmt = null;

    try {
        $select_stmt = $mysqli_connection->prepare(
            "SELECT id_empleado FROM empleados WHERE dni = ? LIMIT 1"
        );

        if (!$select_stmt) {
            throw new Exception("No se pudo preparar la sentencia: " . $mysqli_connection->error);
        }

        $select_stmt->bind_param("s", $dni);

        if (!$select_stmt->execute()) {
            throw new Exception("No se puede ejecutar la sentencia: " . $select_stmt->error);
        }

        $select_stmt->store_result();

        // OPCION 1) No existe el DNI -> SE PUEDE INGRESAR
        if ($select_stmt->num_rows === 0) {
            $select_stmt->close();
            return 'DNI_NO_EXISTE';
        }

        //Existe el DNI -> VER SI ES DE OTRO EMPLEADO O DEL MISMO

        $select_stmt->bind_result($idEncontrado);
        $select_stmt->fetch();
        $select_stmt->close();

        // OPCION 2) ES DEL MISMO EMPLEADO
        if ((int)$idEncontrado === $id_empleado) {
            return 'DNI_MISMO_EMPLEADO';
        }

        // OPCION 3) Existe pero es de otro empleado
        return 'DNI_OTRO_EMPLEADO';
    } catch (Exception $e) {
        error_log("Error en la función check_dni_update: " . $e->getMessage());
        throw $e;
    }
}

// ACTUALIZACION DE EMPLEADO - CUIT: Función para chequear SI YA EXISTE EL CUIT EN LA BD o si es de la misma persona que se actualiza (no cambia DNI)
function check_cuit_update(string $cuit, $id_empleado, mysqli $mysqli_connection): string
{
    $select_stmt = null;

    try {
        $select_stmt = $mysqli_connection->prepare(
            "SELECT id_empleado FROM empleados WHERE cuit = ? LIMIT 1"
        );

        if (!$select_stmt) {
            throw new Exception("No se pudo preparar la sentencia: " . $mysqli_connection->error);
        }

        $select_stmt->bind_param("s", $dni);

        if (!$select_stmt->execute()) {
            throw new Exception("No se puede ejecutar la sentencia: " . $select_stmt->error);
        }

        $select_stmt->store_result();

        // OPCION 1) No existe el CUIT -> SE PUEDE INGRESAR
        if ($select_stmt->num_rows === 0) {
            $select_stmt->close();
            return 'CUIT_NO_EXISTE';
        }

        //Existe el CUIT -> VER SI ES DE OTRO EMPLEADO O DEL MISMO

        $select_stmt->bind_result($idEncontrado);
        $select_stmt->fetch();
        $select_stmt->close();

        // OPCION 2) ES DEL MISMO EMPLEADO
        if ((int)$idEncontrado === $id_empleado) {
            return 'CUIT_MISMO_EMPLEADO';
        }

        // OPCION 3) Existe pero es de otro empleado
        return 'CUIT_OTRO_EMPLEADO';
    } catch (Exception $e) {
        error_log("Error en la función check_cuit_update: " . $e->getMessage());
        throw $e;
    }
}

function actualizar_empleado($mysqli_connection, $data)
{

    try {
        /* ---------- UPDATE empleados ---------- */
        $stmt = $mysqli_connection->prepare(
            "UPDATE empleados
                    SET nombre = ?, apellido = ?, dni = ?, cuit = ?, fecha_nacimiento = ?, telefono = ?, direccion = ?, email = ?, telefono_contacto = ?
                    WHERE id_empleado = ?"
        );

        if (!$stmt) {
            throw new Exception($mysqli_connection->error);
        }

        $stmt->bind_param(
            "sssssssss",
            $data['nombre'],
            $data['apellido'],
            $data['dni'],
            $data['cuit'],
            $data['fecha_nacimiento'],
            $data['telefono'],
            $data['direccion'],
            $data['email'],
            $data['contacto'],
        );

        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {

        error_log("Error al ejecutar la función actualizar_empleado: " . $e->getMessage());
        throw $e; //
    }
}
# BORRAR EMPLEADO
function borrar_empleado(int $id_empleado, mysqli $db): bool
{
    try {
        $db->begin_transaction();

        $stmt = $db->prepare(
            "DELETE FROM empleados WHERE id_empleado = ?"
        );
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta borrar_empleado: " . $db->error);
        }

        $stmt->bind_param("i", $id_empleado);

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta borrar_empleado: " . $stmt->error);
        }

        $stmt->close();

        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollback();
        error_log("Error borrar_empleado: " . $e->getMessage());
        return false;
    }
}


/************************ PERFIL **************************/

# Consultar los datos del usuario de la $_SESSION['user'] para cargarlos en el formulario de actualización de perfil.
function consultarDatos()
{

    $mysqli = connectToDatabase();
    $id_user = $_SESSION['user_data']['id_user'];

    $sql = "
        SELECT nombre, apellido, email, telefono
        FROM usuarios_data
        WHERE id_usuario = ?
    ";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta consultarDatos(): " . $mysqli->error);
    }

    $stmt->bind_param("i", $id_user);
    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar la consulta consultarDatos(): " . $stmt->error);
    }
    
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $user;
}

# CHECK DE EMAIL SOLO EN MODIFICACION DE USUARIO -> Función para chequear que si el usuario intenta cambiar de email, no exista ya en la base de datos, o si coincide con el suyo, no hacer nada
function check_email_modificar(string $email, int $id_usuario, mysqli $mysqli_connection): string
{

    try {
        $sql = "
            SELECT id_usuario
            FROM usuarios_data
            WHERE email = ?
            LIMIT 1
        ";

        $stmt = null;
        $stmt = $mysqli_connection->prepare($sql);
        if (!$stmt) {
            throw new Exception(
                "Error prepare check_email_modificar(): " . $mysqli_connection->error
            );
        }

        $stmt->bind_param("s", $email);

        if (!$stmt->execute()) {
            throw new Exception(
                "Error execute check_email_modificar(): " . $stmt->error
            );
        }

        $stmt->store_result();

        // OPCION 1) No existe el email -> SE PUEDE INGRESAR
        if ($stmt->num_rows === 0) {
            $stmt->close();
            return 'EMAIL_NO_EXISTE';
        }

        //Existe el email -> VER SI ES DE OTRO USUARIO O DEL MISMO

        $stmt->bind_result($idEncontrado);
        $stmt->fetch();
        $stmt->close();

        // OPCION 2) ES DEL MISMO USUARIO
        if ((int)$idEncontrado === $id_usuario) {
            return 'EMAIL_MISMO_USUARIO';
        }

        // OPCION 3) Existe pero es de otro usuario
        return 'EMAIL_OTRO_USUARIO';
    } catch (Exception $e) {
        error_log("Error al ejecutar la función check_email_modificar: " . $e->getMessage());
        throw $e; // propagamos la excepción
    }
}


/***** LOGIN *****/
// Función para buscar USUARIO por su nombre de usuario en la BD
function get_user_by_username($usuario, $mysqli_connection)
{
    # Inicializar la senencia de selección como nula
    $select_stmt = null;

    try {
        # Preparar la sentencia SQL necesaria para buscar al usuario a través su correo electrónico
        $query = "SELECT * FROM usuarios_login WHERE usuario = ? LIMIT 1";
        $select_stmt = $mysqli_connection->prepare($query);
       
        if (!$select_stmt) {
            throw new Exception("Error al preparar la consulta consultarDatos(): " . $mysqli_connection->error);
        }

        # Vincular el correo electrónico a la sentencia
        $select_stmt->bind_param('s', $usuario);

        # Intentar ejecutar la sentencia de selección
        if (!$select_stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta consultarDatos(): " . $select_stmt->error);
        }

        # Obtener el resultado de la consulta
        $result = $select_stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc(); # fetch_assoc() nos permite obtener los datos del resultado como un array asociativo (clave: valor)

            return $user;
        } else {
            // Si no se encuentra el usuario o no existe
            return false;
        }
    } catch (Exception $e) {
        error_log("Error al ejecutar la función get_user_by_username(): " . $e->getMessage());
        return false;
    } finally {
        // Nos aseguramos de cerrar la sentencia si existe
        if ($select_stmt !== null) {
            $select_stmt->close();
        }
    }
}
