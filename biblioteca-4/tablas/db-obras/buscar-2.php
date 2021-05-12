<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_2, PROFUNDIDAD_2);

borraAvisosExcepto();

[$autor, $titulo, $editorial] = compruebaAvisosIndividuales("obras", "buscar-2", "autor", "titulo", "editorial");

compruebaAvisosGenerales("obras", "buscar-2", "registrosNoEncontrados", "autor", "titulo", "editorial");

if (hayErrores("obras", "buscar-2")) {
    header("Location:buscar-1.php");
    exit();
}

cabecera("Obras - Buscar 2", MENU_OBRAS, PROFUNDIDAD_2);

$pdo = conectaDb();

$ordena = recogeValores("ordena", $db["columnasObrasOrden"], "autor ASC");

$consulta = "SELECT *
             FROM $db[obras]
             WHERE
               autor LIKE :autor
               AND titulo LIKE :titulo
               AND editorial LIKE :editorial
             ORDER BY $ordena";
$result = $pdo->prepare($consulta);
$result->execute([":autor" => "%$autor%", ":titulo" => "%$titulo%", ":editorial" => "%$editorial%"]);
if (!$result) {
    print "    <p class=\"aviso-error\">Error en la consulta.</p>\n";
} else {
    print "    <form action=\"$_SERVER[PHP_SELF]\" method=\"$cfg[formMethod]\">\n";
    print "      <p>\n";
    print "        <input type=\"hidden\" name=\"autor\" value=\"$autor\">\n";
    print "        <input type=\"hidden\" name=\"titulo\" value=\"$titulo\">\n";
    print "        <input type=\"hidden\" name=\"editorial\" value=\"$editorial\">\n";
    print "      </p>\n";
    print "\n";
    print "      <p>Registros encontrados:</p>\n";
    print "\n";
    print "      <table class=\"conborde franjas\">\n";
    print "        <thead>\n";
    print "          <tr>\n";
    print "            <th>\n";
    print "              <button name=\"ordena\" value=\"autor ASC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "              Autor\n";
    print "              <button name=\"ordena\" value=\"autor DESC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "            </th>\n";
    print "            <th>\n";
    print "              <button name=\"ordena\" value=\"titulo ASC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "              Título\n";
    print "              <button name=\"ordena\" value=\"titulo DESC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "            </th>\n";
    print "            <th>\n";
    print "              <button name=\"ordena\" value=\"editorial ASC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "              Editorial\n";
    print "              <button name=\"ordena\" value=\"editorial DESC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "            </th>\n";
    print "          </tr>\n";
    print "        </thead>\n";
    print "        <tbody>\n";
    foreach ($result as $valor) {
        print "          <tr>\n";
        print "            <td>$valor[autor]</td>\n";
        print "            <td>$valor[titulo]</td>\n";
        print "            <td>$valor[editorial]</td>\n";
        print "          </tr>\n";
    }
    print "        </tbody>\n";
    print "      </table>\n";
    print "    </form>\n";
}

$pdo = null;

pie();
