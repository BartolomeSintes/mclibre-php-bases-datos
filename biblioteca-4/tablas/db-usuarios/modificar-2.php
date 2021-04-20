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
    [$id] = compruebaAvisosIndividuales("modificar-2", "usuarios", "id");
}

compruebaAvisosGenerales("modificar-2", "incluyeUsuarioRoot", $id);

if (hayErrores("modificar-2")) {
    header("Location:modificar-1.php");
    exit();
}

cabecera("Usuarios - Modificar 2", MENU_USUARIOS, PROFUNDIDAD_2);

imprimeAvisosGenerales("modificar-3");

$pdo = conectaDb();

$consulta = "SELECT * FROM $db[usuarios]
             WHERE id=:id";
$result = $pdo->prepare($consulta);
$result->execute([":id" => $id]);
if (!$result) {
    print "    <p class=\"aviso\">Error en la consulta.</p>\n";
} else {
    $valor = $result->fetch();
    print "    <form action=\"modificar-3.php\" method=\"$cfg[formMethod]\">\n";
    print "      <p>Modifique los campos que desee (deje la contraseña en blanco para mantenerla):</p>\n";
    print "\n";
    print "      <table>\n";
    print "        <tbody>\n";
    print "          <tr>\n";
    print "            <td>Usuario:</td>\n";
    if (hayErrores("modificar-3") && !hayErroresGenerales("modificar-3")) {
        print "            <td><input type=\"text\" name=\"usuario\" size=\"$db[tamUsuariosUsuario]\" maxlength=\"$db[tamUsuariosUsuario]\""
        . imprimeAvisosIndividuales("modificar-3", "usuarios", "usuario", "valor") . " autofocus>" . imprimeAvisosIndividuales("modificar-3", "usuarios", "usuario", "mensaje") . "</td>\n";
    } else {
        print "            <td><input type=\"text\" name=\"usuario\" size=\"$db[tamUsuariosUsuario]\" maxlength=\"$db[tamUsuariosUsuario]\" value=\"$valor[usuario]\"></td>\n";
    }
    print "          </tr>\n";
    print "          <tr>\n";
    print "            <td>Contraseña:</td>\n";
    print "            <td><input type=\"text\" name=\"password\" size=\"$db[tamUsuariosPassword]\" maxlength=\"$db[tamUsuariosPassword]\">" . imprimeAvisosIndividuales("modificar-3", "usuarios", "password", "mensaje") . "</td>\n";
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
    print "              </select>" . imprimeAvisosIndividuales("modificar-3", "usuarios", "nivel", "mensaje") . "\n";
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
