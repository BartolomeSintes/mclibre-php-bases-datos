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
cabecera("Préstamos - Añadir 1", MENU_PRESTAMOS, PROFUNDIDAD_2);

$consulta = "SELECT COUNT(*) FROM $db[tablaPrestamos]";
$result   = $pdo->query($consulta);
if (!$result) {
    print "    <p class=\"aviso\">Error en la consulta.</p>\n";
} elseif ($result->fetchColumn() >= $cfg["maxRegTablePrestamos"] ) {
    print "    <p class=\"aviso\">Se ha alcanzado el número máximo de registros que se pueden guardar.</p>\n";
    print "\n";
    print "    <p class=\"aviso\">Por favor, borre algún registro antes.</p>\n";
} else {
    $consulta2 = "SELECT * FROM $db[tablaPersonas] ORDER BY apellidos";
    $result2   = $pdo->query($consulta2);
    $consulta3 = "SELECT * FROM $db[tablaObras] ORDER BY autor";
    $result3   = $pdo->query($consulta3);
    if (!$result2) {
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } elseif (!$result3) {
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } else {
        print "    <form action=\"insertar-2.php\" method=\"$cfg[formMethod]\">\n";
        print "      <p>Escriba los datos del nuevo préstamo:</p>\n";
        print "\n";
        print "      <table>\n";
        print "        <tbody>\n";
        print "          <tr>\n";
        print "            <td>Persona:</td>\n";
        print "            <td>\n";
        print "            <select name=\"id_persona\">\n";
        print "                <option value=\"\"></option>\n";
        foreach ($result2 as $valor) {
            print "                <option value=\"$valor[id]\">$valor[nombre] $valor[apellidos]</option>\n";
        }
        print "              </select>\n";
        print "            </td>\n";
        print "          </tr>\n";
        print "          <tr>\n";
        print "            <td>Obra:</td>\n";
        print "            <td>\n";
        print "            <select name=\"id_obra\">\n";
        print "                <option value=\"\"></option>\n";
        foreach ($result3 as $valor) {
            print "                <option value=\"$valor[id]\">$valor[autor] - $valor[titulo]</option>\n";
        }
        print "              </select>\n";
        print "            </td>\n";
        print "          </tr>\n";
        print "          <tr>\n";
        print "            <td>Fecha de préstamo:</td>\n";
        print "            <td><input type=\"date\" name=\"prestado\" value=\"" . date("Y-m-j") . "\"></td>\n";
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
}

$pdo = null;
pie();
