<?php
/**
 * RMM-0 - Agenda multiusuario (Cliente) - db-usuarios/modificar-3.php
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

session_start();

require_once "../comunes/biblioteca.php";

if (!isset($_SESSION["nivel"]) || $_SESSION["nivel"] != NIVEL_3) {
    header("location:../index.php");
    exit();
}

cabecera("Tabla Usuarios - Modificar 3", MENU_TABLA_USUARIOS_WEB, 1);

$consulta = http_build_query([
    "accion"   => recoge("accion"),
    "id"       => recoge("id"),
    "usuario"  => recoge("usuario"),
    "password" => recoge("password"),
    "nivel"    => recoge("nivel")
]);

$respuesta1 = file_get_contents("$urlServidor?$consulta");
$respuesta = json_decode($respuesta1, true);
// print "<pre>Respuesta: "; print_r($respuesta); print "</pre>";

foreach ($respuesta["mensajes"] as $mensaje) {
    if ($mensaje["resultado"] == OK) {
        print "    <p>$mensaje[texto]</p>\n";
    } else {
        print "    <p class=\"aviso\">$mensaje[texto]</p>\n";
    }
}
pie();
