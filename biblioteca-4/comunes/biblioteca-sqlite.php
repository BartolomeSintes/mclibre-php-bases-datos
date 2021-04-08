<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

// Configuración específica para SQLite

// Nombres de las tablas

$db["tablaUsuarios"]  = "usuarios";   // Nombre de la tabla Usuarios
$db["tablaPersonas"]  = "personas";   // Nombre de la tabla Personas
$db["tablaObras"]     = "obras";      // Nombre de la tabla Obras
$db["tablaPrestamos"] = "prestamos";  // Nombre de la tabla Préstamos

// Consultas de borrado y creación de base de datos y tablas, etc.

$db["consultasBorraTodo"] = [
    // Borra tablas
    "DROP TABLE $db[tablaUsuarios]",
    "DROP TABLE $db[tablaPersonas]",
    "DROP TABLE $db[tablaObras]",
    "DROP TABLE $db[tablaPrestamos]",
    // Crea tablas
    "CREATE TABLE $db[tablaUsuarios] (
        id INTEGER PRIMARY KEY,
        usuario VARCHAR($db[tamUsuariosUsuario]),
        password VARCHAR($db[tamUsuariosPasswordCifrado]),
        nivel INTEGER
    )",
    "CREATE TABLE $db[tablaPersonas] (
        id INTEGER PRIMARY KEY,
        nombre VARCHAR($db[tamPersonasNombre]),
        apellidos VARCHAR($db[tamPersonasApellidos]),
        dni VARCHAR($db[tamPersonasDni])
    )",
    "CREATE TABLE $db[tablaObras] (
        id INTEGER PRIMARY KEY,
        autor VARCHAR($db[tamObrasAutor]),
        titulo VARCHAR($db[tamObrasTitulo]),
        editorial VARCHAR($db[tamObrasEditorial])
    )",
    "CREATE TABLE $db[tablaPrestamos] (
        id INTEGER PRIMARY KEY,
        id_persona INTEGER UNSIGNED,
        id_obra INTEGER UNSIGNED,
        prestado DATE,
        devuelto DATE,
        FOREIGN KEY(id_persona) REFERENCES $db[tablaPersonas](id) ON DELETE CASCADE ON UPDATE CASCADE
        FOREIGN KEY(id_obra) REFERENCES $db[tablaObras](id) ON DELETE CASCADE ON UPDATE CASCADE
    )",
    // Inserta usuario root
    "INSERT INTO $db[tablaUsuarios]
        VALUES (NULL, '$cfg[rootName]', '$cfg[rootPassword]', $usuariosNiveles[Administrador])",
];

$db["consultasValoresDemo"] = [
    "INSERT INTO $db[tablaUsuarios]
        VALUES (2,'pepe','7c9e7c1494b2684ab7c19d6aff737e460fa9e98d5a234da1310c97ddf5691834',1)",
    "INSERT INTO $db[tablaPersonas]
        VALUES (1,'Pepito','Conejo','123A')",
    "INSERT INTO $db[tablaPersonas]
        VALUES (2,'Juan','Nadie','9876X')",
    "INSERT INTO $db[tablaObras]
        VALUES (1,'Miguel de Cervantes','Don Quijote','Cátedra')",
    "INSERT INTO $db[tablaObras]
        VALUES (2,'Jorge Luis Borges','Ficciones','Ed Sudamericana')",
    "INSERT INTO $db[tablaPrestamos]
        VALUES (1, 1, 1,'" . date("Y-m-d", time() - 4 * 60 * 60 * 24) . "','" . date("Y-m-d", time() - 3 * 60 * 60 * 24) . "')",
    "INSERT INTO $db[tablaPrestamos]
        VALUES (2, 2, 2,'" . date("Y-m-d", time() - 4 * 60 * 60 * 24) . "','" . date("Y-m-d", time() - 2 * 60 * 60 * 24) . "')",
    "INSERT INTO $db[tablaPrestamos]
        VALUES (3, 2, 1,'" . date("Y-m-d", time() - 1 * 60 * 60 * 24) . "','0000-00-00')",
];

if ($cfg["insertaRegistrosDemo"]) {
    $db["consultasBorraTodo"] = array_merge($db["consultasBorraTodo"], $db["consultasValoresDemo"]);
}

// Funciones específicas de bases de datos (SQLITE)

function conectaDb()
{
    global $cfg;

    try {
        $tmp = new PDO("sqlite:" . $cfg["sqliteDatabase"]);
        return $tmp;
    } catch (PDOException $e) {
        cabecera("Error grave", MENU_VOLVER, PROFUNDIDAD_1);
        print "    <p class=\"aviso\">Error: No puede conectarse con la base de datos.</p>\n";
        print "\n";
        print "    <p class=\"aviso\">Error: " . $e->getMessage() . "</p>\n";
        pie();
        exit();
    }
}

function borraTodo($pdo)
{
    global $db;

    foreach ($db["consultasBorraTodo"] as $consulta) {
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
