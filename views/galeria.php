<?php
require_once __DIR__ . '/../config/config.php';

# Comprobar si existe una sesión activa y en caso de que no así la crearemos
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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
                    <li><a class="enlace active" href="#">Galería</a></li>
                    <li><a class="enlace" href="./contacto.php">Contacto</a></li>
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
            <h2>Galería</h2>

            <section class="galeria-container">
                <div class="galeria">
                    <img src="../assets/images/1.jpeg" alt="Grupo Crear SRL">
                    <img src="../assets/images/2.jpeg" alt="Grupo Crear SRL">
                    <img src="../assets/images/3.jpeg" alt="Grupo Crear SRL">
                    <img src="../assets/images/4.jpeg" alt="Grupo Crear SRL">
                    <img src="../assets/images/5.jpeg" alt="Grupo Crear SRL">
                    <img src="../assets/images/6.jpeg" alt="Grupo Crear SRL">
                    <img src="../assets/images/7.jpeg" alt="Grupo Crear SRL">
                    <img src="../assets/images/8.jpeg" alt="Grupo Crear SRL">
                    <img src="../assets/images/9.jpeg" alt="Grupo Crear SRL">
                    <img src="../assets/images/10.jpeg" alt="Grupo Crear SRL">
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

    <!-- SCRIPTS BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
</body>

</html>