<?php
/**
 * RMM-0 - Agenda multiusuario (Servidor) - biblioteca.php
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

define("OK", 1);
define("KO", 0);

define("MYSQL",          "MySQL");         // Base de datos MySQL
define("SQLITE",         "SQLite");        // Base de datos SQLITE

define("NIVEL_1",           "1");          // Usuario web de nivel Usuario
define("NIVEL_2",           "2");          // Usuario web de nivel Administrador
define("NIVEL_3",           "3");          // Usuario web de nivel Gran Jefe

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

// Biblioteca base de datos

if ($dbMotor == MYSQL) {
    require_once "biblioteca-mysql.php";
} elseif ($dbMotor == SQLITE) {
    require_once "biblioteca-sqlite.php";
}

// Funciones comunes

function encripta($var)
{
    // Si se cambia el algortimo de encriptación hay que cambiar $tamPassword
    // Esta función también está en cliente/biblioteca.php
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

function comprueba($campo, $valor)
{
    global $tamUsuariosWebUsuario, $tamUsuariosWebPassword,
        $tamAgendaNombre, $tamAgendaApellidos, $tamAgendaTelefono;

    $mensajes = [];
    $todoOk = OK;

    if ($campo == "usuario") {
        if ($valor == "") {
            $mensajes[] = ["resultado" => KO, "texto" => "El nombre de usuario no puede estar vacío."];
            $todoOk = KO;
        } elseif (mb_strlen("usuario", "UTF-8") > $tamUsuariosWebUsuario) {
            $mensajes[] = ["resultado" => KO, "texto" => "El nombre de usuario no puede tener más de $tamUsuariosWebUsuario caracteres."];
            $todoOk = KO;
        } else {
            $mensajes[] = ["resultado" => OK, "texto" => "El nombre de usuario parece admisible."];
        }
    } elseif ($campo == "password") {
        if ($valor == "") {
            $mensajes[] = ["resultado" => KO, "texto" => "La contraseña no puede estar vacía."];
            $todoOk = KO;
         } elseif (mb_strlen("usuario", "UTF-8") > $tamUsuariosWebPassword) {
            $mensajes[] = ["resultado" => KO, "texto" => "La contraseña no puede tener más de $tamUsuariosWebPassword caracteres."];
            $todoOk = KO;
        } else {
            $mensajes[] = ["resultado" => OK, "texto" => "La contraseña parece  admisible."];
        }
    } elseif ($campo == "nivel") {
        if ($valor != NIVEL_1 && $valor != NIVEL_2 && $valor != NIVEL_3) {
            $mensajes[] = ["resultado" => KO, "texto" => "Nivel incorrecto."];
            $todoOk = KO;
        } else {
            $mensajes[] = ["resultado" => OK, "texto" => "El nombre de usuario parece admisible."];
        }
    } elseif ($campo == "nombre") {
        if (mb_strlen($valor, "UTF-8") > $tamAgendaNombre) {
            $mensajes[] = ["resultado" => KO, "texto" => "El nombre no puede tener más de $tamAgendaNombre caracteres."];
            $todoOk = KO;
        } else {
            $mensajes[] = ["resultado" => OK, "texto" => "El nombre parece admisible."];
        }
    } elseif ($campo == "apellidos") {
        if (mb_strlen($valor, "UTF-8") > $tamAgendaApellidos) {
            $mensajes[] = ["resultado" => KO, "texto" => "Los apellidos no pueden tener más de $tamAgendaApellidos caracteres."];
            $todoOk = KO;
        } else {
            $mensajes[] = ["resultado" => OK, "texto" => "Los apellidos parecen admisibles."];
        }
    } elseif ($campo == "telefono") {
        if (mb_strlen("telefono", "UTF-8") > $tamAgendaTelefono) {
            $mensajes[] = ["resultado" => KO, "texto" => "El teléfono no puede tener más de $tamAgendaTelefono caracteres."];
            $todoOk = KO;
        } else {
            $mensajes[] = ["resultado" => OK, "texto" => "El teléfono parece admisible."];
        }
    }

    return [$todoOk, $mensajes];
}
