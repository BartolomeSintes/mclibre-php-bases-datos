<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto("modificar-3");

// Si en modificar-3 se detecta un error, al volver a modificar-2 se necesita recuperar el id
if (isset($_SESSION["avisosIndividuales"]["modificar-3"]["prestamos"]["id"]["valor"])) {
    $id = $_SESSION["avisosIndividuales"]["modificar-3"]["prestamos"]["id"]["valor"];
} else {
    [$id] = compruebaAvisosIndividuales("modificar-2", "prestamos", "id");
}

if (hayErrores("modificar-2")) {
    header("Location:modificar-1.php");
    exit();
}

cabecera("Préstamos - Modificar 2", MENU_PRESTAMOS, PROFUNDIDAD_2);

imprimeAvisosGenerales("modificar-3");

$pdo = conectaDb();

$consulta = "SELECT COUNT(*)
             FROM $db[prestamos]
             WHERE id=:id";
$result = $pdo->prepare($consulta);
$result->execute([":id" => $id]);
if (!$result) {
    print "    <p class=\"aviso\">Error en la consulta.</p>\n";
} elseif ($result->fetchColumn() == 0) {
    print "    <p class=\"aviso\">Registro no encontrado.</p>\n";
} else {
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
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } elseif (!$result2) {
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } elseif (!$result3) {
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } else {
        $valor = $result->fetch();
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
        print "              </select> ";
        if (hayErrores("modificar-3") && !hayErroresGenerales("modificar-3")) {
            print imprimeAvisosIndividuales("prestamos", "id_persona", "mensaje");
        }
        print "\n";
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
        print "              </select>";
        if (hayErrores("modificar-3") && !hayErroresGenerales("modificar-3")) {
            print imprimeAvisosIndividuales("prestamos", "id_obra", "mensaje");
        }
        print "\n";
        print "            </td>\n";
        print "          </tr>\n";
        print "          <tr>\n";
        print "            <td>Fecha de préstamo:</td>\n";
        print "            <td><input type=\"date\" name=\"prestado\" value=\"$valor[prestado]\">";
        if (hayErrores("modificar-3") && !hayErroresGenerales("modificar-3")) {
            print imprimeAvisosIndividuales("prestamos", "prestado", "mensaje");
        }
        print "</td>\n";
        print "          </tr>\n";
        print "          <tr>\n";
        print "            <td>Fecha de devolución:</td>\n";
        print "            <td><input type=\"date\" name=\"devuelto\" value=\"$valor[devuelto]\">";
        if (hayErrores("modificar-3") && !hayErroresGenerales("modificar-3")) {
            print imprimeAvisosIndividuales("prestamos", "devuelto", "mensaje");
        }
        print "</td>\n";
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
}

$pdo = null;

pie();
