<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../comunes/biblioteca.php";

session_name($cfg["sessionName"]);
session_start();
if (!isset($_SESSION["conectado"]) || $_SESSION["conectado"] != NIVEL_3) {
    header("Location:../index.php");
    exit;
}

$db = conectaDb();
cabecera("Préstamos - Modificar 2", MENU_PRESTAMOS, 1);

$id = recoge("id");

if ($id == "") {
    print "    <p class=\"aviso\">No se ha seleccionado ningún registro.</p>\n";
} else {
    $consulta = "SELECT COUNT(*) FROM $cfg[tablaPrestamos]
       WHERE id=:id";
    $result = $db->prepare($consulta);
    $result->execute([":id" => $id]);
    if (!$result) {
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } elseif ($result->fetchColumn() == 0) {
        print "    <p class=\"aviso\">Registro no encontrado.</p>\n";
    } else {
        $consulta = "SELECT $cfg[tablaPrestamos].id as id,
            $cfg[tablaPersonas].id as id_persona,
            $cfg[tablaPersonas].nombre as nombre,
            $cfg[tablaPersonas].apellidos as apellidos,
            $cfg[tablaObras].id as id_obra,
            $cfg[tablaObras].titulo as titulo,
            $cfg[tablaObras].autor as autor,
            $cfg[tablaPrestamos].prestado as prestado,
            $cfg[tablaPrestamos].devuelto as devuelto
        FROM $cfg[tablaPersonas], $cfg[tablaObras], $cfg[tablaPrestamos]
        WHERE $cfg[tablaPrestamos].id_persona=$cfg[tablaPersonas].id
        AND $cfg[tablaPrestamos].id_obra=$cfg[tablaObras].id
        AND $cfg[tablaPrestamos].id=:id";
        $result = $db->prepare($consulta);
        $result->execute([":id" => $id]);
        $consulta2 = "SELECT * FROM $cfg[tablaPersonas] ORDER BY apellidos";
        $result2   = $db->query($consulta2);
        $consulta3 = "SELECT * FROM $cfg[tablaObras] ORDER BY autor";
        $result3   = $db->query($consulta3);
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
            print "              </select>\n";
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
            print "              </select>\n";
            print "            </td>\n";
            print "          </tr>\n";
            print "          <tr>\n";
            print "            <td>Fecha de préstamo:</td>\n";
            print "            <td><input type=\"date\" name=\"prestado\" value=\"$valor[prestado]\"></td>\n";
            print "          </tr>\n";
            print "          <tr>\n";
            print "            <td>Fecha de devolución:</td>\n";
            print "            <td><input type=\"date\" name=\"devuelto\" value=\"$valor[devuelto]\"></td>\n";
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
}

$db = null;
pie();
