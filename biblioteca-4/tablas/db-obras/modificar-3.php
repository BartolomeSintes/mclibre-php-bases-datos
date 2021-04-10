<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisos();
[$autor, $titulo, $editorial, $id] = compruebaAvisosIndividuales("modificar-3", "autor", "titulo", "editorial", "id");
compruebaAvisosGenerales("modificar-3", "todosVaciosMenosPrimero", "id", "autor", "titulo", "editorial");

if (isset($_SESSION["error"])) {
    header("Location:modificar-2.php");
    exit();
}

cabecera("Obras - Modificar 3", MENU_OBRAS, PROFUNDIDAD_2);

if ($id == "") {
    print "    <p class=\"aviso\">No se ha seleccionado ningún registro.</p>\n";
} else {
    $pdo = conectaDb();

    $consulta = "SELECT COUNT(*) FROM $db[tablaObras]
                 WHERE id=:id";
    $result = $pdo->prepare($consulta);
    $result->execute([":id" => $id]);
    if (!$result) {
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } elseif ($result->fetchColumn() == 0) {
        print "    <p class=\"aviso\">Registro no encontrado.</p>\n";
    } else {
        // La consulta cuenta los registros con un id diferente porque MySQL no distingue
        // mayúsculas de minúsculas y si en un registro sólo se cambian mayúsculas por
        // minúsculas MySQL diría que ya hay un registro como el que se quiere guardar.
        $consulta = "SELECT COUNT(*) FROM $db[tablaObras]
                     WHERE autor=:autor
                     AND titulo=:titulo
                     AND editorial=:editorial
                     AND id<>:id";
        $result = $pdo->prepare($consulta);
        $result->execute([":autor" => $autor, ":titulo" => $titulo,
            ":editorial"           => $editorial, ":id" => $id, ]);
        if (!$result) {
            print "    <p class=\"aviso\">Error en la consulta.</p>\n";
        } elseif ($result->fetchColumn() > 0) {
            print "    <p class=\"aviso\">Ya existe un registro con esos mismos valores. "
                . "No se ha guardado la modificación.</p>\n";
        } else {
            $consulta = "UPDATE $db[tablaObras]
                         SET autor=:autor, titulo=:titulo, editorial=:editorial
                         WHERE id=:id";
            $result = $pdo->prepare($consulta);
            if ($result->execute([":autor" => $autor, ":titulo" => $titulo,
                ":editorial" => $editorial, ":id" => $id, ])) {
                print "    <p>Registro modificado correctamente.</p>\n";
            } else {
                print "    <p class=\"aviso\">Error al modificar el registro.</p>\n";
            }
        }
    }
    $pdo = null;
}

pie();
