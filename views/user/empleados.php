<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../controllers/db_functions.php';
require_once __DIR__ . '/../../controllers/flash.php';

# Comprobar si existe una sesión activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Comprobamos si ya hay usuario logueado y lo redirigimos al index
if (!isset($_SESSION['user_data'])) {
    header(header: 'Location: ../../index.php');
    exit;
}

$old = getFlash('old') ?? [];

try {
    $empleados = obtener_todos_los_empleados($mysqli_connection);
} catch (Exception $e) {
    error_log("Error cargando los datos de los empleados: " . $e->getMessage());
    $empleados = [];
}

$datos = $_SESSION['datos'] ?? [];

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupo CREAR SRL</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/estilos.css">
    <!-- FAVICON -->
    <link rel="apple-touch-icon" sizes="180x180" href="../../assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../../assets/favicon/site.webmanifest">
</head>

<body>
    <div class="mi_contenedor">
        <!-- HEADER -->
        <header class="mi_encabezado">
            <div class="cabecera_logo">
                <div class="contenedor_logo">
                    <img src="../../assets/images/logo.png" alt="logo Grupo Crear SRL">

                    <div class="contenedor_empresa">
                        <h1>Grupo CREAR SRL</h1>
                        <p class="texto_logo">Instalaciones - Construcciones</p>
                    </div>
                </div>
            </div>

            <nav class="navigationBar">
                <input type="checkbox" id="check_menu" class="check_menu">

                <ul class="navigationBarList">
                    <li><a class="enlace" href="../../index.php">Inicio</a></li>
                    <li><a class="enlace" href="../galeria.php">Galería</a></li>
                    <li><a class="enlace" href="../contacto.php">Contacto</a></li>
                    <li><a class="enlace" href="../preguntas_frecuentes.php">Preguntas</a></li>
                    <li>
                        <label for="check_menu" class="label_check">
                            <img src="../../assets/iconos/menu.svg" alt="Menú">
                        </label>
                    </li>
                </ul>

                <ul class="navigationBarListUser">
                    <li><a class="enlace" href="./solicitudes.php">Solicitudes</a></li>
                    <li><a class="enlace" href="./usuarios.php">Usuarios</a></li>
                    <li><a class="enlace active" href="#">Empleados</a></li>
                    <li><a class="enlace" href="./perfil.php">Perfil</a></li>
                    <li><a class="enlace" href="../../controllers/logout.php">Cerrar sesión</a></li>
                </ul>

            </nav>
        </header>
        <!-- MAIN -->
        <main class="mi_principal">

            <h2>Administración de empleados</h2>

            <div class="aviso_registro">
                <?php
                # Comprobar si hay mensajes de error
                if (isset($_SESSION["mensaje_error"])) {
                    echo "<span class='error_message'>" . $_SESSION['mensaje_error'] . "</span>";

                    # Eliminar el mensaje de error
                    unset($_SESSION["mensaje_error"]);
                }

                # Comprobar si hay mensajes de exito
                if (isset($_SESSION["mensaje_exito"])) {
                    echo "<span class='success_message'>" . $_SESSION['mensaje_exito'] . "</span>";

                    # Eliminar el mensaje de error
                    unset($_SESSION["mensaje_exito"]);
                }
                ?>
            </div>

            <section class="section_center">
                <?php if (($_SESSION['user_data']['id_user']) == "1") { ?>
                    <form class="container_form" id="empleados_register_form" action="../../controllers/user/c_empleados.php" method="post">

                        <h3>Registrar nuevo empleado</h3>

                        <div class="form_options">
                            <label for="user_name">Nombre: *</label>
                            <div class="input_zone">
                                <input type="text" id="user_name" name="user_name" value="<?= htmlspecialchars($old['user_name'] ?? '') ?>" placeholder="Escriba el nombre" title="El nombre deberá contener entre 2 y 20 letras y se podrá hacer uso de dos espacios en caso de introducir un nombre compuesto">
                                <small class="input_error"></small>
                            </div>
                        </div>
                        <div class="form_options">
                            <label for="user_lastname">Apellido: *</label>
                            <div class="input_zone">
                                <input type="text" id="user_lastname" name="user_lastname" placeholder="Escriba el apellido" value="<?= htmlspecialchars($old['user_lastname'] ?? '') ?>" title="El/los apellidos deberán contener entre 2 y 20 letras y se podrá hacer uso de un único espacio en caso de introducir un nombre compuesto">
                                <small class="input_error"></small>
                            </div>
                        </div>
                        <div class="form_options">
                            <label for="user_dni">DNI: *</label>
                            <div class="input_zone">
                                <input type="text" id="user_dni" name="user_dni" value="<?= htmlspecialchars($old['user_dni'] ?? '') ?>" placeholder="Escriba el DNI" title="El DNI debe contener 8 dígitos">
                                <small class="input_error"></small>
                            </div>
                        </div>
                        <div class="form_options">
                            <label for="user_cuit">CUIT: *</label>
                            <div class="input_zone">
                                <input type="text" id="user_cuit" name="user_cuit" value="<?= htmlspecialchars($old['user_cuit'] ?? '') ?>" placeholder="Escriba el CUIT" title="El CUIT debe contener 11 dígitos (sin guíones ni espacios)">
                                <small class="input_error"></small>
                            </div>
                        </div>
                        <div class="form_options">
                            <label for="user_date">Fecha de nacimiento: *</label>
                            <div class="input_zone">
                                <input type="date" id="user_date" name="user_date" value="<?= htmlspecialchars($old['user_date'] ?? '') ?>" title="Seleccione fecha de nacimiento (debe ser mayor de edad)">
                                <small class="input_error"></small>
                            </div>
                        </div>
                        <div class="form_options">
                            <label for="user_tel">Teléfono: *</label>
                            <div class="input_zone">
                                <input type="text" id="user_tel" name="user_tel" value="<?= htmlspecialchars($old['user_tel'] ?? '') ?>" placeholder="Escriba el número de teléfono" title="El telefono deberá contener entre 8 y 11 dígitos">
                                <small class="input_error"></small>
                            </div>
                        </div>
                        <div class="form_options">
                            <label for="user_adress">Dirección:</label>
                            <div class="input_zone">
                                <input type="text" id="user_adress" name="user_adress" value="<?= htmlspecialchars($old['user_adress'] ?? '') ?>" placeholder="Escriba la dirección" title="El campo dirección puede quedar vacío o deberá contener entre 8 y 50 caracteres válidos">
                                <small class="input_error"></small>
                            </div>
                        </div>
                        <div class="form_options">
                            <label for="user_email">Email:</label>
                            <div class="input_zone">
                                <input type="text" id="user_email" name="user_email" value="<?= htmlspecialchars($old['user_email'] ?? '') ?>" placeholder="Escriba un correo electrónico" title="El campo email puede quedar vacío o el contenido debe ser similar a: xxxxx@xxx.xxx">
                                <small class="input_error"></small>
                            </div>
                        </div>
                        <div class="form_options">
                            <label for="user_contact">Contacto de emergencia:</label>
                            <div class="input_zone">
                                <textarea name="user_contact" id="user_contact" rows="3" maxlength="250" title="El campo Contacto de emergencia puede quedar vacío o debe escribir entre 10 y 250 caracteres. Sólo se aceptan los siguientes símbolos especiales: . , _ - º " placeholder="Escriba un contacto de emergencia"><?= htmlspecialchars($old['user_contact'] ?? '') ?></textarea>
                                <small class="input_error"></small>
                            </div>
                        </div>

                        <div class="form_buttons">
                            <input type="reset" class="btn_reset" name="reset_form" value="Borrar">
                            <input type="submit" class="btn_enviar" name="registro_empleado" value="Enviar">
                        </div>

                    </form>
                <?php }; ?>
            </section>

            <section class="section_border_top">
                <h3>Empleados registrados</h3>
                <?php if ($empleados) { ?>
                    <div class="empleados_container">

                        <table class="empleados_table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>DNI</th>
                                    <th>CUIT</th>
                                    <th>Fecha Nac.</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Email</th>
                                    <th>Contacto emergencia</th>


                                    <?php if (($_SESSION['user_data']['id_user'] ?? 0) === 1) : ?>
                                        <th>Acciones</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                        <?php } else {
                        echo "<p>No hay empleados registrados</p>";
                    } ?>
                        <tbody>
                            <?php foreach ($empleados as $e): ?>

                                <!-- FILA PRINCIPAL -->
                                <tr>
                                    <td><?= (int)$e['id_empleado'] ?></td>
                                    <td><?= htmlspecialchars($e['nombre']) ?></td>
                                    <td><?= htmlspecialchars($e['apellido']) ?></td>
                                    <td><?= htmlspecialchars($e['dni']) ?></td>
                                    <td><?= htmlspecialchars($e['cuit']) ?></td>
                                    <td><?= date('d-m-Y', strtotime($e['fecha_nacimiento'])) ?></td>
                                    <td><?= htmlspecialchars($e['telefono']) ?></td>
                                    <td><?= htmlspecialchars($e['direccion']) ?></td>
                                    <td><?= htmlspecialchars($e['email']) ?></td>
                                    <td><?= htmlspecialchars($e['contacto_emergencia']) ?></td>

                                    <?php if (($_SESSION['user_data']['id_user'] ?? 0) === 1): ?>
                                        <td class="acciones_td">
                                            <button type="button" class="btn_modificar">Modificar</button>

                                            <form method="post" action="../../controllers/user/c_empleados.php">
                                                <input type="hidden" name="id_empleado" value="<?= (int)$e['id_empleado'] ?>">
                                                <button class="btn_borrar" name="borrar_empleado" type="submit">Borrar</button>
                                            </form>
                                        </td>
                                    <?php endif; ?>
                                </tr>

                                <!-- FILA EDICIÓN (JUSTO DEBAJO) -->
                                <?php if (($_SESSION['user_data']['id_user'] ?? 0) === 1): ?>
                                    <tr class="fila_edit hidden">
                                        <td colspan="12">
                                            <form class="empleado_edit_form" method="post" action="../../controllers/user/c_empleados.php">
                                                <input type="hidden" name="id_empleado" value="<?= (int)$e['id_empleado'] ?>">

                                                <div class="emp_edit_layout">

                                                    <!-- IZQUIERDA: rows -->
                                                    <div class="emp_edit_fields">
                                                        <div class="edit_grid_row1">
                                                            <div> 
                                                                <label>Nombre</label> 
                                                                <input type="text" name="user_name" value="<?= htmlspecialchars($e['nombre']) ?>"> 
                                                            </div>
                                                            <div> 
                                                                <label>Apellido</label> 
                                                                <input type="text" name="user_lastname" value="<?= htmlspecialchars($e['apellido']) ?>"> 
                                                            </div>
                                                            <div> 
                                                                <label>DNI</label> 
                                                                <input type="text" name="user_dni" value="<?= htmlspecialchars($e['dni']) ?>"> 
                                                            </div>
                                                            <div> 
                                                                <label>CUIT</label> 
                                                                <input type="text" name="user_cuit" value="<?= htmlspecialchars($e['cuit']) ?>"> 
                                                            </div>
                                                            <div> 
                                                                <label>Fecha Nac.</label> 
                                                                <input type="date"
                                                                    name="user_date"
                                                                    value="<?= date('Y-m-d', strtotime($e['fecha_nacimiento'])) ?>"> 
                                                            </div>
                                                            <div> 
                                                                <label>Teléfono</label> 
                                                                <input type="text" name="user_tel" value="<?= htmlspecialchars($e['telefono']) ?>"> 
                                                            </div>
                                                        </div>

                                                        <div class="edit_grid_row2">
                                                            <div> <label>Dirección</label> <input type="text" name="user_adress" value="<?= htmlspecialchars($e['direccion']) ?>"> </div>
                                                            <div> <label>Email</label> <input type="email" name="user_email" value="<?= htmlspecialchars($e['email']) ?>"> </div>
                                                            <div> <label>Contacto emergencia</label> <input type="text" name="user_contact" value="<?= htmlspecialchars($e['contacto_emergencia']) ?>"> </div>
                                                        </div>
                                                    </div>

                                                    <!-- DERECHA: actions -->
                                                    <div class="emp_edit_actions">
                                                        <button type="submit" name="modificar_empleado" class="btn_guardar">Guardar</button>
                                                        <button type="button" class="btn_cancel">Cancelar</button>
                                                    </div>

                                                </div>

                                            </form>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </tbody>


                        </table>
                    </div>
            </section>

        </main>
        <!-- PIE DE PÁGINA-->
        <footer class="mi_pie">

            <div class="contenedor_footer">

                <!-- TELEFONOS Y CORREO -->
                <div class="contacto_pie">
                    <div class="contacto_flex_row">
                        <img class="iconos" src="../../assets/iconos/whatsapp-green.svg  " alt="telefono Grupo CREAR SRL" width="30" height="30">
                        <ul>
                            <li>
                                <a href="https://wa.me/5491168719855" target="_blank">1168719855</a>
                            </li>
                            <li>
                                <a href="https://wa.me/5491149933740" target="_blank">1149933740</a>
                            </li>
                            <li>
                                <a href="https://wa.me/5491156662924" target="_blank">1156662924</a>
                            </li>
                            <li>
                                <a href="https://wa.me/5491122631311" target="_blank">1122631311</a>
                            </li>
                        </ul>

                    </div>

                </div>

                <!-- LOGO GRUPO CREAR SRL -->
                <div class="logo_pie">
                    <img src="../../assets/images/logo.png" alt="logo Grupo CREAR SRL">
                    <div>
                        <p>Grupo CREAR SRL</p>
                        <span>Instalaciones - Construcciones</span>
                    </div>
                </div>

                <!-- AVISO LEGAL COPYRIGHT -->
                <div class="contacto_pie_email">
                    <div class="contacto_flex_row">
                        <img class="iconos" src="../../assets/iconos/email.svg" alt="correo Grupo CREAR SRL" width="94" height="32">
                        <a href="mailto:grupocrear@live.com">grupocrear@live.com</a>
                    </div>
                    <small class="aviso_legal">&copy; Todos los derechos reservados</small>
                </div>
            </div>

        </footer>
    </div>

    <script src="../../assets/scripts/v_empleados.js"></script>

</body>

</html>