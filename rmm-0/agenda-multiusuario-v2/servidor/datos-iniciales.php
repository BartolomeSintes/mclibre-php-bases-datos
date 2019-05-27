<?php
/**
 * RMM-0 - Agenda multiusuario (Servidor) - instalacion/datos-iniciales.php
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

function insertaRegistrosIniciales($db)
{
    global $dbTablaUsuariosWeb, $dbTablaAgenda;

    // Inserta Usuarios
    $consulta = "INSERT INTO $dbTablaUsuariosWeb (id, usuario, password, nivel) VALUES
    (2, 'barto', 'c98c1fdb9054218ab27ff2da15a50d62', 1)";

    if ($db->query($consulta)) {
        print "    <p>Registros de Usuarios creados correctamente.</p>\n";
        print "\n";
    } else {
        print "    <p class=\"aviso\">Error al crear los registros de Usuarios.</p>\n";
        print "\n";
    }

    // Inserta Agenda
    $consulta = "INSERT INTO $dbTablaAgenda () VALUES
        (1, 'barto', 'Bartolomé', 'Sintes Marco', '3141592')";
    if ($db->query($consulta)) {
        print "    <p>Registros de Familias creados correctamente.</p>\n";
        print "\n";
    } else {
        print "    <p class=\"aviso\">Error al crear los registros de Familias.</p>\n";
        print "\n";
    }
}
