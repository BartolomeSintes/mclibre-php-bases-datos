<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

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

function comprobaciones($tabla, $campo, $valor)
{
    global $db, $usuariosNiveles;

    $campoOk = false;
    $mensaje = "";

    if ($campo == "id") {
        $pdo      = conectaDb();
        $consulta = "SELECT COUNT(*) FROM $db[$tabla]
                     WHERE id=:id_recibido";
        $result = $pdo->prepare($consulta);
        $result->execute([":id_recibido" => $valor]);
        if (!$result) {
            $mensaje = "Error en la consulta.";
        } elseif ($result->fetchColumn() == 0) {
            $mensaje = "Registro no encontrado.";
            $_SESSION["error"]["avisoGeneral"]["mensaje"] = "Registro no encontrado.";
        } else {
            $campoOk = true;
        }
        $pdo = null;
    } elseif ($campo == "id") {                         // Cualquier tabla
        $campoOk = true;
    } elseif ($campo == "usuario") {                    // Tabla Usuarios
        if ($valor == "") {
            $mensaje = "Debe escribir un nombre de usuario.";
        } elseif (mb_strlen($valor, "UTF-8") > $db["tamUsuariosUsuario"]) {
            $mensaje = "El nombre del usuario no puede tener más de $db[tamUsuariosUsuario] caracteres.";
        } else {
            $campoOk = true;
        }
    } elseif ($campo == "password") {                   // Tabla Usuarios
        if ($valor == "") {
            $mensaje = "Debe escribir una contraseña.";
        } elseif (mb_strlen($valor, "UTF-8") > $db["tamUsuariosPassword"]) {
            $mensaje = "La contraseña no puede tener más de $db[tamUsuariosPassword] caracteres.";
        } else {
            $campoOk = true;
        }
    } elseif ($campo == "nivel") {                      // Tabla Usuarios
        if (!in_array($valor, $usuariosNiveles)) {
            $mensaje = "Nivel de usuario incorrecto.";
        } else {
            $campoOk = true;
        }
    } elseif ($campo == "autor") {                      // Tabla Obras
        if (mb_strlen($valor, "UTF-8") > $db["tamObrasAutor"]) {
            $mensaje = "El nombre del autor no puede tener más de $db[tamObrasAutor] caracteres.";
        } else {
            $campoOk = true;
        }
    } elseif ($campo == "titulo") {                     // Tabla Obras
        if (mb_strlen($valor, "UTF-8") > $db["tamObrasTitulo"]) {
            $mensaje = "El título no puede tener más de $db[tamObrasTitulo] caracteres.";
        } else {
            $campoOk = true;
        }
    } elseif ($campo == "editorial") {                  // Tabla Obras
        if (mb_strlen($valor, "UTF-8") > $db["tamObrasEditorial"]) {
            $mensaje = "La editorial no puede tener más de $db[tamObrasEditorial] caracteres.";
        } else {
            $campoOk = true;
        }
    } elseif ($campo == "nombre") {                     // Tabla Personas
        if (mb_strlen($valor, "UTF-8") > $db["tamPersonasNombre"]) {
            $mensaje = "El nombre no puede tener más de $db[tamPersonasNombre] caracteres.";
        } else {
            $campoOk = true;
        }
    } elseif ($campo == "apellidos") {                  // Tabla Personas
        if (mb_strlen($valor, "UTF-8") > $db["tamPersonasApellidos"]) {
            $mensaje = "Los apellidos no pueden tener más de $db[tamPersonasApellidos] caracteres.";
        } else {
            $campoOk = true;
        }
    } elseif ($campo == "dni") {                        // Tabla Personas
        if (mb_strlen($valor, "UTF-8") > $db["tamPersonasDni"]) {
            $mensaje = "El teléfono no puede tener más de $db[tamPersonasDni] caracteres.";
        } else {
            $campoOk = true;
        }
    } elseif ($campo == "id_persona") {                 // Tabla Préstamos
        $pdo      = conectaDb();
        $consulta = "SELECT COUNT(*) FROM $db[personas]
                     WHERE id=:id_persona";
        $result = $pdo->prepare($consulta);
        $result->execute([":id_persona" => $valor]);
        if (!$result) {
            $mensaje = "Error en la consulta.";
        } elseif ($result->fetchColumn() == 0) {
            $mensaje = "La persona seleccionada no existe.";
        } else {
            $campoOk = true;
        }
        $pdo = null;
    } elseif ($campo == "id_obra") {                    // Tabla Préstamos
        $pdo      = conectaDb();
        $consulta = "SELECT COUNT(*) FROM $db[obras]
                     WHERE id=:id_obra";
        $result = $pdo->prepare($consulta);
        $result->execute([":id_obra" => $valor]);
        if (!$result) {
            $mensaje = "Error en la consulta.";
        } elseif ($result->fetchColumn() == 0) {
            $mensaje = "La obra seleccionada no existe.";
        } else {
            $campoOk = true;
        }
        $pdo = null;
    } elseif ($campo == "id_prestamo") {                // Tabla Préstamos (para devolución)
        $pdo      = conectaDb();
        $consulta = "SELECT COUNT(*) FROM $db[prestamos]
                     WHERE id=:id_prestamo";
        $result = $pdo->prepare($consulta);
        $result->execute([":id_prestamo" => $valor]);
        if (!$result) {
            $mensaje = "Error en la consulta.";
        } elseif ($result->fetchColumn() == 0) {
            $mensaje = "El préstamo seleccionado no existe.";
        } else {
            $campoOk = true;
        }
        $pdo = null;
    } elseif ($campo == "prestado") {                   // Tabla Préstamos
        if ($valor == "" || mb_strlen($valor, "UTF-8") < TAM_FECHA) {
            $mensaje = "La fecha <strong>$valor</strong> no es una fecha válida.";
        } elseif (!ctype_digit(substr($valor, 5, 2)) || !ctype_digit(substr($valor, 8, 2)) || !ctype_digit(substr($valor, 0, 4))) {
            $mensaje = "La fecha <strong>$valor</strong> no es una fecha válida.";
        } elseif (!checkdate(substr($valor, 5, 2), substr($valor, 8, 2), substr($valor, 0, 4))) {
            $mensaje = "La fecha <strong>$valor</strong> no es una fecha válida.";
        } else {
            $campoOk = true;
        }
    } elseif ($campo == "devuelto") {                   // Tabla Préstamos
        if ($valor == "") {
            $valor   = "0000-00-00";
            $campoOk = true;
        } elseif (mb_strlen($valor, "UTF-8") < TAM_FECHA) {
            $mensaje = "La fecha <strong>$valor</strong> no es una fecha válida.";
        } elseif (!ctype_digit(substr($valor, 5, 2)) || !ctype_digit(substr($valor, 8, 2)) || !ctype_digit(substr($valor, 0, 4))) {
            $mensaje = "La fecha <strong>$valor</strong> no es una fecha válida.";
        } elseif (!checkdate(substr($valor, 5, 2), substr($valor, 8, 2), substr($valor, 0, 4))) {
            $mensaje = "La fecha <strong>$valor</strong> no es una fecha válida.";
        } else {
            $campoOk = true;
        }
    }

    return ["valor" => $valor, "campoOk" => $campoOk, "mensaje" => $mensaje];
}

function compruebaAvisosIndividuales()
{
    // Argumentos: pagina_de_origen, tabla, campo_1, campo_2, ...
    $argumentos = func_get_args();
    $origen     = $argumentos[0];
    array_shift($argumentos);
    $tabla = $argumentos[0];
    array_shift($argumentos);
    $resp       = [];
    $paraSesion = [];
    $error      = false;
    foreach ($argumentos as $campo) {
        if (isset($_REQUEST[$campo]) && is_array($_REQUEST[$campo])) {
            $valor              = recoge($campo, []);
            $comp = [];
            foreach ($valor as $indice => $valor2) {
                $resp = comprobaciones($tabla, $campo, $indice);
                $val[$indice] = $resp["valor"];
                $campOk[$indice] = $resp["campoOk"];
                $men[$indice] = $resp["mensaje"];
            }
            $comp = ["valor" => $val, "campoOk" => $campOk, "mensaje" => $men];
            $paraSesion[$campo] = $comp;
        } else {
            $valor              = recoge($campo);
            $comp               = comprobaciones($tabla, $campo, $valor);
            $paraSesion[$campo] = $comp;
        }
        $resp[] = $comp["valor"];
        if (is_array($comp["campoOk"])) {
            foreach($comp["campoOk"] as $valor) {
                if ($valor == false) {
                    $error = true;
                    $_SESSION["error"]["avisoGeneral"]["mensaje"] = "No se han encontrado algunos registros seleccionados.";
                }
            }
        } elseif ($comp["campoOk"] == false) {
            $error = true;
        }
    }
    if ($error) {
        // guarda en $_SESSION["error"] => [$campo1 => ["valor" => $valor1, "campoOk" => $campoOk1, "mensaje" => $mensaje1], $campo2 => ...]
        $_SESSION["error"][$tabla]   = $paraSesion;
        $_SESSION["error"]["origen"] = $origen;
    } else {
        $_SESSION["ok"][$tabla]   = $paraSesion;
        $_SESSION["ok"]["origen"] = $origen;
    }
    // devuelve [$valor1, $valor2, ...
    return $resp;
}

function compruebaAvisosGenerales()
{
    global $cfg, $db;

    $argumentos = func_get_args();
    $origen     = $argumentos[0];
    array_shift($argumentos);
    $tipoComprobacion = $argumentos[0];
    array_shift($argumentos);

    if ($tipoComprobacion == "registrosNoSeleccionados") {
        if (count($argumentos[0]) == 0) {
            $_SESSION["error"]["avisoGeneral"]["mensaje"] = "No ha seleccionado ningún registro.";
            $_SESSION["error"]["origen"]                  = $origen;
        }
        return isset($_SESSION["error"]["avisoGeneral"]["mensaje"]);
    }

    if ($tipoComprobacion == "todosVacios") {
        // Devuelve true si todos los valores son vacíos
        $todosVacios = true;
        foreach ($argumentos as $campo) {
            $valor       = recoge($campo);
            $todosVacios = $todosVacios && ($valor == "");
        }
        if ($todosVacios) {
            // Si no ha detectado errores individuales
            // almacena los valores recibidos para que al volver al formulario, se muestren
            foreach ($argumentos as $campo) {
                if (!isset($_SESSION["error"][$campo])) {
                    $valor              = recoge($campo);
                    $comp               = comprobaciones($campo, $valor);
                    $paraSesion[$campo] = $comp;
                }
            }
            // guarda en $_SESSION["error"] => [$campo1 => ["valor" => $valor1, "campoOk" => $campoOk1, "mensaje" => $mensaje1], $campo2 => ...
            $_SESSION["error"]                            = $paraSesion;
            $_SESSION["error"]["avisoGeneral"]["mensaje"] = "Hay que rellenar al menos uno de los campos. No se ha guardado el registro.";
            $_SESSION["error"]["origen"]                  = $origen;
        }
        return $todosVacios;
    }

    if ($tipoComprobacion == "todosVaciosMenosPrimero") {
        // Esta comprobación es para modificar-3
        // Si detecta un error general (pero no individuales porque están vacíos) y tiene que volver a modificar-2, el campo id se perdería
        // (el campo id no puede ser vacío porque es modificación, así que la comprobación de todosVacíos no se fija en el id)
        $tabla = $argumentos[0];
        array_shift($argumentos);
        $id = $argumentos[0];
        array_shift($argumentos);
        // Devuelve true si todos los valores son vacíos
        $todosVacios = true;
        foreach ($argumentos as $campo) {
            $valor       = recoge($campo);
            $todosVacios = $todosVacios && ($valor == "");
        }
        if ($todosVacios) {
            // Si no ha detectado errores individuales
            // almacena los valores recibidos para que al volver al formulario, se muestren
            // foreach ($argumentos as $campo) {
            //     $_SESSION["error"][$campo] = ["valor" => recoge($campo), "campoOk" => true, "mensaje" => ""];
            // }
            // $_SESSION["error"]["id"] = ["valor" => recoge("id"), "campoOk" => true, "mensaje" => ""];
            // guarda en $_SESSION["error"] => [$campo1 => ["valor" => $valor1, "campoOk" => $campoOk1, "mensaje" => $mensaje1], $campo2 => ...
            $_SESSION["error"]["avisoGeneral"]["mensaje"] = "Hay que rellenar al menos uno de los campos. No se ha guardado el registro.";
            $_SESSION["error"]["origen"]                  = $origen;
        }
        return $todosVacios;
    }

    if ($tipoComprobacion == "algunoVacio") {
        // Devuelve true si algún valor es vacío
        $algunoVacio = false;
        foreach ($argumentos as $campo) {
            $valor       = recoge($campo);
            $algunoVacio = $algunoVacio || ($valor == "");
        }
        if ($algunoVacio) {
            $_SESSION["error"]["avisoGeneral"]["mensaje"] = "Hay que rellenar todos los campos. No se ha guardado el registro.";
            $_SESSION["error"]["origen"]                  = $origen;
        }
        return $algunoVacio;
    }

    if ($tipoComprobacion == "sinRegistros") {
        // Devuelve true si la tabla no tiene registros
        $pdo   = conectaDb();
        $tabla = $argumentos[0];
        if (!in_array($tabla, $db["tablas"])) {
            $_SESSION["error"]["avisoGeneral"]["mensaje"] = "La tabla $tabla no existe";
            $_SESSION["error"]["origen"]                  = $origen;
        } else {
            $consulta = "SELECT COUNT(*) FROM $db[$tabla]";
            $result   = $pdo->query($consulta);
            if (!$result) {
                $_SESSION["error"]["avisoGeneral"]["mensaje"] = "Error en la consulta";
                $_SESSION["error"]["origen"]                  = $origen;
            } elseif ($result->fetchColumn() == 0) {
                $_SESSION["error"]["avisoGeneral"]["mensaje"] = "No se ha creado todavía ningún registro.";
                $_SESSION["error"]["origen"]                  = $origen;
            }
        }
        $pdo = null;
        return isset($_SESSION["error"]["avisoGeneral"]["mensaje"]);
    }

    if ($tipoComprobacion == "limiteNumeroRegistros" && $cfg["maxRegTablaActivado"]) {
        // Devuelve true si se ha alcanzado el número máximo de registros en la tabla
        $pdo   = conectaDb();
        $tabla = $argumentos[0];
        if (!in_array($tabla, $db["tablas"])) {
            $_SESSION["error"]["avisoGeneral"]["mensaje"] = "La tabla $tabla no existe";
            $_SESSION["error"]["origen"]                  = $origen;
        } else {
            $consulta = "SELECT COUNT(*) FROM $db[$tabla]";
            $result   = $pdo->query($consulta);
            if (!$result) {
                $_SESSION["error"]["avisoGeneral"]["mensaje"] = "Error en la consulta";
                $_SESSION["error"]["origen"]                  = $origen;
            } elseif ($result->fetchColumn() >= $cfg["maxRegTabla"][$tabla]) {
                $_SESSION["error"]["avisoGeneral"]["mensaje"] = "Se ha alcanzado el número máximo de registros que se pueden guardar. Por favor, borre algún registro antes.";
                $_SESSION["error"]["origen"]                  = $origen;
            }
        }
        $pdo = null;
        return isset($_SESSION["error"]["avisoGeneral"]["mensaje"]);
    }

    if ($tipoComprobacion == "fechasCrecientes") {
        // Devuelve true si la primera fecha es anterior a la primera
        $antes   = recoge($argumentos[0]);
        $despues = recoge($argumentos[1]);
        if (!checkdate(substr($antes, 5, 2), substr($antes, 8, 2), substr($antes, 0, 4))
            || !checkdate(substr($despues, 5, 2), substr($despues, 8, 2), substr($despues, 0, 4))
            || $antes > $despues) {
            $_SESSION["error"]["avisoGeneral"]["mensaje"] = "La fecha de devolución <strong>$despues</strong> es anterior a la de préstamo <strong>$antes</strong>.";
            $_SESSION["error"]["origen"]                  = $origen;
        }
        return isset($_SESSION["error"]["avisoGeneral"]["mensaje"]);
    }

    if ($tipoComprobacion == "fechasCrecientes2") {
        // Devuelve true si fecha es anterior a la fecha del registro del préstamo
        $pdo         = conectaDb();
        $id_prestamo = recoge($argumentos[0]);
        $devuelto    = recoge($argumentos[1]);
        $consulta    = "SELECT prestado FROM $db[prestamos]
                        WHERE id=:id";
        $result = $pdo->prepare($consulta);
        $result->execute([":id" => $id_prestamo]);
        if (!$result) {
            $_SESSION["error"]["avisoGeneral"]["mensaje"] = "Error en la consulta";
            $_SESSION["error"]["origen"]                  = $origen;
        } else {
            $prestado = $result->fetchColumn();
            if ($prestado > $devuelto) {
                $_SESSION["error"]["avisoGeneral"]["mensaje"] = "La fecha de devolución <strong>$devuelto</strong> es anterior a la de préstamo <strong>$prestado</strong>.";
                $_SESSION["error"]["origen"]                  = $origen;
            }
        }
        $pdo = null;
        return isset($_SESSION["error"]["avisoGeneral"]["mensaje"]);
    }

    return false;
}

function imprimeAvisosGenerales()
{
    if (isset($_SESSION["error"]["avisoGeneral"]) && $_SESSION["error"]["avisoGeneral"]["mensaje"] != "") {
        print "    <p class=\"aviso\">{$_SESSION["error"]["avisoGeneral"]["mensaje"]}</p>\n";
        print "\n";
        return true;
    }
    return false;
}

function imprimeAvisosIndividuales($tabla, $campo, $tipo)
{
    if (isset($_SESSION["error"][$tabla][$campo])) {
        if ($tipo == "valor") {
            return " value=\"{$_SESSION["error"][$tabla][$campo]["valor"]}\"";
        }
        if ($tipo == "mensaje") {
            return " <span class=\"aviso\">{$_SESSION["error"][$tabla][$campo]["mensaje"]}</span>";
        }
    }
    return "";
}

function borraAvisosExcepto()
{
    $argumentos = func_get_args();
    // Borra todos los avisos que no provienen de una página determinada
    if (isset($_SESSION["error"])) {
        if (count($argumentos) == 0) {
            unset($_SESSION["error"]);
        } elseif ($_SESSION["error"]["origen"] != $argumentos[0]) {
            unset($_SESSION["error"]);
        }
    }
    if (isset($_SESSION["ok"])) {
        if (count($argumentos) == 0) {
            unset($_SESSION["ok"]);
        } elseif ($_SESSION["ok"]["origen"] != $argumentos[0]) {
            unset($_SESSION["ok"]);
        }
    }
}
