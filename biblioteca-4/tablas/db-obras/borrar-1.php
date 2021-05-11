<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

cabecera("Obras - Borrar 1", MENU_OBRAS, PROFUNDIDAD_2);

imprimeAvisosGenerales("obras", "borrar-2");

borraAvisosExcepto();

compruebaAvisosGenerales("obras", "borrar-1", "sinRegistros");

imprimeAvisosGenerales("obras", "borrar-1");

if (muestraFormulario()) {
    $pdo = conectaDb();

    $ordena = recogeValores("ordena", $db["columnasObrasOrden"], "titulo ASC");
    $id     = recoge("id[]");

    $consulta = "SELECT *
                 FROM $db[obras]
                 ORDER BY $ordena";
    $result = $pdo->query($consulta);
    if (!$result) {
        print "    <p class=\"aviso-error\">Error en la consulta.</p>\n";
    } else {
        print "    <form action=\"$_SERVER[PHP_SELF]\" method=\"$cfg[formMethod]\">\n";
        print "      <p>Marque los registros que quiera borrar:</p>\n";
        print "\n";
        print "      <table class=\"conborde franjas\">\n";
        print "        <thead>\n";
        print "          <tr>\n";
        print "            <th>Borrar</th>\n";
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
            if (isset($id[$valor["id"]])) {
                print "            <td class=\"centrado\"><input type=\"checkbox\" name=\"id[$valor[id]]\" checked></td>\n";
            } else {
                print "            <td class=\"centrado\"><input type=\"checkbox\" name=\"id[$valor[id]]\"></td>\n";
            }
            print "            <td>$valor[titulo]</td>\n";
            print "            <td>$valor[autor]</td>\n";
            print "            <td>$valor[editorial]</td>\n";
            print "          </tr>\n";
        }
        print "        </tbody>\n";
        print "      </table>\n";
        print "\n";
        print "      <p>\n";
        print "        <input type=\"submit\" value=\"Borrar registro\" formaction=\"borrar-2.php\">\n";
        print "        <input type=\"reset\" value=\"Reiniciar formulario\">\n";
        print "      </p>\n";
        print "    </form>\n";
    }
    $pdo = null;
}

pie();
