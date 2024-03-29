<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_2, PROFUNDIDAD_2);

cabecera("Personas - Buscar 1", MENU_PERSONAS, PROFUNDIDAD_2);

imprimeAvisosGenerales("personas", "buscar-2");

borraAvisosExcepto("personas", "buscar-2");

compruebaAvisosGenerales("personas", "buscar-1", "sinRegistros");

imprimeAvisosGenerales("personas", "buscar-1");

if (muestraFormulario("personas", "buscar-1")) {
    print "    <form action=\"buscar-2.php\" method=\"$cfg[formMethod]\">\n";
    print "      <p>Escriba el criterio de búsqueda (caracteres o números):</p>\n";
    print "\n";
    print "      <table>\n";
    print "        <tbody>\n";
    print "          <tr>\n";
    print "            <td>Nombre:</td>\n";
    print "            <td><input type=\"text\" name=\"nombre\" size=\"$db[tamPersonasNombre]\" maxlength=\"$db[tamPersonasNombre]\""
        . imprimeAvisosIndividuales("personas", "buscar-2", "nombre", "valor") . " autofocus></td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Apellidos:</td>\n";
    print "            <td><input type=\"text\" name=\"apellidos\" size=\"$db[tamPersonasApellidos]\" maxlength=\"$db[tamPersonasApellidos]\""
        . imprimeAvisosIndividuales("personas", "buscar-2", "apellidos", "valor") . "></td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>DNI:</td>\n";
    print "            <td><input type=\"text\" name=\"dni\" size=\"$db[tamPersonasDni]\" maxlength=\"$db[tamPersonasDni]\""
        . imprimeAvisosIndividuales("personas", "buscar-2", "dni", "valor") . "></td>\n";
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
