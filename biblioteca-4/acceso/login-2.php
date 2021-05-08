<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../comunes/biblioteca.php";

compruebaNoSesion(PROFUNDIDAD_1);

borraAvisosExcepto();

compruebaAvisosGenerales("login-2", "validaLogin", "usuarios", "usuario", "password");

if (hayErrores("login-2")) {
    header("Location:login-1.php");
    exit();
}

header("Location:../index.php");
