<?php
/**
 * RMM-0 - Agenda (Servidor) - biblioteca-mysql.php
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

$dbDb    = MYSQL_DATABASE;                     // Nombre de la base de datos
$dbTabla = MYSQL_DATABASE . "." . MYSQL_TABLA; // Nombre de la tabla

// Consultas

$consultaCreaDb = "CREATE DATABASE $dbDb
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci";

$consultaCreaTabla = "CREATE TABLE $dbTabla (
    id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR($tamNombre),
    apellidos VARCHAR($tamApellidos),
    telefono VARCHAR($tamTelefono),
    PRIMARY KEY(id)
    )";

// Funciones comunes de bases de datos (MYSQL)

function conectaDb()
{
    try {
        $tmp = new PDO(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
        $tmp->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        $tmp->exec("set names utf8mb4");
        $resultado = ["resultado" => OK, "mensajes" => [["resultado" => "OK", "texto" => "Conexión con la base de datos realizada."]]];
        return ([$resultado, $tmp]);
    } catch (PDOException $e) {
        $resultado = ["resultado" => KO, "mensajes" => [["resultado" => "KO", "texto" => "No es posible conectar con la base de datos."]]];
        return [$resultado, null];
    }
}

function borraTodo($db)
{
    global $dbDb, $consultaCreaDb, $consultaCreaTabla;

    $mensajes = [];
    $todoOk = KO;

    $consulta = "DROP DATABASE $dbDb";
    if ($db->query($consulta)) {
        $mensajes[] = ["resultado" => OK, "texto" => "Base de datos borrada correctamente."];
        $todoOk1 = OK;
    } else {
        $mensajes[] = ["resultado" => KO, "texto" => "Error al borrar la base de datos."];
        $todoOk1 = KO;
    }

    $consulta = $consultaCreaDb;
    if ($db->query($consulta)) {
        $mensajes[] = ["resultado" => OK, "texto" => "Base de datos creada correctamente."];
        $todoOk2 = OK;
        $consulta = $consultaCreaTabla;
        if ($db->query($consulta)) {
            $mensajes[] = ["resultado" => OK, "texto" => "Tabla creada correctamente."];
            $todoOk3 = OK;
        } else {
            $mensajes[] = ["resultado" => KO, "texto" => "Error al crear la tabla."];
            $todoOk3 = KO;
        }
    } else {
        $mensajes[] = ["resultado" => KO, "texto" => "Error al crear la base de datos."];
        $todoOk2 = KO;
        $todoOk3 = KO;
    }

    if ($todoOk1 == OK && $todoOk2 == OK && $todoOk3 == OK) {
        $todoOk = OK;
    }

    return ["resultado" => $todoOk, "mensajes" => $mensajes];

}
