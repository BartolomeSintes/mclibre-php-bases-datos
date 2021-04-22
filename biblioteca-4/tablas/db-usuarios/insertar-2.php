<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto();

[$usuario, $password, $nivel] = compruebaAvisosIndividuales("insertar-2", "usuarios", "usuario", "password", "nivel");

compruebaAvisosGenerales("insertar-2", "algunoVacio", "usuario", "password", "nivel");

compruebaAvisosGenerales("insertar-2", "limiteNumeroRegistros", "usuarios");

compruebaAvisosGenerales("insertar-2", "yaExisteRegistro", "usuarios", "usuario", "password", "nivel");

if (hayErrores("insertar-2")) {
    header("Location:insertar-1.php");
    exit();
}

borraAvisosExcepto();

cabecera("Usuarios - Añadir 2", MENU_USUARIOS, PROFUNDIDAD_2);

$pdo = conectaDb();

$consulta = "INSERT INTO $db[usuarios] (usuario, password, nivel)
             VALUES (:usuario, :password, $nivel)";
$result = $pdo->prepare($consulta);
if ($result->execute([":usuario" => $usuario, ":password" => encripta($password)])) {
    print "    <p>Registro <strong>$usuario</strong> creado correctamente.</p>\n";
} else {
    print "    <p class=\"aviso\">Error al crear el registro <strong>$usuario</strong>.</p>\n";
}

$pdo = null;

pie();
