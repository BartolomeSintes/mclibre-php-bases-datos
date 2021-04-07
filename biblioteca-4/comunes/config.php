<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

// Base de datos utilizada por la aplicación: MYSQL o SQLITE

$cfg["dbMotor"] = SQLITE;                                   // Valores posibles: MYSQL o SQLITE

// Configuración para SQLite

$cfg["sqliteDatabase"] = "/home/barto/mclibre/tmp/mclibre/biblioteca-4.sqlite";             // Ubicación de la base de datos

// Configuración para MySQL

$cfg["mysqlHost"]     = "mysql:host=localhost";             // Nombre de host
$cfg["mysqlUser"]     = "";                                 // Nombre de usuario
$cfg["mysqlPassword"] = "";                                 // Contraseña de usuario
$cfg["mysqlDatabase"] = "biblioteca_3";                     // Nombre de la base de datos

// Configuración Tablas: Número máximo de registros

$cfg["maxRegTableUsuarios"]  = 999;                         // Número máximo de registros en la tabla Usuarios
$cfg["maxRegTablePersonas"]  = 999;                         // Número máximo de registros en la tabla Personas
$cfg["maxRegTableObras"]     = 999;                         // Número máximo de registros en la tabla Obras
$cfg["maxRegTablePrestamos"] = 999;                         // Número máximo de registros en la tabla Préstamos

// Usuario inicial

$cfg["rootName"]     = "root";                                                              // Usuario inicial: Nombre
$cfg["rootPassword"] = "4813494d137e1631bba301d5acab6e7bb7aa74ce1185d456565ef51d737677b2";  // Usuario inicial: Contraseña

// Inserta registros iniciales de prueba

$cfg["insertaRegistrosDemo"] = true;                        // Incluye o no los registros de prueba al crear la base de datos

// Algoritmo hash para encriptar la contraseña de usuario

$cfg["hashAlgorithm"] = SHA_256;                            // Algoritmo hash: Nombre. Valores posibles: SHA_256
$cfg["hashSize"]      = $hashSizes[$cfg["hashAlgorithm"]];  // Algoritmo hash: Longitud. NO MODIFICAR

// Método de envío de formularios

$cfg["formMethod"] = GET;                                   // Valores posibles: GET o POST

// Hoja de estilo

$cfg["color"] = 220;                                        // Color básico de la aplicación (0 - 360)

// Nombre de sesión

$cfg["sessionName"] = "biblioteca";                         // Nombre de sesión

// Zona horaria

$cfg["zonaHoraria"] = "Europe/Madrid";                      // Zona horaria del servidor
