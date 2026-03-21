|- README.md: La web se trata sobre una empresa argentina de Instalaciones de Gas Natural, rehabilitaciones de suministro e incidencias, donde se podrán hacer envíos de solicitudes de contacto a la empresa. También tiene vistas con galería de imágenes de trabajos realizados, clientes reconocidos, otra de preguntas frecuentes y la de contacto con todos los datos de la empresa para poder comunicarse con ella o enviar el formulario de contacto.  
Para acceder a la web, hay que entrar primero desde la ruta localhost htdocs/PROYECTOS/Grupo Crear SRL.


|- index.php: Es la página principal donde se encuentra una breve presentación de la empresa, junto con un carousel de imágenes de trabajos realizados y una lista con logos de algunos de sus clientes importantes. Tres vistas mas que son las de galería, preguntas frecuentes y contacto. Además, se podrán visualizar cuatro vistas más que se podrán acceder al loguearse con un usuario registrado: solicitudes (de contacto), usuarios, empleados y perfil. 

|-VIEWS: Carpeta donde contendrán las vistas de las páginas que accede cualquier visitante.
|--galeria.php: Contiene diversas imágenes sobre algunos de los trabajos realizados.
|--contacto.php: Vista que contiene el formulario de solicitud de contacto con la empresa.
|--preguntas_frecuentes.php: Vista en la cual se describen preguntas habituales que suelen consultar los clientes a la empresa.

|-VIEWS/user: Carpeta que continene las vistas de acceso exclusivo para los usuarios registrados.
|--solicitudes.php: Página que contiene la  lista de las solicitudes recibidas pendiente de ser resueltas o respondidas, donde el usuario registrado puede modificarlas o borrarlas. 
|--usuarios.php: Vista donde se encuentra la lista de usuarios registrados (empleados administrativos / gerenciales de la empresa) con todos los datos principales. Si el usuario logueado es el "admin" (id_usuario "1") puede editar los datos de los mismos menos la contraseña y nombre de usuario. Tiene también el permiso de borrar al usuario y crear uno nuevo junto con su nombre de usuario y contraseña.
|--empleados.php: Al igual que la página anterior, se muestran en una lista los empleados (operarios) registrados y sus datos principales. Aquí también el usuario admin puede editar los datos actuales de ellos, borrar el registro, como también se le habilita un formulario para agregar a un empleado nuevo. Mientas que los usuarios restantes, sólo pueden visualizar la información.
|--perfil.php: Aquí cada usuario podrá actualizar sus datos personales y su contraseña pero no el nombre de usuario.

|-VIEWS/ERRORS/error500.html: Carpeta y archivo único que se utilizará para redirigir hacia ahí a un usuario ante cualquier error grave de la página.

|-DATABASE: Carpeta que contendrá el o los archivos de las bases de datos con toda la información para la creación de las mismas, sus tablas, atributos, etc.
|--grupo_crear.sql: Archivo sql de la base de datos usada por la web.

|-CONTROLLERS: Carpeta que contendrá los controladores de la página web (comunicación con formularios, bases de datos, funciones, validaciones, etc)
|--c_contacto.php: Controla lo enviado por la vista contacto.php donde el usuario visitante puede enviar sus datos solicitando el contacto de la empresa, enviandosé mediante un formulario.
|--c_login.php: Mediante este controlador se corroboran los datos de inicio de sesión ingresados por los usuarios registrados desde la vista login.php para el inicio de sesión. Esta vista no es accesible desde la web sino que el usuario admin como el resto pueden acceder teniendo el link de la vista exclusivamente para el logueo.
|--db_conn.php: Controlador encargado de la comunicación con la base de datos.
|--db_functions: Controlador que tiene casi todas las funciones con las que trabajará la página web, aislandolas de los controladores que se encargan de verificar los formularios y comunicarse con la web.
|--flash.php: Controlador que contiene las funciones para crear el mensaje de SESSION 'flash" en cada formulario de registro nuevo, donde almacenará los datos ingresados por el usuario o visitante, ante el caso que ese intento de envío sea incorrecto, volverá a cargar la info guardada para que la persona corrija sólo los erróneos. Luego, si se va de la página o cambia a otra web, esa variable se destruye.
|--logout.php: Controlador encargado del cierre de sesión de los usuarios.
|--registrarAdmin.php: Es una página donde el desarrollador genera el hash de la contraseña solicitada para el usuario "admin" donde luego la ingresamos manualmente a la BD junto con el resto de los datos.
|--.env.php: Contiene variables donde se guarda la información relevante para la conexión con la base de datos.
|--.htaccess: Archivo de Apache donde configuramos el código para proteger el archivo .env.php (contenido importante)

|--CONTROLLERS/user: Carpeta que contiene los controladores exclusivos para las vistas de los usuarios registrados.
|---c_empleados.php: Controlador para comunicarse con el formulario de actualización de datos de los empleados y el registro de uno nuevo o el borrado de los mismos (usuario admin) en la vista empleados.php.
|---c_perfil.php: Controlador que validará los datos ingresados por el usuario logueado para la actualización de su propia información de su perfil, mediante el formulario en la vista del perfil. También, podrá actualizar su contraseña mediante este controlador. 
|---c_solicitudes_contacto.php: Controla los datos modificados por los usuarios sobre las solicitudes de contacto enviadas desde la página contacto.php.
|---c_usuarios.php: Corrobora los datos ingresados en la vista usuarios.php tanto para la actualización de datos, el borrado de algún registro o la creación de un usuario nuevo (sólo el admin en estos últimos 2).

|-CONTROLLERS/VALIDATIONS/v_inputData.php: Carpeta que contiene (en este caso uno solo -> v_inputData.php) los archivos con las validaciones de los datos ingresados a los formularios en cada formulario de ingreso de datos, devolviendo a los controladores los resultados de las comprobaciones necesarias (regex, por ejemplo).

|-CONFIG: Carpeta contenedora de los archivos principales referidos a la configuración y protección de cierta información.
|--config.php: Archivo donde se asegura que las páginas (que lo llamen previamente) obtengan los errores de manera más segura si los hubiesen.
|--.htaccess: Archivo que protege a config.php.

|-ASSETS: Carpeta que contendrá distintas carpetas y archivos como imágenes, hojas de estilos, scripts, etc.
|--CSS/estilos.css: Carpeta y archivo que contiene todos los estilos de la web.
|--FAVICON: Carpeta que contiene todos los archivos favicon de la web.
|--iconos: Carpeta que contiene todos los archivos de iconos de la web (email, whatsapp, etc).
|--IMAGES: Carpeta que contiene los archivos de imágnes de la web como los del encabezado, las imagenes de la presentación, archivos de logos de los clientes habituales.
|--SCRIPTS: Carpeta que contiene los archivos scripts de las distintas vistas.

|-SCRIPTS:
|---carousel.js: Controla el carousel de imágenes de index.php.
|---show_password.js: Controla el checkbox para visualizar la contraseña al registrarse en usuarios.php.
|---v_contacto.js: Script que controla los datos ingresados en el formulario de contacto en contacto.php.
|---v_empleados.js: Realiza la animación y verificación de los datos ingresados en la vista de empleados.php en los formularios de registro y actualización del mismo.
|---v_login.js: Verifica la información introducida para el login del usuario en login.php.
|---v_perfil.js: Controla también los formularios de actualización de perfil y cambio de contraseña en perfil.php.
|---v_preguntas.js: Configura el "scrollspy" de la vista preguntas_frecuentes.php.
|---v_solicitudes.js: Corrobora las modificaciones hechas en el registro de alguna solicitud recibida de contacto por parte de algún usuario visitante, mediante la vista contacto.php.
|---v_usuarios.js: Realiza las mismas funciones de animación y control en la vista usuarios.php.
