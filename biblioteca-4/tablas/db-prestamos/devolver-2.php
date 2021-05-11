<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto();

[$id_prestamo, $devuelto] = compruebaAvisosIndividuales("devolver-2", "prestamos", "id_prestamo", "devuelto");

if (hayErrores("devolver-2")) {
    header("Location:devolver-1.php");
    exit();
}

compruebaAvisosGenerales("prestamos", "devolver-2", "fechasCrecientes2", "id_prestamo", "devuelto");

if (hayErrores("devolver-2")) {
    header("Location:devolver-1.php");
    exit();
}

borraAvisosExcepto();

cabecera("Préstamos - Devolver 2", MENU_PRESTAMOS, PROFUNDIDAD_2);

$pdo = conectaDb();

$consulta = "UPDATE $db[prestamos]
             SET devuelto='$devuelto'
             WHERE id=:id";
$result = $pdo->prepare($consulta);
if ($result->execute([":id" => $id_prestamo])) {
    print "    <p class=\"aviso-info\">Registro modificado correctamente.</p>\n";
} else {
    print "    <p class=\"aviso-error\">Error al modificar el registro.</p>\n";
}

$pdo = null;

pie();
