<?php
/**
 * RMM-0 - Agenda multiusuario (Cliente) - biblioteca.php
 *
 * @author    Bartolomé Sintes Marco <bartolome.sintes+mclibre@gmail.com>
 * @copyright 2019 Bartolomé Sintes Marco
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @version   2019-05-27
 * @link      http://www.mclibre.org
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// Constantes y variables globales

define("GET",    "get");                   // Formularios se envían con GET
define("POST",   "post");                  // Formularios se envían con POST

define("OK", 1);
define("KO", 0);

// PATH: Directorio base de la aplicación
$camino = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/";
$directorio = basename($camino);
$camino2 = preg_replace("/" . $directorio . "\/$/", "", $camino);
$directorio2 = basename($camino2);
$urlServidor = preg_replace("/" . $directorio2 . "\/$/", "", $camino2) . "servidor/index.php";

define("MENU_PRINCIPAL",          "menuPrincipal");        // Menú principal
define("MENU_INSTALAR",           "menuInstalar");         // Menú Instalar
define("MENU_IDENTIFICAR",        "menuIdentificar");      // Menú Indentificar usuario
define("MENU_GESTION_TABLAS",     "menuGestionTablas");    // Menú Gestión Tablas
define("MENU_TABLA_USUARIOS_WEB", "menuTablaUsuariosWeb"); // Menú Gestión Tabla Usuarios Web
define("MENU_TABLA_AGENDA",       "menuTablaAgenda");      // Menú Gestión Tabla Agenda
define("MENU_ERROR",              "menuError");            // Menú Error conexión con BD

define("NIVEL_1",           "1");                    // Usuario web de nivel Usuario
define("NIVEL_2",           "2");                    // Usuario web de nivel Administrador
define("NIVEL_3",           "3");                    // Usuario web de nivel Gran Jefe

$usuariosWebNiveles = [
    ["Usuario",       NIVEL_1],
    ["Administrador", NIVEL_2],
    ["Gran Jefe",     NIVEL_3]
];

$columnasUsuariosWeb = [             // Nombre de las columnas de la tabla Usuarios web
    "usuario",
    "password",
    "nivel"
];

$columnasAgenda = [                              // Nombre de las columnas de la tabla
    "nombre",
    "apellidos",
    "telefono"
];

$orden = ["ASC", "DESC"];                // Valores de ordenación

// Constantes y variables configurables

require_once "config.php";

// Funciones comunes

function cabecera($texto, $menu, $profundidadDirectorio)
{
    print "<!DOCTYPE html>\n";
    print "<html lang=\"es\">\n";
    print "<head>\n";
    print "  <meta charset=\"utf-8\">\n";
    print "  <title>\n";
    print "    $texto. \n";
    print "    Agenda multiusuario. RMM-0. Bases de datos.\n";
    print "    Ejercicios. PHP. Bartolomé Sintes Marco. www.mclibre.org\n";
    print "  </title>\n";
    print "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n";
    if ($profundidadDirectorio == 0) {
        print "  <link rel=\"stylesheet\" href=\"comunes/mclibre-php-proyectos.css\" title=\"Color\">\n";
    } else if ($profundidadDirectorio == 1) {
        print "  <link rel=\"stylesheet\" href=\"../comunes/mclibre-php-proyectos.css\" title=\"Color\">\n";
    }
    print "</head>\n";
    print "\n";
    print "<body>\n";
    print "  <header>\n";
    print "    <h1>Agenda multiusuario - $texto</h1>\n";
    print "\n";
    print "    <nav>\n";
    print "      <ul>\n";
    if (!isset($_SESSION["usuario"])) {
        if ($menu == MENU_PRINCIPAL) {
            print "        <li><a href=\"acceso/conectar-1.php\">Identificarse</a></li>\n";
        } elseif ($menu == MENU_INSTALAR) {
            print "        <li><a href=\"../index.php\">Inicio</a></li>\n";
        } elseif ($menu == MENU_IDENTIFICAR) {
            print "        <li><a href=\"../index.php\">Inicio</a></li>\n";
        } elseif ($menu == MENU_ERROR) {
            print "        <li><a href=\"../index.php\">Inicio 1</a></li>\n";
            print "        <li><a href=\"index.php\">Inicio 2</a></li>\n";
        } else {
            print "        <li>Error en la selección de menú</li>\n";
        }
    } elseif ($_SESSION["nivel"] == 1) {
        if ($menu == MENU_PRINCIPAL) {
            print "        <li><a href=\"insertar-1.php\">Añadir registro</a></li>\n";
            print "        <li><a href=\"listar.php\">Listar</a></li>\n";
            print "        <li><a href=\"borrar-1.php\">Borrar</a></li>\n";
            print "        <li><a href=\"buscar-1.php\">Buscar</a></li>\n";
            print "        <li><a href=\"modificar-1.php\">Modificar</a></li>\n";
            print "        <li><a href=\"acceso/salir.php\">Salir</a></li>\n";
        } elseif ($menu == MENU_VOLVER) {
            print "        <li><a href=\"index.php\">Página inicial</a></li>\n";
        } else {
            print "        <li>Error en la selección de menú</li>\n";
        }
    } elseif ($_SESSION["nivel"] == 2 || $_SESSION["nivel"] == 3) {
        if ($menu == MENU_PRINCIPAL) {
            print "        <li><a href=\"administrador/gestion-tablas.php\">Tablas</a></li>\n";
            print "        <li><a href=\"acceso/salir.php\">Salir</a></li>\n";
        } elseif ($menu == MENU_INSTALAR) {
            print "        <li><a href=\"../index.php\">Inicio</a></li>\n";
        } elseif ($menu == MENU_IDENTIFICAR) {
            print "        <li><a href=\"../index.php\">Inicio</a></li>\n";
        } elseif ($menu == MENU_GESTION_TABLAS) {
            print "        <li><a href=\"../index.php\">Inicio</a></li>\n";
            print "        <li><a href=\"../db-usuarios/index.php\">Usuarios</a></li>\n";
            print "        <li><a href=\"../db-agenda/index.php\">Agenda</a></li>\n";
        } elseif ($menu == MENU_TABLA_USUARIOS_WEB) {
            print "        <li><a href=\"../administrador/gestion-tablas.php\">Volver</a></li>\n";
            print "        <li><a href=\"insertar-1.php\">Añadir registro</a></li>\n";
            print "        <li><a href=\"listar.php\">Listar</a></li>\n";
            print "        <li><a href=\"borrar-1.php\">Borrar</a></li>\n";
            print "        <li><a href=\"buscar-1.php\">Buscar</a></li>\n";
            print "        <li><a href=\"modificar-1.php\">Modificar</a></li>\n";
        } elseif ($menu == MENU_TABLA_AGENDA) {
            print "        <li><a href=\"../administrador/gestion-tablas.php\">Volver</a></li>\n";
            print "        <li><a href=\"insertar-1.php\">Añadir registro</a></li>\n";
            print "        <li><a href=\"listar.php\">Listar</a></li>\n";
            print "        <li><a href=\"borrar-1.php\">Borrar</a></li>\n";
        } else {
            print "        <li>Error en la selección de menú</li>\n";
        }
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
    print "      <time datetime=\"2019-05-27\">27 de mayo de 2019</time>\n";
    print "    </p>\n";
    print "\n";
    print "    <p class=\"licencia\">\n";
    print "      Este programa forma parte del curso <strong><a href=\"http://www.mclibre.org/consultar/php/\">Programación \n";
    print "      web en PHP</a></strong> de <a href=\"http://www.mclibre.org/\" rel=\"author\" >Bartolomé Sintes Marco</a>.<br>\n";
    print "      El programa PHP que genera esta página se distribuye bajo \n";
    print "      <a rel=\"license\" href=\"http://www.gnu.org/licenses/agpl.txt\">licencia AGPL 3 o posterior</a>.\n";
    print "    </p>\n";
    print "  </footer>\n";
    print "</body>\n";
    print "</html>";
}

function encripta($var)
{
    // Si se cambia el algortimo de encriptación hay que cambiar $tamPassword
    // Esta función también está en servidor/biblioteca.php
    return (md5($var));
}

function recoge($var)
{
    $tmp = (isset($_REQUEST[$var]))
        ? trim(htmlspecialchars($_REQUEST[$var], ENT_QUOTES, "UTF-8"))
        : "";
    return $tmp;
}

function recogeMatriz($var)
{
    $tmpMatriz = [];
    if (isset($_REQUEST[$var]) && is_array($_REQUEST[$var])) {
        foreach ($_REQUEST[$var] as $indice => $valor) {
            $indiceLimpio = trim(htmlspecialchars($indice, ENT_QUOTES, "UTF-8"));
            $valorLimpio  = trim(htmlspecialchars($valor,  ENT_QUOTES, "UTF-8"));
            $tmpMatriz[$indiceLimpio] = $valorLimpio;
        }
    }
    return $tmpMatriz;
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
