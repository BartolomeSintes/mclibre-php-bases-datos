<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

session_name($cfg["sessionName"]);
session_start();
if (!isset($_SESSION["conectado"]) || $_SESSION["conectado"] < NIVEL_3) {
    header("Location:../../index.php");
    exit;
}

cabecera("Préstamos - Modificar 2", MENU_PRESTAMOS, PROFUNDIDAD_2);

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

    $consulta = "SELECT COUNT(*) FROM $db[tablaPrestamos]
                 WHERE id=:id";
    $result = $pdo->prepare($consulta);
    $result->execute([":id" => $id]);
    if (!$result) {
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } elseif ($result->fetchColumn() == 0) {
        print "    <p class=\"aviso\">Registro no encontrado.</p>\n";
    } else {
        $consulta = "SELECT $db[tablaPrestamos].id as id,
                         $db[tablaPersonas].id as id_persona,
                         $db[tablaPersonas].nombre as nombre,
                         $db[tablaPersonas].apellidos as apellidos,
                         $db[tablaObras].id as id_obra,
                         $db[tablaObras].titulo as titulo,
                         $db[tablaObras].autor as autor,
                         $db[tablaPrestamos].prestado as prestado,
                         $db[tablaPrestamos].devuelto as devuelto
                     FROM $db[tablaPersonas], $db[tablaObras], $db[tablaPrestamos]
                     WHERE $db[tablaPrestamos].id_persona=$db[tablaPersonas].id
                     AND $db[tablaPrestamos].id_obra=$db[tablaObras].id
                     AND $db[tablaPrestamos].id=:id";
        $result = $pdo->prepare($consulta);
        $result->execute([":id" => $id]);
        $consulta2 = "SELECT * FROM $db[tablaPersonas] ORDER BY apellidos";
        $result2   = $pdo->query($consulta2);
        $consulta3 = "SELECT * FROM $db[tablaObras] ORDER BY autor";
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
            print "            <select name=\"id_persona\">\n";
            print "                <option value=\"\"></option>\n";
            foreach ($result2 as $valor2) {
                print "                <option value=\"$valor2[id]\"";
                if ($valor2["id"] == $valor["id_persona"]) {
                    print " selected";
                }
                print ">$valor2[nombre] $valor2[apellidos]</option>\n";
            }
            print "              </select>" . imprimeAvisosIndividuales("id_persona", "mensaje") . "\n";
            print "            </td>\n";
            print "          </tr>\n";
            print "          <tr>\n";
            print "            <td>Obra:</td>\n";
            print "            <td>\n";
            print "            <select name=\"id_obra\">\n";
            print "                <option value=\"\"></option>\n";
            foreach ($result3 as $valor3) {
                print "                <option value=\"$valor3[id]\"";
                if ($valor3["id"] == $valor["id_obra"]) {
                    print " selected";
                }
                print ">$valor3[autor] - $valor3[titulo]</option>\n";
            }
            print "              </select>" . imprimeAvisosIndividuales("id_obra", "mensaje") . "\n";
            print "            </td>\n";
            print "          </tr>\n";
            print "          <tr>\n";
            print "            <td>Fecha de préstamo:</td>\n";
            print "            <td><input type=\"date\" name=\"prestado\" value=\"$valor[prestado]\">" . imprimeAvisosIndividuales("prestado", "mensaje") . "</td>\n";
            print "          </tr>\n";
            print "          <tr>\n";
            print "            <td>Fecha de devolución:</td>\n";
            print "            <td><input type=\"date\" name=\"devuelto\" value=\"$valor[devuelto]\">" . imprimeAvisosIndividuales("devuelto", "mensaje") . "</td>\n";
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
