<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto();
[$id_persona, $id_obra, $prestado] = compruebaAvisosIndividuales("insertar-2", "prestamos", "id_persona", "id_obra", "prestado");
compruebaAvisosGenerales("insertar-2", "algunoVacio", "id_persona", "id_obra", "prestado");
compruebaAvisosGenerales("insertar-2", "limiteNumeroRegistros", "prestamos");

if (isset($_SESSION["error"])) {
    header("Location:insertar-1.php");
    exit();
}

cabecera("Préstamos - Añadir 2", MENU_PRESTAMOS, PROFUNDIDAD_2);

$pdo = conectaDb();

$consulta = "SELECT COUNT(*) FROM $db[tablaPrestamos]
             WHERE id_persona=:id_persona
             AND id_obra=:id_obra
             AND prestado=:prestado";
$result = $pdo->prepare($consulta);
$result->execute([":id_persona" => $id_persona, ":id_obra" => $id_obra, ":prestado" => $prestado]);
if (!$result) {
    print "    <p class=\"aviso\">Error en la consulta.</p>\n";
} elseif ($result->fetchColumn() > 0) {
    print "    <p class=\"aviso\">El registro ya existe.</p>\n";
} else {
    $consulta = "INSERT INTO $db[tablaPrestamos]
                 (id_persona, id_obra, prestado, devuelto)
                 VALUES (:id_persona, :id_obra, :prestado, '0000-00-00')";
    $result = $pdo->prepare($consulta);
    if ($result->execute([":id_persona" => $id_persona, ":id_obra" => $id_obra, ":prestado" => $prestado])) {
        print "    <p>Registro creado correctamente.</p>\n";
    } else {
        print "    <p class=\"aviso\">Error al crear el registro.</p>\n";
    }
}

$pdo = null;
pie();
