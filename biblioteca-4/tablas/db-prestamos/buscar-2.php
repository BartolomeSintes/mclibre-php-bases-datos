<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

session_name($cfg["sessionName"]);
session_start();
if (!isset($_SESSION["conectado"]) || $_SESSION["conectado"] < NIVEL_2) {
    header("Location:../../index.php");
    exit;
}

cabecera("Préstamos - Buscar 2", MENU_PRESTAMOS, PROFUNDIDAD_2);

$nombre     = recoge("nombre");
$apellidos  = recoge("apellidos");
$autor      = recoge("autor");
$titulo     = recoge("titulo");
$prestado_1 = recoge("prestado_1");
$prestado_2 = recoge("prestado_2");
$devuelto_1 = recoge("devuelto_1");
$devuelto_2 = recoge("devuelto_2");
$ordena     = recogeValores("ordena", $db["columnasPrestamosOrden"], "apellidos ASC");

$pdo = conectaDb();

// El número de parámetros en execute debe coincidir con el número de parámetros en la consulta.
$consultaPrestado = "";
$consultaDevuelto = "";
$parametros       = [":nombre" => "%$nombre%", ":apellidos" => "%$apellidos%",
    ":autor"                   => "%$autor%", ":titulo" => "%$titulo%", ];

if ($prestado_1 != "" && $prestado_2 != "") {
    $consultaPrestado          = "AND $db[tablaPrestamos].prestado BETWEEN :prestado_1 AND :prestado_2 ";
    $parametros[":prestado_1"] = $prestado_1;
    $parametros[":prestado_2"] = $prestado_2;
} elseif ($prestado_1 != "") {
    $consultaPrestado          = "AND $db[tablaPrestamos].prestado >= :prestado_1 ";
    $parametros[":prestado_1"] = $prestado_1;
} elseif ($prestado_2 != "") {
    $consultaPrestado          = "AND $db[tablaPrestamos].prestado <= :prestado_2 ";
    $parametros[":prestado_2"] = $prestado_2;
}

if ($devuelto_1 != "" && $devuelto_2 != "") {
    $consultaDevuelto          = "AND $db[tablaPrestamos].devuelto BETWEEN :devuelto_1 AND :devuelto_2 ";
    $parametros[":devuelto_1"] = $devuelto_1;
    $parametros[":devuelto_2"] = $devuelto_2;
} elseif ($devuelto_1 != "") {
    $consultaDevuelto          = "AND $db[tablaPrestamos].devuelto >= :devuelto_1 ";
    $parametros[":devuelto_1"] = $devuelto_1;
} elseif ($devuelto_2 != "") {
    $consultaDevuelto          = "AND $db[tablaPrestamos].devuelto <= :devuelto_2 ";
    $parametros[":devuelto_2"] = $devuelto_2;
}

$consulta = "SELECT COUNT(*)
             FROM $db[tablaPersonas], $db[tablaObras], $db[tablaPrestamos]
             WHERE $db[tablaPrestamos].id_persona=$db[tablaPersonas].id
             AND $db[tablaPrestamos].id_obra=$db[tablaObras].id
             AND $db[tablaPersonas].nombre LIKE :nombre
             AND $db[tablaPersonas].apellidos LIKE :apellidos
             AND $db[tablaObras].autor LIKE :autor
             AND $db[tablaObras].titulo LIKE :titulo "
             . $consultaPrestado
             . $consultaDevuelto;

$result = $pdo->prepare($consulta);
$result->execute($parametros);
if (!$result) {
    print "    <p class=\"aviso\">Error en la consulta.</p>\n";
} elseif ($result->fetchColumn() == 0) {
    print "    <p>No se han encontrado registros.</p>\n";
} else {
    $consulta = "SELECT $db[tablaPrestamos].id as id,
                 $db[tablaPersonas].nombre as nombre,
                 $db[tablaPersonas].apellidos as apellidos,
                 $db[tablaObras].titulo as titulo,
                 $db[tablaObras].autor as autor,
                 $db[tablaPrestamos].prestado as prestado,
                 $db[tablaPrestamos].devuelto as devuelto
                 FROM $db[tablaPersonas], $db[tablaObras], $db[tablaPrestamos]
                 WHERE $db[tablaPrestamos].id_persona=$db[tablaPersonas].id
                 AND $db[tablaPrestamos].id_obra=$db[tablaObras].id
                 AND $db[tablaPersonas].nombre LIKE :nombre
                 AND $db[tablaPersonas].apellidos LIKE :apellidos
                 AND $db[tablaObras].autor LIKE :autor
                 AND $db[tablaObras].titulo LIKE :titulo "
                 . $consultaPrestado
                 . $consultaDevuelto
                 . " ORDER BY $ordena";
    $result = $pdo->prepare($consulta);
    $result->execute($parametros);
    if (!$result) {
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } else {
        print "    <form action=\"$_SERVER[PHP_SELF]\" method=\"$cfg[formMethod]\">\n";
        print "      <p>\n";
        print "        <input type=\"hidden\" name=\"nombre\" value=\"$nombre\">\n";
        print "        <input type=\"hidden\" name=\"apellidos\" value=\"$apellidos\">\n";
        print "        <input type=\"hidden\" name=\"autor\" value=\"$autor\">\n";
        print "        <input type=\"hidden\" name=\"titulo\" value=\"$titulo\">\n";
        print "        <input type=\"hidden\" name=\"prestado_1\" value=\"$prestado_1\">\n";
        print "        <input type=\"hidden\" name=\"prestado_2\" value=\"$prestado_2\">\n";
        print "        <input type=\"hidden\" name=\"devuelto_1\" value=\"$devuelto_1\">\n";
        print "        <input type=\"hidden\" name=\"devuelto_2\" value=\"$devuelto_2\">\n";
        print "      </p>\n";
        print "\n";
        print "      <p>Registros encontrados:</p>\n";
        print "\n";
        print "      <table class=\"conborde franjas\">\n";
        print "        <thead>\n";
        print "          <tr>\n";
        print "            <th>\n";
        print "              <button name=\"ordena\" value=\"apellidos ASC\" class=\"boton-invisible\">\n";
        print "                <img src=\"../../img/abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\">\n";
        print "              </button>\n";
        print "              Persona\n";
        print "              <button name=\"ordena\" value=\"apellidos DESC\" class=\"boton-invisible\">\n";
        print "                <img src=\"../../img/arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\">\n";
        print "              </button>\n";
        print "            </th>\n";
        print "            <th>\n";
        print "              <button name=\"ordena\" value=\"autor ASC\" class=\"boton-invisible\">\n";
        print "                <img src=\"../../img/abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\">\n";
        print "              </button>\n";
        print "              Obra\n";
        print "              <button name=\"ordena\" value=\"autor DESC\" class=\"boton-invisible\">\n";
        print "                <img src=\"../../img/arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\">\n";
        print "              </button>\n";
        print "            </th>\n";
        print "            <th>\n";
        print "              <button name=\"ordena\" value=\"prestado ASC\" class=\"boton-invisible\">\n";
        print "                <img src=\"../../img/abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\">\n";
        print "              </button>\n";
        print "              Préstamo\n";
        print "              <button name=\"ordena\" value=\"prestado DESC\" class=\"boton-invisible\">\n";
        print "                <img src=\"../../img/arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\">\n";
        print "              </button>\n";
        print "            </th>\n";
        print "            <th>\n";
        print "              <button name=\"ordena\" value=\"devuelto ASC\" class=\"boton-invisible\">\n";
        print "                <img src=\"../../img/abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\">\n";
        print "              </button>\n";
        print "              Devolución\n";
        print "              <button name=\"ordena\" value=\"devuelto DESC\" class=\"boton-invisible\">\n";
        print "                <img src=\"../../img/arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\">\n";
        print "              </button>\n";
        print "            </th>\n";
        print "          </tr>\n";
        print "        </thead>\n";
        print "        <tbody>\n";
        foreach ($result as $valor) {
            print "          <tr>\n";
            print "            <td>$valor[nombre] $valor[apellidos]</td>\n";
            print "            <td>$valor[autor] - $valor[titulo]</td>\n";
            print "            <td>";
            if ($valor["prestado"] != "0000-00-00") {
                print $valor["prestado"];
            }
            print "</td>\n";
            print "            <td>";
            if ($valor["devuelto"] != "0000-00-00") {
                print $valor["devuelto"];
            }
            print "</td>\n";
            print "          </tr>\n";
        }
        print "        </tbody>\n";
        print "      </table>\n";
        print "    </form>\n";
    }
}

$pdo = null;
pie();
