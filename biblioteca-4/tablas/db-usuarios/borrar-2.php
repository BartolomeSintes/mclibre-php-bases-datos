<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto();

recoge("id[]");

compruebaAvisosIndividuales("usuarios", "borrar-2", "id");

compruebaAvisosGenerales("usuarios", "borrar-2", "registrosExisten", "id");

compruebaAvisosGenerales("usuarios", "borrar-2", "incluyeUsuarioRoot", "id");

if (hayErrores("usuarios", "borrar-2")) {
    header("Location:borrar-1.php");
    exit();
}

cabecera("Usuarios - Borrar 2", MENU_USUARIOS, PROFUNDIDAD_2);

$pdo = conectaDb();

foreach ($recogido["id"] as $indice => $valor) {
    $consulta = "DELETE
                 FROM $db[usuarios]
                 WHERE id=:indice";
    $result = $pdo->prepare($consulta);
    if ($result->execute([":indice" => $indice])) {
        print "    <p class=\"aviso-info\">Registro borrado correctamente.</p>\n";
    } else {
        print "    <p class=\"aviso-error\">Error al borrar el registro.</p>\n";
    }
}

$pdo = null;

pie();
