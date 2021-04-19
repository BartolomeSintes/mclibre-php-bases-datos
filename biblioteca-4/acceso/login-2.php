<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../comunes/biblioteca.php";

compruebaNoSesion(PROFUNDIDAD_1);

$usuario  = recoge("usuario");
$password = recoge("password");

$pdo = conectaDb();

borraAvisosExcepto();
if (!$usuario) {
    $_SESSION["avisoGeneral"][$origen][] = "Escriba el nombre del usuario";
} else {
    $consulta = "SELECT * FROM $db[usuarios]
                 WHERE usuario=:usuario";
    $result = $pdo->prepare($consulta);
    $result->execute([":usuario" => $usuario]);
    if (!$result) {
        $_SESSION["avisoGeneral"]["login-2"][] = "Error en la consulta";
    } else {
        $valor = $result->fetch();
        if ($valor["password"] != encripta($password)) {
            $_SESSION["avisoGeneral"]["login-2"][] = "Nombre de usuario y/o contraseña incorrectos";
        }
    }
}

$pdo = null;

if (isset($_SESSION["avisoGeneral"]["login-2"])) {
    header("Location:login-1.php");
    exit();
}

$_SESSION["conectado"] = $valor["nivel"];
header("Location:../index.php");
exit();
