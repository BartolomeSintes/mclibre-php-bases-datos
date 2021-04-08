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
cabecera("Préstamos - Devolver 1", MENU_PRESTAMOS, 2);

$ordena = recogeValores("ordena", $db["columnasPrestamosOrden"], "autor ASC");

$consulta = "SELECT COUNT(*) FROM $db[tablaPrestamos]
    WHERE devuelto='0000-00-00'";
$result = $pdo->query($consulta);
if (!$result) {
    print "    <p class=\"aviso\">Error en la consulta.</p>\n";
} elseif ($result->fetchColumn() == 0) {
    print "    <p>No hay obras pendientes de devolución.</p>\n";
} else {
    $consulta = "SELECT $db[tablaPrestamos].id as id,
            $db[tablaPersonas].nombre as nombre,
            $db[tablaPersonas].apellidos as apellidos,
            $db[tablaObras].titulo as titulo,
            $db[tablaObras].autor as autor,
            $db[tablaPrestamos].prestado as prestado,
            $db[tablaPrestamos].devuelto as devuelto
        FROM $db[tablaPersonas], $db[tablaObras], $db[tablaPrestamos]
        WHERE $db[tablaPrestamos].id_persona=$db[tablaPersonas].id
        AND $db[tablaPrestamos].id_obra=$db[tablaObras].id
        AND $db[tablaPrestamos].devuelto='0000-00-00'
        ORDER BY $ordena";
    $result = $pdo->query($consulta);
    if (!$result) {
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } else {
        print "    <form action=\"devolver-2.php\" method=\"$cfg[formMethod]\">\n";
        print "      <p>Seleccione el préstamo pendiente e indique la fecha de devolución:</p>\n";
        print "\n";
        print "      <table>\n";
        print "        <tbody>\n";
        print "          <tr>\n";
        print "            <td>Préstamo:</td>\n";
        print "            <td>\n";
        print "            <select name=\"id\">\n";
        print "                <option value=\"\"></option>\n";
        foreach ($result as $valor) {
            print "                <option value=\"$valor[id]\">$valor[nombre] $valor[apellidos] - $valor[autor] - $valor[titulo] - $valor[prestado]</option>\n";
        }
        print "              </select>\n";
        print "            </td>\n";
        print "          </tr>\n";
        print "          <tr>\n";
        print "            <td>Fecha de devolución:</td>\n";
        print "            <td><input type=\"date\" name=\"devuelto\" value=\"" . date("Y-m-j") . "\"></td>\n";
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
