<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto();

[$id] = compruebaAvisosIndividuales("usuarios", "modificar-3", "id");

if (hayErrores("usuarios", "modificar-3")) {
    header("Location:modificar-1.php");
    exit();
}

compruebaAvisosGenerales("usuarios", "modificar-3", "registrosExisten", $id);

if (hayErrores("usuarios", "modificar-3")) {
    header("Location:modificar-1.php");
    exit();
}

[$usuario, $password, $nivel] = compruebaAvisosIndividuales("usuarios", "modificar-3", "usuario", "password", "nivel");

incluyeValoresOriginalesEnAvisos("usuarios", "modificar-3", "usuario", "password", "nivel", "id");

compruebaAvisosGenerales("usuarios", "modificar-3", "yaExisteRegistroConOtroId", "usuario", "password", "nivel", "id");

compruebaAvisosGenerales("usuarios", "modificar-3", "incluyeUsuarioRoot", $usuario, $password, $nivel, $id);

if (hayErrores("usuarios", "modificar-3")) {
    header("Location:modificar-2.php");
    exit();
}

cabecera("Usuarios - Modificar 3", MENU_USUARIOS, PROFUNDIDAD_2);

$pdo = conectaDb();

if ($password != "") {
    $consulta = "UPDATE $db[usuarios]
                 SET
                   usuario=:usuario,
                   password=:password,
                   nivel=:nivel
                 WHERE id=:id";
    $result = $pdo->prepare($consulta);
    if ($result->execute([":usuario" => $usuario, ":password" => encripta($password), ":nivel" => $nivel, ":id" => $id])) {
        print "    <p class=\"aviso-info\">Registro modificado correctamente.</p>\n";
    } else {
        print "    <p class=\"aviso-error\">Error al modificar el registro.</p>\n";
    }
} else {
    $consulta = "UPDATE $db[usuarios]
                 SET
                   usuario=:usuario,
                   nivel=:nivel
                 WHERE id=:id";
    $result = $pdo->prepare($consulta);
    if ($result->execute([":usuario" => $usuario, ":nivel" => $nivel, ":id" => $id])) {
        print "    <p class=\"aviso-info\">Registro modificado correctamente.</p>\n";
    } else {
        print "    <p class=\"aviso-error\">Error al modificar el registro.</p>\n";
    }
}

$pdo = null;

pie();
