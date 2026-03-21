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
    $usuarios = obtener_todos_los_usuarios($mysqli_connection);
} catch (Exception $e) {
    error_log("Error cargando los datos de los usuarios: " . $e->getMessage());
    $usuarios = [];
}

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
                    <li><a class="enlace active" href="#">Usuarios</a></li>
                    <li><a class="enlace" href="./empleados.php">Empleados</a></li>
                    <li><a class="enlace" href="./perfil.php">Perfil</a></li>
                    <li><a class="enlace" href="../../controllers/logout.php">Cerrar sesión</a></li>
                </ul>

            </nav>
        </header>
        <!-- MAIN -->
        <main class="mi_principal">

            <h2>Administración de usuarios</h2>

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
                    <form class="container_form" id="admin_register_form" action="../../controllers/user/c_usuarios.php" method="post">

                        <h3>Registrar nuevo usuario</h3>

                        <div class="form_options">
                            <label for="user_name">Nombre: *</label>
                            <div class="input_zone">
                                <input type="text" id="user_name" name="user_name" value="<?= htmlspecialchars($old['user_name'] ?? '') ?>" placeholder="Escriba el nombre" title="El nombre deberá contener entre 2 y 20 letras y se podrá hacer uso de dos espacio (no contínuos) en caso de introducir un nombre compuesto">
                                <small class="input_error"></small>
                            </div>
                        </div>

                        <div class="form_options">
                            <label for="user_lastname">Apellido: *</label>
                            <div class="input_zone">
                                <input type="text" id="user_lastname" name="user_lastname" value="<?= htmlspecialchars($old['user_lastname'] ?? '') ?>" placeholder="Escriba el apellido" title="El/los apellidos deberán contener entre 2 y 20 letras y se podrá hacer uso de hasta 2 espacios no consecutivos en caso de introducir un nombre compuesto">
                                <small class="input_error"></small>
                            </div>
                        </div>

                        <div class="form_options">
                            <label for="user_email">Email: *</label>
                            <div class="input_zone">
                                <input type="text" id="user_email" name="user_email" placeholder="Escriba un correo electrónico" value="<?= htmlspecialchars($old['user_email'] ?? '') ?>" title="El formato del correo electrónico no es válido">
                                <small class="input_error"></small>
                            </div>
                        </div>

                        <div class="form_options">
                            <label for="user_tel">Teléfono: *</label>
                            <div class="input_zone">
                                <input type="text" id="user_tel" name="user_tel" value="<?= htmlspecialchars($old['user_tel'] ?? '') ?>" placeholder="Escriba el número de teléfono" title="El teléfono debe contener entre 8 y 11 dígitos">
                                <small class="input_error"></small>
                            </div>
                        </div>

                        <div class="form_options">
                            <label for="user_login_name">Usuario: *</label>
                            <div class="input_zone">
                                <input type="text" id="user_login_name" name="user_login_name" value="<?= htmlspecialchars($old['user_login_name'] ?? '') ?>" placeholder="Escriba un nombre de usuario" title="El nombre de usuario deberá contener entre 6 y 10 caracteres alfanuméricos">
                                <small class="input_error"></small>
                            </div>
                        </div>

                        <div class="form_options">
                            <label for="user_password">Contraseña: *</label>
                            <div class="input_zone">
                                <input type="password" id="user_password" name="user_password" value="<?= htmlspecialchars($old['user_password'] ?? '') ?>" placeholder="Escriba una contraseña" title="La contraseña deberá contener entre 6 y 10 caracteres e incluir de forma obligatoria una letra mayúscula, un número y un símbolo entre los siguientes (.,_-)">
                                <small class="input_error"></small>
                            </div>
                        </div>

                        <div class="password_show">
                            <label for="check_password">
                                <input type="checkbox" id="check_password">
                                Mostrar contraseña
                            </label>
                        </div>

                        <div class="form_buttons">
                            <input type="reset" class="btn_reset" value="Borrar">
                            <input type="submit" class="btn_enviar" name="registro_usuario" value="Enviar">
                        </div>

                    </form>

                <?php }; ?>
            </section>

            <section class="section_border_top">
                <h3>Usuarios registrados</h3>
                <?php if ($usuarios) { ?>
                    <div class="usuarios_container">

                        <table class="usuarios_table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>

                                    <?php if (($_SESSION['user_data']['id_user'] ?? 0) === 1) : ?>
                                        <th>Acciones</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                <?php } else {
                    echo "<p>No hay usuarios registrados</p>";
                } ?>
                        <tbody>
                            <?php foreach ($usuarios as $u): ?>

                                <tr>
                                    <td><?= (int)$u['id_usuario'] ?></td>
                                    <td><?= htmlspecialchars($u['nombre']) ?></td>
                                    <td><?= htmlspecialchars($u['apellido']) ?></td>
                                    <td><?= htmlspecialchars($u['email']) ?></td>
                                    <td><?= htmlspecialchars($u['telefono']) ?></td>

                                    <?php if (($_SESSION['user_data']['id_user']) == "1") : ?>
                                        <td class="acciones_td">

                                            <button type="button" class="btn_modificar">Modificar</button>

                                            <form method="post" id="form_borrar_usuario" action="../../controllers/user/c_usuarios.php">
                                                <input type="hidden" name="id_usuario" value="<?= (int)$u['id_usuario'] ?>">
                                                <button class="btn_borrar" name="borrar_usuario" type="submit">Borrar</button>
                                            </form>

                                        </td>
                                    <?php endif; ?>
                                </tr>

                                <?php if (($_SESSION['user_data']['id_user']) == "1") { ?>
                                    <tr class="fila_edit hidden">
                                        <td colspan="6">

                                            <form class="usuario_edit_form" method="post" action="../../controllers/user/c_usuarios.php">
                                                <input type="hidden" name="id_usuario" value="<?= (int)$u['id_usuario'] ?>">

                                                <div class="edit_grid">
                                                    <div>
                                                        <label>Nombre *</label>
                                                        <input type="text" name="nombre" value="<?= htmlspecialchars($u['nombre']) ?>" placeholder="Escriba el nombre" title="El nombre deberá contener entre 2 y 20 letras y se podrá hacer uso de dos espacio (no contínuos) en caso de introducir un nombre compuesto" required>
                                                    </div>

                                                    <div>
                                                        <label>Apellido *</label>
                                                        <input type="text" name="apellido" value="<?= htmlspecialchars($u['apellido']) ?>" placeholder="Escriba el apellido" title="El/los apellidos deberán contener entre 2 y 20 letras y se podrá hacer uso de un único espacio en caso de introducir un nombre compuesto" required>
                                                    </div>

                                                    <div>
                                                        <label>Email *</label>
                                                        <input type="email" name="email" value="<?= htmlspecialchars($u['email']) ?>" placeholder="Escriba el email" title="El formato del correo electrónico no es válido" required>
                                                    </div>

                                                    <div>
                                                        <label>Teléfono *</label>
                                                        <input type="text" name="telefono" value="<?= htmlspecialchars($u['telefono']) ?>" placeholder="Escriba el teléfono" title="El teléfono debe contener entre 8 y 11 dígitos" required>
                                                    </div>
                                                    <div class="edit_actions_usuarios">
                                                        <button type="submit" class="btn_guardar" name="modificar_usuario">Guardar</button>
                                                        <button type="button" class="btn_cancel">Cancelar</button>
                                                    </div>
                                                </div>

                                            </form>

                                        </td>
                                    </tr>

                                <?php }; ?>

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
    <script src="../../assets/scripts/v_usuarios.js"></script>
    <script src="../../assets/scripts/show_password.js"></script>
</body>

</html>