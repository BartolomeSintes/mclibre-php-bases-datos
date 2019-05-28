<?php
/**
 * RMM-0 - Agenda (Cliente) - modificar-1.php
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

require_once "biblioteca.php";

cabecera("Modificar 1", MENU_VOLVER);

$columna = recogeValores("columna", $columnas, "apellidos");
$orden   = recogeValores("orden", $orden, "ASC");

$consulta = http_build_query([
    "accion"  => "seleccionar-registros-todos",
    "columna" => $columna,
    "orden"   => $orden
]);

$respuesta1 = file_get_contents("$urlServidor?$consulta");
$respuesta = json_decode($respuesta1, true);
// print "<pre>Respuesta: "; print_r($respuesta); print "</pre>";

if ($respuesta["resultado"] == KO) {
    print "    <p class=\"aviso\">{$respuesta["mensajes"][0]["texto"]}</p>\n";
} else {
    print "    <form action=\"modificar-2.php\" method=\"" . FORM_METHOD . "\">\n";
    print "      <p>Indique el registro que quiera modificar:</p>\n";
    print "\n";
    print "      <table class=\"conborde franjas\">\n";
    print "        <thead>\n";
    print "          <tr>\n";
    print "            <th>Modificar</th>\n";
    foreach ($respuesta["estructura"]["columnas"] as $columna) {
        print "            <th>\n";
        print "              <a href=\"$_SERVER[PHP_SELF]?columna=$columna[0]&amp;orden=ASC\">\n";
        print "                <img src=\"abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\" /></a>\n";
        print "              $columna[2]\n";
        print "              <a href=\"$_SERVER[PHP_SELF]?columna=$columna[0]&amp;orden=DESC\">\n";
        print "                <img src=\"arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\" /></a>\n";
        print "            </th>\n";
    }
    print "          </tr>\n";
    print "        </thead>\n";
    print "        <tbody>\n";
    foreach ($respuesta["registros"] as $valor) {
        print "          <tr>\n";
        print "            <td class=\"centrado\"><input type=\"radio\" name=\"id\" value=\"$valor[id]\" /></td>\n";
        foreach ($respuesta["estructura"]["columnas"] as $columna) {
            print "            <td>{$valor[$columna[0]]}</td>\n";
        }
        print "          </tr>\n";
    }
    print "        </tbody>\n";
    print "      </table>\n";
    print "\n";
    print "      <p>\n";
    print "        <input type=\"hidden\" name=\"accion\" value=\"seleccionar-registro-id\" />\n";
    print "        <input type=\"submit\" value=\"Modificar registro\" />\n";
    print "        <input type=\"reset\" value=\"Reiniciar formulario\" />\n";
    print "      </p>\n";
    print "    </form>\n";
}

pie();
