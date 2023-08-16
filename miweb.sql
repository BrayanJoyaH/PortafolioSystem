-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-05-2022 a las 17:57:21
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `miweb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conocimientos`
--

CREATE TABLE `conocimientos` (
  `id` int(15) NOT NULL,
  `imagen` varchar(180) NOT NULL,
  `skill` varchar(180) NOT NULL,
  `experiencia` varchar(180) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `conocimientos`
--

INSERT INTO `conocimientos` (`id`, `imagen`, `skill`, `experiencia`) VALUES
(1, 'images/html.png', 'HTML', '2 años'),
(2, 'images/css.png', 'CSS', '2 años'),
(3, 'images/php.png', 'PHP', '2 años'),
(4, 'images/mysql.png', 'MYSQL', '2 años'),
(5, 'images/gimp.png', 'GIMP', '2 años'),
(6, 'images/js.png', 'JS', '2 meses'),
(7, 'images/e.png', 'Ingles', 'Básico'),
(8, 'images/py.png', 'PYTHON', '1 mes'),
(9, 'images/file.png', '.htaccess', '2 meses'),
(10, 'images/bootstrap.png', 'Boostrap', '5 meses');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudios`
--

CREATE TABLE `estudios` (
  `id` int(15) NOT NULL,
  `icono` varchar(180) NOT NULL,
  `institucion` varchar(180) NOT NULL,
  `titulo` varchar(180) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estudios`
--

INSERT INTO `estudios` (`id`, `icono`, `institucion`, `titulo`) VALUES
(8, 'fab fa-php', 'Politécnico de Colombia', 'Diplomado programación PHP'),
(9, 'fas fa-microchip', 'Universidad de los Andes', 'Ingeniería Electrónica'),
(10, 'fas fa-user-graduate', 'Ied Pio X', 'Bachillerato');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `files`
--

CREATE TABLE `files` (
  `id` int(60) NOT NULL,
  `fld` varchar(50) NOT NULL,
  `url` varchar(300) NOT NULL,
  `name` varchar(300) NOT NULL,
  `state` varchar(60) NOT NULL,
  `extension` varchar(30) NOT NULL,
  `id_user` int(30) NOT NULL,
  `token_user` varchar(50) NOT NULL,
  `cid` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `folders`
--

CREATE TABLE `folders` (
  `id` int(60) NOT NULL,
  `fld` varchar(50) NOT NULL,
  `url` varchar(300) NOT NULL,
  `name` varchar(300) NOT NULL,
  `id_user` int(50) NOT NULL,
  `token_user` varchar(50) NOT NULL,
  `cid` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `folders`
--

INSERT INTO `folders` (`id`, `fld`, `url`, `name`, `id_user`, `token_user`, `cid`) VALUES
(2, 'root', 'files/private/ba0f6c52d0c831fbf3ac89a136a31ad5/root', 'root', 2, 'ba0f6c52d0c831fbf3ac89a136a31ad5', 'root'),
(3, 'root', 'files/private/90d5d888a800e6a19a1c1c8ee7c524f3/root', 'root', 3, '90d5d888a800e6a19a1c1c8ee7c524f3', 'root');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `infopersonal`
--

CREATE TABLE `infopersonal` (
  `nombreCompleto` varchar(120) NOT NULL,
  `edad` varchar(120) NOT NULL,
  `correo` varchar(180) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `estilo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `infopersonal`
--

INSERT INTO `infopersonal` (`nombreCompleto`, `edad`, `correo`, `telefono`, `pais`, `estilo`) VALUES
('Brayan Joya Herrera', '17 años', 'joyadeveloper324@gmail.com', '3208145302', 'Colombia', 'Me gusta mucho las cosas sencillas pero con un estilo clásico y elegante. Me gusta usar mucho el color azul en mis sitios y proyectos personales.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inicio`
--

CREATE TABLE `inicio` (
  `titulo` text NOT NULL,
  `subtitulo` text NOT NULL,
  `descripcion` text NOT NULL,
  `blogtitulo` text NOT NULL,
  `blogdescripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inicio`
--

INSERT INTO `inicio` (`titulo`, `subtitulo`, `descripcion`, `blogtitulo`, `blogdescripcion`) VALUES
('Eco2-Filter', 'Hola Soy Brayan Joya', '	Me llamo Brayan Camilo Joya Herrera, tengo 16 años y soy desarrollador web. Soy de Colombia, actualmente me encuentro estudiando ingenierí­a electrónica en la universidad de los Andes de Colombia. En mis tiempos libres me gusta desarrollar páginas web para mis clientes y de esa manera generar ingresos. Otras de mis pasatiempos son: Jugar baloncesto, Jugar ajedrez y Aprender sobre electrónica; Además me gusta subir contenido a las redes sociales el cual me permita ayudar a la gente compartiendo mis conocimientos y una que otra cosa de entretenimiento. Este es mi sitio personal en el cual puedes encontrar los proyectos que he desarrollado, al igual que puedes encontrar distintos de mis productos y artículos. \\r\\n\\r\\nPuedo ofrecerte mis servicios como desarrollador web elaborando paginas web a medida para tu emprendimiento, comercio online, sitio personal o lo que desees, permiteme apoyarte y trabajar contigo para que puedas tener la página web que tanto anhelas.', 'Lee Artículos de Mi Blog', 'En mi blog puedes encontrar distinto contenido acerca de programación, desarrollo web, manejo  y aprendizaje de las tecnologías web básicas como lo son HTML, CSS, JS, PHP, AJAX, MYSQL entre otras, además subo tips de tecnologí­a y otro tipo de contenido variado.\\r\\n\\r\\n¡Vé y explora mi blog! ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(15) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `minidescripcion` text NOT NULL,
  `logo` varchar(180) NOT NULL,
  `eslogan` varchar(180) NOT NULL,
  `descripcion` text NOT NULL,
  `token` varchar(120) NOT NULL,
  `cid` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id` int(60) NOT NULL,
  `nombre` varchar(400) NOT NULL,
  `minidescripcion` text NOT NULL,
  `logo` varchar(1200) NOT NULL,
  `eslogan` text NOT NULL,
  `descripcion` text NOT NULL,
  `token` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id`, `nombre`, `minidescripcion`, `logo`, `eslogan`, `descripcion`, `token`) VALUES
(1, 'Private Server', 'Private server es un proyecto que ofrece un sistema para gestionar y guardar datos como lo harí­as en google drive.', 'proyectInfo/07e8cebd0fcc66b957cea33f1eca1f52/prvtsvr.png', 'Permite guardar archivos de forma rápida', 'Private server es un proyecto que ofrece un sistema para gestionar y guardar datos como lo harí­as en google drive. El sistema cuenta con un sistema de login y usuarios, al montarlo en un servidor y exportar la base de datos a mysql por defecto viene un usuario admin con contraseña admin, el cual es el que gestionará y tendrá control total de la página como registrar usuarios, eliminarlos y demás.\\r\\n\\r\\nDe igual manera el sistema viene diseñado de manera responsiva para tener una cómoda navegación tanto en dispositivos de escritorio como en móviles.\\r\\n\\r\\nEl Proyecto está desarrollado con las siguientes tecnologí­as:\\r\\n\\r\\n- HTML\\r\\n- CSS\\r\\n- JS\\r\\n- PHP\\r\\n- MYSQL\\r\\n- .HTACCESS\\r\\n\\r\\nSi te interesa el proyecto puedes contactare mediante el formulario que se encuentra en la parte inferior de la página; al igual encontrarás el link para comprar el código fuente en la sección de productos. Tras la compra del código recibirás a tu correo constantemente información sobre la actualización de la aplicación. De la misma forma tienes derecho a enviar tus opiniones sobre actualizaciones que veas necesarias y estas serán atendidas y se te notificará por correo si son aprobadas o no. Además si realizas aportes importantes podrás ser uno de los colaboradores del proyecto y poder ser beneficiario del mismo. ', '07e8cebd0fcc66b957cea33f1eca1f52'),
(2, 'Mi portafolio', 'Es un sitio de mi propiedad que también logra demostrar la experiencia que tengo desarrollando páginas web.', 'proyectInfo/2033e2eb5976a2c56fcf66808f13da96/dswb.png', 'Mi sitio personal', 'Mi sitio demuestra la experiencia que tengo como desarrollador web. Es un sitio muy completo, con sistemas de registro de usuarios, inicio de sesión, páginas para editar los datos de tu cuenta y con otras decenas de funciones que tan solo están disponible pos lor administradores y de la página. Además está diseñada de manera responsiva para dispositivos móviles.\\r\\n\\r\\nEl Proyecto está desarrollado con las siguientes tecnologías:\\r\\n\\r\\n- HTML\\r\\n- CSS\\r\\n- JS\\r\\n- PHP\\r\\n- MYSQL\\r\\n- .HTACCESS\\r\\n\\r\\nSi quieres tener acceso a las opciones de editor de la página tendrás que dirigirte a algún proyecto, comprar su código y enviar una aporte valioso en la actualización de dicha aplicación, si se aprueba tu aporte como un aporte valioso pasarás a ser editor de la página y tener beneficios en los proyectos en que participes. ', '2033e2eb5976a2c56fcf66808f13da96'),
(3, 'Pop Up - Ventana modal', 'Ventana modal hecha tan solo con HTML y CSS sin necesidad de utilizar Javascript.', 'proyectInfo/922475daa90965bae15998f8ef7957af/popup.png', 'Ventana modal tan solo con HTML y CSS', 'Consiste en una ventana modal hecha tan solo con HTML y CSS sin necesidad de utilizar Javascript. Si eres diseÃ±ador web y te interesa aprender como se logra hacer una ventana modal o pop up sin utilizar Javascript, te lo explico en uno de los videos de mi canal de youtube:\\r\\n\\r\\nBrayan Joya - Ventana modal con HTML y CSS', '922475daa90965bae15998f8ef7957af');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(60) NOT NULL,
  `usuario` varchar(300) CHARACTER SET utf8 NOT NULL,
  `password` varchar(300) CHARACTER SET utf8 NOT NULL,
  `nombre` varchar(300) CHARACTER SET utf8 NOT NULL,
  `correo` varchar(300) CHARACTER SET utf8 NOT NULL,
  `last_session` datetime DEFAULT NULL,
  `activacion` int(15) NOT NULL DEFAULT 0,
  `token` varchar(40) CHARACTER SET utf8 NOT NULL,
  `token_password` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `password_request` int(11) DEFAULT 0,
  `id_tipo` int(11) NOT NULL,
  `imagen` varchar(300) NOT NULL,
  `cid` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `correo`, `last_session`, `activacion`, `token`, `token_password`, `password_request`, `id_tipo`, `imagen`, `cid`) VALUES
(2, 'BrayanJoya', '$2y$10$LlEcqXTAiesbsVZ0gne8l.uCBqaK6Czo5O9MBcQiEcAvMPLT0pEOi', 'Brayan Camilo Joya Herrera', 'joyaelipson324@gmail.com', '2022-05-10 10:42:19', 1, 'ba0f6c52d0c831fbf3ac89a136a31ad5', '', 0, 3, 'user/images/ba0f6c52d0c831fbf3ac89a136a31ad5/Brayan.jpg', '0'),
(3, 'cristihan', '$2y$10$gyqlOGQAUlHK/uEWQ2hwpeeJFt.DJNqf0xbPu1X/RVUR368wUEhGa', 'cristihan', 'dpoveda115@gmail.com', NULL, 0, '90d5d888a800e6a19a1c1c8ee7c524f3', NULL, 0, 2, 'user/images/default/user.png', '0');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `conocimientos`
--
ALTER TABLE `conocimientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estudios`
--
ALTER TABLE `estudios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `conocimientos`
--
ALTER TABLE `conocimientos`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `estudios`
--
ALTER TABLE `estudios`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `files`
--
ALTER TABLE `files`
  MODIFY `id` int(60) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
