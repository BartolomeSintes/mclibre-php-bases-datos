<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_2, PROFUNDIDAD_2);

cabecera("Personas - Buscar 2", MENU_PERSONAS, PROFUNDIDAD_2);

borraAvisosExcepto();

[$nombre, $apellidos, $dni] = compruebaAvisosIndividuales("buscar-2", "personas", "nombre", "apellidos", "dni");

compruebaAvisosGenerales("buscar-2", "registrosNoEncontrados", "personas", "nombre", "apellidos", "dni");

if (hayErrores("buscar-2")) {
    header("Location:buscar-1.php");
    exit();
}

$pdo = conectaDb();

$ordena = recogeValores("ordena", $db["columnasPersonasOrden"], "apellidos ASC");

$consulta = "SELECT *
             FROM $db[personas]
             WHERE
               nombre LIKE :nombre
               AND apellidos LIKE :apellidos
               AND dni LIKE :dni
             ORDER BY $ordena";
$result = $pdo->prepare($consulta);
$result->execute([":nombre" => "%$nombre%", ":apellidos" => "%$apellidos%", ":dni" => "%$dni%"]);
if (!$result) {
    print "    <p class=\"aviso\">Error en la consulta.</p>\n";
} else {
    print "    <form action=\"$_SERVER[PHP_SELF]\" method=\"$cfg[formMethod]\">\n";
    print "      <p>\n";
    print "        <input type=\"hidden\" name=\"nombre\" value=\"$nombre\">\n";
    print "        <input type=\"hidden\" name=\"apellidos\" value=\"$apellidos\">\n";
    print "        <input type=\"hidden\" name=\"dni\" value=\"$dni\">\n";
    print "      </p>\n";
    print "\n";
    print "      <p>Registros encontrados:</p>\n";
    print "\n";
    print "      <table class=\"conborde franjas\">\n";
    print "        <thead>\n";
    print "          <tr>\n";
    print "            <th>\n";
    print "              <button name=\"ordena\" value=\"nombre ASC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "              Nombre\n";
    print "              <button name=\"ordena\" value=\"nombre DESC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "            </th>\n";
    print "            <th>\n";
    print "              <button name=\"ordena\" value=\"apellidos ASC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "              Apellidos\n";
    print "              <button name=\"ordena\" value=\"apellidos DESC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "            </th>\n";
    print "            <th>\n";
    print "              <button name=\"ordena\" value=\"dni ASC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "              DNI\n";
    print "              <button name=\"ordena\" value=\"dni DESC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "            </th>\n";
    print "          </tr>\n";
    print "        </thead>\n";
    print "        <tbody>\n";
    foreach ($result as $valor) {
        print "          <tr>\n";
        print "            <td>$valor[nombre]</td>\n";
        print "            <td>$valor[apellidos]</td>\n";
        print "            <td>$valor[dni]</td>\n";
        print "          </tr>\n";
    }
    print "        </tbody>\n";
    print "      </table>\n";
    print "    </form>\n";
}

$pdo = null;

pie();
