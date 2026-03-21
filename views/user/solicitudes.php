<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../controllers/db_functions.php';
# Comprobar si existe una sesión activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Comprobamos si ya hay usuario logueado y lo redirigimos al index
if (!isset($_SESSION['user_data'])) {
    header(header: 'Location: ../../index.php');
    exit;
}

try {
    $solicitudes = obtener_solicitudes($mysqli_connection);
} catch (Exception $e) {
    error_log("Error cargando datos solicitudes de contacto: " . $e->getMessage());
    $solicitudes = [];
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
                    <li><a class="enlace active" href="#">Solicitudes</a></li>
                    <li><a class="enlace" href="./usuarios.php">Usuarios</a></li>
                    <li><a class="enlace" href="./empleados.php">Empleados</a></li>
                    <li><a class="enlace" href="./perfil.php">Perfil</a></li>
                    <li><a class="enlace" href="../../controllers/logout.php">Cerrar sesión</a></li>
                </ul>

            </nav>
        </header>
        <!-- CUERPO PRINCIPAL-->
        <main class="mi_principal">

            <h2>Solicitudes de contacto</h2>

            <div class="aviso_registro">
                <?php
                if (isset($_SESSION['mensaje_error'])) {
                    echo "<span class='error_message'>{$_SESSION['mensaje_error']}</span>";
                    unset($_SESSION['mensaje_error']);
                }
                if (isset($_SESSION['mensaje_exito'])) {
                    echo "<span class='success_message'>{$_SESSION['mensaje_exito']}</span>";
                    unset($_SESSION['mensaje_exito']);
                }
                ?>
            </div>
            <section class="section_center">
                <?php if ($solicitudes) { ?>
                    <div class="solicitud_container">

                        <table class="solicitudes_table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha solicitud</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Motivo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        <?php } else {
                        echo "<p>No hay solicitudes pendientes</p>";
                    } ?>
                        <tbody>
                            <?php foreach ($solicitudes as $s): ?>

                                <!-- FILA PRINCIPAL -->
                                <tr>
                                    <td><?= (int)$s['id_solicitud'] ?></td>
                                    <td><?= !empty($s['fecha_solicitud']) ? date('d-m-Y', strtotime($s['fecha_solicitud'])) : '—' ?></td>
                                    <td><?= htmlspecialchars($s['nombre']) ?></td>
                                    <td><?= htmlspecialchars($s['apellido']) ?></td>
                                    <td><?= htmlspecialchars($s['telefono']) ?></td>
                                    <td><?= htmlspecialchars($s['direccion'] ?? '—') ?></td>
                                    <td class="td_motivo"><?= htmlspecialchars($s['texto']) ?></td>
                                    <td><?= htmlspecialchars($s['estado'] ?? 'Pendiente') ?></td>


                                    <td class="acciones_td">
                                        <button type="button" class="btn_modificar">
                                            Modificar
                                        </button>

                                        <form method="post" action="../../controllers/user/c_solicitudes_contacto.php">
                                            <input type="hidden" name="id_solicitud" value="<?= (int)$s['id_solicitud'] ?>">
                                            <button class="btn_borrar" name="borrar_solicitud">Borrar</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- FILA DESPLEGABLE (EDITAR) -->
                                <tr class="fila_edit hidden">
                                    <td colspan="9">

                                        <form class="solicitud_edit_form" method="post" action="../../controllers/user/c_solicitudes_contacto.php">
                                            <input type="hidden" name="id_solicitud" value="<?= (int)$s['id_solicitud'] ?>">

                                            <div class="edit_grid edit_grid--solicitudes">

                                                <div>
                                                    <label>Estado</label>
                                                    <select name="estado">
                                                        <option value="Pendiente" <?= ($s['estado'] ?? 'Pendiente') === 'Pendiente' ? 'selected' : '' ?>>
                                                            Pendiente
                                                        </option>
                                                        <option value="Respondido" <?= ($s['estado'] ?? '') === 'Respondido' ? 'selected' : '' ?>>
                                                            Respondido
                                                        </option>
                                                    </select>
                                                </div>

                                                <div>
                                                    <label>Fecha cierre</label>
                                                    <input type="date" name="fecha_cierre" value="<?= htmlspecialchars($s['fecha_cierre'] ?? '') ?>">
                                                </div>

                                                <div>
                                                    <label>Observaciones</label>
                                                    <textarea name="observaciones" rows="3" maxlength="250"><?= htmlspecialchars($s['observaciones'] ?? '') ?></textarea>
                                                </div>
                                                <div class="edit_actions_solicitudes">
                                                    <button type="submit" class="btn_guardar" name="guardar_cambios">
                                                        Guardar
                                                    </button>

                                                    <button type="button" class="btn_cancel">
                                                        Cancelar
                                                    </button>
                                                </div>
                                            </div>



                                        </form>

                                    </td>
                                </tr>

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

    <script src="../../assets/scripts/v_solicitudes.js"></script>

</body>

</html>