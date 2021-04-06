<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

// Configuración específica para SQLite

// Configuración general

define("SQLITE_DATABASE", "/home/barto/mclibre/tmp/mclibre/biblioteca-3.sqlite");  // Ubicación de la base de datos

// Nombres de las tablas

$tablaUsuarios  = "usuarios";   // Nombre de la tabla Usuarios
$tablaPersonas  = "personas";   // Nombre de la tabla Personas
$tablaObras     = "obras";      // Nombre de la tabla Obras
$tablaPrestamos = "prestamos";  // Nombre de la tabla Préstamos

// Consultas de borrado y creación de base de datos y tablas, etc.

$consultasBorraTodo = [
    // Borra tablas
    "DROP TABLE $tablaUsuarios",
    "DROP TABLE $tablaPersonas",
    "DROP TABLE $tablaObras",
    "DROP TABLE $tablaPrestamos",
    // Crea tablas
    "CREATE TABLE $tablaUsuarios (
        id INTEGER PRIMARY KEY,
        usuario VARCHAR($cfg[tamUsuariosUsuario]),
        password VARCHAR($cfg[tamUsuariosPasswordCifrado]),
        nivel INTEGER
    )",
    "CREATE TABLE $tablaPersonas (
        id INTEGER PRIMARY KEY,
        nombre VARCHAR($cfg[tamPersonasNombre]),
        apellidos VARCHAR($cfg[tamPersonasApellidos]),
        dni VARCHAR($cfg[tamPersonasDni])
    )",
    "CREATE TABLE $tablaObras (
        id INTEGER PRIMARY KEY,
        autor VARCHAR($cfg[tamObrasAutor]),
        titulo VARCHAR($cfg[tamObrasTitulo]),
        editorial VARCHAR($cfg[tamObrasEditorial])
    )",
    "CREATE TABLE $tablaPrestamos (
        id INTEGER PRIMARY KEY,
        id_persona INTEGER UNSIGNED,
        id_obra INTEGER UNSIGNED,
        prestado DATE,
        devuelto DATE,
        FOREIGN KEY(id_persona) REFERENCES $tablaPersonas(id) ON DELETE CASCADE ON UPDATE CASCADE
        FOREIGN KEY(id_obra) REFERENCES $tablaObras(id) ON DELETE CASCADE ON UPDATE CASCADE
    )",
    // Inserta usuario root
    "INSERT INTO $tablaUsuarios
        VALUES (NULL, '$cfg[rootName]', '$cfg[rootPassword]', $usuariosNiveles[Administrador])",
];

$consultasValoresDemo = [
    "INSERT INTO $tablaUsuarios
        VALUES (2,'pepe','7c9e7c1494b2684ab7c19d6aff737e460fa9e98d5a234da1310c97ddf5691834',1)",
    "INSERT INTO $tablaPersonas
        VALUES (1,'Pepito','Conejo','123A')",
    "INSERT INTO $tablaPersonas
        VALUES (2,'Juan','Nadie','9876X')",
    "INSERT INTO $tablaObras
        VALUES (1,'Miguel de Cervantes','Don Quijote','Cátedra')",
    "INSERT INTO $tablaObras
        VALUES (2,'Jorge Luis Borges','Ficciones','Ed Sudamericana')",
    "INSERT INTO $tablaPrestamos
        VALUES (1, 1, 1,'" . date("Y-m-d", time() - 4 * 60 * 60 * 24) . "','" . date("Y-m-d", time() - 3 * 60 * 60 * 24) . "')",
    "INSERT INTO $tablaPrestamos
        VALUES (2, 2, 2,'" . date("Y-m-d", time() - 4 * 60 * 60 * 24) . "','" . date("Y-m-d", time() - 2 * 60 * 60 * 24) . "')",
    "INSERT INTO $tablaPrestamos
        VALUES (3, 2, 1,'" . date("Y-m-d", time() - 1 * 60 * 60 * 24) . "','0000-00-00')",
];

if ($cfg["insertaRegistrosDemo"]) {
    $consultasBorraTodo = array_merge($consultasBorraTodo, $consultasValoresDemo);
}

// Funciones específicas de bases de datos (SQLITE)

function conectaDb()
{
    try {
        $tmp = new PDO("sqlite:" . SQLITE_DATABASE);
        return $tmp;
    } catch (PDOException $e) {
        cabecera("Error grave", MENU_VOLVER, 1);
        print "    <p class=\"aviso\">Error: No puede conectarse con la base de datos.</p>\n";
        print "\n";
        print "    <p class=\"aviso\">Error: " . $e->getMessage() . "</p>\n";
        pie();
        exit();
    }
}

function borraTodo($pdo)
{
    global $consultasBorraTodo;

    foreach ($consultasBorraTodo as $consulta) {
        if (!$pdo->query($consulta)) {
            print "    <p class=\"aviso\">Error en la consulta: $consulta</p>\n";
            print "\n";
        }
    }
}

function existenTablas($pdo, $nombresTablas)
{
    $existe = true;
    foreach ($nombresTablas as $tabla) {
        $consulta = "SELECT count(*) FROM sqlite_master WHERE type='table' AND name='$tabla'";
        $result   = $pdo->query($consulta);
        if (!$result) {
            $existe = false;
            print "    <p class=\"aviso\">Error en la consulta.</p>\n";
            print "\n";
        } else {
            if ($result->fetchColumn() == 0) {
                $existe = false;
            }
        }
    }
    return $existe;
}
