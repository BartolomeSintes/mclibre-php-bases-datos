<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

// Configuración específica para SQLite

// Nombres de las tablas

$db["usuarios"]  = "usuarios";      // Nombre de la tabla Usuarios
$db["personas"]  = "personas";      // Nombre de la tabla Personas
$db["obras"]     = "obras";         // Nombre de la tabla Obras
$db["prestamos"] = "prestamos";     // Nombre de la tabla Préstamos

// Consultas de borrado y creación de base de datos y tablas

$db["consultasBorraTodo"] = [
    // Borra tablas
    // En SQLite la condición IF EXISTS falla si está habilitada la restricción FOREIGN_KEYS.
    // Como en cada conexión tengo que habilitarla para que funcionen los ON CASCADE,
    // aquí tengo que deshabilitarla, borrar las tablas y habilitarla de nuevo
    "PRAGMA foreign_keys = OFF",
    "DROP TABLE IF EXISTS $db[usuarios]",
    "DROP TABLE IF EXISTS $db[personas]",
    "DROP TABLE IF EXISTS $db[obras]",
    "DROP TABLE IF EXISTS $db[prestamos]",
    "PRAGMA foreign_keys = ON",
    // Crea tablas
    "CREATE TABLE $db[usuarios] (
        id INTEGER PRIMARY KEY,
        usuario VARCHAR($db[tamUsuariosUsuario]),
        password VARCHAR($db[tamUsuariosPasswordCifrado]),
        nivel INTEGER
    )",
    "CREATE TABLE $db[personas] (
        id INTEGER PRIMARY KEY,
        nombre VARCHAR($db[tamPersonasNombre]),
        apellidos VARCHAR($db[tamPersonasApellidos]),
        dni VARCHAR($db[tamPersonasDni])
    )",
    "CREATE TABLE $db[obras] (
        id INTEGER PRIMARY KEY,
        autor VARCHAR($db[tamObrasAutor]),
        titulo VARCHAR($db[tamObrasTitulo]),
        editorial VARCHAR($db[tamObrasEditorial])
    )",
    "CREATE TABLE $db[prestamos] (
        id INTEGER PRIMARY KEY,
        id_persona INTEGER UNSIGNED,
        id_obra INTEGER UNSIGNED,
        prestado DATE,
        devuelto DATE,
        FOREIGN KEY(id_persona) REFERENCES $db[personas](id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY(id_obra) REFERENCES $db[obras](id) ON DELETE CASCADE ON UPDATE CASCADE
    )",
    // Inserta usuario root
    "INSERT INTO $db[usuarios]
        VALUES (NULL, '$cfg[rootName]', '$cfg[rootPassword]', $usuariosNiveles[Administrador])",
];

// Funciones específicas de bases de datos (SQLITE)

function conectaDb()
{
    global $cfg;

    try {
        $tmp = new PDO("sqlite:" . $cfg["sqliteDatabase"]);
        // En SQLite la restricción FOREIGN KEY no está habilitada por defecto, así que tengo que habilitarla en cada conexión
        $consulta = "PRAGMA foreign_keys = ON";
        $result   = $tmp->query($consulta);
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

function existenTablas()
{
    global $db;

    $pdo    = conectaDb();
    $existe = true;
    foreach ($db["tablas"] as $tabla) {
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
    $pdo = null;
    return $existe;
}
