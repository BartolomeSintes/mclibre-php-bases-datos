<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

cabecera("Personas - Añadir 1", MENU_PERSONAS, PROFUNDIDAD_2);

imprimeAvisosGenerales("personas", "insertar-2");

borraAvisosExcepto("insertar-2");

compruebaAvisosGenerales("personas", "insertar-1", "limiteNumeroRegistros");

imprimeAvisosGenerales("personas", "insertar-1");

if (muestraFormulario()) {
    print "    <form action=\"insertar-2.php\" method=\"$cfg[formMethod]\">\n";
    print "      <p>Escriba los datos del nuevo registro:</p>\n";
    print "\n";
    print "      <table>\n";
    print "        <tbody>\n";
    print "          <tr>\n";
    print "            <td>Nombre:</td>\n";
    print "            <td><input type=\"text\" name=\"nombre\" size=\"$db[tamPersonasNombre]\" maxlength=\"$db[tamPersonasNombre]\""
    . imprimeAvisosIndividuales("personas", "insertar-2", "nombre", "valor") . " autofocus>"
    . imprimeAvisosIndividuales("personas", "insertar-2", "nombre", "mensaje") . "</td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Apellidos:</td>\n";
    print "            <td><input type=\"text\" name=\"apellidos\" size=\"$db[tamPersonasApellidos]\" maxlength=\"$db[tamPersonasApellidos]\""
    . imprimeAvisosIndividuales("personas", "insertar-2", "apellidos", "valor") . ">"
    . imprimeAvisosIndividuales("personas", "insertar-2", "apellidos", "mensaje") . "</td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>DNI:</td>\n";
    print "            <td><input type=\"text\" name=\"dni\" size=\"$db[tamPersonasDni]\" maxlength=\"$db[tamPersonasDni]\""
    . imprimeAvisosIndividuales("personas", "insertar-2", "dni", "valor") . ">"
    . imprimeAvisosIndividuales("personas", "insertar-2", "dni", "mensaje") . "</td>\n";
    print "          </tr>\n";
    print "        </tbody>\n";
    print "      </table>\n";
    print "\n";
    print "      <p>\n";
    print "        <input type=\"submit\" value=\"Añadir\">\n";
    print "        <input type=\"reset\" value=\"Reiniciar formulario\">\n";
    print "      </p>\n";
    print "    </form>\n";
}

pie();
