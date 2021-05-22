<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto();

recoge("id");

compruebaAvisosIndividuales("personas", "modificar-3", "id");

if (hayErrores("personas", "modificar-3")) {
    header("Location:modificar-1.php");
    exit();
}

compruebaAvisosGenerales("personas", "modificar-3", "registrosExisten", "id");

if (hayErrores("personas", "modificar-3")) {
    header("Location:modificar-1.php");
    exit();
}

recoge("nombre", "apellidos", "dni");

compruebaAvisosIndividuales("personas", "modificar-3", "nombre", "apellidos", "dni");

incluyeValoresOriginalesEnAvisos("personas", "modificar-3", "id", "nombre", "apellidos", "dni");

compruebaAvisosGenerales("personas", "modificar-3", "todosVaciosMenosPrimero", "id", "nombre", "apellidos", "dni");

compruebaAvisosGenerales("personas", "modificar-3", "yaExisteRegistroConOtroId", "nombre", "apellidos", "dni", "id");

if (hayErrores("personas", "modificar-3")) {
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
if ($result->execute([":nombre" => $recogido["nombre"], ":apellidos" => $recogido["apellidos"], ":dni" => $recogido["dni"], ":id" => $recogido["id"]])) {
    print "    <p class=\"aviso-info\">Registro modificado correctamente.</p>\n";
} else {
    print "    <p class=\"aviso-error\">Error al modificar el registro.</p>\n";
}

$pdo = null;

pie();
