<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

cabecera("Préstamos - Añadir 1", MENU_PRESTAMOS, PROFUNDIDAD_2);

borraAvisosExcepto("insertar-2");

compruebaAvisosGenerales("insertar-1", "limiteNumeroRegistros", "prestamos");

imprimeAvisosGenerales("insertar-1", "insertar-2");

$pdo = conectaDb();

$consulta2 = "SELECT * FROM $db[personas] ORDER BY apellidos";
$result2   = $pdo->query($consulta2);
$consulta3 = "SELECT * FROM $db[obras] ORDER BY autor";
$result3   = $pdo->query($consulta3);
if (!$result2) {
    print "    <p class=\"aviso-error\">Error en la consulta.</p>\n";
} elseif (!$result3) {
    print "    <p class=\"aviso-error\">Error en la consulta.</p>\n";
} else {
    print "    <form action=\"insertar-2.php\" method=\"$cfg[formMethod]\">\n";
    print "      <p>Escriba los datos del nuevo préstamo:</p>\n";
    print "\n";
    print "      <table>\n";
    print "        <tbody>\n";
    print "          <tr>\n";
    print "            <td>Persona:</td>\n";
    print "            <td>\n";
    print "              <select name=\"id_persona\">\n";
    print "                <option value=\"\"></option>\n";
    foreach ($result2 as $valor) {
        print "                <option value=\"$valor[id]\">$valor[nombre] $valor[apellidos]</option>\n";
    }
    print "              </select>" . imprimeAvisosIndividuales("insertar-2", "prestamos", "id_persona", "mensaje"). "\n";
    print "            </td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Obra:</td>\n";
    print "            <td>\n";
    print "              <select name=\"id_obra\">\n";
    print "                <option value=\"\"></option>\n";
    foreach ($result3 as $valor) {
        print "                <option value=\"$valor[id]\">$valor[autor] - $valor[titulo]</option>\n";
    }
    print "              </select>" . imprimeAvisosIndividuales("insertar-2", "prestamos", "id_obra", "mensaje") . "\n";
    print "            </td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Fecha de préstamo:</td>\n";
    print "            <td><input type=\"date\" name=\"prestado\" value=\"" . date("Y-m-j") . "\">"
        . imprimeAvisosIndividuales("insertar-2", "prestamos", "prestado", "mensaje"). "</td>\n";
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

$pdo = null;

pie();
