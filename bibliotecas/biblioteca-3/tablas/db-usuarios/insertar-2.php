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

$pdo = conectaDb();
cabecera("Usuarios - Añadir 2", MENU_USUARIOS, PROFUNDIDAD_2);

$usuario  = recoge("usuario");
$password = recoge("password");
$nivel    = recoge("nivel");

$usuarioOk  = false;
$passwordOk = false;
$nivelOk    = false;

if (mb_strlen($usuario, "UTF-8") > $db["tamUsuariosUsuario"]) {
    print "    <p class=\"aviso\">El nombre usuario no puede tener más de $db[tamUsuariosUsuario] caracteres.</p>\n";
    print "\n";
} else {
    $usuarioOk = true;
}

if (mb_strlen($password, "UTF-8") > $db["tamUsuariosPassword"]) {
    print "    <p class=\"aviso\">La contraseña no puede tener más de $db[tamUsuariosPassword] caracteres.</p>\n";
    print "\n";
} else {
    $passwordOk = true;
}

if (!in_array($nivel, $usuariosNiveles)) {
    print "    <p class=\"aviso\">Nivel de usuario incorrecto.</p>\n";
    print "\n";
} else {
    $nivelOk = true;
}

if ($usuarioOk && $passwordOk && $nivelOk) {
    if ($usuario == "" || $password == "" || $nivel == "") {
        print "    <p class=\"aviso\">Hay que rellenar todos los campos. No se ha guardado el registro.</p>\n";
    } else {
        $consulta = "SELECT COUNT(*) FROM $db[tablaUsuarios]";
        $result   = $pdo->query($consulta);
        if (!$result) {
            print "    <p class=\"aviso\">Error en la consulta.</p>\n";
        } elseif ($result->fetchColumn() >= $cfg["maxRegTableUsuarios"] ) {
            print "    <p class=\"aviso\">Se ha alcanzado el número máximo de registros que se pueden guardar.</p>\n";
            print "\n";
            print "    <p class=\"aviso\">Por favor, borre algún registro antes.</p>\n";
        } else {
            $consulta = "SELECT COUNT(*) FROM $db[tablaUsuarios]
                WHERE usuario=:usuario";
            $result = $pdo->prepare($consulta);
            $result->execute([":usuario" => $usuario]);
            if (!$result) {
                print "    <p class=\"aviso\">Error en la consulta.</p>\n";
            } elseif ($result->fetchColumn() > 0) {
                print "    <p class=\"aviso\">El registro ya existe.</p>\n";
            } else {
                $consulta = "INSERT INTO $db[tablaUsuarios]
                    (usuario, password, nivel)
                    VALUES (:usuario, :password, $nivel)";
                $result = $pdo->prepare($consulta);
                if ($result->execute([":usuario" => $usuario, ":password" => encripta($password)])) {
                    print "    <p>Registro <strong>$usuario " . encripta($password) . "</strong> creado correctamente.</p>\n";
                } else {
                    print "    <p class=\"aviso\">Error al crear el registro <strong>$usuario " . encripta($password) . "</strong>.</p>\n";
                }
            }
        }
    }
}

$pdo = null;
pie();
