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
if (isset($_SESSION["avisosIndividuales"]["modificar-3"]["obras"]["id"]["valor"])) {
    $id = $_SESSION["avisosIndividuales"]["modificar-3"]["obras"]["id"]["valor"];
} else {
    [$id] = compruebaAvisosIndividuales("modificar-2", "obras", "id");
}

if (hayErrores("modificar-2")) {
    header("Location:modificar-1.php");
    exit();
}

cabecera("Obras - Modificar 2", MENU_OBRAS, PROFUNDIDAD_2);

imprimeAvisosGenerales("modificar-3");

$pdo = conectaDb();

$consulta = "SELECT * FROM $db[obras]
             WHERE id=:id";
$result = $pdo->prepare($consulta);
$result->execute([":id" => $id]);
if (!$result) {
    print "    <p class=\"aviso\">Error en la consulta.</p>\n";
} else {
    $valor = $result->fetch();
    print "    <form action=\"modificar-3.php\" method=\"$cfg[formMethod]\">\n";
    print "      <p>Modifique los campos que desee:</p>\n";
    print "\n";
    print "      <table>\n";
    print "        <tbody>\n";
    print "          <tr>\n";
    print "            <td>Autor:</td>\n";
    if (hayErrores("modificar-3") && !hayErroresGenerales("modificar-3")) {
        print "            <td><input type=\"text\" name=\"autor\" size=\"$db[tamObrasAutor]\" maxlength=\"$db[tamObrasAutor]\""
            . imprimeAvisosIndividuales("modificar-3", "obras", "autor", "valor") . " autofocus>" . imprimeAvisosIndividuales("modificar-3", "obras", "autor", "mensaje") . "</td>\n";
    } else {
        print "            <td><input type=\"text\" name=\"autor\" size=\"$db[tamObrasAutor]\" maxlength=\"$db[tamObrasAutor]\" value=\"$valor[autor]\" autofocus></td>\n";
    }
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Título:</td>\n";
    if (hayErrores("modificar-3") && !hayErroresGenerales("modificar-3")) {
        print "            <td><input type=\"text\" name=\"titulo\" size=\"$db[tamObrasTitulo]\" maxlength=\"$db[tamObrasTitulo]\""
            . imprimeAvisosIndividuales("modificar-3", "obras", "titulo", "valor") . ">" . imprimeAvisosIndividuales("modificar-3", "obras", "titulo", "mensaje") . "</td>\n";
    } else {
        print "            <td><input type=\"text\" name=\"titulo\" size=\"$db[tamObrasTitulo]\" maxlength=\"$db[tamObrasTitulo]\" value=\"$valor[titulo]\"></td>\n";
    }
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Editorial:</td>\n";
    if (hayErrores("modificar-3") && !hayErroresGenerales("modificar-3")) {
        print "            <td><input type=\"text\" name=\"editorial\" size=\"$db[tamObrasEditorial]\" maxlength=\"$db[tamObrasEditorial]\""
            . imprimeAvisosIndividuales("modificar-3", "obras", "editorial", "valor") . ">" . imprimeAvisosIndividuales("modificar-3", "obras", "editorial", "mensaje") . "</td>\n";
    } else {
        print "            <td><input type=\"text\" name=\"editorial\" size=\"$db[tamObrasEditorial]\" maxlength=\"$db[tamObrasEditorial]\" value=\"$valor[editorial]\"></td>\n";
    }
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
