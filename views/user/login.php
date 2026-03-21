<?php
require_once __DIR__ . '/../../config/config.php';
# Comprobar si existe una sesión activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Comprobamos si ya hay usuario logueado y lo redirigimos al index
if (isset($_SESSION['user_data'])) {
    header(header: 'Location: ../../index.php');
    exit;
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
                <ul class="navigationBarList">
                    <li>
                        <a class="enlace" href="../../index.php">Inicio</a>
                    </li>
                </ul>
            </nav>
        </header>
        <!-- CUERPO PRINCIPAL-->
        <main class="mi_principal">

            <h2>Login</h2>

            <div class="aviso_registro">
                <?php
                # Comprobar si hay mensajes de error
                if (isset($_SESSION["mensaje_error"])) {
                    echo "<span class='error_message'>" . $_SESSION['mensaje_error'] . "</span>";

                    # Eliminar el mensaje de error
                    unset($_SESSION["mensaje_error"]);
                }
                ?>
            </div>
            <section class="section_center">
                <form class="container_form" id="login_form" action="../../controllers/c_login.php" method="POST">
                    <h3>Inicio de sesión</h3>
                    <div class="form_options">
                        <label for="user_login_name">Usuario:</label>
                        <div class="input_zone">
                            <input type="text" id="user_login_name" name="user_login_name" placeholder="Escriba su nombre de usuario" title="El nombre de usuario registrado para inicio de sesión (no email)">
                            <small class="input_error"></small>
                        </div>
                    </div>
                    <div class="form_options">
                        <label for="user_password">Contraseña: </label>
                        <div class="input_zone">
                            <input type="password" id="user_password" name="user_password" placeholder="Escriba su contraseña">
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
                        <input type="submit" class="btn_enviar" name="iniciar_sesion" value="Enviar">
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

    <!-- <script src="../../assets/scripts/v_login.js"></script> -->
    <script src="../../assets/scripts/show_password.js"></script>
</body>

</html>