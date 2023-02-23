<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   https://www.gnu.org/licenses/agpl-3.0.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "biblioteca.php";

$pdo = conectaDb();

cabecera("Añadir 1", MENU_VOLVER);

// ESTO NO FUNCIONA DE NINGUNA DE LAS DOS MANERAS. SI LA CONSULTA TIENE UN ERROR el fetchColumn da error

// try {
//     $consulta  = "SELECT COUNT(*) FROM $cfg[dbPersonasTabla]";
//     $resultado = $pdo->query($consulta);

//     if ($resultado->fetchColumn() >= $cfg["dbPersonasmaxReg"]) {
//         throw new Exception("    <p class=\"aviso\">Se ha alcanzado el número máximo de registros que se pueden guardar.</p>\n");
//     }
// } catch (PDOException $e) {
//     print "    <p class=\"aviso\">Error en la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
//     pie();
// } catch (Exception $e) {
//     print "    {$e->getMessage()}";
// }

try {
    $consulta  = "SELECTA COUNT(*) FROM $cfg[dbPersonasTabla]";
    $resultado = $pdo->query($consulta);
    try {
        if ($resultado->fetchColumn() >= $cfg["dbPersonasmaxReg"]) {
            throw new Exception("    <p class=\"aviso\">Se ha alcanzado el número máximo de registros que se pueden guardar.</p>\n");
        }
    } catch (Exception $e) {
        print "    {$e->getMessage()}";
    }
} catch (PDOException $e) {
    print "    <p class=\"aviso\">Error en la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    pie();
}



print "    <form action=\"insertar-2.php\" method=\"$cfg[formMethod]\">\n";
print "      <p>Escriba los datos del nuevo registro:</p>\n";
print "\n";
print "      <table>\n";
print "        <tbody>\n";
print "          <tr>\n";
print "            <td>Nombre:</td>\n";
print "            <td><input type=\"text\" name=\"nombre\" size=\"$cfg[dbPersonasTamNombre]\" maxlength=\"$cfg[dbPersonasTamNombre]\" autofocus></td>\n";
print "          </tr>\n";
print "          <tr>\n";
print "            <td>Apellidos:</td>\n";
print "            <td><input type=\"text\" name=\"apellidos\" size=\"$cfg[dbPersonasTamApellidos]\" maxlength=\"$cfg[dbPersonasTamApellidos]\"></td>\n";
print "          </tr>\n";
print "          <tr>\n";
print "            <td>Teléfono:</td>\n";
print "            <td><input type=\"text\" name=\"telefono\" size=\"$cfg[dbPersonasTamTelefono]\" maxlength=\"$cfg[dbPersonasTamTelefono]\"></td>\n";
print "          </tr>\n";
print "          <tr>\n";
print "            <td>Correo:</td>\n";
print "            <td><input type=\"text\" name=\"correo\" size=\"$cfg[dbPersonasTamCorreo]\" maxlength=\"$cfg[dbPersonasTamCorreo]\"></td>\n";
print "          </tr>\n";
print "        </tbody>\n";
print "      </table>\n";
print "\n";
print "      <p>\n";
print "        <input type=\"submit\" value=\"Añadir\">\n";
print "        <input type=\"reset\" value=\"Reiniciar formulario\">\n";
print "      </p>\n";
print "    </form>\n";

$pdo = null;

pie();
