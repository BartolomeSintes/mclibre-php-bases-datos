<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../comunes/biblioteca.php";

session_name($cfg["sessionName"]);
session_start();
if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit();
}

$db = conectaDb();

$tabla  = recogeValores("tabla", $tablas);
$accion = recogeValores("accion", $acciones);

$tablaOk  = $tabla  != "";
$accionOk = $accion != "";

if ($tablaOk && $accionOk) {
    if ($accion == "borrar-1") {
        borrar_1($arg[$tabla][$accion]);
    } elseif ($accion == "borrar-2") {
        borrar_2($arg[$tabla][$accion]);
    } elseif ($accion == "buscar-1") {
        buscar_1($arg[$tabla][$accion]);
    } elseif ($accion == "buscar-2") {
        buscar_2($arg[$tabla][$accion]);
    } elseif ($accion == "insertar-1-a") {
        insertar_1_a($arg[$tabla][$accion]);
    } elseif ($accion == "insertar-1-b") {
        insertar_1_b($arg[$tabla][$accion]);
    } elseif ($accion == "insertar-2") {
        insertar_2($arg[$tabla][$accion]);
    } elseif ($accion == "listar") {
        listar($arg[$tabla][$accion]);
    } elseif ($accion == "modificar-1") {
        modificar_1($arg[$tabla][$accion]);
    } elseif ($accion == "modificar-2") {
        modificar_2($arg[$tabla][$accion]);
    } elseif ($accion == "modificar-3") {
        modificar_3($arg[$tabla][$accion]);
    } else {
        header("Location:../index.php");
    }
} else {
    header("Location:../index.php");
    exit();
}
