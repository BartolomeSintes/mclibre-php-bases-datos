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
[$nombre, $apellidos, $dni] = compruebaAvisosIndividuales("insertar-2", "nombre", "apellidos", "dni");
compruebaAvisosGenerales("insertar-2", "todosVacios", "nombre", "apellidos", "dni");
compruebaAvisosGenerales("insertar-2", "limiteNumeroRegistros", "personas");

if (isset($_SESSION["error"])) {
    header("Location:insertar-1.php");
    exit();
}

cabecera("Personas - Añadir 2", MENU_PERSONAS, PROFUNDIDAD_2);

$pdo = conectaDb();

$consulta = "SELECT COUNT(*) FROM $db[tablaPersonas]
             WHERE nombre=:nombre
             AND apellidos=:apellidos
             AND dni=:dni";
$result = $pdo->prepare($consulta);
$result->execute([":nombre" => $nombre, ":apellidos" => $apellidos, ":dni" => $dni]);
if (!$result) {
    print "    <p class=\"aviso\">Error en la consulta.</p>\n";
} elseif ($result->fetchColumn() > 0) {
    print "    <p class=\"aviso\">El registro ya existe.</p>\n";
} else {
    $consulta = "INSERT INTO $db[tablaPersonas]
                 (nombre, apellidos, dni)
                 VALUES (:nombre, :apellidos, :dni)";
    $result = $pdo->prepare($consulta);
    if ($result->execute([":nombre" => $nombre, ":apellidos" => $apellidos, ":dni" => $dni])) {
        print "    <p>Registro <strong>$nombre $apellidos - $dni</strong> creado correctamente.</p>\n";
    } else {
        print "    <p class=\"aviso\">Error al crear el registro <strong>$nombre $apellidos - $dni</strong>.</p>\n";
    }
}

$pdo = null;
pie();
