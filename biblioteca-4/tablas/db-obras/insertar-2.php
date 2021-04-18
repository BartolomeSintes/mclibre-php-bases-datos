<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto();
[$autor, $titulo, $editorial] = compruebaAvisosIndividuales("insertar-2", "obras", "autor", "titulo", "editorial");
compruebaAvisosGenerales("insertar-2", "todosVacios", "autor", "titulo", "editorial");
compruebaAvisosGenerales("insertar-2", "limiteNumeroRegistros", $db["obras"]);

if (isset($_SESSION["error"])) {
    header("Location:insertar-1.php");
    exit();
}

cabecera("Obras - Añadir 2", MENU_OBRAS, PROFUNDIDAD_2);

$pdo = conectaDb();

$consulta = "SELECT COUNT(*) FROM $db[obras]
             WHERE autor=:autor
             AND titulo=:titulo
             AND editorial=:editorial";
$result = $pdo->prepare($consulta);
$result->execute([":autor" => $autor, ":titulo" => $titulo, ":editorial" => $editorial]);
if (!$result) {
    print "    <p class=\"aviso\">Error en la consulta.</p>\n";
} elseif ($result->fetchColumn() > 0) {
    print "    <p class=\"aviso\">El registro ya existe.</p>\n";
} else {
    $consulta = "INSERT INTO $db[obras]
                 (autor, titulo, editorial)
                 VALUES (:autor, :titulo, :editorial)";
    $result = $pdo->prepare($consulta);
    if ($result->execute([":autor" => $autor, ":titulo" => $titulo, ":editorial" => $editorial])) {
        print "    <p>Registro <strong>$autor - $titulo - $editorial</strong> creado correctamente.</p>\n";
    } else {
        print "    <p class=\"aviso\">Error al crear el registro <strong>$autor - $titulo - $editorial</strong>.</p>\n";
    }
}

$pdo = null;
pie();
