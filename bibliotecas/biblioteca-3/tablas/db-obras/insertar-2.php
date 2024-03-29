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
cabecera("Obras - Añadir 2", MENU_OBRAS, PROFUNDIDAD_2);

$autor     = recoge("autor");
$titulo    = recoge("titulo");
$editorial = recoge("editorial");

$autorOk     = false;
$tituloOk    = false;
$editorialOk = false;

if (mb_strlen($autor, "UTF-8") > $db["tamObrasAutor"]) {
    print "    <p class=\"aviso\">El autor no puede tener más de $db[tamObrasAutor] caracteres.</p>\n";
    print "\n";
} else {
    $autorOk = true;
}

if (mb_strlen($titulo, "UTF-8") > $db["tamObrasTitulo"]) {
    print "    <p class=\"aviso\">Los títulos no pueden tener más de $db[tamObrasTitulo] caracteres.</p>\n";
    print "\n";
} else {
    $tituloOk = true;
}

if (mb_strlen($editorial, "UTF-8") > $db["tamObrasEditorial"]) {
    print "    <p class=\"aviso\">La editorial no puede tener más de $db[tamObrasEditorial] caracteres.</p>\n";
    print "\n";
} else {
    $editorialOk = true;
}

if ($autorOk && $tituloOk && $editorialOk) {
    if ($autor == "" && $titulo == "" && $editorial == "") {
        print "    <p class=\"aviso\">Hay que rellenar al menos uno de los campos. No se ha guardado el registro.</p>\n";
    } else {
        $consulta = "SELECT COUNT(*) FROM $db[tablaObras]";
        $result   = $pdo->query($consulta);
        if (!$result) {
            print "    <p class=\"aviso\">Error en la consulta.</p>\n";
        } elseif ($result->fetchColumn() >= $cfg["maxRegTableObras"] ) {
            print "    <p class=\"aviso\">Se ha alcanzado el número máximo de registros que se pueden guardar.</p>\n";
            print "\n";
            print "    <p class=\"aviso\">Por favor, borre algún registro antes.</p>\n";
        } else {
            $consulta = "SELECT COUNT(*) FROM $db[tablaObras]
                WHERE autor=:autor
                AND titulo=:titulo
                AND editorial=:editorial";
            $result = $pdo->prepare($consulta);
            $result->execute([":autor" => $autor, ":titulo" => $titulo,
                ":editorial"           => $editorial, ]);
            if (!$result) {
                print "    <p class=\"aviso\">Error en la consulta.</p>\n";
            } elseif ($result->fetchColumn() > 0) {
                print "    <p class=\"aviso\">El registro ya existe.</p>\n";
            } else {
                $consulta = "INSERT INTO $db[tablaObras]
                    (autor, titulo, editorial)
                    VALUES (:autor, :titulo, :editorial)";
                $result = $pdo->prepare($consulta);
                if ($result->execute([":autor" => $autor, ":titulo" => $titulo,
                    ":editorial" => $editorial, ])) {
                    print "    <p>Registro <strong>$autor $titulo $editorial</strong> creado correctamente.</p>\n";
                } else {
                    print "    <p class=\"aviso\">Error al crear el registro <strong>$autor $titulo $editorial</strong>.</p>\n";
                }
            }
        }
    }
}

$pdo = null;
pie();
