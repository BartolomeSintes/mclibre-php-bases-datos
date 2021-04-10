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

borraAvisos();
[$usuario, $password, $nivel, $id] = compruebaAvisosIndividuales("modificar-3", "usuario", "password", "nivel", "id");
compruebaAvisosGenerales("modificar-3", "algunoVacio", "usuario", "password", "nivel");

if (isset($_SESSION["error"])) {
    header("Location:modificar-2.php");
    exit();
}

cabecera("Usuarios - Modificar 3", MENU_USUARIOS, PROFUNDIDAD_2);

if ($id == "") {
    print "    <p class=\"aviso\">No se ha seleccionado ningún registro.</p>\n";
} else {
    $pdo = conectaDb();

    $consulta = "SELECT * FROM $db[tablaUsuarios]
                 WHERE id=:id";
    $result = $pdo->prepare($consulta);
    $result->execute([":id" => $id]);
    if (!$result) {
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } else {
        $valor = $result->fetch();
        if ($valor["usuario"] == $cfg["rootName"]) {
            print "    <p>Este usuario no se puede modificar.</p>\n";
        } else {
            $consulta = "SELECT COUNT(*) FROM $db[tablaUsuarios]
                         WHERE id=:id";
            $result = $pdo->prepare($consulta);
            $result->execute([":id" => $id]);
            if (!$result) {
                print "    <p class=\"aviso\">Error en la consulta.</p>\n";
            } elseif ($result->fetchColumn() == 0) {
                print "    <p class=\"aviso\">Registro no encontrado.</p>\n";
            } else {
                // La consulta cuenta los registros con un id diferente porque MySQL no distingue
                // mayúsculas de minúsculas y si en un registro sólo se cambian mayúsculas por
                // minúsculas MySQL diría que ya hay un registro como el que se quiere guardar.
                $consulta = "SELECT COUNT(*) FROM $db[tablaUsuarios]
                             WHERE usuario=:usuario
                             AND id<>:id";
                $result = $pdo->prepare($consulta);
                $result->execute([":usuario" => $usuario, ":id" => $id]);
                if (!$result) {
                    print "    <p class=\"aviso\">Error en la consulta.</p>\n";
                } elseif ($result->fetchColumn() > 0) {
                    print "    <p class=\"aviso\">Ya existe un registro con ese nombre de usuario. "
                        . "No se ha guardado la modificación.</p>\n";
                } else {
                    if ($password != "") {
                        $consulta = "UPDATE $db[tablaUsuarios]
                                     SET usuario=:usuario, password=:password, nivel=:nivel
                                     WHERE id=:id";
                        $result = $pdo->prepare($consulta);
                        if ($result->execute([":usuario" => $usuario, ":password" => encripta($password),
                            ":nivel" => $nivel, ":id" => $id, ])) {
                            print "    <p>Registro modificado correctamente.</p>\n";
                        } else {
                            print "    <p class=\"aviso\">Error al modificar el registro.</p>\n";
                        }
                    } else {
                        $consulta = "UPDATE $db[tablaUsuarios]
                                     SET usuario=:usuario, nivel=:nivel
                                     WHERE id=:id";
                        $result = $pdo->prepare($consulta);
                        if ($result->execute([":usuario" => $usuario,
                            ":nivel" => $nivel, ":id" => $id, ])) {
                            print "    <p>Registro modificado correctamente.</p>\n";
                        } else {
                            print "    <p class=\"aviso\">Error al modificar el registro.</p>\n";
                        }
                    }
                }
            }
        }
    }
    $pdo = null;
}

pie();
