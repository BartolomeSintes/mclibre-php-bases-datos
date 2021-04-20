<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

cabecera("Obras - Borrar 2", MENU_OBRAS, PROFUNDIDAD_2);

$id = recoge("id", []);

borraAvisosExcepto();

compruebaAvisosGenerales("borrar-2", "registrosNoSeleccionados", $id);

compruebaAvisosIndividuales("borrar-2", "obras", "id");

if (hayErrores("borrar-2")) {
    header("Location:borrar-1.php");
    exit();
}

$pdo = conectaDb();

foreach ($id as $indice => $valor) {
    $consulta = "DELETE FROM $db[obras]
                 WHERE id=:indice";
    $result = $pdo->prepare($consulta);
    if ($result->execute([":indice" => $indice])) {
        print "    <p>Registro borrado correctamente.</p>\n";
    } else {
        print "    <p class=\"aviso\">Error al borrar el registro.</p>\n";
    }
}

$pdo = null;

pie();
