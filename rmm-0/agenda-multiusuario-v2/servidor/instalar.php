<?php
/**
 * RMM-0 - Agenda multiusuario (Servidor) - instalacion.php
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

require_once "datos-iniciales.php";

function cabecera()
{
    print "<!DOCTYPE html>\n";
    print "<html lang=\"es\">\n";
    print "<head>\n";
    print "  <meta charset=\"utf-8\" />\n";
    print "  <title>\n";
    print "    Instalación. \n";
    print "    Agenda multiusuario. RMM-0. Bases de datos.\n";
    print "    Ejercicios. PHP. Bartolomé Sintes Marco. www.mclibre.org\n";
    print "  </title>\n";
    print "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\n";
    print "  <style>html { font-family: sans-serif; .aviso { color: red; }</style>\n";
    print "</head>\n";
    print "\n";
    print "<body>\n";
}

function pie()
{
    print "</body>\n";
    print "</html>";
}

if (!isset($_REQUEST["si"]) && !isset($_REQUEST["resi"]) && !isset($_REQUEST["fin"])) {
    cabecera();
    print "  <form action=\"$_SERVER[PHP_SELF]\" method=\"POST\">\n";
    print "    <h1>Instalación de la aplicación - Paso 1/3</h1>\n";
    print "    <p>Escriba en el archivo <strong>config.php</strong> el nombre de usuario en MySQL/SQLITE y su contraseña y pulse el botón <strong>Instalar</strong>.</p>\n";
    print "    <p>Se creará el usuario administrador de nombre <strong>root</strong> con contraseña <strong>root</strong>.</p>\n";
    print "    <p>Una vez instalada la aplicación, borre la carpeta /instalacion.</p>\n";
    print "    <p><button type=\"submit\" value=\"Sí\" name=\"si\">Instalar aplicación</button></p>\n";
    print "  </form>\n";
    pie();
} elseif (isset($_REQUEST["si"])) {
    cabecera();
    print "  <form action=\"$_SERVER[PHP_SELF]\" method=\"POST\">\n";
    print "    <h1>Instalación de la aplicación - Paso 2/3</h1>\n";
    print "    <p>¿Está usted seguro? ¡Se borrará la base de datos anterior!</p>\n";
    print "    <p><button type=\"submit\" value=\"Sí\" name=\"resi\">Sí, Instalar aplicación</button></p>\n";
    print "  </form>\n";
    pie();
} elseif (isset($_REQUEST["resi"])) {
    cabecera();
    print "  <h1>Instalación de la aplicación - Paso 3/3</h1>\n";
    [$respuesta, $db] = conectaDb();
    if ($respuesta["resultado"] == KO) {
        print "  <p class=\"aviso\">{$respuesta["mensajes"][0]["texto"]}</p>\n";
    } else {
        foreach ($respuesta["mensajes"] as $mensajes) {
            print "  <p>{$mensajes["texto"]}</p>\n";
        }
        $respuesta = borraTodo($db);
        foreach ($respuesta["mensajes"] as $mensajes) {
            if ($respuesta["resultado"] == KO) {
                print "  <p class=\"aviso\">{$mensajes["texto"]}</p>\n";
            } else {
                print "  <p>{$mensajes["texto"]}</p>\n";
            }
        }
        print "  <p>En un sistema en producción, recuerde borrar este fichero <strong>instalar.php</strong>.</p>\n";
    }
    pie();
    $db = null;
} else {
    header("location:../index.php");
    exit();
}
