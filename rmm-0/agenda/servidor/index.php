<?php
/**
 * RMM-0 - Agenda (Servidor) - index.php
 *
 * @author    Bartolomé Sintes Marco <bartolome.sintes+mclibre@gmail.com>
 * @copyright 2019 Bartolomé Sintes Marco
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @version   2019-05-27
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

[$resultado, $db] = conectaDb();

if ($db == null) {
    $todoOk = KO;
    $mensajes = $resultado["mensajes"];
    $registros = [];
} else {
    $todoOk = KO;
    $mensajes = [];
    $registros = [];

    $accion = recoge("accion");

    if ($accion == "borrar-todo") {
        $resultado = borraTodo($db);
        $todoOk = $resultado["resultado"];
        $mensajes = $resultado["mensajes"];
    } elseif ($accion == "comprobar-limite-registros") {
        $consulta = "SELECT COUNT(*) FROM $dbTabla";
        $result = $db->query($consulta);
        if (!$result) {
            $mensajes[] = ["resultado" => KO, "texto" => "Error en la consulta $consulta."];
            $todoOk = KO;
        } elseif ($result->fetchColumn() >= MAX_REG_TABLA) {
            $mensajes[] = ["resultado" => KO, "texto" => "Se ha alcanzado el número máximo de registros que se pueden guardar. Por favor, borre algún registro antes."];
            $todoOk = KO;
        } else {
            $mensajes[] = ["resultado" => OK, "texto" => "No se ha alcanzado el número máximo de registros que se pueden guardar."];
            $todoOk = OK;
        }
    } elseif ($accion == "insertar-registro") {
        $nombre    = recoge("nombre");
        $apellidos = recoge("apellidos");
        $telefono  = recoge("telefono");
        $nombreOk    = comprueba("nombre", $nombre);
        $apellidosOk = comprueba("apellidos", $apellidos);
        $telefonoOk  = comprueba("telefono", $nombreOk);

        if ($nombreOk["resultado"] && $apellidosOk["resultado"] && $telefonoOk["resultado"]) {
            if ($nombre == "" && $apellidos == "" && $telefono == "") {
                $mensajes[] = ["resultado" => KO, "texto" => "Hay que rellenar al menos uno de los campos. No se ha guardado el registro."];
                $todoOk = KO;
            } else {
                $consulta = "SELECT COUNT(*) FROM $dbTabla";
                $result = $db->query($consulta);
                if (!$result) {
                    $mensajes[] = ["resultado" => KO, "texto" => "Error en la consulta $consulta."];
                    $todoOk = KO;
                } elseif ($result->fetchColumn() >= MAX_REG_TABLA) {
                    $mensajes[] = ["resultado" => KO, "texto" => "Se ha alcanzado el número máximo de registros que se pueden guardar. Por favor, borre algún registro antes."];
                    $todoOk = KO;
                } else {
                    $consulta = "SELECT COUNT(*) FROM $dbTabla
                    WHERE nombre=:nombre
                    AND apellidos=:apellidos
                    AND telefono=:telefono";
                    $result = $db->prepare($consulta);
                    $result->execute([":nombre" => $nombre, ":apellidos" => $apellidos, ":telefono" => $telefono]);
                    if (!$result) {
                        $mensajes[] = ["resultado" => KO, "texto" => "Error en la consulta."];
                        $todoOk = KO;
                    } elseif ($result->fetchColumn() > 0) {
                        $mensajes[] = ["resultado" => KO, "texto" => "El registro ya existe."];
                        $todoOk = KO;
                    } else {
                        $consulta = "INSERT INTO $dbTabla
                        (nombre, apellidos, telefono)
                        VALUES (:nombre, :apellidos, :telefono)";
                        $result = $db->prepare($consulta);
                        if ($result->execute([":nombre" => $nombre, ":apellidos" => $apellidos, ":telefono" => $telefono])) {
                            $mensajes[] = ["resultado" => OK, "texto" => "Registro <strong>$nombre $apellidos</strong> creado correctamente."];
                        } else {
                            $mensajes[] = ["resultado" => KO, "texto" => "Error al crear el registro <strong>$nombre $apellidos</strong>."];
                            $todoOk = KO;
                        }
                    }
                }
            }
        }
    } elseif ($accion == "seleccionar-registros-todos") {
        $columna = recogeValores("columna", $columnas, "apellidos");
        $orden   = recogeValores("orden", $orden, "ASC");

        $consulta = "SELECT COUNT(*) FROM $dbTabla";
        $result = $db->query($consulta);
        if (!$result) {
            $mensajes[] = ["resultado" => KO, "texto" => "Error en la consulta."];
            $todoOk = KO;
        } elseif ($result->fetchColumn() == 0) {
            $mensajes[] = ["resultado" => KO, "texto" => "No se ha creado todavía ningún registro."];
            $todoOk = KO;
        } else {
            $consulta = "SELECT * FROM $dbTabla
            ORDER BY $columna $orden";
            $result = $db->query($consulta);
            if (!$result) {
                $mensajes[] = ["resultado" => KO, "texto" => "Error en la consulta."];
                $todoOk = KO;
            } else {
                $mensajes[] = ["resultado" => OK, "texto" => "Registros seleccionados correctamente."];
                foreach ($result as $valor) {
                    $registros[] = [
                        "id"        => $valor["id"],
                        "nombre"    => $valor["nombre"],
                        "apellidos" => $valor["apellidos"],
                        "telefono"  => $valor["telefono"]
                    ];
                }
                $todoOk = OK;
            }
        }
    } elseif ($accion == "borrar-registros-id") {
        $id = recogeMatriz("id");
        if (count($id) == 0) {
            $mensajes[] = ["resultado" => KO, "texto" => "No se ha seleccionado ningún registro."];
            $todoOk = KO;
        } else {
            foreach ($id as $indice => $valor) {
                $consulta = "SELECT COUNT(*) FROM $dbTabla
                WHERE id=:indice";
                $result = $db->prepare($consulta);
                $result->execute([":indice" => $indice]);
                if (!$result) {
                    $mensajes[] = ["resultado" => KO, "texto" => "Error en la consulta."];
                    $todoOk = KO;
                } elseif ($result->fetchColumn() == 0) {
                    $mensajes[] = ["resultado" => KO, "texto" => "Registro no encontrado."];
                    $todoOk = KO;
                } else {
                    $consulta = "DELETE FROM $dbTabla
                    WHERE id=:indice";
                    $result = $db->prepare($consulta);
                    if ($result->execute([":indice" => $indice])) {
                        $mensajes[] = ["resultado" => OK, "texto" => "Registro borrado correctamente."];
                    } else {
                        $mensajes[] = ["resultado" => KO, "texto" => "Error al borrar el registro."];
                        $todoOk = KO;
                    }
                }
            }
        }
    } elseif ($accion == "seleccionar-registro-id") {
        $id    = recoge("id");

        $consulta = "SELECT COUNT(*) FROM $dbTabla
       WHERE id=:id";
        $result = $db->prepare($consulta);
        $result->execute([":id" => $id]);
        if (!$result) {
            $mensajes[] = ["resultado" => KO, "texto" => "Error en la consulta."];
            $todoOk = KO;
        } elseif ($result->fetchColumn() == 0) {
            $mensajes[] = ["resultado" => KO, "texto" => "Registro no encontrado."];
            $todoOk = KO;
        } else {
            $consulta = "SELECT * FROM $dbTabla
            WHERE id=:id";
            $result = $db->prepare($consulta);
            $result->execute([":id" => $id]);
            if (!$result) {
                $mensajes[] = ["resultado" => KO, "texto" => "Error en la consulta."];
                $todoOk = KO;
            } else {
                $mensajes[] = ["resultado" => OK, "texto" => "Registro seleccionado."];
                $valor = $result->fetch();
                $registros[] = [
                    "id"        => $valor["id"],
                    "nombre"    => $valor["nombre"],
                    "apellidos" => $valor["apellidos"],
                    "telefono"  => $valor["telefono"]
                ];
                $todoOk = OK;
            }
        }
    } elseif ($accion == "modificar-registro") {
        $id        = recoge("id");
        $nombre    = recoge("nombre");
        $apellidos = recoge("apellidos");
        $telefono  = recoge("telefono");
        $nombreOk    = comprueba("nombre", $nombre);
        $apellidosOk = comprueba("apellidos", $apellidos);
        $telefonoOk  = comprueba("telefono", $nombreOk);

        if ($nombreOk["resultado"] && $apellidosOk["resultado"] && $telefonoOk["resultado"]) {
            if ($id == "") {
                $mensajes[] = ["resultado" => KO, "texto" => "No se ha seleccionado ningún registro."];
                $todoOk = KO;
            } elseif ($nombre == "" && $apellidos == "" && $telefono == "") {
                $mensajes[] = ["resultado" => KO, "texto" => "Hay que rellenar al menos uno de los campos. No se ha modificado el registro."];
                $todoOk = KO;
            } else {
                $consulta = "SELECT COUNT(*) FROM $dbTabla
                WHERE id=:id";
                $result = $db->prepare($consulta);
                $result->execute([":id" => $id]);
                if (!$result) {
                    $mensajes[] = ["resultado" => KO, "texto" => "Error en la consulta."];
                    $todoOk = KO;
                } elseif ($result->fetchColumn() == 0) {
                    $mensajes[] = ["resultado" => KO, "texto" => "Registro no encontrado."];
                    $todoOk = KO;
                } else {
                    // La consulta cuenta los registros con un id diferente porque MySQL no distingue
                    // mayúsculas de minúsculas y si en un registro sólo se cambian mayúsculas por
                    // minúsculas MySQL diría que ya hay un registro como el que se quiere guardar.
                    $consulta = "SELECT COUNT(*) FROM $dbTabla
                    WHERE nombre=:nombre
                    AND apellidos=:apellidos
                    AND telefono=:telefono
                    AND id<>:id";
                    $result = $db->prepare($consulta);
                    $result->execute([
                        ":nombre" => $nombre, ":apellidos" => $apellidos,
                        ":telefono" => $telefono, ":id" => $id
                    ]);
                    if (!$result) {
                        $mensajes[] = ["resultado" => KO, "texto" => "Error en la consulta."];
                        $todoOk = KO;
                    } elseif ($result->fetchColumn() > 0) {
                        $mensajes[] = ["resultado" => KO, "texto" => "Ya existe un registro con esos mismos valores. No se ha guardado la modificación."];
                        $todoOk = KO;
                    } else {
                        $consulta = "UPDATE $dbTabla
                        SET nombre=:nombre, apellidos=:apellidos, telefono=:telefono
                        WHERE id=:id";
                        $result = $db->prepare($consulta);
                        if ($result->execute([
                            ":nombre" => $nombre, ":apellidos" => $apellidos,
                            ":telefono" => $telefono, ":id" => $id
                        ])) {
                            $mensajes[] = ["resultado" => OK, "texto" => "Registro modificado correctamente."];
                            $todoOk = OK;
                        } else {
                            $mensajes[] = ["resultado" => KO, "texto" => "Error al modificar el registro."];
                            $todoOk = OK;
                        }
                    }
                }
            }
        }
    } elseif ($accion == "contar-registros-todos") {
        $consulta = "SELECT COUNT(*) FROM $dbTabla";
        $result = $db->query($consulta);
        if (!$result) {
            $mensajes[] = ["resultado" => KO, "texto" => "Error en la consulta."];
            $todoOk = KO;
        } else {
            $numeroRegistros = $result->fetchColumn();
            if ($numeroRegistros == 0) {
                $mensajes[] = ["resultado" => KO, "texto" => "No se ha creado todavía ningún registro."];
                $todoOk = KO;
            } else {
                $mensajes[] = ["resultado" => OK, "texto" => "Registros contados correctamente."];
                $registros[] = [$numeroRegistros];
                $todoOk = OK;
            }
        }
    } elseif ($accion == "buscar-registros") {
        $nombre    = recoge("nombre");
        $apellidos = recoge("apellidos");
        $telefono  = recoge("telefono");
        $columna = recogeValores("columna", $columnas, "apellidos");
        $orden   = recogeValores("orden", $orden, "ASC");

        $consulta = "SELECT COUNT(*) FROM $dbTabla
            WHERE nombre LIKE :nombre
            AND apellidos LIKE :apellidos
            AND telefono LIKE :telefono";
        $result = $db->prepare($consulta);
        $result->execute([":nombre" => "%$nombre%", ":apellidos" => "%$apellidos%", ":telefono" => "%$telefono%"]);
        if (!$result) {
            $mensajes[] = ["resultado" => KO, "texto" => "Error en la consulta."];
            $todoOk = KO;
        } elseif ($result->fetchColumn() == 0) {
            $mensajes[] = ["resultado" => KO, "texto" => "No se ha encontrado ningún registro."];
            $todoOk = KO;
        } else {
            $consulta = "SELECT * FROM $dbTabla
                WHERE nombre LIKE :nombre
                AND apellidos LIKE :apellidos
                AND telefono LIKE :telefono
                ORDER BY $columna $orden";
            $result = $db->prepare($consulta);
            $result->execute([":nombre" => "%$nombre%", ":apellidos" => "%$apellidos%", ":telefono" => "%$telefono%"]);
            if (!$result) {
                $mensajes[] = ["resultado" => KO, "texto" => "Error en la consulta."];
                $todoOk = KO;
            } else {
                $mensajes[] = ["resultado" => OK, "texto" => "Registros encontrados correctamente."];
                $todoOk = OK;
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
    } else {
        $resultado = KO;
        $mensajes = [["resultado" => "KO", "texto" => "Acción no disponible."]];
        $registros = [];
    }

    $db = null;
}
print json_encode(["resultado" => $todoOk, "mensajes" => $mensajes, "registros" => $registros]);
