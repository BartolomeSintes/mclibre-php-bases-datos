<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../../comunes/biblioteca.php";

compruebaSesion(NIVEL_3, PROFUNDIDAD_2);

borraAvisosExcepto();

recoge("usuario", "password", "nivel");

compruebaAvisosIndividuales("usuarios", "buscar-2", "usuario", "password", "nivel");

compruebaAvisosGenerales("usuarios", "buscar-2", "registrosNoEncontrados", "usuario", "password", "nivel");

if (hayErrores("usuarios", "buscar-2")) {
    header("Location:buscar-1.php");
    exit();
}

cabecera("Usuarios - Buscar 2", MENU_USUARIOS, PROFUNDIDAD_2);

$pdo = conectaDb();

recogeValores("ordena", $db["columnasUsuariosOrden"], "password ASC");

$consulta = "SELECT *
             FROM $db[usuarios]
             WHERE
               usuario LIKE :usuario
               AND password LIKE :password
               AND nivel LIKE :nivel
             ORDER BY $recogido[ordena]";
$result = $pdo->prepare($consulta);
$result->execute([":usuario" => "%$recogido[usuario]%", ":password" => "%$recogido[password]%", ":nivel" => "%$recogido[nivel]%"]);
if (!$result) {
    print "    <p class=\"aviso-error\">Error en la consulta.</p>\n";
} else {
    print "    <form action=\"$_SERVER[PHP_SELF]\" method=\"$cfg[formMethod]\">\n";
    print "      <p>\n";
    print "        <input type=\"hidden\" name=\"usuario\" value=\"$recogido[usuario]\">\n";
    print "        <input type=\"hidden\" name=\"password\" value=\"$recogido[password]\">\n";
    print "        <input type=\"hidden\" name=\"nivel\" value=\"$recogido[nivel]\">\n";
    print "      </p>\n";
    print "\n";
    print "      <p>Registros encontrados:</p>\n";
    print "\n";
    print "      <table class=\"conborde franjas\">\n";
    print "        <thead>\n";
    print "          <tr>\n";
    print "            <th>\n";
    print "              <button name=\"ordena\" value=\"usuario ASC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "              Usuario\n";
    print "              <button name=\"ordena\" value=\"usuario DESC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "            </th>\n";
    print "            <th>\n";
    print "              <button name=\"ordena\" value=\"password ASC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "              Contraseña\n";
    print "              <button name=\"ordena\" value=\"password DESC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "            </th>\n";
    print "            <th>\n";
    print "              <button name=\"ordena\" value=\"nivel ASC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "              Nivel\n";
    print "              <button name=\"ordena\" value=\"nivel DESC\" class=\"boton-invisible\">\n";
    print "                <img src=\"../../img/arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\">\n";
    print "              </button>\n";
    print "            </th>\n";
    print "        </thead>\n";
    print "        <tbody>\n";
    foreach ($result as $valor) {
        print "          <tr>\n";
        print "            <td>$valor[usuario]</td>\n";
        print "            <td>$valor[password]</td>\n";
        print "            <td>" . array_search($valor["nivel"], $usuariosNiveles) . "</td>\n";
        print "          </tr>\n";
    }
    print "        </tbody>\n";
    print "      </table>\n";
    print "    </form>\n";
}

$pdo = null;

pie();
