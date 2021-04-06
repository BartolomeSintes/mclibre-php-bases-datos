<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../comunes/biblioteca.php";

session_name($cfg["sessionName"]);
session_start();
if (!isset($_SESSION["conectado"]) || $_SESSION["conectado"] != NIVEL_3) {
    header("Location:../index.php");
    exit;
}

if (!isset($_REQUEST["si"])) {
    header("Location:index.php");
    exit();
}

$db = conectaDb();

cabecera("Administrador - Borrar todo 2", MENU_ADMINISTRADOR, 1);

if ($cfg["insertaRegistrosDemo"]) {
    print "  <p>Base de datos creada, insertando registros de prueba.</p>\n";
} else {
    print "  <p>Base de datos creada.</p>\n";
}

borraTodo($db);

$db = null;
pie();
