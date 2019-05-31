<?php
/**
 * RMM-0 - Agenda multiusuario (Cliente) - conectar-1.php
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
if (isset($_SESSION["id"])) {
    header("Location:../index.php");
    exit();
}

require_once "../comunes/biblioteca.php";

cabecera("Identificar 1", MENU_IDENTIFICAR, 1);

$consulta = http_build_query([
    "accion"  => "usuarios-campos"
]);

$respuesta1 = file_get_contents("$urlServidor?$consulta");
$respuesta = json_decode($respuesta1, true);
// print "<pre>Respuesta: "; print_r($respuesta); print "</pre>";

if ($respuesta["resultado"] == KO) {
    print "    <p class=\"aviso\">{$respuesta["mensajes"][0]["texto"]}</p>\n";
} else {
    $aviso = recoge("aviso");
    if ($aviso) {
        print "    <p class=\"aviso\">$aviso</p>\n";
        print "\n";
    }
    print "    <form action=\"conectar-2.php\" method=\"" . FORM_METHOD . "\">\n";
    print "      <p>Escriba su nombre de usuario y contraseña:</p>\n";
    print "\n";
    print "      <table>\n";
    print "        <tbody>\n";
    print "          <tr>\n";
    print "            <td>{$respuesta["estructura"]["columnas"][0][2]}:</td>\n";
    print "            <td><input type=\"text\" name=\"{$respuesta["estructura"]["columnas"][0][0]}\" size=\"{$respuesta["estructura"]["columnas"][0][1]}\" "
        . "maxlength=\"{$respuesta["estructura"]["columnas"][0][1]}\" autofocus/></td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>{$respuesta["estructura"]["columnas"][1][2]}:</td>\n";
    print "            <td><input type=\"{$respuesta["estructura"]["columnas"][1][0]}\" name=\"password\" size=\"{$respuesta["estructura"]["columnas"][1][1]}\" "
        . "maxlength=\"{$respuesta["estructura"]["columnas"][1][1]}\"></td>\n";
    print "          </tr>\n";
    print "        </tbody>\n";
    print "      </table>\n";
    print "\n";
    print "      <p>\n";
    print "        <input type=\"submit\" value=\"Identificar\">\n";
    print "        <input type=\"reset\" value=\"Borrar\">\n";
    print "      </p>\n";
    print "    </form>\n";
}
pie();
