<?php
/**
 * Agenda - servidor.php
 *
 * @author    Bartolomé Sintes Marco <bartolome.sintes+mclibre@gmail.com>
 * @copyright 2018 Bartolomé Sintes Marco
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @version   2018-12-09
 * @link      http://www.mclibre.org
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once "biblioteca.php";

$db = conectaDb();

$accion = recoge("accion");

$mensajes = [];
$registros = [];
$todoOk = OK;

if ($accion == "borrar-todo") {
    $resultado = borraTodo($db);
    print json_encode($resultado);
} elseif ($accion == "insertar") {
    $nombre    = recoge("nombre");
    $apellidos = recoge("apellidos");
    $telefono  = recoge("telefono");
    $nombreOk    = comprueba("nombre", $nombre);
    $apellidosOk = comprueba("apellidos", $apellidos);
    $telefonoOk  = comprueba("telefono", $nombreOk);

    if ($nombreOk["resultado"] && $apellidosOk["resultado"] && $telefonoOk["resultado"]) {
        if ($nombre == "" && $apellidos == "" && $telefono == "") {
            $mensajes[] = ["resultado" => NOK, "texto" => "Hay que rellenar al menos uno de los campos. No se ha guardado el registro."];
            $todoOk = NOK;
        } else {
            $consulta = "SELECT COUNT(*) FROM $dbTabla";
            $result = $db->query($consulta);
            if (!$result) {
                $mensajes[] = ["resultado" => NOK, "texto" => "Error en la consulta $consulta."];
                $todoOk = NOK;
            } elseif ($result->fetchColumn() >= MAX_REG_TABLA) {
                $mensajes[] = ["resultado" => NOK, "texto" => "Se ha alcanzado el número máximo de registros que se pueden guardar. Por favor, borre algún registro antes."];
                $todoOk = NOK;
            } else {
                $consulta = "SELECT COUNT(*) FROM $dbTabla
                    WHERE nombre=:nombre
                    AND apellidos=:apellidos
                    AND telefono=:telefono";
                $result = $db->prepare($consulta);
                $result->execute([":nombre" => $nombre, ":apellidos" => $apellidos, ":telefono" => $telefono]);
                if (!$result) {
                    $mensajes[] = ["resultado" => NOK, "texto" => "Error en la consulta."];
                    $todoOk = NOK;
                } elseif ($result->fetchColumn() > 0) {
                    $mensajes[] = ["resultado" => NOK, "texto" => "El registro ya existe."];
                    $todoOk = NOK;
                } else {
                    $consulta = "INSERT INTO $dbTabla
                        (nombre, apellidos, telefono)
                        VALUES (:nombre, :apellidos, :telefono)";
                    $result = $db->prepare($consulta);
                    if ($result->execute([":nombre" => $nombre, ":apellidos" => $apellidos, ":telefono" => $telefono])) {
                        $mensajes[] = ["resultado" => OK, "texto" => "Registro <strong>$nombre $apellidos</strong> creado correctamente."];
                    } else {
                        $mensajes[] = ["resultado" => NOK, "texto" => "Error al crear el registro <strong>$nombre $apellidos</strong>."];
                        $todoOk = NOK;
                    }
                }
            }
        }
    }
    print json_encode(["resultado" => $todoOk, "mensajes" => $mensajes]);
} elseif ($accion == "listar") {
    $columna = recogeValores("columna", $columnas, "apellidos");
    $orden   = recogeValores("orden", $orden, "ASC");

    $consulta = "SELECT COUNT(*) FROM $dbTabla";
    $result = $db->query($consulta);
    if (!$result) {
        $mensajes[] = ["resultado" => NOK, "texto" => "Error en la consulta."];
        $todoOk = NOK;
    } elseif ($result->fetchColumn() == 0) {
        $mensajes[] = ["resultado" => NOK, "texto" => "No se ha creado todavía ningún registro."];
        $todoOk = NOK;
    } else {
        $consulta = "SELECT * FROM $dbTabla
            ORDER BY $columna $orden";
        $result = $db->query($consulta);
        if (!$result) {
            $mensajes[] = ["resultado" => NOK, "texto" => "Error en la consulta."];
            $todoOk = NOK;
        } else {
            $mensajes[] = ["resultado" => OK, "texto" => "Listado completo de registros."];
            foreach ($result as $valor) {
                $registros[] = [
                    "id"        => $valor["id"],
                    "nombre"    => $valor["nombre"],
                    "apellidos" => $valor["apellidos"],
                    "telefono"  => $valor["telefono"]
                ];
            }
        }
    }
    print json_encode(["resultado" => $todoOk, "mensajes" => $mensajes, "registros" => $registros]);
} elseif ($accion == "borrar") {
    $id = recogeMatriz("id");
    if (count($id) == 0) {
        $mensajes[] = ["resultado" => NOK, "texto" => "No se ha seleccionado ningún registro."];
        $todoOk = NOK;
    } else {
        foreach ($id as $indice => $valor) {
            $consulta = "SELECT COUNT(*) FROM $dbTabla
                WHERE id=:indice";
            $result = $db->prepare($consulta);
            $result->execute([":indice" => $indice]);
            if (!$result) {
                $mensajes[] = ["resultado" => NOK, "texto" => "Error en la consulta."];
                $todoOk = NOK;
            } elseif ($result->fetchColumn() == 0) {
                $mensajes[] = ["resultado" => NOK, "texto" => "Registro no encontrado."];
                $todoOk = NOK;
            } else {
                $consulta = "DELETE FROM $dbTabla
                    WHERE id=:indice";
                $result = $db->prepare($consulta);
                if ($result->execute([":indice" => $indice])) {
                    $mensajes[] = ["resultado" => OK, "texto" => "Registro borrado correctamente."];
                } else {
                    $mensajes[] = ["resultado" => NOK, "texto" => "Error al borrar el registro."];
                    $todoOk = NOK;
                }
            }
        }
    }
    print json_encode(["resultado" => $todoOk, "mensajes" => $mensajes, "registros" => $registros]);
} elseif ($accion == "seleccionar") {
    $id    = recoge("id");

    $consulta = "SELECT COUNT(*) FROM $dbTabla
       WHERE id=:id";
    $result = $db->prepare($consulta);
    $result->execute([":id" => $id]);
    if (!$result) {
        $mensajes[] = ["resultado" => NOK, "texto" => "Error en la consulta."];
        $todoOk = NOK;
    } elseif ($result->fetchColumn() == 0) {
        $mensajes[] = ["resultado" => NOK, "texto" => "Registro no encontrado."];
        $todoOk = NOK;
    } else {
        $consulta = "SELECT * FROM $dbTabla
            WHERE id=:id";
        $result = $db->prepare($consulta);
        $result->execute([":id" => $id]);
        if (!$result) {
            $mensajes[] = ["resultado" => NOK, "texto" => "Error en la consulta."];
            $todoOk = NOK;
        } else {
            $mensajes[] = ["resultado" => OK, "texto" => "Registro seleccionado."];
            $valor = $result->fetch();
            $registros[] = [
                "id"        => $valor["id"],
                "nombre"    => $valor["nombre"],
                "apellidos" => $valor["apellidos"],
                "telefono"  => $valor["telefono"]
            ];
        }
    }
    print json_encode(["resultado" => $todoOk, "mensajes" => $mensajes, "registros" => $registros]);
} elseif ($accion == "modificar") {
    $id        = recoge("id");
    $nombre    = recoge("nombre");
    $apellidos = recoge("apellidos");
    $telefono  = recoge("telefono");
    $nombreOk    = comprueba("nombre", $nombre);
    $apellidosOk = comprueba("apellidos", $apellidos);
    $telefonoOk  = comprueba("telefono", $nombreOk);

    if ($nombreOk["resultado"] && $apellidosOk["resultado"] && $telefonoOk["resultado"]) {
        if ($nombre == "" && $apellidos == "" && $telefono == "") {
            $mensajes[] = ["resultado" => NOK, "texto" => "Hay que rellenar al menos uno de los campos. No se ha modificado el registro."];
            $todoOk = NOK;
        } else {
            $consulta = "SELECT COUNT(*) FROM $dbTabla";
            $result = $db->query($consulta);
            if (!$result) {
                $mensajes[] = ["resultado" => NOK, "texto" => "Error en la consulta $consulta."];
                $todoOk = NOK;
            } elseif ($result->fetchColumn() >= MAX_REG_TABLA) {
                $mensajes[] = ["resultado" => NOK, "texto" => "Se ha alcanzado el número máximo de registros que se pueden guardar. Por favor, borre algún registro antes."];
                $todoOk = NOK;
            } else {
                $consulta = "SELECT COUNT(*) FROM $dbTabla
                    WHERE nombre=:nombre
                    AND apellidos=:apellidos
                    AND telefono=:telefono";
                $result = $db->prepare($consulta);
                $result->execute([":nombre" => $nombre, ":apellidos" => $apellidos, ":telefono" => $telefono]);
                if (!$result) {
                    $mensajes[] = ["resultado" => NOK, "texto" => "Error en la consulta."];
                    $todoOk = NOK;
                } elseif ($result->fetchColumn() > 0) {
                    $mensajes[] = ["resultado" => NOK, "texto" => "El registro ya existe."];
                    $todoOk = NOK;
                } else {
                    $consulta = "INSERT INTO $dbTabla
                        (nombre, apellidos, telefono)
                        VALUES (:nombre, :apellidos, :telefono)";
                    $result = $db->prepare($consulta);
                    if ($result->execute([":nombre" => $nombre, ":apellidos" => $apellidos, ":telefono" => $telefono])) {
                        $mensajes[] = ["resultado" => OK, "texto" => "Registro <strong>$nombre $apellidos</strong> creado correctamente."];
                    } else {
                        $mensajes[] = ["resultado" => NOK, "texto" => "Error al crear el registro <strong>$nombre $apellidos</strong>."];
                        $todoOk = NOK;
                    }
                }
            }
        }
    }
    print json_encode(["resultado" => $todoOk, "mensajes" => $mensajes]);
} else {
    print json_encode(["resultado" => NOK, "mensajes" => [["resultado" => "NOK", "texto" => "Acción no disponible"]], "registros" => []]);
}

$db = null;
