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
if (isset($_SESSION["avisosIndividuales"]["modificar-3"]["usuarios"]["id"]["valor"])) {
    $id = $_SESSION["avisosIndividuales"]["modificar-3"]["usuarios"]["id"]["valor"];
} else {
    [$id] = compruebaAvisosIndividuales("usuarios", "modificar-2", "id");
}

if (hayErrores("modificar-2")) {
    header("Location:modificar-1.php");
    exit();
}

compruebaAvisosGenerales("usuarios", "modificar-2", "registrosExisten", $id);

if (hayErrores("modificar-2")) {
    header("Location:modificar-1.php");
    exit();
}

cabecera("Usuarios - Modificar 2", MENU_USUARIOS, PROFUNDIDAD_2);

imprimeAvisosGenerales("usuarios", "modificar-3");

$pdo = conectaDb();

$consulta = "SELECT *
             FROM $db[usuarios]
             WHERE id=:id";
$result = $pdo->prepare($consulta);
$result->execute([":id" => $id]);
if (!$result) {
    print "    <p class=\"aviso-error\">Error en la consulta.</p>\n";
} else {
    $valor = $result->fetch(PDO::FETCH_ASSOC);
    print "    <form action=\"modificar-3.php\" method=\"$cfg[formMethod]\">\n";
    print "      <p>Modifique los campos que desee (deje la contraseña en blanco para mantenerla):</p>\n";
    print "\n";
    print "      <table>\n";
    print "        <tbody>\n";
    print "          <tr>\n";
    print "            <td>Usuario:</td>\n";
    print "            <td><input type=\"text\" name=\"usuario\" size=\"$db[tamUsuariosUsuario]\" maxlength=\"$db[tamUsuariosUsuario]\""
        . imprimeAvisosIndividuales("usuarios", "modificar-3", "usuario", "valor", $valor["usuario"]) . " autofocus>"
        . imprimeAvisosIndividuales("usuarios", "modificar-3", "usuario", "mensaje") . "</td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Contraseña:</td>\n";
    print "            <td><input type=\"text\" name=\"password\" size=\"$db[tamUsuariosPassword]\" maxlength=\"$db[tamUsuariosPassword]\">"
        . imprimeAvisosIndividuales("usuarios", "modificar-3", "password", "mensaje") . "</td>\n";
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Nivel:</td>\n";
    print "            <td>\n";
    print "              <select name=\"nivel\">\n";
    foreach ($usuariosNiveles as $indice2 => $valor2) {
        print "                <option value=\"$valor2\"";
        if ($valor2 == $valor["nivel"]) {
            print " selected";
        }
        print ">$indice2</option>\n";
    }
    print "              </select>" . imprimeAvisosIndividuales("usuarios", "modificar-3", "nivel", "mensaje") . "\n";
    print "            </td>\n";
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
