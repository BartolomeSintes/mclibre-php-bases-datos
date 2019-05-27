<?php
/**
 * RMM-0 - Agenda multiusuario (Servidor) - biblioteca-sqlite.php
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

// Variables globales


$dbDb               = SQLITE_DATABASE;            // Nombre de la base de datos
$dbTablaUsuariosWeb = SQLITE_TABLA_USUARIOS_WEB;  // Nombre de la tabla de Usuarios de la web
$dbTablaAgenda      = SQLITE_TABLA_AGENDA;        // Nombre de la tabla de Agenda

// Consultas

$consultaCreaTablaUsuariosWeb = "CREATE TABLE $dbTablaUsuariosWeb (
    usuario VARCHAR($tamUsuariosWebUsuario) PRIMARY KEY,
    password VARCHAR($tamUsuariosWebCifrado),
    nivel INTEGER NOT NULL
    )";

$consultaCreaTablaAgenda = "CREATE TABLE $dbTablaAgenda (
    id INTEGER PRIMARY KEY,
    usuario VARCHAR($tamUsuariosWebUsuario),
    nombre VARCHAR($tamAgendaNombre),
    apellidos VARCHAR($tamAgendaApellidos),
    telefono VARCHAR($tamAgendaTelefono),
    FOREIGN KEY(usuario) REFERENCES $dbTablaUsuariosWeb(usuario)
    ON DELETE CASCADE ON UPDATE CASCADE
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
        $resultado = ["resultado" => KO, "mensajes" => [["resultado" => "KO", "texto" => "No es posible conectar con la base de datos."]]];
        return [$resultado, null];
    }
}

function borraTodo($db)
{
    global $dbTablaUsuariosWeb, $consultaCreaTablaUsuariosWeb,
        $dbTablaAgenda, $consultaCreaTablaAgenda,
        $administradorNombre, $administradorPassword;

    $mensajes = [];
    $todoOk = KO;

    $consulta = "DROP TABLE $dbTablaUsuariosWeb";
    if ($db->query($consulta)) {
        $mensajes[] = ["resultado" => OK, "texto" => "Tabla <strong>Usuarios de la web</strong> borrada correctamente."];
        $todoOk1 = OK;
    } else {
        $mensajes[] = ["resultado" => KO, "texto" => "Error al borrar la tabla <strong>Usuarios de la web</strong>."];
        $todoOk1 = KO;
    }

    $consulta = "DROP TABLE $dbTablaAgenda";
    if ($db->query($consulta)) {
        $mensajes[] = ["resultado" => OK, "texto" => "Tabla <strong>Agenda</strong> borrada correctamente."];
        $todoOk2 = OK;
    } else {
        $mensajes[] = ["resultado" => KO, "texto" => "Error al borrar la tabla <strong>Agenda</strong>."];
        $todoOk2 = KO;
    }

    $consulta = $consultaCreaTablaUsuariosWeb;
    if ($db->query($consulta)) {
        $mensajes[] = ["resultado" => OK, "texto" => "Tabla <strong>Usuarios de la web</strong> creada correctamente."];
        $todoOk3 = OK;
    } else {
        $mensajes[] = ["resultado" => KO, "texto" => "Error al crear la tabla <strong>Usuarios de la web</strong>."];
        $todoOk3 = KO;
    }

    $consulta = $consultaCreaTablaAgenda;
    if ($db->query($consulta)) {
        $mensajes[] = ["resultado" => OK, "texto" => "Tabla <strong>Agenda</strong> creada correctamente."];
        $todoOk4 = OK;

        if ($administradorNombre != "") {
            $consulta = "INSERT INTO $dbTablaUsuariosWeb
                VALUES ('$administradorNombre', '" . encripta($administradorPassword) . "', '" . NIVEL_3 . "')";
            if ($db->query($consulta)) {
                $mensajes[] = ["resultado" => OK, "texto" => "Registro de <strong>Usuario root</strong> creado correctamente."];
                $todoOk5 = OK;
            } else {
                $mensajes[] = ["resultado" => OK, "texto" => "Error al crear el registro de <strong>Usuario root</strong>."];
                $todoOk5 = KO;
            }
        }
    } else {
        $mensajes[] = ["resultado" => KO, "texto" => "Error al crear la tabla de Agenda."];
        $todoOk4 = KO;
    }

    if ($todoOk1 == OK && $todoOk2 == OK && $todoOk3 == OK && $todoOk4 == OK &&$todoOk5) {
        $todoOk = OK;
    }

    return ["resultado" => $todoOk, "mensajes" => $mensajes];
}
