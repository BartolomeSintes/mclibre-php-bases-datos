<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_2, PROFUNDIDAD_2);

cabecera("Préstamos - Buscar 2", MENU_PRESTAMOS, PROFUNDIDAD_2);

recoge("nombre", "apellidos", "autor", "titulo", "prestado_1", "prestado_2", "devuelto_1", "devuelto_2");

recogeValores("ordena", $db["columnasPrestamosOrden"], "apellidos ASC");

$pdo = conectaDb();

// El número de parámetros en execute debe coincidir con el número de parámetros en la consulta.
$consultaPrestado = "";
$consultaDevuelto = "";
$parametros       = [":nombre" => "%$recogido[nombre]%", ":apellidos" => "%$recogido[apellidos]%", ":autor" => "%$recogido[autor]%", ":titulo" => "%$recogido[titulo]%"];

if ($recogido["prestado_1"] != "" && $recogido["prestado_2"] != "") {
    $consultaPrestado          = "AND $db[prestamos].prestado BETWEEN :prestado_1 AND :prestado_2 ";
    $parametros[":prestado_1"] = $recogido["prestado_1"];
    $parametros[":prestado_2"] = $recogido["prestado_2"];
} elseif ($recogido["prestado_1"] != "") {
    $consultaPrestado          = "AND $db[prestamos].prestado >= :prestado_1 ";
    $parametros[":prestado_1"] = $recogido["prestado_1"];
} elseif ($recogido["prestado_2"] != "") {
    $consultaPrestado          = "AND $db[prestamos].prestado <= :prestado_2 ";
    $parametros[":prestado_2"] = $recogido["prestado_2"];
}

if ($recogido["devuelto_1"] != "" && $recogido["devuelto_2"] != "") {
    $consultaDevuelto          = "AND $db[prestamos].devuelto BETWEEN :devuelto_1 AND :devuelto_2 ";
    $parametros[":devuelto_1"] = $recogido["devuelto_1"];
    $parametros[":devuelto_2"] = $recogido["devuelto_2"];
} elseif ($recogido["devuelto_1"] != "") {
    $consultaDevuelto          = "AND $db[prestamos].devuelto >= :devuelto_1 ";
    $parametros[":devuelto_1"] = $recogido["devuelto_1"];
} elseif ($recogido["devuelto_2"] != "") {
    $consultaDevuelto          = "AND $db[prestamos].devuelto <= :devuelto_2 ";
    $parametros[":devuelto_2"] = $recogido["devuelto_2"];
}

$consulta = "SELECT COUNT(*)
             FROM $db[prestamos] as prestamos
             JOIN $db[obras] as obras
             ON prestamos.id_obra=obras.id
             JOIN $db[personas] as personas
             ON prestamos.id_persona=personas.id
             WHERE
               nombre LIKE :nombre
               AND apellidos LIKE :apellidos
               AND autor LIKE :autor
               AND titulo LIKE :titulo "
             . $consultaPrestado
             . $consultaDevuelto;

$result = $pdo->prepare($consulta);
$result->execute($parametros);
if (!$result) {
    print "    <p class=\"aviso-error\">Error en la consulta.</p>\n";
} elseif ($result->fetchColumn() == 0) {
    print "    <p class=\"aviso-info\">No se han encontrado registros.</p>\n";
} else {
    $consulta = "SELECT
                   prestamos.id,
                   personas.nombre,
                   personas.apellidos,
                   obras.titulo,
                   obras.autor,
                   prestamos.prestado,
                   prestamos.devuelto
                FROM $db[prestamos] as prestamos
                JOIN $db[obras] as obras
                ON prestamos.id_obra=obras.id
                JOIN $db[personas] as personas
                ON prestamos.id_persona=personas.id
                WHERE
                  nombre LIKE :nombre
                  AND apellidos LIKE :apellidos
                  AND autor LIKE :autor
                  AND titulo LIKE :titulo "
                . $consultaPrestado
                . $consultaDevuelto
                . " ORDER BY $recogido[ordena]";

    $result = $pdo->prepare($consulta);
    $result->execute($parametros);
    if (!$result) {
        print "    <p class=\"aviso-error\">Error en la consulta.</p>\n";
    } else {
        print "    <form action=\"$_SERVER[PHP_SELF]\" method=\"$cfg[formMethod]\">\n";
        print "      <p>\n";
        print "        <input type=\"hidden\" name=\"nombre\" value=\"$recogido[nombre]\">\n";
        print "        <input type=\"hidden\" name=\"apellidos\" value=\"$recogido[apellidos]\">\n";
        print "        <input type=\"hidden\" name=\"autor\" value=\"$recogido[autor]\">\n";
        print "        <input type=\"hidden\" name=\"titulo\" value=\"$recogido[titulo]\">\n";
        print "        <input type=\"hidden\" name=\"prestado_1\" value=\"$recogido[prestado_1]\">\n";
        print "        <input type=\"hidden\" name=\"prestado_2\" value=\"$recogido[prestado_2]\">\n";
        print "        <input type=\"hidden\" name=\"devuelto_1\" value=\"$recogido[devuelto_1]\">\n";
        print "        <input type=\"hidden\" name=\"devuelto_2\" value=\"$recogido[devuelto_2]\">\n";
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
