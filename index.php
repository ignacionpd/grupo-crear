<?php
require_once __DIR__ . '/config/config.php';

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
    <link rel="stylesheet" href="./assets/css/estilos.css">
    <!-- FAVICON -->
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="./assets/favicon/site.webmanifest">
</head>

<body>
    <div class="mi_contenedor">
        <!-- HEADER -->
        <header class="mi_encabezado">
            <div class="cabecera_logo">
                <div class="contenedor_logo">
                    <img src="./assets/images/logo.png" alt="logo Grupo Crear SRL">

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
                    <li><a class="enlace active" href="#">Inicio</a></li>
                    <li><a class="enlace" href="./views/galeria.php">Galería</a></li>
                    <li><a class="enlace" href="./views/contacto.php">Contacto</a></li>
                    <li><a class="enlace" href="./views/preguntas_frecuentes.php">Preguntas</a></li>

                    <?php if (isset($_SESSION["user_data"])): ?>
                        <li>
                            <label for="check_menu" class="label_check">
                                <img src="./assets/iconos/menu.svg" alt="Menú">
                            </label>
                        </li>
                    <?php endif; ?>
                </ul>

                <?php if (isset($_SESSION["user_data"])): ?>

                    <ul class="navigationBarListUser">
                        <li><a class="enlace" href="./views/user/solicitudes.php">Solicitudes</a></li>
                        <li><a class="enlace" href="./views/user/usuarios.php">Usuarios</a></li>
                        <li><a class="enlace" href="./views/user/empleados.php">Empleados</a></li>
                        <li><a class="enlace" href="./views/user/perfil.php">Perfil</a></li>
                        <li><a class="enlace" href="./controllers/logout.php">Cerrar sesión</a></li>
                    </ul>
                <?php endif; ?>
            </nav>
        </header>
        <!-- CUERPO PRINCIPAL-->
        <main class="mi_principal">

            <section>
                <h2>¿Quiénes somos?</h2>
                <div class="contenedor_presentacion">
                    <div>
                        <img src="./assets/images/articulo_gas_natural_ban.png" alt="Grupo Crear SRL Naturgy">
                        <small>Artículo publicado por la empresa <b>Gas Natural Ban</b> (hoy "<b>Naturgy</b>") año 1997 en su revista oficial de ese momento en la entrevista al fundador de la empresa.</small>
                    </div>
                    <div>
                        <p><b>Grupo CREAR SRL</b> es una empresa familiar con más de 30 años de experiencia trabajando en instalaciones internas y redes externas de Gas Natural, de baja, media y alta presión.</p>
                        <p>Brindamos servicio tanto a clientes particulares, como comercios, colegios, industrias, barrios cerrados, administraciones, fincas, y municipios.</p>
                        <p>Contamos con personal altamente cualificado para atender las necesidades de nuestros clientes, siendo nuestros principales objetivos la <b>seguridad, tranquilidad y satisfacción</b> de ellos.</p>
                        <p>Somos un equipo con gasistas matriculados de 1º y 2º categoría, operarios con larga experiencia en el área, y personal de administración para atender las solicitudes y atención que nuestros clientes necesitan.</p>
                        <p>Ante cualquier consulta, duda o petición, no dude en contactarnos, que el equipo lo atenderá a la brevedad.</p>
                    </div>
                </div>
            </section>

            <!-- CAROUSEL -->
            <section>
                <div class="carousel-container">

                    <div class="carousel-fade">

                        <div class="carousel-slide active">
                            <img src="./assets/images/1.jpeg" alt="Grupo Crear SRL">
                        </div>

                        <div class="carousel-slide">
                            <img src="./assets/images/2.jpeg" alt="Grupo Crear SRL">
                        </div>

                        <div class="carousel-slide">
                            <img src="./assets/images/3.jpeg" alt="Grupo Crear SRL">
                        </div>

                        <div class="carousel-slide">
                            <img src="./assets/images/4.jpeg" alt="Grupo Crear SRL">
                        </div>

                        <div class="carousel-slide">
                            <img src="./assets/images/5.jpeg" alt="Grupo Crear SRL">
                        </div>

                        <div class="carousel-slide">
                            <img src="./assets/images/6.jpeg" alt="Grupo Crear SRL">
                        </div>

                        <div class="carousel-slide">
                            <img src="./assets/images/7.jpeg" alt="Grupo Crear SRL">
                        </div>

                        <div class="carousel-slide">
                            <img src="./assets/images/8.jpeg" alt="Grupo Crear SRL">
                        </div>

                        <div class="carousel-slide">
                            <img src="./assets/images/9.jpeg" alt="Grupo Crear SRL">
                        </div>

                        <div class="carousel-slide">
                            <img src="./assets/images/10.jpeg" alt="Grupo Crear SRL">
                        </div>

                        <!-- Flechas -->
                        <button class="carousel-btn prev">&#10094;</button>
                        <button class="carousel-btn next">&#10095;</button>

                    </div>

                </div>
            </section>

            <section class="enlaces-container">
                <h2>Algunos de nuestros clientes</h2>

                <div class="enlaces">
                    <img src="./assets/images/logos_clientes/muni_sanmi.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/muni_tigre.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/molinos.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/migusto.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/mostaza.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/nordelta.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/san_andres.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/standrews.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/marin.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/ungs.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/sofitel.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/austral.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/green_eat.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/arquenna.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/cabrera.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/caroline.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/de_franco.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/dibona.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/dock.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/federico_negro.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/pac.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/sallemi.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/victor_lopez.png" alt="Grupo Crear SRL">
                    <img src="./assets/images/logos_clientes/mastrangelo.png" alt="Grupo Crear SRL">
                </div>
            </section>
        </main>
        <!-- PIE DE PÁGINA-->
        <footer class="mi_pie">

            <div class="contenedor_footer">

                <!-- TELEFONOS Y CORREO -->
                <div class="contacto_pie">
                    <div class="contacto_flex_row">
                        <img class="iconos" src="./assets/iconos/whatsapp-green.svg  " alt="telefono Grupo CREAR SRL" width="30" height="30">
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
                    <img src="./assets/images/logo.png" alt="logo Grupo CREAR SRL">
                    <div>
                        <p>Grupo CREAR SRL</p>
                        <span>Instalaciones - Construcciones</span>
                    </div>
                </div>

                <!-- AVISO LEGAL COPYRIGHT -->
                <div class="contacto_pie_email">
                    <div class="contacto_flex_row">
                        <img class="iconos" src="./assets/iconos/email.svg" alt="correo Grupo CREAR SRL" width="94" height="32">
                        <a href="mailto:grupocrear@live.com">grupocrear@live.com</a>
                    </div>
                    <small class="aviso_legal">&copy; Todos los derechos reservados</small>
                </div>
            </div>
        </footer>
    </div>

    <script src="./assets/scripts/carousel.js"></script>
</body>

</html>