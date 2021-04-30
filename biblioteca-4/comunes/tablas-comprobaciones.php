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

function comprobaciones($origen, $tabla, $campo, $valor)
{
    global $db, $usuariosNiveles;

    $campoOk = false;
    $mensaje = "";

    if ($campo == "id") {
        if ($valor == "") {
            // 2021-04-28 Comento la línea para que no salga el mensaje duplicado si no se selecciona ningún registro al borrar o mdificar, aunque no sé si sirve para algo
            // $mensaje                                = "No se ha seleccionado ningún registro.";
            $_SESSION["avisosGenerales"][$origen][] = "No se ha seleccionado ningún registro.";
        } else {
            $pdo      = conectaDb();
            $consulta = "SELECT COUNT(*)
                         FROM $db[$tabla]
                     WHERE id=:id_recibido";
            $result = $pdo->prepare($consulta);
            $result->execute([":id_recibido" => $valor]);
            if (!$result) {
                $mensaje = "Error en la consulta.";
            } elseif ($result->fetchColumn() == 0) {
                // $mensaje                                = "Registro no encontrado.";
                $_SESSION["avisosGenerales"][$origen][] = "Registro no encontrado.";
            } else {
                $campoOk = true;
            }
            $pdo = null;
        }
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
            $mensaje = "El DNI no puede tener más de $db[tamPersonasDni] caracteres.";
        } else {
            $campoOk = true;
        }
    } elseif ($campo == "id_persona") {                 // Tabla Préstamos
        $pdo      = conectaDb();
        $consulta = "SELECT COUNT(*)
                     FROM $db[personas]
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
        $consulta = "SELECT COUNT(*)
                     FROM $db[obras]
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
        $consulta = "SELECT COUNT(*)
                     FROM $db[prestamos]
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
            $valor = recoge($campo, []);
            $comp  = [];
            foreach ($valor as $indice => $valor2) {
                $resp          = comprobaciones($origen, $tabla, $campo, $indice);
                $comp[$indice] = ["valor" => $resp["valor"], "campoOk" => $resp["campoOk"], "mensaje" => $resp["mensaje"]];
            }
        } else {
            $valor = recoge($campo);
            $comp  = comprobaciones($origen, $tabla, $campo, $valor);
        }
        $paraSesion[$campo] = $comp;
        $resp[]             = $valor;
        // if (is_array($comp["campoOk"])) {
        //     foreach ($comp["campoOk"] as $valor) {
        //         if ($valor == false) {
        //             $error                                        = true;
        //             $_SESSION["avisosGenerales"][$origen][] = "No se han encontrado algunos registros seleccionados.";
        //         }
        //     }
        // } elseif ($comp["campoOk"] == false) {
        //     $error = true;
        // }
    }
    // guarda [$campo1 => ["valor" => $valor1, "campoOk" => $campoOk1, "mensaje" => $mensaje1], $campo2 => ...]
    // printValores($paraSesion);
    // exit();
    $_SESSION["avisosIndividuales"][$origen][$tabla] = $paraSesion;
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
        if (is_array($argumentos[0])) {
            if (count($argumentos[0]) == 0) {
                $_SESSION["avisosGenerales"][$origen][] = "No ha seleccionado ningún registro.";
                return true;
            }
        } else {
            if ($argumentos[0] == "") {
                $_SESSION["avisosGenerales"][$origen][] = "No ha seleccionado ningún registro.";
                return true;
            }
        }
    }

    if ($tipoComprobacion == "yaExisteRegistro") {
        $pdo      = conectaDb();
        $consulta = "SELECT COUNT(*)
                     FROM $argumentos[0] "
                  . "WHERE ";
        for ($i = 1; $i < count($argumentos) - 1; $i++) {
            $consulta .= "lower($argumentos[$i])=lower(:$argumentos[$i]) AND ";
        }
        $consulta .= "lower($argumentos[$i])=lower(:$argumentos[$i])";
        $parametros = [];
        for ($i = 1; $i < count($argumentos); $i++) {
            $parametros += [":" . $argumentos[$i] => recoge($argumentos[$i])];
        }
        $result = $pdo->prepare($consulta);
        $result->execute($parametros);
        if (!$result) {
            $_SESSION["avisosGenerales"][$origen][] = "Error en la consulta.";
            return true;
        }
        if ($result->fetchColumn() > 0) {
            $_SESSION["avisosGenerales"][$origen][] = "El registro ya existe.";
            return true;
        }
        $pdo = null;
    }

    if ($tipoComprobacion == "incluyeUsuarioRoot") {
        $pdo = conectaDb();
        if (!is_array($argumentos[0])) {
            $argumentos[0] = [$argumentos[0] => "on"];
        }
        foreach ($argumentos[0] as $indice => $valor) {
            $consulta = "SELECT *
                         FROM $db[usuarios]
                         WHERE id=:id";
            $result = $pdo->prepare($consulta);
            $result->execute([":id" => $indice]);
            if (!$result) {
                $_SESSION["avisosGenerales"][$origen][] = "Error en la consulta.";
                return true;
            }
            $valor = $valor = $result->fetch(PDO::FETCH_ASSOC);
            if ($valor["usuario"] == $cfg["rootName"]) {
                $_SESSION["avisosGenerales"][$origen][] = "El usuario root no se puede borrar o modificar.";
                return true;
            }
        }
        $pdo = null;
    }

    // La consulta cuenta los registros con un id diferente para que que al cambiar
    // alguna mayúscula por minúscula o viceversa no diga que el registro ya existe.
    if ($tipoComprobacion == "yaExisteRegistroConOtroId") {
        $pdo      = conectaDb();
        $consulta = "SELECT COUNT(*)
                     FROM $argumentos[0] "
                  . "WHERE ";
        for ($i = 1; $i < count($argumentos) - 1; $i++) {
            $consulta .= "lower($argumentos[$i])=lower(:$argumentos[$i]) AND ";
        }
        $consulta .= "lower($argumentos[$i])<>lower(:$argumentos[$i])";
        $parametros = [];
        for ($i = 1; $i < count($argumentos); $i++) {
            $parametros += [":" . $argumentos[$i] => recoge($argumentos[$i])];
        }
        $result = $pdo->prepare($consulta);
        $result->execute($parametros);
        if (!$result) {
            $_SESSION["avisosGenerales"][$origen][] = "Error en la consulta.";
            return true;
        }
        if ($result->fetchColumn() > 0) {
            $_SESSION["avisosGenerales"][$origen][] = "Ya existe un registro con esos mismos valores. Se muestran los datos originales (sin modificar).";
            return true;
        }
        $pdo = null;
    }

    if ($tipoComprobacion == "registrosNoEncontrados") {            // Para Buscar
        $pdo      = conectaDb();
        $consulta = "SELECT COUNT(*)
                     FROM $argumentos[0] "
                  . "WHERE ";
        for ($i = 1; $i < count($argumentos) - 1; $i++) {
            $consulta .= "$argumentos[$i] like :$argumentos[$i] AND ";
        }
        $consulta .= "$argumentos[$i] like :$argumentos[$i]";
        $parametros = [];
        for ($i = 1; $i < count($argumentos); $i++) {
            $parametros += [":" . $argumentos[$i] => "%" . recoge($argumentos[$i]) . "%"];
        }
        $result = $pdo->prepare($consulta);
        $result->execute($parametros);
        if (!$result) {
            $_SESSION["avisosGenerales"][$origen][] = "Error en la consulta.";
            return true;
        }
        if ($result->fetchColumn() == 0) {
            $_SESSION["avisosGenerales"][$origen][] = "No se han encontrado registros.";
            return true;
        }
        $pdo = null;
    }

    if ($tipoComprobacion == "todosVacios") {
        // Devuelve true si todos los valores son vacíos
        $todosVacios = true;
        foreach ($argumentos as $campo) {
            $valor       = recoge($campo);
            $todosVacios = $todosVacios && ($valor == "");
        }
        if ($todosVacios) {
            $_SESSION["avisosGenerales"][$origen][] = "Hay que rellenar al menos uno de los campos. No se ha guardado el registro.";
            return true;
        }
    }

    if ($tipoComprobacion == "todosVaciosMenosPrimero") {
        // Esta comprobación es para modificar-3
        // Si detecta un error general (pero no individuales porque están vacíos) y tiene que volver a modificar-2, el campo id se perdería
        // (el campo id no puede ser vacío porque es modificación, así que la comprobación de todosVacíos no se fija en el id)
        // TODO COMPROBAR SI FUNCIONA, QUE CREO QUE NO LO HACE
        $id = $argumentos[0];
        array_shift($argumentos);
        // Devuelve true si todos los valores son vacíos
        $todosVacios = true;
        foreach ($argumentos as $campo) {
            $valor       = recoge($campo);
            $todosVacios = $todosVacios && ($valor == "");
        }
        if ($todosVacios) {
            $_SESSION["avisosGenerales"][$origen][] = "Hay que rellenar al menos uno de los campos. Se muestran los datos originales (sin modificar).";
            return true;
        }
    }

    if ($tipoComprobacion == "algunoVacio") {
        // Devuelve true si algún valor es vacío
        $algunoVacio = false;
        foreach ($argumentos as $campo) {
            $valor       = recoge($campo);
            $algunoVacio = $algunoVacio || ($valor == "");
        }
        if ($algunoVacio) {
            $_SESSION["avisosGenerales"][$origen][] = "Hay que rellenar todos los campos. No se ha guardado el registro.";
            return true;
        }
    }

    if ($tipoComprobacion == "sinRegistros") {
        // Devuelve true si la tabla no tiene registros
        $pdo   = conectaDb();
        $tabla = $argumentos[0];
        if (!in_array($tabla, $db["tablas"])) {
            $_SESSION["avisosGenerales"][$origen][] = "La tabla $tabla no existe";
            return true;
        }
        $consulta = "SELECT COUNT(*)
                     FROM $db[$tabla]";
        $result = $pdo->query($consulta);
        if (!$result) {
            $_SESSION["avisosGenerales"][$origen][] = "Error en la consulta";
            return true;
        }
        if ($result->fetchColumn() == 0) {
            $_SESSION["avisosGenerales"][$origen][] = "No se ha creado todavía ningún registro.";
            return true;
        }
        $pdo = null;
    }

    if ($tipoComprobacion == "sinPrestamosPendientes") {
        // Devuelve true si la tabla no tiene registros
        $pdo   = conectaDb();
        $tabla = $argumentos[0];
        if (!in_array($tabla, $db["tablas"])) {
            $_SESSION["avisosGenerales"][$origen][] = "La tabla $tabla no existe";
            return true;
        }
        $consulta = "SELECT COUNT(*)
                     FROM $db[prestamos]
                     WHERE devuelto='0000-00-00'";
        $result = $pdo->query($consulta);
        if (!$result) {
            $_SESSION["avisosGenerales"][$origen][] = "Error en la consulta";
            return true;
        }
        if ($result->fetchColumn() == 0) {
            $_SESSION["avisosGenerales"][$origen][] = "No hay obras pendientes de devolución.";
            return true;
        }
        $pdo = null;
    }

    if ($tipoComprobacion == "limiteNumeroRegistros" && $cfg["maxRegTablaActivado"]) {
        // Devuelve true si se ha alcanzado el número máximo de registros en la tabla
        $pdo   = conectaDb();
        $tabla = $argumentos[0];
        if (!in_array($tabla, $db["tablas"])) {
            $_SESSION["avisosGenerales"][$origen][] = "La tabla $tabla no existe";
            return true;
        }
        $consulta = "SELECT COUNT(*)
                     FROM $db[$tabla]";
        $result = $pdo->query($consulta);
        if (!$result) {
            $_SESSION["avisosGenerales"][$origen][] = "Error en la consulta";
            return true;
        }
        if ($result->fetchColumn() >= $cfg["maxRegTabla"][$tabla]) {
            $_SESSION["avisosGenerales"][$origen][] = "Se ha alcanzado el número máximo de registros que se pueden guardar. Por favor, borre algún registro antes.";
            return true;
        }
        $pdo = null;
    }

    if ($tipoComprobacion == "fechasCrecientes") {
        // Devuelve true si la primera fecha es anterior a la primera
        $antes   = recoge($argumentos[0]);
        $despues = recoge($argumentos[1]);
        if (!checkdate(substr($antes, 5, 2), substr($antes, 8, 2), substr($antes, 0, 4))
            || !checkdate(substr($despues, 5, 2), substr($despues, 8, 2), substr($despues, 0, 4))
            || $antes > $despues) {
            $_SESSION["avisosGenerales"][$origen][] = "La fecha de devolución <strong>$despues</strong> es anterior a la de préstamo <strong>$antes</strong>.";
            return true;
        }
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
            $_SESSION["avisosGenerales"][$origen][] = "Error en la consulta";
            return true;
        }
        $prestado = $result->fetchColumn();
        if ($prestado > $devuelto) {
            $_SESSION["avisosGenerales"][$origen][] = "La fecha de devolución <strong>$devuelto</strong> es anterior a la de préstamo <strong>$prestado</strong>.";
            return true;
        }
        $pdo = null;
    }

    return false;
}

function imprimeAvisosGenerales()
{
    $argumentos = func_get_args();

    $avisosImpresos = false;
    foreach ($argumentos as $origen) {
        if (isset($_SESSION["avisosGenerales"][$origen]) && count($_SESSION["avisosGenerales"][$origen]) > 0) {
            foreach ($_SESSION["avisosGenerales"][$origen] as $mensaje) {
                print "    <p class=\"aviso-error\">$mensaje</p>\n";
            }
            $avisosImpresos = true;
        }
    }
    return $avisosImpresos;
}

function imprimeAvisosIndividuales($origen, $tabla, $campo, $tipo, $valor = "SINVALORNINGUNO")
{
    if (hayErrores($origen) && !hayErroresGenerales($origen)) {
        if (isset($_SESSION["avisosIndividuales"][$origen][$tabla][$campo])) {
            if ($tipo == "valor") {
                return " value=\"{$_SESSION["avisosIndividuales"][$origen][$tabla][$campo]["valor"]}\"";
            }
            if ($tipo == "mensaje" && $_SESSION["avisosIndividuales"][$origen][$tabla][$campo]["mensaje"]) {
                return " <span class=\"aviso-error\">{$_SESSION["avisosIndividuales"][$origen][$tabla][$campo]["mensaje"]}</span>";
            }
        }
    } else {
        if ($tipo == "valor" && $valor != "SINVALORNINGUNO") {
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
