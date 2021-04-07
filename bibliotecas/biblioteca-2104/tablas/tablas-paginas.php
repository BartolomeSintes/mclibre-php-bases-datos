<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

 // TODO: TENER EN CUENTA EL NIVEL
function comprueba_sesion($nivel)
{
    if (!isset($_SESSION["conectado"])) {
        header("Location:../index.php");
        exit;
    }
}

function listar($arg)
{
    global $cfg;

    comprueba_sesion($arg["nivel"]);
    $db = conectaDb();
    cabecera($arg["cabeceraTexto"], $arg["cabeceraMenu"], $arg["cabeceraProfundidad"]);
    $ordena = recogeValores("ordena", $arg["columnasOrden"], $arg["columnasOrdenPredeterminado"]);

    $result = consultas($arg["tabla"], $arg["accion"], 1);
    if (!$result) {
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } elseif ($result[0][0] == 0) {
        print "    <p>No se ha creado todavía ningún registro.</p>\n";
    } else {
        $result = consultas($arg["tabla"], $arg["accion"], 2, [$ordena]);
        if (!$result) {
            print "    <p class=\"aviso\">Error en la consulta.</p>\n";
        } else {
            print "    <p>Listado completo de registros:</p>\n";
            print "\n";
            print "    <form action=\"$_SERVER[PHP_SELF]\" method=\"$cfg[formMethod]\">\n";
            print "      <table class=\"conborde franjas\">\n";
            print "        <thead>\n";
            print "          <tr>\n";
            foreach ($arg["campos"] as $campo) {
                print "            <th>\n";
                print "              <button name=\"ordena\" value=\"$campo[campo] ASC\" class=\"boton-invisible\">\n";
                print "                <img src=\"../img/abajo.svg\" alt=\"A-Z\" title=\"A-Z\" width=\"15\" height=\"12\">\n";
                print "              </button>\n";
                print "              $campo[texto] \n";
                print "              <button name=\"ordena\" value=\"$campo[campo] DESC\" class=\"boton-invisible\">\n";
                print "                <img src=\"../img/arriba.svg\" alt=\"Z-A\" title=\"Z-A\" width=\"15\" height=\"12\">\n";
                print "              </button>\n";
                print "            </th>\n";
            }
            print "          </tr>\n";
            print "        </thead>\n";
            print "        <tbody>\n";
            $arg["result"] = $result;
            fragmentos($arg["tabla"], $arg["accion"], 1, $arg);
            print "        </tbody>\n";
            print "      </table>\n";
            print "\n";
            print "      <p>\n";
            print "        <input type=\"hidden\" name=\"tabla\" value=\"$arg[tabla]\">\n";
            print "        <input type=\"hidden\" name=\"accion\" value=\"listar\">\n";
            print "      </p>\n";
            print "    </form>\n";
        }
    }

    $db = null;
    pie();
}

function insertar_1_a($arg)
{
    global $cfg;

    comprueba_sesion($arg["nivel"]);
    $db = conectaDb();
    cabecera($arg["cabeceraTexto"], $arg["cabeceraMenu"], $arg["cabeceraProfundidad"]);

    $result = consultas($arg["tabla"], $arg["accion"], 1);
    if (!$result) {
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } elseif ($result[0][0] >= $cfg["maxRegTableObras"]) {
        print "    <p class=\"aviso\">Se ha alcanzado el número máximo de registros que se pueden guardar.</p>\n";
        print "\n";
        print "    <p class=\"aviso\">Por favor, borre algún registro antes.</p>\n";
    } else {
        print "    <form action=\"tablas.php\" method=\"$cfg[formMethod]\">\n";
        print "      <p>Escriba los datos del nuevo registro:</p>\n";
        print "\n";
        print "      <table>\n";
        print "        <tbody>\n";
        fragmentos($arg["tabla"], $arg["accion"], 1, $arg);
        print "        </tbody>\n";
        print "      </table>\n";
        print "\n";
        print "      <p>\n";
        print "        <input type=\"hidden\" name=\"tabla\" value=\"$arg[tabla]\">\n";
        print "        <input type=\"hidden\" name=\"accion\" value=\"insertar-2\">\n";
        print "        <input type=\"submit\" value=\"Añadir\">\n";
        print "        <input type=\"reset\" value=\"Reiniciar formulario\">\n";
        print "      </p>\n";
        print "    </form>\n";
    }

    $db = null;
    pie();
}

function insertar_1_b($arg)
{
    global $cfg;

    comprueba_sesion($arg["nivel"]);
    $db = conectaDb();
    cabecera($arg["cabeceraTexto"], $arg["cabeceraMenu"], $arg["cabeceraProfundidad"]);

    $consulta = "SELECT COUNT(*) FROM $cfg[tablaPrestamos]";
    $result   = $db->query($consulta);
    if (!$result) {
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
    } elseif ($result->fetchColumn() >= $cfg["maxRegTablePrestamos"]) {
        print "    <p class=\"aviso\">Se ha alcanzado el número máximo de registros que se pueden guardar.</p>\n";
        print "\n";
        print "    <p class=\"aviso\">Por favor, borre algún registro antes.</p>\n";
    } else {
        $consulta2 = "SELECT * FROM $cfg[tablaPersonas] ORDER BY apellidos";
        $result2   = $db->query($consulta2);
        $consulta3 = "SELECT * FROM $cfg[tablaObras] ORDER BY autor";
        $result3   = $db->query($consulta3);
        if (!$result2) {
            print "    <p class=\"aviso\">Error en la consulta.</p>\n";
        } elseif (!$result3) {
            print "    <p class=\"aviso\">Error en la consulta.</p>\n";
        } else {
            print "    <form action=\"insertar-2.php\" method=\"$cfg[formMethod]\">\n";
            print "      <p>Escriba los datos del nuevo préstamo:</p>\n";
            print "\n";
            print "      <table>\n";
            print "        <tbody>\n";
            print "          <tr>\n";
            print "            <td>Persona:</td>\n";
            print "            <td>\n";
            print "            <select name=\"id_persona\">\n";
            print "                <option value=\"\"></option>\n";
            foreach ($result2 as $valor) {
                print "                <option value=\"$valor[id]\">$valor[nombre] $valor[apellidos]</option>\n";
            }
            print "              </select>\n";
            print "            </td>\n";
            print "          </tr>\n";
            print "          <tr>\n";
            print "            <td>Obra:</td>\n";
            print "            <td>\n";
            print "            <select name=\"id_obra\">\n";
            print "                <option value=\"\"></option>\n";
            foreach ($result3 as $valor) {
                print "                <option value=\"$valor[id]\">$valor[autor] - $valor[titulo]</option>\n";
            }
            print "              </select>\n";
            print "            </td>\n";
            print "          </tr>\n";
            print "          <tr>\n";
            print "            <td>Fecha de préstamo:</td>\n";
            print "            <td><input type=\"date\" name=\"prestado\" value=\"" . date("Y-m-j") . "\"></td>\n";
            print "          </tr>\n";
            print "        </tbody>\n";
            print "      </table>\n";
            print "\n";
            print "      <p>\n";
            print "        <input type=\"submit\" value=\"Añadir\">\n";
            print "        <input type=\"reset\" value=\"Reiniciar formulario\">\n";
            print "      </p>\n";
            print "    </form>\n";
        }
    }

    $db = null;
    pie();
}

function insertar_2($arg)
{
    global $cfg;

    comprueba_sesion($arg["nivel"]);
    $db = conectaDb();
    cabecera($arg["cabeceraTexto"], $arg["cabeceraMenu"], $arg["cabeceraProfundidad"]);

    $ok      = true;
    $valores = [];
    foreach ($arg["controles"] as $control) {
        $valores[$control] = recoge($control);
        $ok                = $ok && comprobaciones($control, $valores[$control]);
    }
    if ($ok) {
        if (compruebaConjunto($valores, "algunoVacio")) {
            print "    <p class=\"aviso\">Hay que rellenar todos los campos. No se ha guardado el registro.</p>\n";
        } else {
            $result = consultas($arg["tabla"], $arg["accion"], 1);
            if (!$result) {
                print "    <p class=\"aviso\">Error en la consulta.</p>\n";
            } elseif ($result[0][0] >= $cfg["maxRegTableUsuarios"]) {
                print "    <p class=\"aviso\">Se ha alcanzado el número máximo de registros que se pueden guardar.</p>\n";
                print "\n";
                print "    <p class=\"aviso\">Por favor, borre algún registro antes.</p>\n";
            } else {
                // $consulta = "SELECT COUNT(*) FROM $cfg[tablaUsuarios]
                //     WHERE usuario=:usuario";
                // $result = $db->prepare($consulta);
                // $result->execute([":usuario" => $usuario]);
                $result = consultas($arg["tabla"], $arg["accion"], 2, [$valores[$arg["consultaParametros"][0][0]]]);
                if (!$result) {
                    print "    <p class=\"aviso\">Error en la consulta.</p>\n";
                } elseif ($result[0][0] > 0) {
                    print "    <p class=\"aviso\">El registro ya existe.</p>\n";
                } else {
                    $result = consultas(
                        $arg["tabla"],
                        $arg["accion"],
                        3,
                        [$valores[$arg["consultaParametros"][1][0]], $valores[$arg["consultaParametros"][1][1]], $valores[$arg["consultaParametros"][1][2]]]
                    );
                    if ($result) {
                        print "    <p>Registro creado correctamente.</p>\n";
                    } else {
                        print "    <p class=\"aviso\">Error al crear el registro <strong>$usuario " . encripta($password) . "</strong>.</p>\n";
                    }
                }
            }
        }
    }
}

function borrar_1($arg)
{
    global $cfg;

    print "<p>XXX borrar_1() por escribir</p>";
}

function borrar_2($arg)
{
    global $cfg;

    print "<p>XXX borrar_2() por escribir</p>";
}

function buscar_1($arg)
{
    global $cfg;

    print "<p>XXX buscar_1() por escribir</p>";
}

function buscar_2($arg)
{
    global $cfg;

    print "<p>XXX buscar_2() por escribir</p>";
}

function modificar_1($arg)
{
    global $cfg;

    print "<p>XXX modificar_1() por escribir</p>";
}

function modificar_2($arg)
{
    global $cfg;

    print "<p>XXX modificar_2() por escribir</p>";
}

function modificar_3($arg)
{
    global $cfg;

    print "<p>XXX modificar_3() por escribir</p>";
}
