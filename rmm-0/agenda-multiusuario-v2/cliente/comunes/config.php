<?php
/**
 * RMM-0 - Agenda multiusuario (Cliente) - config.php
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

// Método de envío de formularios

define("FORM_METHOD",    GET);     // Valores posibles: GET o POST

// Configuración Tabla Usuarios de la web

$tamUsuariosWebUsuario  = 20;  // Tamaño del campo Usuarios de la web > Usuario
$tamUsuariosWebPassword = 20;  // Tamaño del campo Usuarios de la web > Contraseña
$tamUsuariosWebCifrado  = 32;  // Tamaño del campo Usuarios de la web > Contraseña encriptada

$administradorNombre   = "root";  // Nombre del usuario Administrador
$administradorPassword = "root";  // Password del usuario Administrador

// Configuración Tabla Agenda

$tamNombre    = 40;           // Tamaño de la columna Nombre
$tamApellidos = 60;           // Tamaño de la columna Apellidos
$tamTelefono  = 10;           // Tamaño de la columna Teléfono
