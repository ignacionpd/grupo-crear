<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../controllers/db_functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Verificamos si no hay usuario logueado
if (!isset($_SESSION['user_data'])) {
    header('Location: ../../index.php');
    exit;
}

//Consultamos los datos del usuario para poder ingresarlos en el formulario
$user = consultarDatos();

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
                    <li><a class="enlace" href="./empleados.php">Empleados</a></li>
                    <li><a class="enlace active" href="#">Perfil</a></li>
                    <li><a class="enlace" href="../../controllers/logout.php">Cerrar sesión</a></li>
                </ul>

            </nav>
        </header>
        <!-- CUERPO PRINCIPAL-->

        <main class="mi_principal">

            <h2>Perfil</h2>

            <div class="aviso_registro">
                <?php
                if (isset($_SESSION["mensaje_error"])) {
                    echo "<span class='error_message'>{$_SESSION['mensaje_error']}</span>";
                    unset($_SESSION["mensaje_error"]);
                }
                if (isset($_SESSION["mensaje_exito"])) {
                    echo "<span class='success_message'>{$_SESSION['mensaje_exito']}</span>";
                    unset($_SESSION["mensaje_exito"]);
                }
                ?>
            </div>
            <section class="contenedor_perfil">
                <form class="container_form" id="user_profile_form" action="../../controllers/user/c_perfil.php" method="post">

                    <h3>Actualizar datos del perfil</h3>

                    <div class="form_options">
                        <label for="user_name">Nombre: *</label>
                        <div class="input_zone">
                            <input type="text" id="user_name" name="user_name" value="<?= $user['nombre'] ?>" title="El nombre deberá contener entre 2 y 20 letras y se podrá hacer uso de hasta 2 espacios (no consecutivos) en caso de introducir un nombre compuesto" placeholder="Escriba su nombre">
                            <small class="input_error"></small>
                        </div>
                    </div>

                    <div class="form_options">
                        <label for="user_lastname">Apellido: *</label>
                        <div class="input_zone">
                            <input type="text" id="user_lastname" name="user_lastname" value="<?= $user['apellido'] ?>" title="El/Los apellidos deberán contener entre 2 y 20 letras y se podrá hacer uso de un único espacio en caso de introducir un nombre compuesto" placeholder="Escriba su apellido/s">
                            <small class="input_error"></small>
                        </div>
                    </div>

                    <div class="form_options">
                        <label for="user_email">Email: *</label>
                        <div class="input_zone">
                            <input type="text" id="user_email" name="user_email" value="<?= $user['email'] ?>" title="El correo electrónico similar a: xxxxx@xxx.xxx" placeholder="Escriba su email">
                            <small class="input_error"></small>
                        </div>
                    </div>
                    <div class="form_options">
                        <label for="user_tel">Teléfono: *</label>
                        <div class="input_zone">
                            <input type="text" id="user_tel" name="user_tel" value="<?= $user['telefono'] ?>" placeholder="Escriba el número de teléfono" title="Su teléfono debe contener 8 y 11 dígitos">
                            <small class="input_error"></small>
                        </div>
                    </div>

                    <div class="form_buttons">
                        <button type="submit" class="btn_enviar" name="actualizar_perfil">Actualizar perfil</button>
                    </div>
                </form>

                <form class="container_form" id="user_password_form" action="../../controllers/user/c_perfil.php" method="post">

                    <h3>Cambiar contraseña</h3>

                    <div class="form_options">
                        <label for="password">Nueva contraseña</label>
                        <div class="input_zone">
                            <input id="password" type="password" name="password" title="La contraseña deberá contener entre 4 y 10 caracteres e incluir de forma obligatoria una letra mayúscula, un número y un símbolo entre los siguientes (.,_-)">
                            <small class="input_error"></small>
                        </div>
                    </div>

                    <div class="form_options">
                        <label for="password2">Repetir contraseña</label>
                        <div class="input_zone">
                            <input id="password2" type="password" name="password2" title="La contraseña deberá contener entre 4 y 10 caracteres e incluir de forma obligatoria una letra mayúscula, un número y un símbolo entre los siguientes (.,_-)">
                            <small class="input_error"></small>
                        </div>
                    </div>

                    <div class="form_buttons">
                        <button class="btn_modificar" type="submit" name="cambiar_contrasena">Modificar</button>
                    </div>
                </form>
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

    <script src="../../assets/scripts/v_perfil.js"></script>

</body>

</html>