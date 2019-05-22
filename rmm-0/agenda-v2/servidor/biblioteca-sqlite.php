<?php
/**
 * RMM-0 - Agenda (Servidor) - biblioteca-sqlite.php
 *
 * @author    Bartolomé Sintes Marco <bartolome.sintes+mclibre@gmail.com>
 * @copyright 2018 Bartolomé Sintes Marco
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @version   2019-05-18
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

// Variables globales

$dbDb    = SQLITE_DATABASE;   // Nombre de la base de datos
$dbTabla = SQLITE_TABLA;      // Nombre de la tabla

// Consultas

$consultaCreaTabla = "CREATE TABLE $dbTabla (
    id INTEGER PRIMARY KEY,
    nombre VARCHAR($tamNombre),
    apellidos VARCHAR($tamApellidos),
    telefono VARCHAR($tamTelefono)
    )";

// Funciones comunes de bases de datos (SQLITE)

function conectaDb()
{
    global $dbDb;

    try {
        $tmp = new PDO("sqlite:" . $dbDb);
        $resultado = ["resultado" => OK, "mensajes" => [["resultado" => "OK", "texto" => "Conexión con la base de datos realizada."]]];
        return ([$resultado, $tmp]);
    } catch (PDOException $e) {
        $resultado = ["resultado" => NOK, "mensajes" => [["resultado" => "NOK", "texto" => "No es posible conectar con la base de datos."]]];
        return [$resultado, null];
    }
}

function borraTodo($db)
{
    global $dbTabla, $consultaCreaTabla;

    $mensajes = [];
    $todoOk = NOK;

    $consulta = "DROP TABLE $dbTabla";
    if ($db->query($consulta)) {
        $mensajes[] = ["resultado" => OK, "texto" => "Tabla borrada correctamente."];
        $todoOk1 = OK;
    } else {
        $mensajes[] = ["resultado" => NOK, "texto" => "Error al borrar la tabla."];
        $todoOk1 = NOK;
    }

    $consulta = $consultaCreaTabla;
    if ($db->query($consulta)) {
        $mensajes[] = ["resultado" => OK, "texto" => "Tabla creada correctamente."];
        $todoOk2 = OK;
    } else {
        $mensajes[] = ["resultado" => NOK, "texto" => "Error al borrar la tabla."];
        $todoOk2 = NOK;
    }

    if ($todoOk1 == OK && $todoOk2 == OK) {
        $todoOk = OK;
    }

    return ["resultado" => $todoOk, "mensajes" => $mensajes];
}
