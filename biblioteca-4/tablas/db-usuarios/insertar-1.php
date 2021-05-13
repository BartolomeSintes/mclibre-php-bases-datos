<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

cabecera("Usuarios - Añadir 1", MENU_USUARIOS, PROFUNDIDAD_2);

imprimeAvisosGenerales("usuarios", "insertar-2");

borraAvisosExcepto("usuarios", "insertar-2");

compruebaAvisosGenerales("usuarios", "insertar-1", "limiteNumeroRegistros");

imprimeAvisosGenerales("usuarios", "insertar-1");

if (muestraFormulario("usuarios", "insertar-1")) {
    print "    <form action=\"insertar-2.php\" method=\"$cfg[formMethod]\">\n";
    print "      <p>Escriba los datos del nuevo registro:</p>\n";
    print "\n";
    print "      <table>\n";
    print "        <tbody>\n";
    print "          <tr>\n";
    print "            <td>Usuario:</td>\n";
    print "            <td><input type=\"text\" name=\"usuario\" size=\"$db[tamUsuariosUsuario]\" maxlength=\"$db[tamUsuariosUsuario]\""
        . imprimeAvisosIndividuales("usuarios", "insertar-2", "usuario", "valor") . " autofocus>"
        . imprimeAvisosIndividuales("usuarios", "insertar-2", "usuario", "mensaje") . "</td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Contraseña:</td>\n";
    print "            <td><input type=\"text\" name=\"password\" size=\"$db[tamUsuariosPassword]\" maxlength=\"$db[tamUsuariosPassword]\""
        . imprimeAvisosIndividuales("usuarios", "insertar-2", "password", "valor") . ">"
        . imprimeAvisosIndividuales("usuarios", "insertar-2", "password", "mensaje") . "</td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Nivel:</td>\n";
    print "            <td>\n";
    print "              <select name=\"nivel\">\n";
    print "                <option value=\"\"></option>\n";
    foreach ($usuariosNiveles as $indice => $valor) {
        print "                <option value=\"$valor\" "
            . imprimeAvisosIndividuales("usuarios", "insertar-2", "nivel", "select", $valor) . ">$indice</option>\n";
    }
    print "              </select>" . imprimeAvisosIndividuales("usuarios", "insertar-2", "nivel", "mensaje") . "\n";
    print "            </td>\n";
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
