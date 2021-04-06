<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

function consultas($tabla, $pagina, $numero, $argumentos = [])
{
    global $cfg;
    // print "$tabla, $pagina, $numero";
    // print "<pre>"; print_r($argumentos); print "</pre>";

    $db = conectaDb();

    if ($tabla == "usuarios" && $pagina == "insertar-1-a" && $numero == 1) {
        $consulta = "SELECT COUNT(*) FROM $cfg[tablaUsuarios]";
        $result   = $db->query($consulta);
        return $result->fetchAll();
    }
    if ($tabla == "usuarios" && $pagina == "insertar-2" && $numero == 1) {
        $consulta = "SELECT COUNT(*) FROM $cfg[tablaUsuarios]";
        $result   = $db->query($consulta);
        return $result->fetchAll();
    }
    if ($tabla == "usuarios" && $pagina == "insertar-2" && $numero == 2) {
        $consulta = "SELECT COUNT(*) FROM $cfg[tablaUsuarios]
                        WHERE usuario=:usuario";
        $result = $db->prepare($consulta);
        $result->execute([":usuario" => $argumentos[0]]);
        return $result->fetchAll();
    }
    if ($tabla == "usuarios" && $pagina == "insertar-2" && $numero == 3) {
        $consulta = "INSERT INTO $cfg[tablaUsuarios]
                        (usuario, password, nivel)
                        VALUES (:usuario, :password, $argumentos[0])"; // nivel
        $result = $db->prepare($consulta);
        return $result->execute([":usuario" => $argumentos[1], ":password" => encripta($argumentos[2])]);
    }
    if ($tabla == "usuarios" && $pagina == "listar" && $numero == 1) {
        $consulta = "SELECT COUNT(*) FROM $cfg[tablaUsuarios]";
        $result   = $db->query($consulta);
        return $result->fetchAll();
    }
    if ($tabla == "usuarios" && $pagina == "listar" && $numero == 2) {
        $consulta = "SELECT * FROM $cfg[tablaUsuarios] ORDER BY $argumentos[0]";
        $result   = $db->query($consulta);
        return $result->fetchAll();
    }

    if ($tabla == "obras" && $pagina == "insertar-1-a" && $numero == 1) {
        $consulta = "SELECT COUNT(*) FROM $cfg[tablaObras]";
        $result   = $db->query($consulta);
        return $result->fetchAll();
    }
    if ($tabla == "obras" && $pagina == "listar" && $numero == 1) {
        $consulta = "SELECT COUNT(*) FROM $cfg[tablaObras]";
        $result   = $db->query($consulta);
        return $result->fetchAll();
    }
    if ($tabla == "obras" && $pagina == "listar" && $numero == 2) {
        $consulta = "SELECT * FROM $cfg[tablaObras] ORDER BY $argumentos[0]";
        $result   = $db->query($consulta);
        return $result->fetchAll();
    }

    if ($tabla == "personas" && $pagina == "insertar-1-a" && $numero == 1) {
        $consulta = "SELECT COUNT(*) FROM $cfg[tablaPersonas]";
        $result   = $db->query($consulta);
        return $result->fetchAll();
    }
    if ($tabla == "personas" && $pagina == "listar" && $numero == 1) {
        $consulta = "SELECT COUNT(*) FROM $cfg[tablaPersonas]";
        $result   = $db->query($consulta);
        return $result->fetchAll();
    }
    if ($tabla == "personas" && $pagina == "listar" && $numero == 2) {
        $consulta = "SELECT * FROM $cfg[tablaPersonas] ORDER BY $argumentos[0]";
        $result   = $db->query($consulta);
        return $result->fetchAll();
    }

    if ($tabla == "prestamos" && $pagina == "listar" && $numero == 1) {
        $consulta = "SELECT COUNT(*) FROM $cfg[tablaPrestamos]";
        $result   = $db->query($consulta);
        return $result->fetchAll();
    }
    if ($tabla == "prestamos" && $pagina == "listar" && $numero == 2) {
        $consulta = "SELECT $cfg[tablaPrestamos].id as id,
                    $cfg[tablaPersonas].nombre as nombre,
                    $cfg[tablaPersonas].apellidos as apellidos,
                    $cfg[tablaObras].titulo as titulo,
                    $cfg[tablaObras].autor as autor,
                    $cfg[tablaPrestamos].prestado as prestado,
                    $cfg[tablaPrestamos].devuelto as devuelto
                FROM $cfg[tablaPersonas], $cfg[tablaObras], $cfg[tablaPrestamos]
                WHERE $cfg[tablaPrestamos].id_persona=$cfg[tablaPersonas].id
                AND $cfg[tablaPrestamos].id_obra=$cfg[tablaObras].id
                ORDER BY $argumentos[0]";
        $result = $db->query($consulta);
        return $result->fetchAll();
    }
}

function consultasViejo($tabla, $pagina, $numero, $argumentos = [])
{
    global $cfg;

    if ($tabla == "usuarios" && $pagina == "insertar-1-a" && $numero == 1) {
        return "SELECT COUNT(*) FROM $cfg[tablaUsuarios]";
    }
    if ($tabla == "usuarios" && $pagina == "insertar-2" && $numero == 1) {
        return "SELECT COUNT(*) FROM  $cfg[tablaUsuarios]";
    }
    if ($tabla == "usuarios" && $pagina == "insertar-2" && $numero == 2) {
        $consulta = "SELECT COUNT(*) FROM $cfg[tablaUsuarios]
                        WHERE usuario=:usuario";
    }
    if ($tabla == "usuarios" && $pagina == "insertar-2" && $numero == 3) {
        $consulta = "INSERT INTO $cfg[tablaUsuarios]
                        (usuario, password, nivel)
                        VALUES (:usuario, :password, $argumentos[0])";
    }
    if ($tabla == "usuarios" && $pagina == "listar" && $numero == 1) {
        return "SELECT COUNT(*) FROM $cfg[tablaUsuarios]";
    }
    if ($tabla == "usuarios" && $pagina == "listar" && $numero == 2) {
        return "SELECT * FROM $cfg[tablaUsuarios] ORDER BY $argumentos[0]";
    }

    if ($tabla == "obras" && $pagina == "insertar-1-a" && $numero == 1) {
        return "SELECT COUNT(*) FROM $argumentos[0]";
    }
    if ($tabla == "obras" && $pagina == "listar" && $numero == 1) {
        return "SELECT COUNT(*) FROM $argumentos[0]";
    }
    if ($tabla == "obras" && $pagina == "listar" && $numero == 2) {
        return "SELECT * FROM $argumentos[0] ORDER BY $argumentos[1]";
    }

    if ($tabla == "personas" && $pagina == "insertar-1-a" && $numero == 1) {
        return "SELECT COUNT(*) FROM $argumentos[0]";
    }
    if ($tabla == "personas" && $pagina == "listar" && $numero == 1) {
        return "SELECT COUNT(*) FROM $argumentos[0]";
    }
    if ($tabla == "personas" && $pagina == "listar" && $numero == 2) {
        return "SELECT * FROM $argumentos[0] ORDER BY $argumentos[1]";
    }

    if ($tabla == "prestamos" && $pagina == "insertar-1-b" && $numero == 1) {
        return "SELECT COUNT(*) FROM $argumentos[0]";
    }
    if ($tabla == "prestamos" && $pagina == "insertar-1-b" && $numero == 2) {
        return "SELECT * FROM $argumentos[0] ORDER BY apellidos";
    }
    if ($tabla == "prestamos" && $pagina == "insertar-1-b" && $numero == 3) {
        return "SELECT * FROM $argumentos[0] ORDER BY autor";
    }
    if ($tabla == "prestamos" && $pagina == "listar" && $numero == 1) {
        return "SELECT COUNT(*) FROM $argumentos[0]";
    }
    if ($tabla == "prestamos" && $pagina == "listar" && $numero == 2) {
        return "SELECT $cfg[tablaPrestamos].id as id,
                    $cfg[tablaPersonas].nombre as nombre,
                    $cfg[tablaPersonas].apellidos as apellidos,
                    $cfg[tablaObras].titulo as titulo,
                    $cfg[tablaObras].autor as autor,
                    $cfg[tablaPrestamos].prestado as prestado,
                    $cfg[tablaPrestamos].devuelto as devuelto
                FROM $cfg[tablaPersonas], $cfg[tablaObras], $cfg[tablaPrestamos]
                WHERE $cfg[tablaPrestamos].id_persona=$cfg[tablaPersonas].id
                AND $cfg[tablaPrestamos].id_obra=$cfg[tablaObras].id
                ORDER BY $argumentos[1]";
    }
}
