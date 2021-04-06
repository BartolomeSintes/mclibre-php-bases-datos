<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

// Configuración específica para MYSQL

// Configuración general

define("MYSQL_HOST", "mysql:host=localhost");         // Nombre de host
define("MYSQL_USER", "");                             // Nombre de usuario
define("MYSQL_PASSWORD", "");                         // Contraseña de usuario
define("MYSQL_DATABASE", "biblioteca_3");             // Nombre de la base de datos

// Nombres de las tablas

$tablaUsuarios  = MYSQL_DATABASE . ".usuarios";       // Nombre de la tabla Usuarios
$tablaPersonas  = MYSQL_DATABASE . ".personas";       // Nombre de la tabla Personas
$tablaObras     = MYSQL_DATABASE . ".obras";          // Nombre de la tabla Obras
$tablaPrestamos = MYSQL_DATABASE . ".prestamos";      // Nombre de la tabla Préstamos

// Consultas de borrado y creación de base de datos y tablas, etc.

$consultasBorraTodo = [
    // Borra base de datos
    "DROP DATABASE " . MYSQL_DATABASE,
    // Crea base de datos
    "CREATE DATABASE " . MYSQL_DATABASE . "
        CHARACTER SET utf8mb4
        COLLATE utf8mb4_unicode_ci",
    // Crea tablas
    "CREATE TABLE $tablaUsuarios (
        id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
        usuario VARCHAR($cfg[tamUsuariosUsuario]),
        password VARCHAR($cfg[tamUsuariosPasswordCifrado]),
        nivel INTEGER
    )",
    "CREATE TABLE $tablaPersonas (
        id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR($cfg[tamPersonasNombre]),
        apellidos VARCHAR($cfg[tamPersonasApellidos]),
        dni VARCHAR($cfg[tamPersonasDni])
    )",
    "CREATE TABLE $tablaObras (
        id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
        autor VARCHAR($cfg[tamObrasAutor]),
        titulo VARCHAR($cfg[tamObrasTitulo]),
        editorial VARCHAR($cfg[tamObrasEditorial])
    )",
    "CREATE TABLE $tablaPrestamos (
        id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
        id_persona INTEGER NOT NULL,
        id_obra INTEGER NOT NULL,
        prestado DATE,
        devuelto DATE,
        FOREIGN KEY(id_persona) REFERENCES $tablaPersonas(id) ON DELETE CASCADE ON UPDATE CASCADE,
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

// Funciones específicas de bases de datos (MYSQL)

function conectaDb()
{
    try {
        $tmp = new PDO(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
        $tmp->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        $tmp->exec("set names utf8mb4");
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
    $existe   = true;
    $consulta = "SELECT count(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . MYSQL_DATABASE . "'";
    $result   = $pdo->query($consulta);
    if (!$result) {
        $existe = false;
        print "    <p class=\"aviso\">Error en la consulta.</p>\n";
        print "\n";
    } else {
        if ($result->fetchColumn() == 0) {
            $existe = false;
        } else {
            foreach ($nombresTablas as $tabla) {
                // En information_schema.tables los nombres de las tablas no llevan el nombre
                // de la base de datos, así que lo elimino
                $tabla    = str_replace(MYSQL_DATABASE . ".", "", $tabla);
                $consulta = "SELECT count(*) FROM information_schema.tables
                WHERE table_schema = '" . MYSQL_DATABASE . "'
                    AND table_name = '$tabla'";
                $result = $pdo->query($consulta);
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
        }
    }
    return $existe;
}
