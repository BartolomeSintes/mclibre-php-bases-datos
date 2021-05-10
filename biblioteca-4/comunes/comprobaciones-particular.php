<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

function comprobaciones($origen, $tabla, $campo, $valor)
{
    global $db, $usuariosNiveles;

    $campoOk = false;
    $mensaje = "";

    if ($campo == "id") {
        if ($valor == "" || $valor == []) {
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "No ha seleccionado ningún registro.", "claseAviso" => "aviso-error"];
            $valor                                  = "";
        } else {
            $campoOk = true;
        }
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
        if ($valor == "") {
            $mensaje = "No se ha seleccionado ningún préstamo.";
        } else {
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
        if ($origen == "devolver-2" && $valor == "") {
            $mensaje = "No ha indicado la fecha.";
        } elseif ($valor == "") {
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

function compruebaAvisosGenerales()
{
    global $cfg, $db;

    $argumentos = func_get_args();
    $origen     = $argumentos[0];
    array_shift($argumentos);
    $tipoComprobacion = $argumentos[0];
    array_shift($argumentos);

    // Esta comprobación no se utiliza, ya que en la comprobación individual del id o de los id si
    // es vacío se genera este mismo avisoGeneral.
    if ($tipoComprobacion == "registrosNoSeleccionados") {
        if (is_array($argumentos[0])) {
            if (count($argumentos[0]) == 0) {
                $_SESSION["avisosGenerales"][$origen][] = ["texto" => "No ha seleccionado ningún registro.", "claseAviso" => "aviso-error"];
            }
        } else {
            if ($argumentos[0] == "") {
                $_SESSION["avisosGenerales"][$origen][] = ["texto" => "No ha seleccionado ningún registro.", "claseAviso" => "aviso-error"];
            }
        }
    }

    if ($tipoComprobacion == "validaLogin") {
        $pdo      = conectaDb();
        $consulta = "SELECT *
                     FROM $argumentos[0]
                     WHERE usuario=:usuario
                    AND password=:password";
        $result = $pdo->prepare($consulta);
        $result->execute([":usuario" => recoge($argumentos[1]), ":password" => encripta(recoge($argumentos[2]))]);
        if (!$result) {
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Error en la consulta.", "claseAviso" => "aviso-error"];
        } else {
            $valor = $result->fetch(PDO::FETCH_ASSOC);
            if (!is_array($valor)) {
                $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Nombre de usuario y/o contraseña incorrectos.", "claseAviso" => "aviso-error"];
            } else {
                $_SESSION["conectado"] = $valor["nivel"];
            }
        }
        $pdo = null;
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
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Error en la consulta.", "claseAviso" => "aviso-error"];
        }
        if ($result->fetchColumn() > 0) {
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "El registro ya existe.", "claseAviso" => "aviso-error"];
        }
        $pdo = null;
    }

    if ($tipoComprobacion == "incluyeUsuarioRoot") {
        $pdo      = conectaDb();
        $consulta = "SELECT *
                     FROM $db[usuarios]
                     WHERE usuario='$cfg[rootName]'";
        $result = $pdo->query($consulta);
        if (!$result) {
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Error en la consulta.", "claseAviso" => "aviso-error"];
        }
        $valor = $result->fetch(PDO::FETCH_ASSOC);
        if (!is_array($argumentos[0])) {
            $argumentos[0] = [$argumentos[0] => "on"];
        }
        foreach ($argumentos[0] as $indice => $valor2) {
            if ($valor["id"] == $indice) {
                $_SESSION["avisosGenerales"][$origen][] = ["texto" => "El usuario root no se puede borrar.", "claseAviso" => "aviso-error"];
            }
        }
        $pdo = null;
    }

    if ($tipoComprobacion == "registrosExisten") {
        $pdo = conectaDb();
        if (!is_array($argumentos[1])) {
            $consulta = "SELECT COUNT(*)
                         FROM $argumentos[0]
                         WHERE id=:id";
            $result = $pdo->prepare($consulta);
            $result->execute([":id" => $argumentos[1]]);
            if (!$result) {
                $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Error en la consulta.", "claseAviso" => "aviso-error"];
            } elseif ($result->fetchColumn() == 0) {
                $_SESSION["avisosGenerales"][$origen][] = ["texto" => "El registro indicado no existe.", "claseAviso" => "aviso-error"];
            }
        } else {
            if (count($argumentos[1]) == 1) {
                $consulta = "SELECT COUNT(*)
                             FROM $argumentos[0]
                             WHERE id=:id";
                $result = $pdo->prepare($consulta);
                $result->execute([":id" => key($argumentos[1])]);
                if (!$result) {
                    $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Error en la consulta.", "claseAviso" => "aviso-error"];
                } elseif ($result->fetchColumn() == 0) {
                    $_SESSION["avisosGenerales"][$origen][] = ["texto" => "El registro indicado no existe.", "claseAviso" => "aviso-error"];
                }
            } else {
                foreach ($argumentos[1] as $indice => $valor2) {
                    $consulta = "SELECT COUNT(*)
                             FROM $argumentos[0]
                             WHERE id=:id";
                    $result = $pdo->prepare($consulta);
                    $result->execute([":id" => $indice]);
                    if (!$result) {
                        $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Error en la consulta.", "claseAviso" => "aviso-error"];
                    } elseif ($result->fetchColumn() == 0) {
                        $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Al menos uno de los registros indicados no existe.", "claseAviso" => "aviso-error"];
                    }
                }
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
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Error en la consulta.", "claseAviso" => "aviso-error"];
        }
        if ($result->fetchColumn() > 0) {
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Ya existe un registro con esos mismos valores. Se muestran los datos originales (sin modificar).", "claseAviso" => "aviso-error"];
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
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Error en la consulta.", "claseAviso" => "aviso-error"];
        }
        if ($result->fetchColumn() == 0) {
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "No se han encontrado registros.", "claseAviso" => "aviso-error"];
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
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Hay que rellenar al menos uno de los campos. No se ha guardado el registro.", "claseAviso" => "aviso-error"];
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
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Hay que rellenar al menos uno de los campos. Se muestran los datos originales (sin modificar).", "claseAviso" => "aviso-error"];
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
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Hay que rellenar todos los campos. No se ha guardado el registro.", "claseAviso" => "aviso-error"];
        }
    }

    if ($tipoComprobacion == "sinRegistros") {
        // Devuelve true si la tabla no tiene registros
        $pdo   = conectaDb();
        $tabla = $argumentos[0];
        if (!in_array($tabla, $db["tablas"])) {
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "La tabla $tabla no existe.", "claseAviso" => "aviso-error"];
        }
        $consulta = "SELECT COUNT(*)
                     FROM $db[$tabla]";
        $result = $pdo->query($consulta);
        if (!$result) {
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Error en la consulta.", "claseAviso" => "aviso-error"];
        }
        if ($result->fetchColumn() == 0) {
            $_SESSION["avisosGenerales"][$origen][]          = ["texto" => "No se ha creado todavía ningún registro.", "claseAviso" => "aviso-info"];
            $_SESSION["avisosGenerales"]["ocultaFormulario"] = true;
        }
        $pdo = null;
    }

    if ($tipoComprobacion == "sinPrestamosPendientes") {
        // Devuelve true si la tabla no tiene registros
        $pdo   = conectaDb();
        $tabla = $argumentos[0];
        if (!in_array($tabla, $db["tablas"])) {
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "La tabla $tabla no existe", "claseAviso" => "aviso-error"];
        }
        $consulta = "SELECT COUNT(*)
                     FROM $db[prestamos]
                     WHERE devuelto='0000-00-00'";
        $result = $pdo->query($consulta);
        if (!$result) {
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Error en la consulta.", "claseAviso" => "aviso-error"];
        }
        if ($result->fetchColumn() == 0) {
            $_SESSION["avisosGenerales"][$origen][]          = ["texto" => "No hay préstamos pendientes de devolución.", "claseAviso" => "aviso-info"];
            $_SESSION["avisosGenerales"]["ocultaFormulario"] = true;
        }
        $pdo = null;
    }

    if ($tipoComprobacion == "limiteNumeroRegistros" && $cfg["maxRegTablaActivado"]) {
        // Devuelve true si se ha alcanzado el número máximo de registros en la tabla
        $pdo   = conectaDb();
        $tabla = $argumentos[0];
        if (!in_array($tabla, $db["tablas"])) {
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "La tabla $tabla no existe", "claseAviso" => "aviso-error"];
        }
        $consulta = "SELECT COUNT(*)
                     FROM $db[$tabla]";
        $result = $pdo->query($consulta);
        if (!$result) {
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Error en la consulta.", "claseAviso" => "aviso-error"];
        }
        if ($result->fetchColumn() >= $cfg["maxRegTabla"][$tabla]) {
            $_SESSION["avisosGenerales"][$origen][]          = ["texto" => "Se ha alcanzado el número máximo de registros que se pueden guardar. Por favor, borre algún registro antes.", "claseAviso" => "aviso-info"];
            $_SESSION["avisosGenerales"]["ocultaFormulario"] = true;
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
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "La fecha de devolución <strong>$despues</strong> es anterior a la de préstamo <strong>$antes</strong>.", "claseAviso" => "aviso-error"];
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
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "Error en la consulta.", "claseAviso" => "aviso-error"];
        }
        $prestado = $result->fetchColumn();
        if ($prestado > $devuelto) {
            $_SESSION["avisosGenerales"][$origen][] = ["texto" => "La fecha de devolución <strong>$devuelto</strong> es anterior a la de préstamo <strong>$prestado</strong>.", "claseAviso" => "aviso-error"];
        }
        $pdo = null;
    }
}
