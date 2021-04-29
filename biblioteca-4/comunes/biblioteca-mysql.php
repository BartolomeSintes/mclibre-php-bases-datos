<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

// Configuración específica para MYSQL

// Nombres de las tablas

$db["usuarios"]  = $cfg["mysqlDatabase"] . ".usuarios";       // Nombre de la tabla Usuarios
$db["personas"]  = $cfg["mysqlDatabase"] . ".personas";       // Nombre de la tabla Personas
$db["obras"]     = $cfg["mysqlDatabase"] . ".obras";          // Nombre de la tabla Obras
$db["prestamos"] = $cfg["mysqlDatabase"] . ".prestamos";      // Nombre de la tabla Préstamos

// Consultas de borrado y creación de base de datos y tablas, etc.

$db["consultasBorraTodo"] = [
    // Borra base de datos
    "DROP DATABASE IF EXISTS " . $cfg["mysqlDatabase"],
    // Crea base de datos
    "CREATE DATABASE " . $cfg["mysqlDatabase"] . "
        CHARACTER SET utf8mb4
        COLLATE utf8mb4_unicode_ci",
    // Crea tablas
    "CREATE TABLE $db[usuarios] (
        id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
        usuario VARCHAR($db[tamUsuariosUsuario]),
        password VARCHAR($db[tamUsuariosPasswordCifrado]),
        nivel INTEGER
    )",
    "CREATE TABLE $db[personas] (
        id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR($db[tamPersonasNombre]),
        apellidos VARCHAR($db[tamPersonasApellidos]),
        dni VARCHAR($db[tamPersonasDni])
    )",
    "CREATE TABLE $db[obras] (
        id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
        autor VARCHAR($db[tamObrasAutor]),
        titulo VARCHAR($db[tamObrasTitulo]),
        editorial VARCHAR($db[tamObrasEditorial])
    )",
    "CREATE TABLE $db[prestamos] (
        id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
        id_persona INTEGER NOT NULL,
        id_obra INTEGER NOT NULL,
        prestado DATE,
        devuelto DATE,
        FOREIGN KEY(id_persona) REFERENCES $db[personas](id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY(id_obra) REFERENCES $db[obras](id) ON DELETE CASCADE ON UPDATE CASCADE
    )",
    // Inserta usuario root
    "INSERT INTO $db[usuarios]
        VALUES (NULL, '$cfg[rootName]', '$cfg[rootPassword]', $usuariosNiveles[Administrador])",
];

// Funciones específicas de bases de datos (MYSQL)

function conectaDb()
{
    global $cfg;

    try {
        $tmp = new PDO($cfg["mysqlHost"], $cfg["mysqlUser"], $cfg["mysqlPassword"]);
        $tmp->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        $tmp->exec("set names utf8mb4");
        return $tmp;
    } catch (PDOException $e) {
        cabecera("Error grave", MENU_VOLVER, PROFUNDIDAD_1);
        print "    <p class=\"aviso-error\">Error: No puede conectarse con la base de datos.</p>\n";
        print "\n";
        print "    <p class=\"aviso-error\">Error: " . $e->getMessage() . "</p>\n";
        pie();
        exit();
    }
}

function existenTablas()
{
    global $cfg, $db;

    $pdo = conectaDb();

    $existe   = true;
    $consulta = "SELECT count(*)
                 FROM INFORMATION_SCHEMA.SCHEMATA
                 WHERE SCHEMA_NAME = '" . $cfg["mysqlDatabase"] . "'";
    $result   = $pdo->query($consulta);
    if (!$result) {
        $existe = false;
        print "    <p class=\"aviso-error\">Error en la consulta.</p>\n";
        print "\n";
    } else {
        if ($result->fetchColumn() == 0) {
            $existe = false;
        } else {
            foreach ($db["tablas"] as $tabla) {
                // En information_schema.tables los nombres de las tablas no llevan el nombre
                // de la base de datos, así que lo elimino
                $tabla    = str_replace($cfg["mysqlDatabase"] . ".", "", $tabla);
                $consulta = "SELECT count(*)
                             FROM information_schema.tables
                             WHERE
                               table_schema = '" . $cfg["mysqlDatabase"] . "'
                               AND table_name = '$tabla'";
                $result = $pdo->query($consulta);
                if (!$result) {
                    $existe = false;
                    print "    <p class=\"aviso-error\">Error en la consulta.</p>\n";
                    print "\n";
                } else {
                    if ($result->fetchColumn() == 0) {
                        $existe = false;
                    }
                }
            }
        }
    }

    $pdo = null;
    return $existe;
}
