<?php
/**
 * RMM-0 - Agenda (Cliente) - buscar-1.php
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

require_once "biblioteca.php";

cabecera("Buscar 1", MENU_VOLVER);

$consulta = http_build_query([
    "accion"  => "contar-registros-todos",
]);

$respuesta1 = file_get_contents("$urlServidor?$consulta");
$respuesta = json_decode($respuesta1, true);
// print "<pre>Respuesta: "; print_r($respuesta); print "</pre>";

if ($respuesta["resultado"] == KO) {
    print "    <p class=\"aviso\">{$respuesta["mensajes"][0]["texto"]}</p>\n";
} else {
    print "    <form action=\"buscar-2.php\" method=\"" . FORM_METHOD . "\">\n";
    print "      <p>Escriba el criterio de búsqueda (caracteres o números):</p>\n";
    print "\n";
    print "      <table>\n";
    print "        <tbody>\n";
    print "          <tr>\n";
    print "            <td>Nombre:</td>\n";
    print "            <td><input type=\"text\" name=\"nombre\" size=\"$tamNombre\" maxlength=\"$tamNombre\" autofocus></td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Apellidos:</td>\n";
    print "            <td><input type=\"text\" name=\"apellidos\" size=\"$tamApellidos\" maxlength=\"$tamApellidos\"></td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Teléfono:</td>\n";
    print "            <td><input type=\"text\" name=\"telefono\" size=\"$tamTelefono\" maxlength=\"$tamTelefono\"></td>\n";
    print "          </tr>\n";
    print "        </tbody>\n";
    print "      </table>\n";
    print "\n";
    print "      <p>\n";
    print "        <input type=\"hidden\" name=\"accion\" value=\"buscar-registros\">\n";
    print "        <input type=\"submit\" value=\"Buscar\">\n";
    print "        <input type=\"reset\" value=\"Reiniciar formulario\">\n";
    print "      </p>\n";
    print "    </form>\n";
}

pie();
