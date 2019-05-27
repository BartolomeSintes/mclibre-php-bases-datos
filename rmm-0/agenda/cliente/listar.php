<?php
/**
 * RMM-0 - Agenda (Cliente) - listar.php
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

cabecera("Listar", MENU_VOLVER);

$columna = recogeValores("columna", $columnas, "apellidos");
$orden   = recogeValores("orden", $orden, "ASC");

$consulta = http_build_query([
    "accion"  => "seleccionar-registros-todos",
    "columna" => $columna,
    "orden"   => $orden
]);

$respuesta1 = file_get_contents("$urlServidor?$consulta");
$respuesta = json_decode($respuesta1, true);
// print "<pre>"; print_r($respuesta); print "</pre>";

if ($respuesta["resultado"] == KO) {
    print "    <p class=\"aviso\">{$respuesta["mensajes"][0]["texto"]}</p>\n";
} else {
    print "    <p>Listado completo de registros:</p>\n";
    print "\n";
    print "    <table class=\"conborde franjas\">\n";
    print "      <thead>\n";
    print "        <tr>\n";
    print "          <th>\n";
    print "            <a href=\"$_SERVER[PHP_SELF]?columna=nombre&amp;orden=ASC\">\n";
    print "              <img src=\"abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\" /></a>\n";
    print "            Nombre\n";
    print "            <a href=\"$_SERVER[PHP_SELF]?columna=nombre&amp;orden=DESC\">\n";
    print "              <img src=\"arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\" /></a>\n";
    print "          </th>\n";
    print "          <th>\n";
    print "            <a href=\"$_SERVER[PHP_SELF]?columna=apellidos&amp;orden=ASC\">\n";
    print "              <img src=\"abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\" /></a>\n";
    print "            Apellidos\n";
    print "            <a href=\"$_SERVER[PHP_SELF]?columna=apellidos&amp;orden=DESC\">\n";
    print "              <img src=\"arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\" /></a>\n";
    print "          </th>\n";
    print "          <th>\n";
    print "            <a href=\"$_SERVER[PHP_SELF]?columna=telefono&amp;orden=ASC\">\n";
    print "              <img src=\"abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\" /></a>\n";
    print "            Teléfono\n";
    print "            <a href=\"$_SERVER[PHP_SELF]?columna=telefono&amp;orden=DESC\">\n";
    print "              <img src=\"arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\" /></a>\n";
    print "          </th>\n";
    print "        </tr>\n";
    print "      </thead>\n";
    print "      <tbody>\n";
    foreach ($respuesta["registros"] as $valor) {
        print "        <tr>\n";
        print "          <td>$valor[nombre]</td>\n";
        print "          <td>$valor[apellidos]</td>\n";
        print "          <td>$valor[telefono]</td>\n";
        print "        </tr>\n";
    }
    print "      </tbody>\n";
    print "    </table>\n";
}

pie();
