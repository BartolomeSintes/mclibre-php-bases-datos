<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

cabecera("Personas - Modificar 1", MENU_PERSONAS, PROFUNDIDAD_2);

imprimeAvisosGenerales("modificar-2", "modificar-3");

borraAvisosExcepto();

compruebaAvisosGenerales("modificar-1", "sinRegistros", "personas");

if (!imprimeAvisosGenerales("modificar-1")) {
    $pdo = conectaDb();

    $ordena = recogeValores("ordena", $db["columnasPersonasOrden"], "apellidos ASC");
    $id     = recoge("id");

    $consulta = "SELECT *
                 FROM $db[personas]
                 ORDER BY $ordena";
    $result = $pdo->query($consulta);
    if (!$result) {
        print "    <p class=\"aviso-error\">Error en la consulta.</p>\n";
    } else {
        print "    <form action=\"$_SERVER[PHP_SELF]\" method=\"$cfg[formMethod]\">\n";
        print "      <p>Indique el registro que quiera modificar:</p>\n";
        print "\n";
        print "      <table class=\"conborde franjas\">\n";
        print "        <thead>\n";
        print "          <tr>\n";
        print "            <th>Modificar</th>\n";
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
            if ($id == $valor["id"]) {
                print "            <td class=\"centrado\"><input type=\"radio\" name=\"id\" value=\"$valor[id]\" checked></td>\n";
            } else {
                print "            <td class=\"centrado\"><input type=\"radio\" name=\"id\" value=\"$valor[id]\"></td>\n";
            }
            print "            <td>$valor[nombre]</td>\n";
            print "            <td>$valor[apellidos]</td>\n";
            print "            <td>$valor[dni]</td>\n";
            print "          </tr>\n";
        }
        print "        </tbody>\n";
        print "      </table>\n";
        print "\n";
        print "      <p>\n";
        print "        <input type=\"submit\" value=\"Modificar registro\" formaction=\"modificar-2.php\">\n";
        print "        <input type=\"reset\" value=\"Reiniciar formulario\">\n";
        print "      </p>\n";
        print "    </form>\n";
    }
    $pdo = null;
}

pie();
