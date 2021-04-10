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

borraAvisos();
[$id_prestamo, $devuelto] = compruebaAvisosIndividuales("devolver-2", "id_prestamo", "devuelto");
compruebaAvisosGenerales("devolver-2", "fechasCrecientes2", "id_prestamo", "devuelto");

if (isset($_SESSION["error"])) {
    header("Location:devolver-1.php");
    exit();
}

cabecera("Préstamos - Devolver 2", MENU_PRESTAMOS, PROFUNDIDAD_2);

$pdo = conectaDb();

$consulta = "UPDATE $db[tablaPrestamos]
             SET devuelto='$devuelto'
             WHERE id=:id";
$result = $pdo->prepare($consulta);
if ($result->execute([":id" => $id_prestamo])) {
    print "    <p>Registro modificado correctamente.</p>\n";
} else {
    print "    <p class=\"aviso\">Error al modificar el registro.</p>\n";
}

$pdo = null;
pie();
