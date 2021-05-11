<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto();

[$nombre, $apellidos, $dni] = compruebaAvisosIndividuales("personas", "insertar-2", "nombre", "apellidos", "dni");

compruebaAvisosGenerales("personas", "insertar-2", "todosVacios", "nombre", "apellidos", "dni");

compruebaAvisosGenerales("personas", "insertar-2", "limiteNumeroRegistros");

compruebaAvisosGenerales("personas", "insertar-2", "yaExisteRegistro", "nombre", "apellidos", "dni");

if (hayErrores("insertar-2")) {
    header("Location:insertar-1.php");
    exit();
}

cabecera("Personas - Añadir 2", MENU_PERSONAS, PROFUNDIDAD_2);

$pdo = conectaDb();

$consulta = "INSERT INTO $db[personas] (nombre, apellidos, dni)
             VALUES (:nombre, :apellidos, :dni)";
$result = $pdo->prepare($consulta);
if ($result->execute([":nombre" => $nombre, ":apellidos" => $apellidos, ":dni" => $dni])) {
    print "    <p class=\"aviso-info\">Registro <strong>$nombre $apellidos - $dni</strong> creado correctamente.</p>\n";
} else {
    print "    <p class=\"aviso-error\">Error al crear el registro <strong>$nombre $apellidos - $dni</strong>.</p>\n";
}

$pdo = null;

pie();
