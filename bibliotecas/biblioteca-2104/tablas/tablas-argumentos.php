<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

$arg["usuarios"]["borrar-1"] = [
    "tabla"               => $cfg["tablaUsuarios"],
    "accion"              => "borrar-1",
    "nivel"               => NIVEL_3,
    "cabeceraTexto"       => "Usuarios - Borrar 1",
    "cabeceraMenu"        => MENU_USUARIOS,
    "cabeceraProfundidad" => 1,
];

$arg["usuarios"]["borrar-2"] = [
    "tabla"               => $cfg["tablaUsuarios"],
    "accion"              => "borrar-2",
    "nivel"               => NIVEL_3,
    "cabeceraTexto"       => "Usuarios - Borrar 2",
    "cabeceraMenu"        => MENU_USUARIOS,
    "cabeceraProfundidad" => 1,
];

$arg["usuarios"]["buscar-1"] = [
    "tabla"               => $cfg["tablaUsuarios"],
    "accion"              => "buscar-1",
    "nivel"               => NIVEL_3,
    "cabeceraTexto"       => "Usuarios - Buscar 1",
    "cabeceraMenu"        => MENU_USUARIOS,
    "cabeceraProfundidad" => 1,
];

$arg["usuarios"]["buscar-2"] = [
    "tabla"               => $cfg["tablaUsuarios"],
    "accion"              => "buscar-2",
    "nivel"               => NIVEL_3,
    "cabeceraTexto"       => "Usuarios - Buscar 2",
    "cabeceraMenu"        => MENU_USUARIOS,
    "cabeceraProfundidad" => 1,
];

$arg["usuarios"]["insertar-1-a"] = [
    "tabla"               => $cfg["tablaUsuarios"],
    "accion"              => "insertar-1-a",
    "nivel"               => NIVEL_3,
    "cabeceraTexto"       => "Usuarios - Añadir 1",
    "cabeceraMenu"        => MENU_USUARIOS,
    "cabeceraProfundidad" => 1,
];

$arg["usuarios"]["insertar-2"] = [
    "tabla"               => $cfg["tablaUsuarios"],
    "accion"              => "insertar-2",
    "nivel"               => NIVEL_3,
    "cabeceraTexto"       => "Usuarios - Añadir 2",
    "cabeceraMenu"        => MENU_USUARIOS,
    "cabeceraProfundidad" => 1,
    "controles"           => ["usuario", "password", "nivel"],
    "compruebaConjunto"   => "algunoVacio",
    "consultaParametros"  => [["usuario"], ["nivel", "usuario", "password"]],
];

$arg["usuarios"]["listar"] = [
    "tabla"                       => $cfg["tablaUsuarios"],
    "accion"                      => "listar",
    "nivel"                       => NIVEL_3,
    "cabeceraTexto"               => "Usuarios - Listar",
    "cabeceraMenu"                => MENU_USUARIOS,
    "cabeceraProfundidad"         => 1,
    "columnasOrden"               => $columnasUsuariosOrden,
    "columnasOrdenPredeterminado" => "usuario ASC",
    "campos"                      => [
        ["campo" => "usuario", "texto" => "Usuario"],
        ["campo" => "password", "texto" => "Contraseña"],
        ["campo" => "nivel", "texto" => "Nivel"],
    ],
];

$arg["usuarios"]["modificar-1"] = [
    "tabla"               => $cfg["tablaUsuarios"],
    "accion"              => "modificar-1",
    "nivel"               => NIVEL_3,
    "cabeceraTexto"       => "Usuarios - Modificar 1",
    "cabeceraMenu"        => MENU_USUARIOS,
    "cabeceraProfundidad" => 1,
];

$arg["usuarios"]["modificar-2"] = [
    "tabla"               => $cfg["tablaUsuarios"],
    "accion"              => "modificar-2",
    "nivel"               => NIVEL_3,
    "cabeceraTexto"       => "Usuarios - Modificar 2",
    "cabeceraMenu"        => MENU_USUARIOS,
    "cabeceraProfundidad" => 1,
];

$arg["usuarios"]["modificar-3"] = [
    "tabla"               => $cfg["tablaUsuarios"],
    "accion"              => "modificar-3",
    "nivel"               => NIVEL_3,
    "cabeceraTexto"       => "Usuarios - Modificar 3",
    "cabeceraMenu"        => MENU_USUARIOS,
    "cabeceraProfundidad" => 1,
];

$arg["obras"]["insertar-1-a"] = [
    "tabla"               => $cfg["tablaObras"],
    "accion"              => "insertar-1-a",
    "nivel"               => NIVEL_3,
    "cabeceraTexto"       => "Obras - Añadir 1",
    "cabeceraMenu"        => MENU_OBRAS,
    "cabeceraProfundidad" => 1,
];

 $arg["obras"]["listar"] = [
     "tabla"                       => $cfg["tablaObras"],
     "accion"                      => "listar",
     "nivel"                       => NIVEL_2,
     "cabeceraTexto"               => "Obras - Listar",
     "cabeceraMenu"                => MENU_OBRAS,
     "cabeceraProfundidad"         => 1,
     "columnasOrden"               => $columnasObrasOrden,
     "columnasOrdenPredeterminado" => "titulo ASC",
     "campos"                      => [
         ["campo" => "autor", "texto" => "Autor"],
         ["campo" => "titulo", "texto" => "Título"],
         ["campo" => "editorial", "texto" => "Editorial"],
     ],
 ];

 $arg["personas"]["insertar-1-a"] = [
     "tabla"               => $cfg["tablaPersonas"],
     "accion"              => "insertar-1-a",
     "nivel"               => NIVEL_3,
     "cabeceraTexto"       => "Personas - Añadir 1",
     "cabeceraMenu"        => MENU_PERSONAS,
     "cabeceraProfundidad" => 1,
 ];
 $arg["personas"]["listar"] = [
     "tabla"                       => $cfg["tablaPersonas"],
     "accion"                      => "listar",
     "nivel"                       => NIVEL_3,
     "cabeceraTexto"               => "Personas - Listar",
     "cabeceraMenu"                => MENU_PERSONAS,
     "cabeceraProfundidad"         => 1,
     "columnasOrden"               => $columnasPersonasOrden,
     "columnasOrdenPredeterminado" => "apellidos ASC",
     "campos"                      => [
         ["campo" => "nombre", "texto" => "Nombre"],
         ["campo" => "apellidos", "texto" => "Apellidos"],
         ["campo" => "dni", "texto" => "DNI"],
     ],
 ];

 $arg["prestamos"]["insertar-1-b"] = [
     "accion"              => "insertar-1-b",
     "nivel"               => NIVEL_3,
     "cabeceraTexto"       => "Préstamos - Añadir 1",
     "cabeceraMenu"        => MENU_PRESTAMOS,
     "cabeceraProfundidad" => 1,
 ];

$arg["prestamos"]["insertar-2"] = [
    "accion"              => "insertar-1-b",
    "nivel"               => NIVEL_3,
    "cabeceraTexto"       => "Préstamos - Añadir 1",
    "cabeceraMenu"        => MENU_PRESTAMOS,
    "cabeceraProfundidad" => 1,
];

$arg["prestamos"]["listar"] = [
    "tabla"                       => $cfg["tablaPrestamos"],
    "accion"                      => "listar",
    "nivel"                       => NIVEL_3,
    "cabeceraTexto"               => "Préstamos - Listar",
    "cabeceraMenu"                => MENU_PRESTAMOS,
    "cabeceraProfundidad"         => 1,
    "columnasOrden"               => $columnasPrestamosOrden,
    "columnasOrdenPredeterminado" => "apellidos ASC",
    "campos"                      => [
        ["campo" => "apellidos", "texto" => "Persona"],
        ["campo" => "autor", "texto" => "Obra"],
        ["campo" => "prestado", "texto" => "Préstamo"],
        ["campo" => "devuelto", "texto" => "Devolución"],
    ],
];
