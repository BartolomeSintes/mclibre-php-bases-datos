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
if (isset($_SESSION["avisosIndividuales"]["modificar-3"]["personas"]["id"]["valor"])) {
    $id = $_SESSION["avisosIndividuales"]["modificar-3"]["personas"]["id"]["valor"];
} else {
    [$id] = compruebaAvisosIndividuales("modificar-2", "personas", "id");
}

if (hayErrores("modificar-2")) {
    header("Location:modificar-1.php");
    exit();
}

cabecera("Personas - Modificar 2", MENU_PERSONAS, PROFUNDIDAD_2);

imprimeAvisosGenerales("modificar-3");

$pdo = conectaDb();

$consulta = "SELECT * FROM $db[personas]
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
    print "            <td>Nombre:</td>\n";
    if (hayErrores("modificar-3") && !hayErroresGenerales("modificar-3")) {
        print "            <td><input type=\"text\" name=\"nombre\" size=\"$db[tamPersonasNombre]\" maxlength=\"$db[tamPersonasNombre]\""
        . imprimeAvisosIndividuales("modificar-3", $db["personas"], "nombre", "valor") . " autofocus>" . imprimeAvisosIndividuales("modificar-3", $db["personas"], "nombre", "mensaje") . "</td>\n";
    } else {
        print "            <td><input type=\"text\" name=\"nombre\" size=\"$db[tamPersonasNombre]\" maxlength=\"$db[tamPersonasNombre]\" value=\"$valor[nombre]\"></td>\n";
    }
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Apellidos:</td>\n";
    if (hayErrores("modificar-3") && !hayErroresGenerales("modificar-3")) {
        print "            <td><input type=\"text\" name=\"apellidos\" size=\"$db[tamPersonasApellidos]\" maxlength=\"$db[tamPersonasApellidos]\""
        . imprimeAvisosIndividuales("modificar-3", $db["personas"], "apellidos", "valor") . ">" . imprimeAvisosIndividuales("modificar-3", $db["personas"], "apellidos", "mensaje") . "</td>\n";
    } else {
        print "            <td><input type=\"text\" name=\"apellidos\" size=\"$db[tamPersonasApellidos]\" maxlength=\"$db[tamPersonasApellidos]\" value=\"$valor[apellidos]\"></td>\n";
    }
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>DNI:</td>\n";
    if (hayErrores("modificar-3") && !hayErroresGenerales("modificar-3")) {
        print "            <td><input type=\"text\" name=\"dni\" size=\"$db[tamPersonasDni]\" maxlength=\"$db[tamPersonasDni]\""
        . imprimeAvisosIndividuales("modificar-3", $db["personas"], "dni", "valor") . ">" . imprimeAvisosIndividuales("modificar-3", $db["personas"], "dni", "mensaje") . "</td>\n";
    } else {
        print "            <td><input type=\"text\" name=\"dni\" size=\"$db[tamPersonasDni]\" maxlength=\"$db[tamPersonasDni]\" value=\"$valor[dni]\">" . imprimeAvisosIndividuales("modificar-3", $db["personas"], "dni", "mensaje") . "</td>\n";
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
