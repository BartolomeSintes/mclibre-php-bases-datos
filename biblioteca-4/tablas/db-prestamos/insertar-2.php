<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto();

[$id_persona, $id_obra, $prestado] = compruebaAvisosIndividuales("prestamos", "insertar-2", "id_persona", "id_obra", "prestado");

compruebaAvisosGenerales("prestamos", "insertar-2", "algunoVacio", "id_persona", "id_obra", "prestado");

compruebaAvisosGenerales("prestamos", "insertar-2", "limiteNumeroRegistros");

compruebaAvisosGenerales("prestamos", "insertar-2", "yaExisteRegistro", "id_persona", "id_obra", "prestado");

if (hayErrores("insertar-2")) {
    header("Location:insertar-1.php");
    exit();
}

cabecera("Préstamos - Añadir 2", MENU_PRESTAMOS, PROFUNDIDAD_2);

$pdo = conectaDb();

$consulta = "INSERT INTO $db[prestamos] (id_persona, id_obra, prestado, devuelto)
             VALUES (:id_persona, :id_obra, :prestado, '0000-00-00')";
$result = $pdo->prepare($consulta);
if ($result->execute([":id_persona" => $id_persona, ":id_obra" => $id_obra, ":prestado" => $prestado])) {
    print "    <p class=\"aviso-info\">Registro creado correctamente.</p>\n";
} else {
    print "    <p class=\"aviso-error\">Error al crear el registro.</p>\n";
}

$pdo = null;

pie();
