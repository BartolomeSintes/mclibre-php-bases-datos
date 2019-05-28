<?php
/**
 * RMM-0 - Agenda multiusuario (Cliente) - conectar-2.php
 *
 * @author    Bartolomé Sintes Marco <bartolome.sintes+mclibre@gmail.com>
 * @copyright 2019 Bartolomé Sintes Marco
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @version   2019-05-27
 * @link      http://www.mclibre.org
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

session_start();
if (isset($_SESSION["id"])) {
    header("Location:../index.php");
    exit();
}

require_once "../comunes/biblioteca.php";

$usuario   = recoge("usuario");
$password  = recoge("password");

$consulta = http_build_query([
    "accion"   => "usuarios-validar",
    "usuario"  => $usuario,
    "password" => $password
]);

$respuesta1 = file_get_contents("$urlServidor?$consulta");
$respuesta = json_decode($respuesta1, true);
// print "<pre>Respuesta: "; print_r($respuesta); print "</pre>";

if ($respuesta["resultado"] == KO) {
    header("Location:conectar-1.php?aviso=Error: Nombre o contraseña incorrecta");
    exit();
} else {
    $_SESSION["usuario"]  = $usuario;
    $_SESSION["password"] = $password;
    $_SESSION["nivel"]    = $respuesta["registros"][0]["nivel"];
    header("Location:../index.php");
    exit();
}
