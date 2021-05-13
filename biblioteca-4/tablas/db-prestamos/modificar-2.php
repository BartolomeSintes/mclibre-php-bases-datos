<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto("prestamos", "modificar-3");

// Si en modificar-3 se detecta un error, al volver a modificar-2 se necesita recuperar el id
if (isset($_SESSION["avisos"]["prestamos"]["modificar-3"]["campos"]["id"]["valor"])) {
    $id = $_SESSION["avisos"]["prestamos"]["modificar-3"]["campos"]["id"]["valor"];
} else {
    [$id] = compruebaAvisosIndividuales("prestamos", "modificar-2", "id");
}

if (hayErrores("prestamos", "modificar-2")) {
    header("Location:modificar-1.php");
    exit();
}

compruebaAvisosGenerales("prestamos", "modificar-2", "registrosExisten", $id);

if (hayErrores("prestamos", "modificar-2")) {
    header("Location:modificar-1.php");
    exit();
}

cabecera("Préstamos - Modificar 2", MENU_PRESTAMOS, PROFUNDIDAD_2);

imprimeAvisosGenerales("prestamos", "modificar-3");

$pdo = conectaDb();

$consulta = "SELECT
                prestamos.id,
                personas.id as id_persona,
                personas.nombre,
                personas.apellidos,
                obras.id as id_obra,
                obras.titulo,
                obras.autor,
                prestamos.prestado,
                prestamos.devuelto
            FROM $db[prestamos] as prestamos
            JOIN $db[obras] as obras
            ON prestamos.id_obra=obras.id
            JOIN $db[personas] as personas
            ON prestamos.id_persona=personas.id
            WHERE prestamos.id=:id";
$result = $pdo->prepare($consulta);
$result->execute([":id" => $id]);
$consulta2 = "SELECT * FROM $db[personas] ORDER BY apellidos";
$result2   = $pdo->query($consulta2);
$consulta3 = "SELECT * FROM $db[obras] ORDER BY autor";
$result3   = $pdo->query($consulta3);
if (!$result) {
    print "    <p class=\"aviso-error\">Error en la consulta.</p>\n";
} elseif (!$result2) {
    print "    <p class=\"aviso-error\">Error en la consulta.</p>\n";
} elseif (!$result3) {
    print "    <p class=\"aviso-error\">Error en la consulta.</p>\n";
} else {
    $valor = $result->fetch(PDO::FETCH_ASSOC);
    print "    <form action=\"modificar-3.php\" method=\"$cfg[formMethod]\">\n";
    print "      <p>Modifique los campos que desee:</p>\n";
    print "\n";
    print "      <table>\n";
    print "        <tbody>\n";
    print "          <tr>\n";
    print "            <td>Persona:</td>\n";
    print "            <td>\n";
    print "              <select name=\"id_persona\">\n";
    print "                <option value=\"\"></option>\n";
    foreach ($result2 as $valor2) {
        print "                <option value=\"$valor2[id]\"";
        if ($valor2["id"] == $valor["id_persona"]) {
            print " selected";
        }
        print ">$valor2[nombre] $valor2[apellidos]</option>\n";
    }
    print "              </select> " . imprimeAvisosIndividuales("prestamos", "modificar-3", "id_persona", "mensaje") . "\n";
    print "            </td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Obra:</td>\n";
    print "            <td>\n";
    print "              <select name=\"id_obra\">\n";
    print "                <option value=\"\"></option>\n";
    foreach ($result3 as $valor3) {
        print "                <option value=\"$valor3[id]\"";
        if ($valor3["id"] == $valor["id_obra"]) {
            print " selected";
        }
        print ">$valor3[autor] - $valor3[titulo]</option>\n";
    }
    print "              </select>" . imprimeAvisosIndividuales("prestamos", "modificar-3", "id_obra", "mensaje") . "\n";
    print "            </td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Fecha de préstamo:</td>\n";
    print "            <td><input type=\"date\" name=\"prestado\" value=\"$valor[prestado]\">"
        . imprimeAvisosIndividuales("prestamos", "modificar-3", "prestado", "mensaje") . "</td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Fecha de devolución:</td>\n";
    print "            <td><input type=\"date\" name=\"devuelto\" value=\"$valor[devuelto]\">"
        . imprimeAvisosIndividuales("prestamos", "modificar-3", "devuelto", "mensaje") . "</td>\n";
    print "          </tr>\n";
    print "        </tbody>\n";
    print "      </table>\n";
    print "\n";
    print "      <p>\n";
    print "        <input type=\"hidden\" name=\"id\" value=\"$id\">\n";
    print "        <input type=\"submit\" value=\"Actualizar\">\n";
    print "        <input type=\"reset\" value=\"Reiniciar formulario\">\n";
    print "      </p>\n";
    print "    </form>\n";
}

$pdo = null;

pie();
