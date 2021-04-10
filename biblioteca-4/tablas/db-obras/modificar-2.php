<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

cabecera("Obras - Modificar 2", MENU_OBRAS, PROFUNDIDAD_2);

borraAvisos("modificar-3");

imprimeAvisosGenerales();

// Si en modificar-3 se detecta un error, al volver a modificar-2 se necesita recuperar el id
if (isset($_SESSION["error"]["id"])) {
    $id = $_SESSION["error"]["id"]["valor"];
} elseif (isset($_SESSION["ok"]["id"])) {
    $id = $_SESSION["ok"]["id"]["valor"];
} else {
    $id = recoge("id");
}

if ($id == "") {
    print "    <p class=\"aviso\">No se ha seleccionado ningún registro.</p>\n";
} else {
    $pdo = conectaDb();

    $consulta = "SELECT COUNT(*) FROM $db[tablaObras]
                 WHERE id=:id";
    $result = $pdo->prepare($consulta);
    $result->execute([":id" => $id]);
    if (!$result) {
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } elseif ($result->fetchColumn() == 0) {
        print "    <p class=\"aviso\">Registro no encontrado.</p>\n";
    } else {
        $consulta = "SELECT * FROM $db[tablaObras]
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
            if (isset($_SESSION["error"]["autor"])) {
                print "            <td><input type=\"text\" name=\"autor\" size=\"$db[tamObrasAutor]\" maxlength=\"$db[tamObrasAutor]\""
                    . imprimeAvisosIndividuales("autor", "valor") . " autofocus>" . imprimeAvisosIndividuales("autor", "mensaje") . "</td>\n";
            } else {
                print "            <td><input type=\"text\" name=\"autor\" size=\"$db[tamObrasAutor]\" maxlength=\"$db[tamObrasAutor]\" value=\"$valor[autor]\" autofocus></td>\n";
            }
            print "          </tr>\n";
            print "          <tr>\n";
            print "            <td>Título:</td>\n";
            if (isset($_SESSION["error"]["titulo"])) {
                print "            <td><input type=\"text\" name=\"titulo\" size=\"$db[tamObrasTitulo]\" maxlength=\"$db[tamObrasTitulo]\""
                    . imprimeAvisosIndividuales("titulo", "valor") . ">" . imprimeAvisosIndividuales("titulo", "mensaje") . "</td>\n";
            } else {
                print "            <td><input type=\"text\" name=\"titulo\" size=\"$db[tamObrasTitulo]\" maxlength=\"$db[tamObrasTitulo]\" value=\"$valor[titulo]\"></td>\n";
            }
            print "          </tr>\n";
            print "          <tr>\n";
            print "            <td>Editorial:</td>\n";
            if (isset($_SESSION["error"]["editorial"])) {
                print "            <td><input type=\"text\" name=\"editorial\" size=\"$db[tamObrasEditorial]\" maxlength=\"$db[tamObrasEditorial]\""
                    . imprimeAvisosIndividuales("editorial", "valor") . ">" . imprimeAvisosIndividuales("editorial", "mensaje") . "</td>\n";
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
    }
    $pdo = null;
}

pie();
