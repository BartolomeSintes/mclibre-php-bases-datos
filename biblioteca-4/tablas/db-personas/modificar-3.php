<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto();

[$id] = compruebaAvisosIndividuales("modificar-3", "personas", "id");

if (hayErrores("modificar-3")) {
    header("Location:modificar-1.php");
    exit();
}

[$nombre, $apellidos, $dni, $id] = compruebaAvisosIndividuales("modificar-3", "personas", "nombre", "apellidos", "dni", "id");

compruebaAvisosGenerales("modificar-3", "todosVaciosMenosPrimero", "id", "nombre", "apellidos", "dni");

compruebaAvisosGenerales("modificar-3", "yaExisteRegistroConOtroId", "personas", "nombre", "apellidos", "dni", "id");

if (hayErrores("modificar-3")) {
    header("Location:modificar-2.php");
    exit();
}

cabecera("Personas - Modificar 3", MENU_PERSONAS, PROFUNDIDAD_2);

$pdo = conectaDb();

$consulta = "UPDATE $db[personas]
             SET
               nombre=:nombre,
               apellidos=:apellidos,
               dni=:dni
             WHERE id=:id";
$result = $pdo->prepare($consulta);
if ($result->execute([":nombre" => $nombre, ":apellidos" => $apellidos, ":dni" => $dni, ":id" => $id])) {
    print "    <p>Registro modificado correctamente.</p>\n";
} else {
    print "    <p class=\"aviso\">Error al modificar el registro.</p>\n";
}

$pdo = null;

pie();
