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

$pdo = conectaDb();
cabecera("Usuarios - Añadir 1", MENU_USUARIOS, 2);

if (compruebaLimiteRegistros("usuarios")) {
    print "    <p class=\"aviso\">{$_SESSION["error"]["maxRegTabla"]["mensaje"]}</p>\n";
} else {
    print "    <form action=\"insertar-2.php\" method=\"$cfg[formMethod]\">\n";
    if (isset($_SESSION["error"]["avisoGeneral"])) {
        print "    <p class=\"aviso\">{$_SESSION["error"]["avisoGeneral"]["mensaje"]}</p>\n";
    }
    print "      <p>Escriba los datos del nuevo registro:</p>\n";
    print "\n";
    print "      <table>\n";
    print "        <tbody>\n";
    print "          <tr>\n";
    print "            <td>Usuario:</td>\n";
    if (isset($_SESSION["error"]["usuario"])) {
        print "            <td><input type=\"text\" name=\"usuario\" size=\"$db[tamUsuariosUsuario]\" maxlength=\"$db[tamUsuariosUsuario]\" value=\"{$_SESSION["error"]["usuario"]["valor"]}\" autofocus>\n";
        print "              <span class=\"aviso\">{$_SESSION["error"]["usuario"]["mensaje"]}</span></td>\n";
    } else {
        print "            <td><input type=\"text\" name=\"usuario\" size=\"$db[tamUsuariosUsuario]\" maxlength=\"$db[tamUsuariosUsuario]\" autofocus></td>\n";
    }
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Contraseña:</td>\n";
    if (isset($_SESSION["error"]["password"])) {
        print "            <td><input type=\"text\" name=\"password\" size=\"$db[tamUsuariosPassword]\" maxlength=\"$db[tamUsuariosPassword]\" value=\"{$_SESSION["error"]["password"]["valor"]}\" autofocus>\n";
        print "              <span class=\"aviso\">{$_SESSION["error"]["password"]["mensaje"]}</span></td>\n";
    } else {
        print "            <td><input type=\"text\" name=\"password\" size=\"$db[tamUsuariosPassword]\" maxlength=\"$db[tamUsuariosPassword]\" autofocus></td>\n";
    }
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Nivel:</td>\n";
    print "            <td>\n";
    print "              <select name=\"nivel\">\n";
    foreach ($usuariosNiveles as $indice => $valor) {
        print "                <option value=\"$valor\">$indice</option>\n";
    }
    print "              </select>\n";
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
unset($_SESSION["error"]);
$pdo = null;
pie();
