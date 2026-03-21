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
                    <li><a class="enlace" href="./galeria.php">Galería</a></li>
                    <li><a class="enlace" href="./contacto.php">Contacto</a></li>
                    <li><a class="enlace active" href="#">Preguntas</a></li>

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

            <!-- CABECERA FAQ (STICKY) -->
            <div class="faq-header">
                <h2>Preguntas frecuentes</h2>
                <details class="faq-dropdown">
                    <summary>Ver todas las preguntas</summary>
                    <nav class="faq-nav">
                        <a href="#s1" class="faq-link">¿Estan matriculados?</a>
                        <a href="#s2" class="faq-link">¿En qué zonas trabajan?</a>
                        <a href="#s3" class="faq-link">¿Qué trabajos realizan?</a>
                        <a href="#s4" class="faq-link">¿Realizan trámites ante Naturgy?</a>
                        <a href="#s5" class="faq-link">¿Cuánto demora un trámite de habilitación?</a>
                        <a href="#s6" class="faq-link">¿Qué documentación necesito para el trámite de rehabilitación de suministro?</a>
                        <a href="#s7" class="faq-link">¿Cómo es la forma de pago?</a>
                        <a href="#s8" class="faq-link">¿Hacen urgencias?</a>
                        <a href="#s9" class="faq-link">¿Puedo ser titular del servicio si no tengo escritura?</a>
                        <a href="#s10" class="faq-link">¿Qué documentación necesito para hacer cambio de titularidad?</a>
                    </nav>
                </details>
            </div>

            <!-- CONTENIDO -->
            <section class="faq-container">

                <article id="s1" class="faq-section">
                    <h4>¿Estan matriculados?</h4>
                    <p><strong>►</strong> Sí. Somos gasistas matriculados habilitados para realizar trabajos bajo normativa vigente y presentar trámites ante Naturgy SA.</p>
                    <button class="btn_contactar"><a href="./contacto.php">Quiero contactarme</a></button>
                </article>

                <article id="s2" class="faq-section">
                    <h4>¿En qué zonas trabajan?</h4>
                    <p><strong>►</strong> Trabajo en San Miguel y zonas aledañas del Gran Buenos Aires.</p>
                    <button class="btn_contactar"><a href="./contacto.php">Quiero contactarme</a></button>
                </article>

                <article id="s3" class="faq-section">
                    <h4>¿Qué trabajos realizan?</h4>
                    <ul>
                        <li>Instalaciones internas de gas natural doméstico, comercial o industrial (instaladores matriculados de primera y segunda categoría).</li>
                        <li>Asesoramiento - Cálculo de diámetro de cañería.</li>
                        <li>Trámites de habilitación y rehabilitación. Inspecciones parciales y finales.</li>
                        <li>Extensiones de red externa para gas natural / Gestión de factibilidad.</li>
                        <li>Pruebas de hermeticidad.</li>
                        <li>Confección de Planos (incluyendo planos de combustión).</li>
                        <li>Certificacion/Relevamiento de instalación interna para gas natural. Regularización de instalaciones observadas.</li>
                        <li>Colocación, reemplazo y reparación de artefactos.</li>
                        <li>Mantenimiento de instalaciones.</li>
                        <li>Gestiones administrativas - atención al cliente/matriculado (cambios de titularidad, bajas de servicio, renovación de matrículas, etc).</li>
                    </ul>
                    <button class="btn_contactar"><a href="./contacto.php">Quiero contactarme</a></button>
                </article>

                <article id="s4" class="faq-section">
                    <h4>¿Realizan trámites ante Naturgy?</h4>
                    <p><strong>►</strong> Sí. Nos encargamos de gestionar el trámite completo ante Naturgy bajo normativa NAG200, incluyendo presentación de planos y coordinación de inspecciones.</p>
                    <button class="btn_contactar"><a href="./contacto.php">Quiero contactarme</a></button>
                </article>

                <article id="s5" class="faq-section">
                    <h4>¿Cuánto demora un trámite de habilitación?</h4>
                    <p><strong>►</strong> Depende del tipo de trabajo y los tiempos de inspección de Naturgy, pero generalmente el proceso puede demorar entre 7 y 20 días hábiles.</p>
                    <button class="btn_contactar"><a href="./contacto.php">Quiero contactarme</a></button>
                </article>

                <article id="s6" class="faq-section">
                    <h4>¿Qué documentación necesito para el trámite de rehabilitación de suministro?</h4>
                    <ul>
                        <li><strong>Dirección completa del suministro a rehabilitar</strong> (si es posible, acompañarla con ubicación de Google Maps).</li>
                        <li><strong>Factura/boleta de gas</strong> (no es necesario que sea la última, sí que figure el actual titular del servicio).</li>
                        <li><strong>DNI del titular</strong> que figura en la factura (en lo posible escaneado).<br><span> -> Si ud. no es el actual titular del servicio, y no cuenta con el DNI del mismo, dar aviso y le comentaremos cómo proceder</span>.</li>
                        <li><strong>Teléfono de contacto o celular</strong> del titular.</li>
                        <li><span>-> Si las cañerías de gas fueron modificadas desde que usted instaló el gas, informarlo.</span></li>
                        <li><span>-> Si cuenta con algún plano de la vivienda, por favor, enviarlo, ya que acelera el proceso (preferentemente en formato DWG para poder visualizarlo en AutoCAD).</span></li>
                    </ul>
                    <button class="btn_contactar"><a href="./contacto.php">Quiero contactarme</a></button>
                </article>

                <article id="s7" class="faq-section">
                    <h4>¿Cómo es la forma de pago?</h4>
                    <p><strong>►</strong> Se solicita un anticipo del 50% para iniciar el trabajo y el saldo restante al finalizar o aprobarse la inspección.</p>
                    <button class="btn_contactar"><a href="./contacto.php">Quiero contactarme</a></button>
                </article>

                <article id="s8" class="faq-section">
                    <h4>¿Hacen urgencias?</h4>
                    <p><strong>►</strong> Sí, realizamos visitas urgentes según disponibilidad.</p>
                    <button class="btn_contactar"><a href="./contacto.php">Quiero contactarme</a></button>
                </article>

                <article id="s9" class="faq-section">
                    <h4>¿Puedo ser titular del servicio si no tengo escritura?
                    </h4>
                    <p><strong>►</strong> Sí. Contáctenos y le comentaremos cómo proceder.</p>
                    <button class="btn_contactar"><a href="./contacto.php">Quiero contactarme</a></button>
                </article>

                <article id="s10" class="faq-section">
                    <h4>¿Qué documentación necesito para hacer cambio de titularidad?</h4>
                    <ul>
                        <li><strong>Factura de naturgy</strong> (puede ser antigua)</li>
                        <li><strong>DNI del futuro titular</strong></li>
                        <li><strong>Escritura/boleto/contrato</strong> donde figure el futuro titular.<br><span>-> Si no figura la misma numeración que en la factura de naturgy, presentar <strong>certificado de domicilio</strong>. Podés gestionarlo de manera <strong>PRESENCIAL</strong> en el Registro de las Personas, o de manera <strong>ONLINE</strong> haciendo click en el siguiente <a href="https://www.gba.gob.ar/registrodelaspersonas/declaracion_jurada_de_domicilio_tramite_online" target="_blank" style="text-decoration: none;">link</a> del Registro.</span></li>
                        <li><strong>Email</strong></li>
                        <li><strong>Teléfono</strong></li>
                        <li><strong>Foto del medidor</strong> (sólo si se trata de un departamento)*</li>
                        <li><strong>Constancia de AFIP / Habilitación / Estatuto</strong> (sólo si es cliente COMERCIAL)*</li>
                        <li><span>-> Si se trata de un <strong>ENTE OFICIAL</strong>, también enviar:</span>
                            <ul>
                                <li>Asamblea o Acta donde figure el responsable (presidente o representante)</li>
                                <li>DNI del responsable</li>
                                <li>Poder o nombramiento del responsable que demuestre su cargo</li>
                                <li>Nota solicitando el cambio de titularidad (solicitar nota-modelo)</li>
                            </ul>
                        </li>
                    </ul>
                    <button class="btn_contactar"><a href="./contacto.php">Quiero contactarme</a></button>
                </article>

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
    
    <script src="../assets/scripts/v_preguntas.js"></script>
</body>

</html>