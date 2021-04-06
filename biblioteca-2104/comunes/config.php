<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

// URL de la aplicación

$cfg["urlBase"] = "D:/_Carpetas_frecuentes/Documentos/_MCLibre.org/Actual/consultar/php-bases-datos/biblioteca-2104/";

// Base de datos utilizada por la aplicación: MYSQL o SQLITE

$cfg["dbMotor"] = SQLITE;                 // Valores posibles: MYSQL o SQLITE

// Algoritmo hash para encriptar la contraseña de usuario

$cfg["hashAlgorithm"] = SHA_256;                            // Algoritmo hash: Nombre. Valores posibles: SHA_256
$cfg["hashSize"]      = $hashSizes[$cfg["hashAlgorithm"]];  // Algoritmo hash: Longitud

// Configuración Tabla Usuarios

$cfg["maxRegTableUsuarios"]        = 999;                   // Número máximo de registros en la tabla Usuarios
$cfg["tamUsuariosUsuario"]         = 20;                    // Tamaño de la columna Usuarios > Nombre de Usuario
$cfg["tamUsuariosPasswordCifrado"] = $cfg["hashSize"];      // Tamaño de la columna Usuarios > Contraseña de Usuario cifrada
$cfg["tamUsuariosPassword"]        = 20;                    // Tamaño de la Contraseña de Usuario en el formulario

// Configuración Tabla Personas

$cfg["maxRegTablePersonas"]  = 999;       // Número máximo de registros en la tabla Personas
$cfg["tamPersonasNombre"]    = 40;        // Tamaño de la columna Personas > Nombre
$cfg["tamPersonasApellidos"] = 60;        // Tamaño de la columna Personas > Apellidos
$cfg["tamPersonasDni"]       = 9;         // Tamaño de la columna Personas > DNI

// Configuración Tabla Obras

$cfg["maxRegTableObras"]  = 999;          // Número máximo de registros en la tabla Obras
$cfg["tamObrasAutor"]     = 60;           // Tamaño de la columna Obras > Autor
$cfg["tamObrasTitulo"]    = 60;           // Tamaño de la columna Obras > Titulo
$cfg["tamObrasEditorial"] = 20;           // Tamaño de la columna Obras > Editorial

// Configuración Tabla Préstamos

$cfg["maxRegTablePrestamos"] = 999;       // Número máximo de registros en la tabla Préstamos
$cfg["tamPrestamosPersona"]  = 60;        // Tamaño de la columna Préstamos > Persona
$cfg["tamPrestamosObra"]     = 60;        // Tamaño de la columna Préstamos > Obra
$cfg["tamPrestamosPrestado"] = 20;        // Tamaño de la columna Préstamos > Fecha de Préstamo
$cfg["tamPrestamosDevuelto"] = 20;        // Tamaño de la columna Préstamos > Fecha de Devolución
$cfg["tamFecha"]             = 10;        // Longitud de una cadena de fecha (AAAA-MM-DD)

// Usuario inicial

$cfg["rootName"]     = "root";                                                                  // Usuario inicial: Nombre
$cfg["rootPassword"] = "4813494d137e1631bba301d5acab6e7bb7aa74ce1185d456565ef51d737677b2";  // Usuario inicial: Contraseña

// Método de envío de formularios

$cfg["formMethod"] = GET;                 // Valores posibles: GET o POST

// Hoja de estilo

$cfg["color"] = 200;                       // Color básico de la aplicación (0 - 360)

// Nombre de sesión

$cfg["sessionName"] = "biblioteca";       // Nombre de sesión

// Zona horaria

$cfg["zonaHoraria"] = "Europe/Madrid";    // Zona horaria del servidor
