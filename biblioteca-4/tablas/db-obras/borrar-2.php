<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

$pdo = conectaDb();
cabecera("Obras - Borrar 2", MENU_OBRAS, PROFUNDIDAD_2);

$id = recoge("id", []);

if (count($id) == 0) {
    print "    <p class=\"aviso\">No se ha seleccionado ningún registro.</p>\n";
} else {
    foreach ($id as $indice => $valor) {
        $consulta = "SELECT COUNT(*) FROM $db[obras]
                     WHERE id=:indice";
        $result = $pdo->prepare($consulta);
        $result->execute([":indice" => $indice]);
        if (!$result) {
            print "    <p class=\"aviso\">Error en la consulta.</p>\n";
        } elseif ($result->fetchColumn() == 0) {
            print "    <p class=\"aviso\">Registro no encontrado.</p>\n";
        } else {
            $consulta = "DELETE FROM $db[obras]
                         WHERE id=:indice";
            $result = $pdo->prepare($consulta);
            if ($result->execute([":indice" => $indice])) {
                print "    <p>Registro borrado correctamente.</p>\n";
            } else {
                print "    <p class=\"aviso\">Error al borrar el registro.</p>\n";
            }
        }
    }
}

$pdo = null;
pie();
