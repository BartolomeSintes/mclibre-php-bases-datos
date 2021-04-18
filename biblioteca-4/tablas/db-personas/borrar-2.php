<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

$pdo = conectaDb();

cabecera("Personas - Borrar 2", MENU_PERSONAS, PROFUNDIDAD_2);

$id = recoge("id", []);

borraAvisosExcepto();

compruebaAvisosGenerales("borrar-2", "registrosNoSeleccionados", $id);
compruebaAvisosIndividuales("borrar-2", "personas", "id");

if (isset($_SESSION["error"])) {
    header("Location:borrar-1.php");
    exit();
}

foreach ($id as $indice => $valor) {
    $consulta = "DELETE FROM $db[personas]
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
