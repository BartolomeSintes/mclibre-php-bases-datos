<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_1);

cabecera("Administrador - Borrar todo 1", MENU_ADMINISTRADOR, PROFUNDIDAD_1);

print "    <form action=\"borrar-todo-2.php\" method=\"$cfg[formMethod]\">\n";
print "      <p>Por favor, confirme que desea borrar todos los datos de la base de datos.</p>\n";
print "\n";
print "      <p>También puede incluir en la base de datos unos datos de prueba.</p>\n";
print "\n";
print "      <p><label><input type=\"checkbox\" name=\"demo\" checked> Incluir datos de prueba</label></p>\n";
print "\n";
print "      <p>Haga clic en Sí para borrar todo los datos.</p>\n";
print "      <p>\n";
print "        <input type=\"submit\" value=\"Sí\" name=\"borrar\">\n";
print "        <input type=\"submit\" value=\"No\" name=\"borrar\">\n";
print "      </p>\n";
print "    </form>\n";

pie();
