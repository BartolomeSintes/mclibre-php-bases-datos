<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

// Constantes comunes

// Valores de atributo form de formularios

define("GET", "get");                   // Formularios se envían con GET
define("POST", "post");                 // Formularios se envían con POST

// Opciones de la función borraTodo()

define("DEMO_SI", true);                // Sí incluye valores de prueba en la base de datos al crearla
define("DEMO_NO", false);               // No incluye valores de prueba en la base de datos al crearla

// Profundidad de nivel de la página

define("PROFUNDIDAD_0", 0);             // Profundidad de nivel de la página: directorio raíz
define("PROFUNDIDAD_1", 1);             // Profundidad de nivel de la página: subdirectorio
define("PROFUNDIDAD_2", 2);             // Profundidad de nivel de la página: sub-subdirectorio
define("PROFUNDIDAD_3", 3);             // Profundidad de nivel de la página: sub-sub-subdirectorio

// Nombres de las bases de datos

define("MYSQL", "MySQL");               // Base de datos MySQL
define("SQLITE", "SQLite");             // Base de datos SQLITE

// Algoritmos de hash

define("SHA_256", "sha256");            // Nombres de los algoritmos de hash
$hashSizes = [SHA_256 => 64];           // Tamaños de los valores hash

// Nombres de los menús

define("MENU_PRINCIPAL", "menuPrincipal");                     // Menú principal sin conectar
define("MENU_PRINCIPAL_CONECTADO", "menuPrincipalConectado");  // Menú principal conectado
define("MENU_VOLVER", "menuVolver");                           // Menú Volver
define("MENU_USUARIOS", "menuUsuarios");                       // Menú Usuarios
define("MENU_ADMINISTRADOR", "menuAdministrador");             // Menú Administrador
define("MENU_PERSONAS", "menuPersonas");                       // Menú Personas
define("MENU_OBRAS", "menuObras");                             // Menú Obras
define("MENU_PRESTAMOS", "menuPrestamos");                     // Menú Préstamos

// Niveles de usuarios

define("NIVEL_1", 1);                   // Usuario web de nivel Usuario básico
define("NIVEL_2", 2);                   // Usuario web de nivel Usuario avanzado
define("NIVEL_3", 3);                   // Usuario web de nivel Administrador

$usuariosNiveles = [
    "Usuario Básico"   => NIVEL_1,
    "Usuario Avanzado" => NIVEL_2,
    "Administrador"    => NIVEL_3,
];

// Constantes y variables configurables

require_once "config.php";

// Fecha y hora

define("TAM_FECHA", 10);                 // Longitud de una cadena de fecha (AAAA-MM-DD)

// Tamaño de los campos en la base de datos

$db["tamUsuariosUsuario"]         = 20;                // Tamaño de la columna Usuarios > Nombre de Usuario
$db["tamUsuariosPasswordCifrado"] = $cfg["hashSize"];  // Tamaño de la columna Usuarios > Contraseña de Usuario cifrada
$db["tamUsuariosPassword"]        = 20;                // Tamaño de la Contraseña de Usuario en el formulario
$db["tamPersonasNombre"]          = 40;                // Tamaño de la columna Personas > Nombre
$db["tamPersonasApellidos"]       = 60;                // Tamaño de la columna Personas > Apellidos
$db["tamPersonasDni"]             = 9;                 // Tamaño de la columna Personas > DNI
$db["tamObrasAutor"]              = 60;                // Tamaño de la columna Obras > Autor
$db["tamObrasTitulo"]             = 60;                // Tamaño de la columna Obras > Titulo
$db["tamObrasEditorial"]          = 20;                // Tamaño de la columna Obras > Editorial

// Biblioteca base de datos

if ($cfg["dbMotor"] == MYSQL) {
    require_once "biblioteca-mysql.php";
} elseif ($cfg["dbMotor"] == SQLITE) {
    require_once "biblioteca-sqlite.php";
}

// Tablas

$db["tablas"] = [
    $db["usuarios"],
    $db["personas"],
    $db["obras"],
    $db["prestamos"],
];

// Valores de ordenación de las tablas

$db["columnasUsuariosOrden"] = [
    "usuario ASC", "usuario DESC",
    "password ASC", "password DESC",
    "nivel ASC", "nivel DESC",
];

$db["columnasPersonasOrden"] = [
    "nombre ASC", "nombre DESC",
    "apellidos ASC", "apellidos DESC",
    "dni ASC", "dni DESC",
];

$db["columnasObrasOrden"] = [
    "autor ASC", "autor DESC",
    "titulo ASC", "titulo DESC",
    "editorial ASC", "editorial DESC",
];

$db["columnasPrestamosOrden"] = [
    "apellidos ASC", "apellidos DESC",
    "autor ASC", "autor DESC",
    "prestado ASC", "prestado DESC",
    "devuelto ASC", "devuelto DESC",
];

// Consultas de creación de registros de prueba

$db["consultasValoresDemo"] = [
    "INSERT INTO $db[usuarios]
        VALUES (2,'basico','b1bbef3b6a1cb6f98a451620e6b59f6329e17fa692b48aa148816c71ef08798f', 1)",
    "INSERT INTO $db[usuarios]
        VALUES (3,'avanzado','ab7aa4a533c4160bdf3fbe6b29469c00caf0886692d884c78fc4c0beb03b33c1', 2)",
    "INSERT INTO $db[personas]
        VALUES (1,'Pepito','Conejo','123A')",
    "INSERT INTO $db[personas]
        VALUES (2,'Juan','Nadie','9876X')",
    "INSERT INTO $db[obras]
        VALUES (1,'Miguel de Cervantes','Don Quijote','Cátedra')",
    "INSERT INTO $db[obras]
        VALUES (2,'Jorge Luis Borges','Ficciones','Ed Sudamericana')",
    "INSERT INTO $db[prestamos]
        VALUES (1, 1, 1,'" . date("Y-m-d", time() - 4 * 60 * 60 * 24) . "','" . date("Y-m-d", time() - 3 * 60 * 60 * 24) . "')",
    "INSERT INTO $db[prestamos]
        VALUES (2, 2, 2,'" . date("Y-m-d", time() - 4 * 60 * 60 * 24) . "','" . date("Y-m-d", time() - 2 * 60 * 60 * 24) . "')",
    "INSERT INTO $db[prestamos]
        VALUES (3, 2, 1,'" . date("Y-m-d", time() - 1 * 60 * 60 * 24) . "','0000-00-00')",
];

// Funciones comunes

function recoge($var, $m = "")
{
    if (!isset($_REQUEST[$var])) {
        $tmp = (is_array($m)) ? [] : "";
    } elseif (!is_array($_REQUEST[$var])) {
        $tmp = trim(htmlspecialchars($_REQUEST[$var], ENT_QUOTES, "UTF-8"));
    } else {
        $tmp = $_REQUEST[$var];
        array_walk_recursive($tmp, function (&$valor) {
            $valor = trim(htmlspecialchars($valor, ENT_QUOTES, "UTF-8"));
        });
    }
    return $tmp;
}

function recogeValores($var, $valoresValidos, $valorPredeterminado)
{
    foreach ($valoresValidos as $valorValido) {
        if (isset($_REQUEST[$var]) && $_REQUEST[$var] == $valorValido) {
            return $valorValido;
        }
    }
    return $valorPredeterminado;
}

function compruebaSesion($nivel, $profundidad)
{
    global $cfg;

    session_name($cfg["sessionName"]);
    session_start();
    if (!isset($_SESSION["conectado"]) || $_SESSION["conectado"] < $nivel) {
        $destino = "Location:";
        for ($i = 0; $i < $profundidad; $i++) {
            $destino .= "../";
        }
        $destino .= "index.php";
        header($destino);
        exit;
    }
}

function compruebaNoSesion($profundidad)
{
    global $cfg;

    session_name($cfg["sessionName"]);
    session_start();
    if (isset($_SESSION["conectado"])) {
        $destino = "Location:";
        for ($i = 0; $i < $profundidad; $i++) {
            $destino .= "../";
        }
        $destino .= "index.php";
        header($destino);
        exit;
    }
}

function borraTodo($incluyeDemo)
{
    global $db;

    $pdo = conectaDb();
    foreach ($db["consultasBorraTodo"] as $consulta) {
        if (!$pdo->query($consulta)) {
            print "    <p class=\"aviso-error\">Error en la consulta: $consulta</p>\n";
            print "\n";
        }
    }
    if ($incluyeDemo) {
        foreach ($db["consultasValoresDemo"] as $consulta) {
            if (!$pdo->query($consulta)) {
                print "    <p class=\"aviso-error\">Error en la consulta: $consulta</p>\n";
                print "\n";
            }
        }
    }
    $pdo = null;
}

function cabecera($texto, $menu, $profundidadDirectorio)
{
    print "<!DOCTYPE html>\n";
    print "<html lang=\"es\">\n";
    print "<head>\n";
    print "  <meta charset=\"utf-8\">\n";
    print "  <title>\n";
    print "    $texto. Biblioteca-4.\n";
    print "    Ejercicios. PHP. Bartolomé Sintes Marco. www.mclibre.org\n";
    print "  </title>\n";
    print "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n";
    if ($profundidadDirectorio == 0) {
        print "  <link rel=\"stylesheet\" href=\"comunes/mclibre-php-proyectos.css.php\" title=\"Color\" />\n";
    } elseif ($profundidadDirectorio == 1) {
        print "  <link rel=\"stylesheet\" href=\"../comunes/mclibre-php-proyectos.css.php\" title=\"Color\" />\n";
    } elseif ($profundidadDirectorio == 2) {
        print "  <link rel=\"stylesheet\" href=\"../../comunes/mclibre-php-proyectos.css.php\" title=\"Color\" />\n";
    }

    print "</head>\n";
    print "\n";
    print "<body>\n";
    print "  <header>\n";
    print "    <h1>Biblioteca-4 - $texto</h1>\n";
    print "\n";
    print "    <nav>\n";
    print "      <ul>\n";
    if (!isset($_SESSION["conectado"])) {
        if ($menu == MENU_PRINCIPAL) {
            print "        <li><a href=\"acceso/login-1.php\">Conectarse</a></li>\n";
        } elseif ($menu == MENU_VOLVER) {
            print "        <li><a href=\"../index.php\">Volver</a></li>\n";
        } else {
            print "        <li>Error en la selección de menú</li>\n";
        }
    } elseif ($_SESSION["conectado"] == NIVEL_1) {
        if ($menu == MENU_PRINCIPAL) {
            print "        <li><a href=\"acceso/login-1.php\">Conectarse</a></li>\n";
        } elseif ($menu == MENU_PRINCIPAL_CONECTADO) {
            print "        <li><a href=\"tablas/db-obras/index.php\">Obras</a></li>\n";
            print "        <li><a href=\"acceso/logout.php\" data-test-id=\"desconectarse\">Desconectarse</a></li>\n";
        } elseif ($menu == MENU_VOLVER) {
            print "        <li><a href=\"../index.php\">Volver</a></li>\n";
        } elseif ($menu == MENU_OBRAS) {
            print "        <li><a href=\"../../index.php\">Volver</a></li>\n";
            print "        <li><a href=\"listar.php\">Listar</a></li>\n";
        } else {
            print "        <li>Error en la selección de menú</li>\n";
        }
    } elseif ($_SESSION["conectado"] == NIVEL_2) {
        if ($menu == MENU_PRINCIPAL) {
            print "        <li><a href=\"acceso/login-1.php\">Conectarse</a></li>\n";
        } elseif ($menu == MENU_PRINCIPAL_CONECTADO) {
            print "        <li><a href=\"tablas/db-personas/index.php\">Personas</a></li>\n";
            print "        <li><a href=\"tablas/db-obras/index.php\">Obras</a></li>\n";
            print "        <li><a href=\"tablas/db-prestamos/index.php\">Préstamos</a></li>\n";
            print "        <li><a href=\"acceso/logout.php\" data-test-id=\"desconectarse\">Desconectarse</a></li>\n";
        } elseif ($menu == MENU_VOLVER) {
            print "        <li><a href=\"../../index.php\">Volver</a></li>\n";
        } elseif ($menu == MENU_PERSONAS) {
            print "        <li><a href=\"../../index.php\">Volver</a></li>\n";
            print "        <li><a href=\"listar.php\">Listar</a></li>\n";
            print "        <li><a href=\"buscar-1.php\">Buscar</a></li>\n";
        } elseif ($menu == MENU_OBRAS) {
            print "        <li><a href=\"../../index.php\">Volver</a></li>\n";
            print "        <li><a href=\"listar.php\">Listar</a></li>\n";
            print "        <li><a href=\"buscar-1.php\">Buscar</a></li>\n";
        } elseif ($menu == MENU_PRESTAMOS) {
            print "        <li><a href=\"../../index.php\">Volver</a></li>\n";
            print "        <li><a href=\"listar.php\">Listar</a></li>\n";
            print "        <li><a href=\"buscar-1.php\">Buscar</a></li>\n";
        } else {
            print "        <li>Error en la selección de menú</li>\n";
        }
    } elseif ($_SESSION["conectado"] == NIVEL_3) {
        if ($menu == MENU_PRINCIPAL) {
            print "        <li><a href=\"acceso/login-1.php\">Conectarse</a></li>\n";
        } elseif ($menu == MENU_PRINCIPAL_CONECTADO) {
            print "        <li><a href=\"tablas/db-personas/index.php\">Personas</a></li>\n";
            print "        <li><a href=\"tablas/db-obras/index.php\">Obras</a></li>\n";
            print "        <li><a href=\"tablas/db-prestamos/index.php\">Préstamos</a></li>\n";
            print "        <li><a href=\"tablas/db-usuarios/index.php\">Usuarios</a></li>\n";
            print "        <li><a href=\"administrador/index.php\">Administrador</a></li>\n";
            print "        <li><a href=\"acceso/logout.php\" data-test-id=\"desconectarse\">Desconectarse</a></li>\n";
        } elseif ($menu == MENU_VOLVER) {
            print "        <li><a href=\"../../index.php\">Volver</a></li>\n";
        } elseif ($menu == MENU_PERSONAS) {
            print "        <li><a href=\"../../index.php\">Volver</a></li>\n";
            print "        <li><a href=\"insertar-1.php\">Añadir registro</a></li>\n";
            print "        <li><a href=\"listar.php\">Listar</a></li>\n";
            print "        <li><a href=\"borrar-1.php\">Borrar</a></li>\n";
            print "        <li><a href=\"buscar-1.php\">Buscar</a></li>\n";
            print "        <li><a href=\"modificar-1.php\">Modificar</a></li>\n";
        } elseif ($menu == MENU_OBRAS) {
            print "        <li><a href=\"../../index.php\">Volver</a></li>\n";
            print "        <li><a href=\"insertar-1.php\">Añadir registro</a></li>\n";
            print "        <li><a href=\"listar.php\">Listar</a></li>\n";
            print "        <li><a href=\"borrar-1.php\">Borrar</a></li>\n";
            print "        <li><a href=\"buscar-1.php\">Buscar</a></li>\n";
            print "        <li><a href=\"modificar-1.php\">Modificar</a></li>\n";
        } elseif ($menu == MENU_PRESTAMOS) {
            print "        <li><a href=\"../../index.php\">Volver</a></li>\n";
            print "        <li><a href=\"insertar-1.php\">Nuevo préstamo</a></li>\n";
            print "        <li><a href=\"devolver-1.php\">Nueva devolución</a></li>\n";
            print "        <li><a href=\"listar.php\">Listar</a></li>\n";
            print "        <li><a href=\"borrar-1.php\">Borrar</a></li>\n";
            print "        <li><a href=\"buscar-1.php\">Buscar</a></li>\n";
            print "        <li><a href=\"modificar-1.php\">Modificar</a></li>\n";
        } elseif ($menu == MENU_USUARIOS) {
            print "        <li><a href=\"../../index.php\">Volver</a></li>\n";
            print "        <li><a href=\"insertar-1.php\">Añadir registro</a></li>\n";
            print "        <li><a href=\"listar.php\">Listar</a></li>\n";
            print "        <li><a href=\"borrar-1.php\">Borrar</a></li>\n";
            print "        <li><a href=\"buscar-1.php\">Buscar</a></li>\n";
            print "        <li><a href=\"modificar-1.php\">Modificar</a></li>\n";
        } elseif ($menu == MENU_ADMINISTRADOR) {
            print "        <li><a href=\"../index.php\">Volver</a></li>\n";
            print "        <li><a href=\"calendario.php\">Calendario</a></li>\n";
            print "        <li><a href=\"borrar-todo-1.php\">Borrar todo</a></li>\n";
        } else {
            print "        <li>Error en la selección de menú</li>\n";
        }
    } else {
        print "        <li>Error en la selección de menú</li>\n";
    }
    print "      </ul>\n";
    print "    </nav>\n";
    print "  </header>\n";
    print "\n";
    print "  <main>\n";
}

function pie()
{
    print "  </main>\n";
    print "\n";
    print "  <footer>\n";
    print "    <p class=\"ultmod\">\n";
    print "      Última modificación de esta página:\n";
    print "      <time datetime=\"2021-04-22\">22 de abril de 2021</time>\n";
    print "    </p>\n";
    print "\n";
    print "    <p class=\"licencia\">\n";
    print "      Este programa forma parte del curso <strong><a href=\"https://www.mclibre.org/consultar/php/\">Programación \n";
    print "      web en PHP</a></strong> de <a href=\"https://www.mclibre.org/\" rel=\"author\">Bartolomé Sintes Marco</a>.<br>\n";
    print "      El programa PHP que genera esta página se distribuye bajo \n";
    print "      <a rel=\"license\" href=\"http://www.gnu.org/licenses/agpl.txt\">licencia AGPL 3 o posterior</a>.\n";
    print "    </p>\n";
    print "  </footer>\n";
    print "</body>\n";
    print "</html>";
}

function encripta($cadena)
{
    global $cfg;

    return hash($cfg["hashAlgorithm"], $cadena);
}

require_once "tablas-comprobaciones.php";
