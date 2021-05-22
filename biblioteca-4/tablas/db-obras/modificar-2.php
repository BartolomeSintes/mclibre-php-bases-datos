<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto("obras", "modificar-3");

// Si en modificar-3 se detecta un error, al volver a modificar-2 se necesita recuperar el id
if (isset($_SESSION["avisos"]["obras"]["modificar-3"]["campos"]["id"]["valor"])) {
    $recogido["id"] = $_SESSION["avisos"]["obras"]["modificar-3"]["campos"]["id"]["valor"];
} else {
    recoge("id");
    compruebaAvisosIndividuales("obras", "modificar-2", "id");
}

if (hayErrores("obras", "modificar-2")) {
    header("Location:modificar-1.php");
    exit();
}

compruebaAvisosGenerales("obras", "modificar-2", "registrosExisten", "id");

if (hayErrores("obras", "modificar-2")) {
    header("Location:modificar-1.php");
    exit();
}

cabecera("Obras - Modificar 2", MENU_OBRAS, PROFUNDIDAD_2);

imprimeAvisosGenerales("obras", "modificar-3");

$pdo = conectaDb();

$consulta = "SELECT *
             FROM $db[obras]
             WHERE id=:id";
$result = $pdo->prepare($consulta);
$result->execute([":id" => $recogido["id"]]);
if (!$result) {
    print "    <p class=\"aviso-error\">Error en la consulta.</p>\n";
} else {
    $valor = $result->fetch(PDO::FETCH_ASSOC);
    print "    <form action=\"modificar-3.php\" method=\"$cfg[formMethod]\">\n";
    print "      <p>Modifique los campos que desee:</p>\n";
    print "\n";
    print "      <table>\n";
    print "        <tbody>\n";
    print "          <tr>\n";
    print "            <td>Autor:</td>\n";
    print "            <td><input type=\"text\" name=\"autor\" size=\"$db[tamObrasAutor]\" maxlength=\"$db[tamObrasAutor]\""
        . imprimeAvisosIndividuales("obras", "modificar-3", "autor", "valor", $valor["autor"]) . " autofocus>"
        . imprimeAvisosIndividuales("obras", "modificar-3", "autor", "mensaje") . "</td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Título:</td>\n";
    print "            <td><input type=\"text\" name=\"titulo\" size=\"$db[tamObrasTitulo]\" maxlength=\"$db[tamObrasTitulo]\""
        . imprimeAvisosIndividuales("obras", "modificar-3", "titulo", "valor", $valor["titulo"]) . ">"
        . imprimeAvisosIndividuales("obras", "modificar-3", "titulo", "mensaje") . "</td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Editorial:</td>\n";
    print "            <td><input type=\"text\" name=\"editorial\" size=\"$db[tamObrasEditorial]\" maxlength=\"$db[tamObrasEditorial]\""
        . imprimeAvisosIndividuales("obras", "modificar-3", "editorial", "valor", $valor["editorial"]) . ">"
        . imprimeAvisosIndividuales("obras", "modificar-3", "editorial", "mensaje") . "</td>\n";
    print "          </tr>\n";
    print "        </tbody>\n";
    print "      </table>\n";
    print "\n";
    print "      <p>\n";
    print "        <input type=\"hidden\" name=\"id\" value=\"$recogido[id]\">\n";
    print "        <input type=\"submit\" value=\"Actualizar\">\n";
    print "        <input type=\"reset\" value=\"Reiniciar formulario\">\n";
    print "      </p>\n";
    print "    </form>\n";
}

$pdo = null;

pie();
