<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../comunes/biblioteca.php";

compruebaNoSesion(PROFUNDIDAD_1);

cabecera("Login 1", MENU_VOLVER, PROFUNDIDAD_1);

if (!existenTablas()) {
    if ($cfg["insertaRegistrosDemo"]) {
        print "  <p>La base de datos no estaba creada. Se ha creado la base de datos, insertando registros de prueba.</p>\n";
    } else {
        print "<p>La base de datos no estaba creada. Se ha creado la base de datos.</p>\n";
    }
    print "\n";
    borraTodo($cfg["insertaRegistrosDemo"]);
}

borraAvisosExcepto("login-2");

imprimeAvisosGenerales("login-2");

print "    <form action=\"login-2.php\" method=\"$cfg[formMethod]\">\n";
print "      <p>Escriba su nombre de usuario y contraseña:</p>\n";
print "\n";
print "      <table>\n";
print "        <tbody>\n";
print "          <tr>\n";
print "            <td>Nombre:</td>\n";
print "            <td><input type=\"text\" name=\"usuario\" size=\"$db[tamUsuariosUsuario]\" "
    . "maxlength=\"$db[tamUsuariosUsuario]\" autofocus/></td>\n";
print "          </tr>\n";
print "          <tr>\n";
print "            <td>Contraseña:</td>\n";
print "            <td><input type=\"password\" name=\"password\" size=\"$db[tamUsuariosPassword]\" "
    . "maxlength=\"$db[tamUsuariosPassword]\" /></td>\n";
print "          </tr>\n";
print "        </tbody>\n";
print "      </table>\n";
print "\n";
print "      <p>\n";
print "        <input type=\"submit\" value=\"Identificar\" />\n";
print "        <input type=\"reset\" value=\"Borrar\" />\n";
print "      </p>\n";
print "    </form>\n";

pie();
