<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/flash.php';

# Comprobar si existe una sesión activa y en caso de que no así la crearemos
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$old = getFlash('old') ?? [];

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupo CREAR SRL</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/estilos.css">
    <!-- FAVICON -->
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/favicon/site.webmanifest">
</head>

<body>
    <div class="mi_contenedor">
        <!-- HEADER -->
        <header class="mi_encabezado">
            <div class="cabecera_logo">
                <div class="contenedor_logo">
                    <img src="../assets/images/logo.png" alt="logo Grupo Crear SRL">

                    <div class="contenedor_empresa">
                        <h1>Grupo CREAR SRL</h1>
                        <p class="texto_logo">Instalaciones - Construcciones</p>
                    </div>
                </div>
            </div>

            <nav class="navigationBar">

                <?php if (isset($_SESSION["user_data"])): ?>
                    <input type="checkbox" id="check_menu" class="check_menu">
                <?php endif; ?>

                <ul class="navigationBarList">
                    <li><a class="enlace" href="../index.php">Inicio</a></li>
                    <li><a class="enlace" href="./galeria.php">Galería</a></li>
                    <li><a class="enlace active" href="#">Contacto</a></li>
                    <li><a class="enlace" href="./preguntas_frecuentes.php">Preguntas</a></li>

                    <?php if (isset($_SESSION["user_data"])): ?>
                        <li>
                            <label for="check_menu" class="label_check">
                                <img src="../assets/iconos/menu.svg" alt="Menú">
                            </label>
                        </li>
                    <?php endif; ?>
                </ul>

                <?php if (isset($_SESSION["user_data"])): ?>

                    <ul class="navigationBarListUser">
                        <li><a class="enlace" href="./user/solicitudes.php">Solicitudes</a></li>
                        <li><a class="enlace" href="./user/usuarios.php">Usuarios</a></li>
                        <li><a class="enlace" href="./user/empleados.php">Empleados</a></li>
                        <li><a class="enlace" href="./user/perfil.php">Perfil</a></li>
                        <li><a class="enlace" href="../controllers/logout.php">Cerrar sesión</a></li>
                    </ul>
                <?php endif; ?>
            </nav>
        </header>
        <!-- CUERPO PRINCIPAL-->
        <main class="mi_principal">

            <h2>Contacto</h2>
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
            <section>
                <div class="contenedor_presentacion_contacto">

                    <div class="container_datos_contacto">
                        <h3>Datos de contacto</h3>

                        <div class="datos_contacto">
                            <div class="flex_row">
                                <img src="../assets/iconos/clock.svg" alt="horario atención Grupo CREAR SRL">
                                <span>Horario de atención:</span>
                                <p>Lunes a Viernes de 8hs a 18hs</p>
                            </div>
                            <div class="flex_row">
                                <img src="../assets/iconos/whatsapp-green.svg" alt="telefono Grupo CREAR SRL">
                                <span>Teléfonos:</span>
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
                            <div class="flex_row">
                                <img src="../assets/iconos/email.svg" alt="correo Grupo CREAR SRL">
                                <span>Email:</span>
                                <a href="mailto:grupocrear@live.com">grupocrear@live.com</a>
                            </div>
                            <div class="flex_row">
                                <img src="../assets/iconos/location.svg" alt="ubicacion Grupo CREAR SRL">
                                <span>Ubicación:</span>
                                <p>San Miguel - Bs. As.</p>
                            </div>

                        </div>
                    </div>
                    <div class="container_form">
                        <form id="contacto_form" action="../controllers/c_contacto.php" method="post">
                            <h3>Formulario de contacto</h3>

                            <div class="form_options">
                                <label for="input_name">Nombre: *</label>
                                <div class="input_zone">
                                    <input type="text" id="input_name" name="input_name" value="<?= htmlspecialchars($old['input_name'] ?? '') ?>" placeholder="Escriba su nombre" title="El nombre deberá contener entre 2 y 20 letras y se podrá hacer uso de hasta 2 espacios no consecutivos" required>
                                    <small class="input_error"></small>
                                </div>
                            </div>
                            <div class="form_options">
                                <label for="input_lastname">Apellido: *</label>
                                <div class="input_zone">
                                    <input type="text" id="input_lastname" name="input_lastname" value="<?= htmlspecialchars($old['input_lastname'] ?? '') ?>" placeholder="Escriba su apellido" title="El/los apellidos deberán contener entre 2 y 20 letras y se podrá hacer uso de un único espacio" required>
                                    <small class="input_error"></small>
                                </div>
                            </div>
                            <div class="form_options">
                                <label for="input_tel">Teléfono: *</label>
                                <div class="input_zone">
                                    <input type="text" id="input_tel" name="input_tel" value="<?= htmlspecialchars($old['input_tel'] ?? '') ?>" placeholder="Escriba su número de teléfono" title="El telefono deberá contener entre 8 y 11 dígitos" required>
                                    <small class="input_error"></small>
                                </div>
                            </div>
                            <div class="form_options">
                                <label for="input_email">Email: *</label>
                                <div class="input_zone">
                                    <input type="text" id="input_email" name="input_email" value="<?= htmlspecialchars($old['input_email'] ?? '') ?>" placeholder="Escriba su correo electrónico" title="El correo electrónico similar a: xxxxx@xxx.xxx" required>
                                    <small class="input_error"></small>
                                </div>
                            </div>
                            <div class="form_options">
                                <label for="input_adress">Dirección:</label>
                                <div class="input_zone">
                                    <input type="text" id="input_adress" name="input_adress" value="<?= htmlspecialchars($old['input_adress'] ?? '') ?>" placeholder="Escriba su dirección" title="La dirección deberá contener entre 3 y 45 letras">
                                    <small class="input_error"></small>
                                </div>
                            </div>
                            <div class="form_options">
                                <label for="input_text">Mensaje: *</label>
                                <div class="input_zone">
                                    <textarea id="input_text" name="input_text" value="<?= htmlspecialchars($old['input_text'] ?? '') ?>" placeholder="Escriba un comentario" title="Puede escribir entre 10 y 250 caracteres. Sólo se aceptan los siguientes símbolos especiales: . , _ - º " required></textarea>
                                    <small class="input_error"></small>
                                </div>
                            </div>

                            <div class="form_buttons">
                                <input type="reset" class="btn_reset" value="Borrar">
                                <input type="submit" class="btn_enviar" name="contactarse" value="Enviar">
                            </div>

                        </form>
                    </div>
                </div>
            </section>

        </main>
        <!-- PIE DE PÁGINA-->
        <footer class="mi_pie">

            <div class="contenedor_footer">

                <!-- TELEFONOS Y CORREO -->
                <div class="contacto_pie">
                    <div class="contacto_flex_row">
                        <img class="iconos" src="../assets/iconos/whatsapp-green.svg  " alt="telefono Grupo CREAR SRL" width="30" height="30">
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
                    <img src="../assets/images/logo.png" alt="logo Grupo CREAR SRL">
                    <div>
                        <p>Grupo CREAR SRL</p>
                        <span>Instalaciones - Construcciones</span>
                    </div>
                </div>

                <!-- AVISO LEGAL COPYRIGHT -->
                <div class="contacto_pie_email">
                    <div class="contacto_flex_row">
                        <img class="iconos" src="../assets/iconos/email.svg" alt="correo Grupo CREAR SRL" width="94" height="32">
                        <a href="mailto:grupocrear@live.com">grupocrear@live.com</a>
                    </div>
                    <small class="aviso_legal">&copy; Todos los derechos reservados</small>
                </div>
            </div>

        </footer>


    </div>

    <script src="../assets/scripts/v_contacto.js"></script>

</body>

</html>