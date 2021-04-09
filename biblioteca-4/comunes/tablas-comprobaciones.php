<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

function comprobaciones($campo, $valor)
{
    global $db, $usuariosNiveles;

    $campoOk = false;
    $mensaje = "";

    if ($campo == "usuario") {
        if ($valor == "") {
            $mensaje = "Debe escribir un nombre de usuario.";
        } elseif (mb_strlen($valor, "UTF-8") > $db["tamUsuariosUsuario"]) {
            $mensaje = "El nombre usuario no puede tener más de $db[tamUsuariosUsuario] caracteres.";
        } else {
            $campoOk = true;
        }
    } elseif ($campo == "password") {
        if ($valor == "") {
            $mensaje = "Debe escribir una contraseña.";
        } elseif (mb_strlen($valor, "UTF-8") > $db["tamUsuariosPassword"]) {
            $mensaje = "La contraseña no puede tener más de $db[tamUsuariosPassword] caracteres.";
        } else {
            $campoOk = true;
        }
    } elseif ($campo = "nivel") {
        if (!in_array($valor, $usuariosNiveles)) {
            $mensaje = "Nivel de usuario incorrecto.";
        } else {
            $campoOk = true;
        }
    } elseif ($campo = "id") {
        $campoOk = true;
    }

    return ["valor" => $valor, "campoOk" => $campoOk, "mensaje" => $mensaje];
}

function compruebaIndividuales()
{
    $resp       = [];
    $paraSesion = [];
    $error      = false;
    foreach (func_get_args() as $campo) {
        $valor              = recoge($campo);
        $comp               = comprobaciones($campo, $valor);
        $paraSesion[$campo] = $comp;
        $resp[]             = $comp["valor"];
        if ($comp["campoOk"] == false) {
            $error = true;
        }
    }
    if ($error) {
        // guarda en $_SESSION["error"] => [$campo1 => ["valor" => $valor1, "campoOk" => $campoOk1, "mensaje" => $mensaje1], $campo2 => ...
        $_SESSION["error"] = $paraSesion;
    }
    // devuelve [$valor1, $valor2, ...
    return $resp;
}

function compruebaConjunto()
{
    $campos           = func_get_args();
    $tipoComprobacion = $campos[0];
    array_shift($campos);

    if ($tipoComprobacion == "todosVacios") {
        // Devuelve true si todos los valores son vacíos
        $todosVacios = true;
        foreach ($campos as $campo) {
            $valor       = recoge($campo);
            $todosVacios = $todosVacios && ($valor == "");
        }
        if ($todosVacios) {
            $_SESSION["error"]["avisoGeneral"]["mensaje"] = "Hay que rellenar al menos uno de los campos. No se ha guardado el registro.";
        }
        return $todosVacios;
    }
    if ($tipoComprobacion == "algunoVacio") {
        // Devuelve true si todos los valores son vacíos
        $algunoVacio = false;
        foreach ($campos as $campo) {
            $valor       = recoge($campo);
            $algunoVacio = $algunoVacio || ($valor == "");
        }
        if ($algunoVacio) {
            $_SESSION["error"]["avisoGeneral"]["mensaje"] = "Hay que rellenar todos los campos. No se ha guardado el registro.";
        }
        return $algunoVacio;
    }
    return true;
}

function imprimeError($campo)
{
    if (isset($_SESSION["error"][$campo]) && $_SESSION["error"][$campo]["mensaje"] != "") {
        print " <span class=\"aviso\">{$_SESSION["error"][$campo]["mensaje"]}</span>";
    } else {
        print "tuturú";
        print_r($_SESSION);
    }
}

function compruebaLimiteRegistros($tabla)
{
    global $cfg, $db;

    if ($cfg["maxRegTablaActivado"]) {
        $pdo = conectaDb();
        if (!in_array($tabla, $db["tablas"])) {
            $_SESSION["error"]["maxRegTabla"]["mensaje"] = "La tabla $tabla no existe";
        } else {
            $consulta = "SELECT COUNT(*) FROM $tabla";
            $result   = $pdo->query($consulta);
            if (!$result) {
                $_SESSION["error"]["maxRegTabla"]["mensaje"] = "Error en la consulta";
            } elseif ($result->fetchColumn() >= $cfg["maxRegTabla"][$tabla]) {
                $_SESSION["error"]["maxRegTabla"]["mensaje"] = "Se ha alcanzado el número máximo de registros que se pueden guardar. Por favor, borre algún registro antes.";
            }
        }
        $pdo = null;
        return isset($_SESSION["error"]["maxRegTabla"]["mensaje"]);
    }
}
