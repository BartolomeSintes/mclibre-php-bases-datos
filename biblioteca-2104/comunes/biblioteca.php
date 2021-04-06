<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

// Constantes comunes

define("GET", "get");                      // Formularios se envían con GET
define("POST", "post");                    // Formularios se envían con POST

define("MYSQL", "MySQL");                  // Base de datos MySQL
define("SQLITE", "SQLite");                // Base de datos SQLITE

define("MENU_PRINCIPAL", "menuPrincipal");                     // Menú principal sin conectar
define("MENU_PRINCIPAL_CONECTADO", "menuPrincipalConectado");  // Menú principal conectado
define("MENU_VOLVER", "menuVolver");                           // Menú Volver
define("MENU_USUARIOS", "menuUsuarios");                       // Menú Usuarios
define("MENU_ADMINISTRADOR", "menuAdministrador");             // Menú Administrador
define("MENU_PERSONAS", "menuPersonas");                       // Menú Personas
define("MENU_OBRAS", "menuObras");                             // Menú Obras
define("MENU_PRESTAMOS", "menuPrestamos");                     // Menú Préstamos

// Algoritmos de hash

define("SHA_256", "sha256");                               // Nombres de los algoritmos de hash
$hashSizes = [SHA_256 => 64];                              // Tamaños de los valores hash

// Niveles de usuarios
define("NIVEL_1", "1");                    // Usuario web de nivel Usuario básico
define("NIVEL_2", "2");                    // Usuario web de nivel Usuario avanzado
define("NIVEL_3", "3");                    // Usuario web de nivel Administrador

$usuariosNiveles = [
    "Usuario Básico"   => NIVEL_1,
    "Usuario Avanzado" => NIVEL_2,
    "Administrador"   => NIVEL_3,
];

$acciones = [
    "borrar-1",
    "borrar-2",
    "buscar-1",
    "buscar-2",
    "insertar-1-a",
    "insertar-1-b",
    "insertar-2",
    "listar",
    "modificar-1",
    "modificar-2",
    "modificar-3",
];

// Constantes y variables configurables

require_once "config.php";

// Biblioteca base de datos

if ($cfg["dbMotor"] == MYSQL) {
    require_once "biblioteca-mysql.php";
} elseif ($cfg["dbMotor"] == SQLITE) {
    require_once "biblioteca-sqlite.php";
}

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

function recogeValores($var, $valoresValidos, $valorPredeterminado = "")
{
    foreach ($valoresValidos as $valorValido) {
        if (isset($_REQUEST[$var]) && $_REQUEST[$var] == $valorValido) {
            return $valorValido;
        }
    }
    return $valorPredeterminado;
}

function cabecera($texto, $menu, $profundidadDirectorio)
{
    global $cfg;

    print "<!DOCTYPE html>\n";
    print "<html lang=\"es\">\n";
    print "<head>\n";
    print "  <meta charset=\"utf-8\">\n";
    print "  <title>\n";
    print "    $texto. Biblioteca.\n";
    print "    Ejercicios. PHP. Bartolomé Sintes Marco. www.mclibre.org\n";
    print "  </title>\n";
    print "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n";
    if ($profundidadDirectorio == 0) {
        print "  <link rel=\"stylesheet\" href=\"comunes/mclibre-php-proyectos.css.php\" title=\"$cfg[color]\" />\n";
    } elseif ($profundidadDirectorio == 1) {
        print "  <link rel=\"stylesheet\" href=\"../comunes/mclibre-php-proyectos.css.php\" title=\"$cfg[color]\" />\n";
    }
    print "</head>\n";
    print "\n";
    print "<body>\n";
    print "  <header>\n";
    print "    <h1>Biblioteca - $texto</h1>\n";
    print "\n";
    print "    <nav>\n";
    print "      <form action=\"../tablas/tablas.php\" method=\"$cfg[formMethod]\" class=\"enlace\">\n";
    print "        <ul>\n";
    if (!isset($_SESSION["conectado"])) {
        if ($menu == MENU_PRINCIPAL) {
            print "          <li><a href=\"acceso/login-1.php\">Conectarse</a></li>\n";
        } elseif ($menu == MENU_VOLVER) {
            print "          <li><a href=\"../index.php\">Volver</a></li>\n";
        } else {
            print "          <li>Error en la selección de menú</li>\n";
        }
    } elseif ($_SESSION["conectado"] == NIVEL_2) {
        if ($menu == MENU_PRINCIPAL) {
            print "          <li><a href=\"acceso/login-1.php\">Conectarse</a></li>\n";
        } elseif ($menu == MENU_PRINCIPAL_CONECTADO) {
            print "          <li><a href=\"db-obras/index.php\">Obras</a></li>\n";
            print "          <li><a href=\"acceso/logout.php\">Desconectarse</a></li>\n";
        } elseif ($menu == MENU_VOLVER) {
            print "          <li><a href=\"../index.php\">Volver</a></li>\n";
        } elseif ($menu == MENU_OBRAS) {
            print "          <li><a href=\"../index.php\">Volver</a></li>\n";
            print "          <li><a href=\"listar.php\">Listar</a></li>\n";
        } else {
            print "          <li>Error en la selección de menú</li>\n";
        }
    } else {
        if ($menu == MENU_PRINCIPAL) {
            print "          <li><a href=\"acceso/login-1.php\">Conectarse</a></li>\n";
        } elseif ($menu == MENU_PRINCIPAL_CONECTADO) {
            print "          <li><a href=\"db-personas/index.php\">Personas</a></li>\n";
            print "          <li><a href=\"db-obras/index.php\">Obras</a></li>\n";
            print "          <li><a href=\"db-prestamos/index.php\">Préstamos</a></li>\n";
            print "          <li><a href=\"db-usuarios/index.php\">Usuarios</a></li>\n";
            print "          <li><a href=\"administrador/index.php\">Administrador</a></li>\n";
            print "          <li><a href=\"acceso/logout.php\">Desconectarse</a></li>\n";
        } elseif ($menu == MENU_VOLVER) {
            print "          <li><a href=\"../index.php\">Volver</a></li>\n";
        } elseif ($menu == MENU_PERSONAS) {
            print "          <li class=\"oculto\"><input type=\"hidden\" name=\"tabla\" value=\"personas\"></li>\n";
            print "          <li><a href=\"../index.php\">Volver</a></li>\n";
            print "          <li><button type=\"submit\" name=\"accion\" value=\"insertar-1-a\">Añadir registro</button></li>\n";
            print "          <li><button type=\"submit\" name=\"accion\" value=\"listar\">Listar</button></li>\n";
            print "          <li><a href=\"borrar-1.php\">Borrar</a></li>\n";
            print "          <li><a href=\"buscar-1.php\">Buscar</a></li>\n";
            print "          <li><a href=\"modificar-1.php\">Modificar</a></li>\n";
        } elseif ($menu == MENU_OBRAS) {
            print "          <li class=\"oculto\"><input type=\"hidden\" name=\"tabla\" value=\"obras\"></li>\n";
            print "          <li><a href=\"../index.php\">Volver</a></li>\n";
            print "          <li><button type=\"submit\" name=\"accion\" value=\"insertar-1-a\">Añadir registro</button></li>\n";
            print "          <li><button type=\"submit\" name=\"accion\" value=\"listar\">Listar</button></li>\n";
            print "          <li><a href=\"borrar-1.php\">Borrar</a></li>\n";
            print "          <li><a href=\"buscar-1.php\">Buscar</a></li>\n";
            print "          <li><a href=\"modificar-1.php\">Modificar</a></li>\n";
        } elseif ($menu == MENU_PRESTAMOS) {
            print "          <li class=\"oculto\"><input type=\"hidden\" name=\"tabla\" value=\"prestamos\"></li>\n";
            print "          <li><a href=\"../index.php\">Volver</a></li>\n";
            print "          <li><button type=\"submit\" name=\"accion\" value=\"insertar-1-b\">Nuevo préstamo</button></li>\n";
            print "          <li><a href=\"devolver-1.php\">Nueva devolución</a></li>\n";
            print "          <li><button type=\"submit\" name=\"accion\" value=\"listar\">Listar</button></li>\n";
            print "          <li><a href=\"borrar-1.php\">Borrar</a></li>\n";
            print "          <li><a href=\"buscar-1.php\">Buscar</a></li>\n";
            print "          <li><a href=\"modificar-1.php\">Modificar</a></li>\n";
        } elseif ($menu == MENU_USUARIOS) {
            print "          <li class=\"oculto\"><input type=\"hidden\" name=\"tabla\" value=\"usuarios\"></li>\n";
            print "          <li><a href=\"../index.php\">Volver</a></li>\n";
            print "          <li><button type=\"submit\" name=\"accion\" value=\"insertar-1-a\">Añadir registro</button></li>\n";
            print "          <li><button type=\"submit\" name=\"accion\" value=\"listar\">Listar</button></li>\n";
            print "          <li><button type=\"submit\" name=\"accion\" value=\"borrar-1\">Borrar</button></li>\n";
            print "          <li><button type=\"submit\" name=\"accion\" value=\"buscar-1\">Buscar</button></li>\n";
            print "          <li><button type=\"submit\" name=\"accion\" value=\"modificar-1\">Modificar</button></li>\n";
        } elseif ($menu == MENU_ADMINISTRADOR) {
            print "          <li><a href=\"../index.php\">Volver</a></li>\n";
            print "          <li><a href=\"calendario.php\">Calendario</a></li>\n";
            print "          <li><a href=\"borrar-todo-1.php\">Borrar todo</a></li>\n";
        } else {
            print "          <li>Error en la selección de menú</li>\n";
        }
    }
    print "        </ul>\n";
    print "      </form>\n";
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
    print "      <time datetime=\"2021-04-02\">2 de abril de 2021</time>\n";
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

// Funciones de gestión de las tablas
require_once $cfg["urlBase"]."tablas/tablas-comprobaciones.php";
require_once $cfg["urlBase"]."tablas/tablas-consultas.php";
require_once $cfg["urlBase"]."tablas/tablas-fragmentos.php";
require_once $cfg["urlBase"]."tablas/tablas-argumentos.php";

require_once $cfg["urlBase"]."tablas/tablas-paginas.php";
