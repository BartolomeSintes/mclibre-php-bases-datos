<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_2, PROFUNDIDAD_2);

cabecera("Préstamos - Buscar 1", MENU_PRESTAMOS, PROFUNDIDAD_2);

imprimeAvisosGenerales("prestamos", "buscar-2");

borraAvisosExcepto("prestamos", "buscar-2");

compruebaAvisosGenerales("prestamos", "buscar-1", "sinRegistros", );

imprimeAvisosGenerales("prestamos", "buscar-1");

if (muestraFormulario("prestamos", "buscar-1")) {
    print "    <form action=\"buscar-2.php\" method=\"$cfg[formMethod]\">\n";
    print "      <p>Escriba el criterio de búsqueda (caracteres o números):</p>\n";
    print "\n";
    print "      <table>\n";
    print "        <tbody>\n";
    print "          <tr>\n";
    print "            <td>Persona - Nombre:</td>\n";
    print "            <td><input type=\"text\" name=\"nombre\" size=\"$db[tamPersonasNombre]\" maxlength=\"$db[tamPersonasNombre]\""
        . imprimeAvisosIndividuales("prestamos", "buscar-2", "nombre", "valor") . " autofocus></td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Persona - Apellidos:</td>\n";
    print "            <td><input type=\"text\" name=\"apellidos\" size=\"$db[tamPersonasApellidos]\" maxlength=\"$db[tamPersonasApellidos]\""
        . imprimeAvisosIndividuales("prestamos", "buscar-2", "apellidos", "valor") . "></td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Obra - Autor:</td>\n";
    print "            <td><input type=\"text\" name=\"autor\" size=\"$db[tamObrasAutor]\" maxlength=\"$db[tamObrasAutor]\""
        . imprimeAvisosIndividuales("prestamos", "buscar-2", "autor", "valor") . "></td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Obra - Título:</td>\n";
    print "            <td><input type=\"text\" name=\"titulo\" size=\"$db[tamObrasTitulo]\" maxlength=\"$db[tamObrasTitulo]\""
        . imprimeAvisosIndividuales("prestamos", "buscar-2", "titulo", "valor") . "></td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Fecha de préstamo:</td>\n";
    print "            <td>Entre <input type=\"date\" name=\"prestado_1\"> y <input type=\"date\" name=\"prestado_2\"></td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Fecha de devolución:</td>\n";
    print "            <td>Entre <input type=\"date\" name=\"devuelto_1\"> y <input type=\"date\" name=\"devuelto_2\"></td>\n";
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
