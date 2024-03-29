<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto("personas", "modificar-3");

// Si en modificar-3 se detecta un error, al volver a modificar-2 se necesita recuperar el id
if (isset($_SESSION["avisos"]["personas"]["modificar-3"]["campos"]["id"]["valor"])) {
    $recogido["id"] = $_SESSION["avisos"]["personas"]["modificar-3"]["campos"]["id"]["valor"];
} else {
    recoge("id");
    compruebaAvisosIndividuales("personas", "modificar-2", "id");
}

if (hayErrores("personas", "modificar-2")) {
    header("Location:modificar-1.php");
    exit();
}

compruebaAvisosGenerales("personas", "modificar-2", "registrosExisten", "id");

if (hayErrores("personas", "modificar-2")) {
    header("Location:modificar-1.php");
    exit();
}

cabecera("Personas - Modificar 2", MENU_PERSONAS, PROFUNDIDAD_2);

imprimeAvisosGenerales("personas", "modificar-3");

$pdo = conectaDb();

$consulta = "SELECT *
             FROM $db[personas]
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
    print "            <td>Nombre:</td>\n";
    print "            <td><input type=\"text\" name=\"nombre\" size=\"$db[tamPersonasNombre]\" maxlength=\"$db[tamPersonasNombre]\""
        . imprimeAvisosIndividuales("personas", "modificar-3", "nombre", "valor", $valor["nombre"]) . " autofocus>"
        . imprimeAvisosIndividuales("personas", "modificar-3", "nombre", "mensaje") . "</td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Apellidos:</td>\n";
    print "            <td><input type=\"text\" name=\"apellidos\" size=\"$db[tamPersonasApellidos]\" maxlength=\"$db[tamPersonasApellidos]\""
        . imprimeAvisosIndividuales("personas", "modificar-3", "apellidos", "valor", $valor["apellidos"]) . ">"
        . imprimeAvisosIndividuales("personas", "modificar-3", "apellidos", "mensaje") . "</td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>DNI:</td>\n";
    print "            <td><input type=\"text\" name=\"dni\" size=\"$db[tamPersonasDni]\" maxlength=\"$db[tamPersonasDni]\""
        . imprimeAvisosIndividuales("personas", "modificar-3", "dni", "valor", $valor["dni"]) . ">"
        . imprimeAvisosIndividuales("personas", "modificar-3", "dni", "mensaje") . "</td>\n";
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
