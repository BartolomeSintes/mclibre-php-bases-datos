<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto();

[$usuario, $password, $nivel] = compruebaAvisosIndividuales("usuarios", "insertar-2", "usuario", "password", "nivel");

compruebaAvisosGenerales("usuarios", "insertar-2", "algunoVacio", "usuario", "password", "nivel");

compruebaAvisosGenerales("usuarios", "insertar-2", "limiteNumeroRegistros");

compruebaAvisosGenerales("usuarios", "insertar-2", "yaExisteRegistro", "usuario");

if (hayErrores("usuarios", "insertar-2")) {
    header("Location:insertar-1.php");
    exit();
}

cabecera("Usuarios - Añadir 2", MENU_USUARIOS, PROFUNDIDAD_2);

$pdo = conectaDb();

$consulta = "INSERT INTO $db[usuarios] (usuario, password, nivel)
             VALUES (:usuario, :password, $nivel)";
$result = $pdo->prepare($consulta);
if ($result->execute([":usuario" => $usuario, ":password" => encripta($password)])) {
    print "    <p class=\"aviso-info\">Registro <strong>$usuario</strong> creado correctamente.</p>\n";
} else {
    print "    <p class=\"aviso-error\">Error al crear el registro <strong>$usuario</strong>.</p>\n";
}

$pdo = null;

pie();
