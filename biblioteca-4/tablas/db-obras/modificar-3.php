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

[$autor, $titulo, $editorial, $id] = compruebaAvisosIndividuales("modificar-3", "obras", "autor", "titulo", "editorial", "id");

compruebaAvisosGenerales("modificar-3", "todosVaciosMenosPrimero", "id", "autor", "titulo", "editorial");

compruebaAvisosGenerales("modificar-3", "yaExisteRegistroConOtroId", "obras", "autor", "titulo", "editorial", "id");

if (hayErrores("modificar-3")) {
    header("Location:modificar-2.php");
    exit();
}

cabecera("Obras - Modificar 3", MENU_OBRAS, PROFUNDIDAD_2);

$pdo = conectaDb();

$consulta = "UPDATE $db[obras]
             SET
               autor=:autor,
               titulo=:titulo,
               editorial=:editorial
             WHERE id=:id";
$result = $pdo->prepare($consulta);
if ($result->execute([":autor" => $autor, ":titulo" => $titulo, ":editorial" => $editorial, ":id" => $id])) {
    print "    <p class=\"aviso-info\">Registro modificado correctamente.</p>\n";
} else {
    print "    <p class=\"aviso-error\">Error al modificar el registro.</p>\n";
}

$pdo = null;

pie();
