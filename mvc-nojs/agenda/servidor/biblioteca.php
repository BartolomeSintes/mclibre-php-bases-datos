<?php
/**
 * Agenda - biblioteca.php
 *
 * @author    Bartolomé Sintes Marco <bartolome.sintes+mclibre@gmail.com>
 * @copyright 2018 Bartolomé Sintes Marco
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @version   2018-12-09
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
define("NOK", 0);

define("MYSQL",          "MySQL");         // Base de datos MySQL
define("SQLITE",         "SQLite");        // Base de datos SQLITE

define("MENU_PRINCIPAL", "menuPrincipal"); // Menú principal
define("MENU_VOLVER",    "menuVolver");    // Menú Volver a inicio

$columnas = [                              // Nombre de las columnas de la tabla
    "nombre",
    "apellidos",
    "telefono"
];

$orden = ["ASC", "DESC"];                // Valores de ordenación

// Constantes y variables configurables

require_once "config.php";

// Biblioteca base de datos

if ($dbMotor == MYSQL) {
    require_once "biblioteca-mysql.php";
} elseif ($dbMotor == SQLITE) {
    require_once "biblioteca-sqlite.php";
}

// Funciones comunes

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

function comprueba($campo, $valor)
{
    global $tamNombre, $tamApellidos, $tamTelefono;

    $mensajes = [];
    $todoOk = OK;

    if ($campo == "nombre") {
        if (mb_strlen($valor, "UTF-8") > $tamNombre) {
            $mensajes[] = ["resultado" => NOK, "texto" => "El nombre no puede tener más de $tamNombre caracteres."];
            $todoOk = NOK;
        } else {
            $mensajes[] = ["resultado" => OK, "texto" => "El nombre parece admisible."];
        }
    } elseif ($campo == "apellidos") {
        if (mb_strlen($valor, "UTF-8") > $tamApellidos) {
            $mensajes[] = ["resultado" => NOK, "texto" => "Los apellidos no pueden tener más de $tamApellidos caracteres."];
            $todoOk = NOK;
        } else {
            $mensajes[] = ["resultado" => OK, "texto" => "Los apellidos parecen admisibles."];
        }
    } elseif ($campo == "telefono") {
        if (mb_strlen("telefono", "UTF-8") > $tamTelefono) {
            $mensajes[] = ["resultado" => NOK, "texto" => "El teléfono no puede tener más de $tamTelefono caracteres."];
            $todoOk = NOK;
        } else {
            $mensajes[] = ["resultado" => OK, "texto" => "El teléfono parece admisible."];
        }
    }

    return ["resultado" => $todoOk, "mensajes" => $mensajes];
}
