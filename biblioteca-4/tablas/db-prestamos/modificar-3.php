<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto();

[$id] = compruebaAvisosIndividuales("modificar-3", "obras", "id");

if (hayErrores("modificar-3")) {
    header("Location:modificar-1.php");
    exit();
}

[$id_persona, $id_obra, $prestado, $devuelto, $id] = compruebaAvisosIndividuales("modificar-3", "prestamos", "id_persona", "id_obra", "prestado", "devuelto", "id");

compruebaAvisosGenerales("modificar-3", "fechasCrecientes", "prestado", "devuelto");

compruebaAvisosGenerales("modificar-3", "todosVaciosMenosPrimero", "id", "id_persona", "id_obra", "prestado", "devuelto");

compruebaAvisosGenerales("modificar-3", "yaExisteRegistroConOtroId", "prestamos", "id_persona", "id_obra", "prestado", "devuelto", "id");

if (hayErrores("modificar-3")) {
    header("Location:modificar-2.php");
    exit();
}

cabecera("Préstamos - Modificar 3", MENU_PRESTAMOS, PROFUNDIDAD_2);

$pdo = conectaDb();

$consulta = "UPDATE $db[prestamos]
             SET
               id_persona=:id_persona,
               id_obra=:id_obra,
               prestado=:prestado,
               devuelto=:devuelto
             WHERE id=:id";
$result = $pdo->prepare($consulta);
if ($result->execute([":id_persona" => $id_persona, ":id_obra" => $id_obra,
    ":prestado" => $prestado, ":devuelto" => $devuelto, ":id" => $id, ])) {
    print "    <p class=\"aviso-info\">Registro modificado correctamente.</p>\n";
} else {
    print "    <p class=\"aviso-error\">Error al modificar el registro.</p>\n";
}

$pdo = null;

pie();
