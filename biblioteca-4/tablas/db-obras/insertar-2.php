<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto();

recoge("autor", "titulo", "editorial");

compruebaAvisosIndividuales("obras", "insertar-2", "autor", "titulo", "editorial");

compruebaAvisosGenerales("obras", "insertar-2", "todosVacios", "autor", "titulo", "editorial");

compruebaAvisosGenerales("obras", "insertar-2", "limiteNumeroRegistros");

compruebaAvisosGenerales("obras", "insertar-2", "yaExisteRegistro", "autor", "titulo", "editorial");

if (hayErrores("obras", "insertar-2")) {
    header("Location:insertar-1.php");
    exit();
}

cabecera("Obras - Añadir 2", MENU_OBRAS, PROFUNDIDAD_2);

$pdo = conectaDb();

$consulta = "INSERT INTO $db[obras] (autor, titulo, editorial)
             VALUES (:autor, :titulo, :editorial)";
$result = $pdo->prepare($consulta);
if ($result->execute([":autor" => $recogido["autor"], ":titulo" => $recogido["titulo"], ":editorial" => $recogido["editorial"]])) {
    print "    <p class=\"aviso-info\">Registro <strong>$recogido[autor] - $recogido[titulo] - $recogido[editorial]</strong> creado correctamente.</p>\n";
} else {
    print "    <p class=\"aviso-error\">Error al crear el registro <strong>$recogido[autor] - $recogido[titulo] - $recogido[editorial]</strong>.</p>\n";
}

$pdo = null;

pie();
