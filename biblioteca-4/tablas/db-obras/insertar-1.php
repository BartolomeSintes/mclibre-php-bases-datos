<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

cabecera("Obras - Añadir 1", MENU_OBRAS, PROFUNDIDAD_2);

borraAvisosExcepto("insertar-2");

imprimeAvisosGenerales("insertar-2");

compruebaAvisosGenerales("insertar-1", "limiteNumeroRegistros", "obras");

imprimeAvisosGenerales("insertar-1");

print "    <form action=\"insertar-2.php\" method=\"$cfg[formMethod]\">\n";
print "      <p>Escriba los datos del nuevo registro:</p>\n";
print "\n";
print "      <table>\n";
print "        <tbody>\n";
print "          <tr>\n";
print "            <td>Autor:</td>\n";
print "            <td><input type=\"text\" name=\"autor\" size=\"$db[tamObrasAutor]\" maxlength=\"$db[tamObrasAutor]\""
    . imprimeAvisosIndividuales("insertar-2", "obras", "autor", "valor") . " autofocus>"
    . imprimeAvisosIndividuales("insertar-2", "obras", "autor", "mensaje") . "</td>\n";
print "          </tr>\n";
print "          <tr>\n";
print "            <td>Título:</td>\n";
print "            <td><input type=\"text\" name=\"titulo\" size=\"$db[tamObrasTitulo]\" maxlength=\"$db[tamObrasTitulo]\""
    . imprimeAvisosIndividuales("insertar-2", "obras", "titulo", "valor") . ">"
    . imprimeAvisosIndividuales("insertar-2", "obras", "titulo", "mensaje") . "</td>\n";
print "          </tr>\n";
print "          <tr>\n";
print "            <td>Editorial:</td>\n";
print "            <td><input type=\"text\" name=\"editorial\" size=\"$db[tamObrasEditorial]\" maxlength=\"$db[tamObrasEditorial]\""
    . imprimeAvisosIndividuales("insertar-2", "obras", "editorial", "valor") . ">"
    . imprimeAvisosIndividuales("insertar-2", "obras", "editorial", "mensaje") . "</td>\n";
print "          </tr>\n";
print "        </tbody>\n";
print "      </table>\n";
print "\n";
print "      <p>\n";
print "        <input type=\"submit\" value=\"Añadir\">\n";
print "        <input type=\"reset\" value=\"Reiniciar formulario\">\n";
print "      </p>\n";
print "    </form>\n";

pie();
