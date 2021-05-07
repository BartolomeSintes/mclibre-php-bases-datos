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

compruebaAvisosGenerales("insertar-2", "limiteNumeroRegistros", "obras");

compruebaAvisosGenerales("insertar-2", "yaExisteRegistro", "obras", "autor", "titulo", "editorial");

if (hayErrores("insertar-2")) {
    header("Location:insertar-1.php");
    exit();
}

cabecera("Obras - Añadir 2", MENU_OBRAS, PROFUNDIDAD_2);

$pdo = conectaDb();

$consulta = "INSERT INTO $db[obras] (autor, titulo, editorial)
             VALUES (:autor, :titulo, :editorial)";
$result = $pdo->prepare($consulta);
if ($result->execute([":autor" => $autor, ":titulo" => $titulo, ":editorial" => $editorial])) {
    print "    <p class=\"aviso-info\">Registro <strong>$autor - $titulo - $editorial</strong> creado correctamente.</p>\n";
} else {
    print "    <p class=\"aviso-error\">Error al crear el registro <strong>$autor - $titulo - $editorial</strong>.</p>\n";
}

$pdo = null;

pie();
