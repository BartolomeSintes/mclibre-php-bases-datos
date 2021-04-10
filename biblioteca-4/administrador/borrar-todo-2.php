<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_1);

if (!isset($_REQUEST["si"])) {
    header("Location:index.php");
    exit();
}

$pdo = conectaDb();

cabecera("Administrador - Borrar todo 2", MENU_ADMINISTRADOR, PROFUNDIDAD_1);

if ($cfg["insertaRegistrosDemo"]) {
    print "  <p>Base de datos creada, insertando registros de prueba.</p>\n";
} else {
    print "  <p>Base de datos creada.</p>\n";
}

borraTodo($pdo);

$pdo = null;
pie();
