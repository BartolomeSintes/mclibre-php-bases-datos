<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

cabecera("Préstamos - Devolver 1", MENU_PRESTAMOS, PROFUNDIDAD_2);

borraAvisosExcepto("devolver-2");

imprimeAvisosGenerales();

$ordena = recogeValores("ordena", $db["columnasPrestamosOrden"], "autor ASC");

$pdo = conectaDb();

$consulta = "SELECT COUNT(*) FROM $db[prestamos]
             WHERE devuelto='0000-00-00'";
$result = $pdo->query($consulta);
if (!$result) {
    print "    <p class=\"aviso\">Error en la consulta.</p>\n";
} elseif ($result->fetchColumn() == 0) {
    print "    <p>No hay obras pendientes de devolución.</p>\n";
} else {
    $consulta = "SELECT $db[prestamos].id as id,
                     $db[personas].nombre as nombre,
                     $db[personas].apellidos as apellidos,
                     $db[obras].titulo as titulo,
                     $db[obras].autor as autor,
                     $db[prestamos].prestado as prestado,
                     $db[prestamos].devuelto as devuelto
                 FROM $db[personas], $db[obras], $db[prestamos]
                 WHERE $db[prestamos].id_persona=$db[personas].id
                 AND $db[prestamos].id_obra=$db[obras].id
                 AND $db[prestamos].devuelto='0000-00-00'
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
        print "            <select name=\"id_prestamo\">\n";
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
