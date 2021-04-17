<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

cabecera("Personas - Modificar 2", MENU_PERSONAS, PROFUNDIDAD_2);

borraAvisosExcepto("modificar-3");

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

    $consulta = "SELECT COUNT(*) FROM $db[tablaPersonas]
                 WHERE id=:id";
    $result = $pdo->prepare($consulta);
    $result->execute([":id" => $id]);
    if (!$result) {
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } elseif ($result->fetchColumn() == 0) {
        print "    <p class=\"aviso\">Registro no encontrado.</p>\n";
    } else {
        $consulta = "SELECT * FROM $db[tablaPersonas]
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
            if (isset($_SESSION["error"]["nombre"])) {
                print "            <td><input type=\"text\" name=\"nombre\" size=\"$db[tamPersonasNombre]\" maxlength=\"$db[tamPersonasNombre]\""
                . imprimeAvisosIndividuales("personas", "nombre", "valor") . " autofocus>" . imprimeAvisosIndividuales("personas", "nombre", "mensaje") . "</td>\n";
            } else {
                print "            <td><input type=\"text\" name=\"nombre\" size=\"$db[tamPersonasNombre]\" maxlength=\"$db[tamPersonasNombre]\" value=\"$valor[nombre]\"></td>\n";
            }
            print "          </tr>\n";
            print "          <tr>\n";
            print "            <td>Apellidos:</td>\n";
            if (isset($_SESSION["error"]["apellidos"])) {
                print "            <td><input type=\"text\" name=\"apellidos\" size=\"$db[tamPersonasApellidos]\" maxlength=\"$db[tamPersonasApellidos]\""
                . imprimeAvisosIndividuales("personas", "apellidos", "valor") . ">" . imprimeAvisosIndividuales("personas", "apellidos", "mensaje") . "</td>\n";
            } else {
                print "            <td><input type=\"text\" name=\"apellidos\" size=\"$db[tamPersonasApellidos]\" maxlength=\"$db[tamPersonasApellidos]\" value=\"$valor[apellidos]\"></td>\n";
            }
            print "          </tr>\n";
            print "          <tr>\n";
            print "            <td>DNI:</td>\n";
            if (isset($_SESSION["error"]["dni"])) {
                print "            <td><input type=\"text\" name=\"dni\" size=\"$db[tamPersonasDni]\" maxlength=\"$db[tamPersonasDni]\""
                . imprimeAvisosIndividuales("personas", "dni", "valor") . ">" . imprimeAvisosIndividuales("personas", "dni", "mensaje") . "</td>\n";
            } else {
                print "            <td><input type=\"text\" name=\"dni\" size=\"$db[tamPersonasDni]\" maxlength=\"$db[tamPersonasDni]\" value=\"$valor[dni]\"></td>\n";
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
