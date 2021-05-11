<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "comprobaciones-particular.php";

function printValores()
{
    $argumentos = func_get_args();

    foreach ($argumentos as $valor) {
        if (is_array($valor)) {
            print "<pre>";
            print_r($valor);
            print "</pre>\n";
        } else {
            print "<p>$valor</p>\n";
        }
    }
}

function printSesion()
{
    print "  <details>\n";
    print "    <summary>Sesión</summary>\n";
    print "    <pre>";
    print_r($_SESSION);
    print "    </pre>\n";
    print "  </details>\n";
    print "\n";
}

function compruebaAvisosIndividuales()
{
    // Argumentos: pagina_de_origen, tabla, campo_1, campo_2, ...
    $argumentos = func_get_args();
    $tabla = $argumentos[0];
    array_shift($argumentos);
    $origen     = $argumentos[0];
    array_shift($argumentos);
    $resp       = [];
    $paraSesion = [];
    $error      = false;
    foreach ($argumentos as $campo) {
        $valor = recoge($campo);
        $campo = (substr($campo, -2) == "[]") ? substr($campo, 0, -2) : $campo;
        if (is_array($valor) && count($valor) > 0) {
            $comp = [];
            foreach ($valor as $indice => $valor2) {
                $resp          = comprobaciones($origen, $tabla, $campo, $indice);
                $comp[$indice] = ["valor" => $resp["valor"], "campoOk" => $resp["campoOk"], "mensaje" => $resp["mensaje"]];
            }
        } else {
            $comp = comprobaciones($origen, $tabla, $campo, $valor);
        }
        $paraSesion[$campo] = $comp;
        $resp[]             = $valor;
    }
    if (isset($_SESSION["avisosIndividuales"][$origen][$tabla])) {
        $_SESSION["avisosIndividuales"][$origen][$tabla] = array_merge_recursive($_SESSION["avisosIndividuales"][$origen][$tabla], $paraSesion);
    } else {
        $_SESSION["avisosIndividuales"][$origen][$tabla] = $paraSesion;
    }
    // devuelve [$valor1, $valor2, ...
    return $resp;
}

function incluyeValoresOriginalesEnAvisos()
{
    $argumentos = func_get_args();
    $tabla     = $argumentos[0];
    array_shift($argumentos);
    $origen     = $argumentos[0];
    array_shift($argumentos);
    $pdo      = conectaDb();
    $consulta = "SELECT *
                 FROM $tabla "
              . "WHERE id=:id";
    $result = $pdo->prepare($consulta);
    $result->execute([":id" => recoge($argumentos[count($argumentos) - 1])]);
    if (!$result) {
        $_SESSION["avisosGenerales"][$origen][$tabla][] = ["texto" => "Error en la consulta.", "claseAviso" => "aviso-error"];
    } else {
        $valor = $result->fetch(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($argumentos); $i++) {
            $_SESSION["avisosIndividuales"][$origen][$tabla][$argumentos[$i]]["original"] = $valor[$argumentos[$i]];
        }
    }
    $_SESSION["avisosIndividuales"][$origen]["muestraValoresOriginalesEnFormulario"] = true;
}

function imprimeAvisosGenerales()
{
    $argumentos = func_get_args();
    $tabla     = $argumentos[0];
    array_shift($argumentos);
    foreach ($argumentos as $origen) {
        if (isset($_SESSION["avisosGenerales"][$origen][$tabla]) && count($_SESSION["avisosGenerales"][$origen][$tabla]) > 0) {
            $_SESSION["avisosGenerales"][$origen][$tabla] = array_unique($_SESSION["avisosGenerales"][$origen][$tabla], SORT_REGULAR);
            foreach ($_SESSION["avisosGenerales"][$origen][$tabla] as $aviso) {
                print "    <p class=\"$aviso[claseAviso]\">$aviso[texto]</p>\n";
            }
        }
    }
}

function imprimeAvisosIndividuales($tabla, $origen, $campo, $tipo, $valor = "")
{
    if (hayErrores($origen)) {
        // if (hayErrores($origen)) {
        if (isset($_SESSION["avisosIndividuales"][$origen][$tabla][$campo])) {
            if ($tipo == "valor") {
                if (isset($_SESSION["avisosIndividuales"][$origen]["muestraValoresOriginalesEnFormulario"])) {
                    return " value=\"{$_SESSION["avisosIndividuales"][$origen][$tabla][$campo]["original"]}\"";
                }
                return " value=\"{$_SESSION["avisosIndividuales"][$origen][$tabla][$campo]["valor"]}\"";
            }
            if ($tipo == "mensaje" && $_SESSION["avisosIndividuales"][$origen][$tabla][$campo]["mensaje"]) {
                return " <span class=\"aviso-error\">{$_SESSION["avisosIndividuales"][$origen][$tabla][$campo]["mensaje"]}</span>";
            }
        }
    } else {
        if ($tipo == "valor" && $valor) {
            return " value=\"$valor\"";
        }
    }
    return "";
}

function borraAvisosExcepto()
{
    // Borra todos los avisos que no provienen de una página determinada
    $argumentos = func_get_args();

    if (!count($argumentos)) {
        unset($_SESSION["avisosGenerales"], $_SESSION["avisosIndividuales"]);
    } else {
        if (isset($_SESSION["avisosIndividuales"])) {
            foreach ($_SESSION["avisosIndividuales"] as $indice => $valor) {
                if ($indice != $argumentos[0]) {
                    unset($_SESSION["avisosIndividuales"][$indice]);
                }
            }
            if (!count($_SESSION["avisosIndividuales"])) {
                unset($_SESSION["avisosIndividuales"]);
            }
        }
        if (isset($_SESSION["avisosGenerales"])) {
            foreach ($_SESSION["avisosGenerales"] as $indice => $valor) {
                if ($indice != $argumentos[0]) {
                    unset($_SESSION["avisosGenerales"][$indice]);
                }
            }
            if (!count($_SESSION["avisosGenerales"])) {
                unset($_SESSION["avisosGenerales"]);
            }
        }
    }
}

function hayErrores()
{
    $argumentos = func_get_args();
    if (!count($argumentos)) {
        if (isset($_SESSION["avisosGenerales"])) {
            return true;
        }
        if (isset($_SESSION["avisosIndividuales"])) {
            foreach ($_SESSION["avisosIndividuales"] as $origen => $tmp1) {
                foreach ($_SESSION["avisosIndividuales"][$origen] as $tabla => $tmp2) {
                    foreach ($_SESSION["avisosIndividuales"][$origen][$tabla] as $campo => $valor) {
                        if (!is_array($_SESSION["avisosIndividuales"][$origen][$tabla][$campo])) {
                            if ($valor["campoOk"] == false) {
                                return true;
                            }
                        }
                        foreach ($_SESSION["avisosIndividuales"][$origen][$tabla][$campo] as $indice => $valor) {
                            if ($valor["campoOk"] == false) {
                                return true;
                            }
                        }
                    }
                }
            }
        }
    } else {
        if (isset($_SESSION["avisosGenerales"])) {
            foreach ($_SESSION["avisosGenerales"] as $indice => $valor) {
                if ($indice == $argumentos[0]) {
                    return true;
                }
            }
        }
        if (isset($_SESSION["avisosIndividuales"])) {
            foreach ($_SESSION["avisosIndividuales"] as $origen => $tmp1) {
                if (in_array($origen, $argumentos)) {
                    foreach ($_SESSION["avisosIndividuales"][$origen] as $tabla => $tmp2) {
                        foreach ($_SESSION["avisosIndividuales"][$origen][$tabla] as $campo => $valor) {
                            if (count($valor) == count($valor, COUNT_RECURSIVE)) { // Si no es un campo id
                                if ($valor["campoOk"] == false) {
                                    return true;
                                }
                            } else {
                                foreach ($valor as $subvalor) {
                                    if ($subvalor["campoOk"] == false) {
                                        return true;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return false;
}

function hayErroresGenerales($origen)
{
    return isset($_SESSION["avisosGenerales"][$origen]);
}

function muestraFormulario()
{
    return !isset($_SESSION["avisosGenerales"]["ocultaFormulario"]);
}
