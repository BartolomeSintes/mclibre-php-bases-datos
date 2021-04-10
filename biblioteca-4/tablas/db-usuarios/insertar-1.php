<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

session_name($cfg["sessionName"]);
session_start();
if (!isset($_SESSION["conectado"]) || $_SESSION["conectado"] < NIVEL_3) {
    header("Location:../../index.php");
    exit;
}

cabecera("Usuarios - Añadir 1", MENU_USUARIOS, PROFUNDIDAD_2);

borraAvisos("insertar-2");
compruebaAvisosGenerales("insertar-1", "limiteNumeroRegistros", "usuarios");

imprimeAvisosGenerales();

print "    <form action=\"insertar-2.php\" method=\"$cfg[formMethod]\">\n";
print "      <p>Escriba los datos del nuevo registro:</p>\n";
print "\n";
print "      <table>\n";
print "        <tbody>\n";
print "          <tr>\n";
print "            <td>Usuario:</td>\n";
print "            <td><input type=\"text\" name=\"usuario\" size=\"$db[tamUsuariosUsuario]\" maxlength=\"$db[tamUsuariosUsuario]\""
    . imprimeAvisosIndividuales("usuario", "valor") . " autofocus>" . imprimeAvisosIndividuales("usuario", "mensaje") . "</td>\n";
print "          </tr>\n";
print "          <tr>\n";
print "            <td>Contraseña:</td>\n";
print "            <td><input type=\"text\" name=\"password\" size=\"$db[tamUsuariosPassword]\" maxlength=\"$db[tamUsuariosPassword]\""
    . imprimeAvisosIndividuales("password", "valor") . ">" . imprimeAvisosIndividuales("password", "mensaje") . "</td>\n";
print "          </tr>\n";
print "          <tr>\n";
print "            <td>Nivel:</td>\n";
print "            <td>\n";
print "              <select name=\"nivel\">\n";
foreach ($usuariosNiveles as $indice => $valor) {
    print "                <option value=\"$valor\">$indice</option>\n";
}
print "              </select>" . imprimeAvisosIndividuales("nivel", "mensaje") . "\n";
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

pie();
