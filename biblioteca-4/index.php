<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "comunes/biblioteca.php";

session_name($cfg["sessionName"]);
session_start();

if (!isset($_SESSION["conectado"])) {
    cabecera("Inicio", MENU_PRINCIPAL, PROFUNDIDAD_0);
} else {
    cabecera("Inicio", MENU_PRINCIPAL_CONECTADO, PROFUNDIDAD_0);
}

pie();
