<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_1);

recoge("borrar", "demo");

if ($recogido["borrar"] != "Sí") {
    header("Location:index.php");
    exit();
}

cabecera("Administrador - Borrar todo 2", MENU_ADMINISTRADOR, PROFUNDIDAD_1);

if ($recogido["demo"] == "on") {
    print "    <p class=\"aviso-info\">Base de datos creada, insertando registros de prueba.</p>\n";
} else {
    print "    <p class=\"aviso-info\">Base de datos creada.</p>\n";
}

borraTodo($recogido["demo"] == "on");

pie();
