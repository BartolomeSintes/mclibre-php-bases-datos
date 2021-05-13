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
    $tabla      = $argumentos[0];
    array_shift($argumentos);
    $origen = $argumentos[0];
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
    if (isset($_SESSION["avisos"][$tabla][$origen]["campos"])) {
        $_SESSION["avisos"][$tabla][$origen]["campos"] = array_merge_recursive($_SESSION["avisos"][$tabla][$origen]["campos"], $paraSesion);
    } else {
        $_SESSION["avisos"][$tabla][$origen]["campos"] = $paraSesion;
    }
    // devuelve [$valor1, $valor2, ...
    return $resp;
}

function incluyeValoresOriginalesEnAvisos()
{
    global $db;

    $argumentos = func_get_args();
    $tabla      = $argumentos[0];
    array_shift($argumentos);
    $origen = $argumentos[0];
    array_shift($argumentos);
    $id = $argumentos[0];
    array_shift($argumentos);
    $pdo      = conectaDb();
    $consulta = "SELECT *
                 FROM $db[$tabla] "
              . "WHERE id=:id";
    $result = $pdo->prepare($consulta);
    $result->execute([":id" => recoge($id)]);
    if (!$result) {
        $_SESSION["avisos"][$tabla][$origen]["generales"][] = ["texto" => "Error en la consulta.", "claseAviso" => "aviso-error"];
    } else {
        $valor = $result->fetch(PDO::FETCH_ASSOC);
        foreach ($argumentos as $campo) {
            $_SESSION["avisos"][$tabla][$origen]["campos"][$campo]["original"] = $valor[$campo];
        }
    }
    $_SESSION["avisos"][$tabla][$origen]["muestraValoresOriginalesEnFormulario"] = true;
}

function imprimeAvisosGenerales($tabla, $origen)
{
    if (isset($_SESSION["avisos"][$tabla][$origen]["generales"]) && count($_SESSION["avisos"][$tabla][$origen]["generales"]) > 0) {
        $_SESSION["avisos"][$tabla][$origen]["generales"] = array_unique($_SESSION["avisos"][$tabla][$origen]["generales"], SORT_REGULAR);
        foreach ($_SESSION["avisos"][$tabla][$origen]["generales"] as $aviso) {
            print "    <p class=\"$aviso[claseAviso]\">$aviso[texto]</p>\n";
        }
    }
}

function imprimeAvisosIndividuales($tabla, $origen, $campo, $tipo, $valor = "")
{
    if (hayErrores($tabla, $origen)) {
        if (isset($_SESSION["avisos"][$tabla][$origen]["campos"][$campo])) {
            if ($tipo == "valor") {
                if (isset($_SESSION["avisos"][$tabla][$origen]["muestraValoresOriginalesEnFormulario"])) {
                    return " value=\"{$_SESSION["avisos"][$tabla][$origen]["campos"][$campo]["original"]}\"";
                }
                return " value=\"{$_SESSION["avisos"][$tabla][$origen]["campos"][$campo]["valor"]}\"";
            }
            if ($tipo == "mensaje" && $_SESSION["avisos"][$tabla][$origen]["campos"][$campo]["mensaje"]) {
                return " <span class=\"aviso-error\">{$_SESSION["avisos"][$tabla][$origen]["campos"][$campo]["mensaje"]}</span>";
            }
            if ($tipo == "select" && $_SESSION["avisos"][$tabla][$origen]["campos"][$campo]["valor"] == $valor) {
                return " selected";
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
        unset($_SESSION["avisos"]);
    } else {
        $tabla  = $argumentos[0];
        $origen = $argumentos[1];
        if (isset($_SESSION["avisos"][$tabla][$origen])) {
            $tmp = $_SESSION["avisos"][$tabla][$origen];
            unset($_SESSION["avisos"]);
            $_SESSION["avisos"][$tabla][$origen] = $tmp;
        } else {
            unset($_SESSION["avisos"]);
        }
    }
}

function hayErrores($tabla, $origen)
{
    if (isset($_SESSION["avisos"][$tabla][$origen]["generales"])) {
        return true;
    }
    if (isset($_SESSION["avisos"][$tabla][$origen]["campos"])) {
        foreach ($_SESSION["avisos"][$tabla][$origen]["campos"] as $campo => $valor) {
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
    return false;
}

function muestraFormulario($tabla, $origen)
{
    return !isset($_SESSION["avisos"][$tabla][$origen]["ocultaFormulario"]);
}
