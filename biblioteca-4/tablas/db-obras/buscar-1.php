<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_2, PROFUNDIDAD_2);

cabecera("Obras - Buscar 1", MENU_OBRAS, PROFUNDIDAD_2);

imprimeAvisosGenerales("obras", "buscar-2");

borraAvisosExcepto("obras", "buscar-2");

compruebaAvisosGenerales("obras", "buscar-1", "sinRegistros");

imprimeAvisosGenerales("obras", "buscar-1");

if (muestraFormulario("obras", "buscar-1")) {
    print "    <form action=\"buscar-2.php\" method=\"$cfg[formMethod]\">\n";
    print "      <p>Escriba el criterio de búsqueda (caracteres o números):</p>\n";
    print "\n";
    print "      <table>\n";
    print "        <tbody>\n";
    print "          <tr>\n";
    print "            <td>Autor:</td>\n";
    print "            <td><input type=\"text\" name=\"autor\" size=\"$db[tamObrasAutor]\" maxlength=\"$db[tamObrasAutor]\""
        . imprimeAvisosIndividuales("obras", "buscar-2", "autor", "valor") . " autofocus></td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Título:</td>\n";
    print "            <td><input type=\"text\" name=\"titulo\" size=\"$db[tamObrasTitulo]\" maxlength=\"$db[tamObrasTitulo]\""
        . imprimeAvisosIndividuales("obras", "buscar-2", "titulo", "valor") . "></td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Editorial:</td>\n";
    print "            <td><input type=\"text\" name=\"editorial\" size=\"$db[tamObrasEditorial]\" maxlength=\"$db[tamObrasEditorial]\""
        . imprimeAvisosIndividuales("obras", "buscar-2", "editorial", "valor") . "></td>\n";
    print "          </tr>\n";
    print "        </tbody>\n";
    print "      </table>\n";
    print "\n";
    print "      <p>\n";
    print "        <input type=\"submit\" value=\"Buscar\">\n";
    print "        <input type=\"reset\" value=\"Reiniciar formulario\">\n";
    print "      </p>\n";
    print "    </form>\n";
}

pie();
