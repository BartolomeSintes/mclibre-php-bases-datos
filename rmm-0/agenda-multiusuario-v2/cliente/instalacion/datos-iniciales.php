<?php
/**
 * RMM-0 - Agenda multiusuario (Cliente) - instalacion/datos-iniciales.php
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
    global $dbTablaUsuariosWeb, $dbTablaFamilia, $dbTablaSubfamilia, $dbTablaInstrumento, $dbTablaAutor, $dbTablaTitulo, $dbTablaPartitura, $dbTablaAsociacion, $dbTablaMusico;

    // Inserta Usuarios
    $consulta = "INSERT INTO $dbTablaUsuariosWeb (id, usuario, password, nivel) VALUES
    (2, 'david', '172522ec1028ab781d9dfd17eaca4427', 2),
    (3, 'barto', 'c98c1fdb9054218ab27ff2da15a50d62', 2),
    (4, 'manolo', '12cdb9b24211557ef1802bf5a875fd2c', 1),
    (5, 'lucia', '3ba430337eb30f5fd7569451b5dfdf32', 1),
    (6, 'quique', 'ee98233c8450086f4e58d2fd31330dc3', 1)";
if ($db->query($consulta)) {
    print "    <p>Registros de Usuarios creados correctamente.</p>\n";
    print "\n";
} else {
    print "    <p class=\"aviso\">Error al crear los registros de Usuarios.</p>\n";
    print "\n";
}

    // Inserta Familias
    $consulta = "INSERT INTO $dbTablaFamilia (familia) VALUES
        ('Viento-Madera'),
        ('Viento-Metal'),
        ('Percusión'),
        ('Cuerda'),
        ('Teclados'),
        ('Score')";
    if ($db->query($consulta)) {
        print "    <p>Registros de Familias creados correctamente.</p>\n";
        print "\n";
    } else {
        print "    <p class=\"aviso\">Error al crear los registros de Familias.</p>\n";
        print "\n";
    }

    // Inserta Autores
    $consulta = "INSERT INTO $dbTablaAutor (autor) VALUES
        ('Jaime Enguídanos Royo'),
        ('Ferrer Ferran'),
        ('José Alamá-Gil'),
        ('Juan Gonzalo Gómez de Val'),
        ('Francisco Andreu Comos')";
    if ($db->query($consulta)) {
        print "    <p>Registros de Autores creados correctamente.</p>\n";
        print "\n";
    } else {
        print "    <p class=\"aviso\">Error al crear los registros de Autores.</p>\n";
        print "\n";
    }

    // Inserta Titulos
    $consulta = "INSERT INTO $dbTablaTitulo (titulo, autor) VALUES
    ('La Fallera', 'Ferrer Ferran'),
    ('¡Al cielo con ella!', 'Jaime Enguídanos Royo'),
    ('María Dolores Bolín', 'José Alamá-Gil'),
    ('Mar y Paz', 'Juan Gonzalo Gómez de Val'),
    ('Nuestras Bandas de Música','Francisco Andreu Comos')";
    if ($db->query($consulta)) {
        print "    <p>Registros de Títulos creados correctamente.</p>\n";
        print "\n";
    } else {
        print "    <p class=\"aviso\">Error al crear los registros de Títulos.</p>\n";
        print "\n";
    }

    // Inserta Subfamilias
    $consulta = "INSERT INTO $dbTablaSubfamilia (subfamilia, familia) VALUES
        ('Clarinete', 'Viento-Madera'),
        ('Trompeta', 'Viento-Metal'),
        ('Flauta', 'Viento-Madera'),
        ('Trompa', 'Viento-Metal'),
        ('Tuba', 'Viento-Metal'),
        ('Piano', 'Teclados'),
        ('Fagot', 'Viento-Madera'),
        ('Percusión', 'Percusión'),
        ('Saxo', 'Viento-Madera'),
        ('Mallets', 'Percusión'),
        ('Violín', 'Cuerda'),
        ('Cello', 'Cuerda'),
        ('Oboe', 'Viento-Madera'),
        ('Trombón', 'Viento-Metal'),
        ('Score', 'Score')";
    if ($db->query($consulta)) {
        print "    <p>Registros de Subfamilias creados correctamente.</p>\n";
        print "\n";
    } else {
        print "    <p class=\"aviso\">Error al crear los registros de Subfamilias.</p>\n";
        print "\n";
    }

    // Inserta Asociaciones
    $consulta = "INSERT INTO $dbTablaAsociacion (CIF, asociacion, poblacion) VALUES
        ('B12345678', 'Los Relampagos', 'Madrid')";
    if ($db->query($consulta)) {
        print "    <p>Registro de Asociación creado correctamente.</p>\n";
        print "\n";
    } else {
        print "    <p class=\"aviso\">Error al crear el registro de Asociación.</p>\n";
        print "\n";
    }
    $consulta = "INSERT INTO $dbTablaAsociacion (CIF, asociacion, poblacion) VALUES
        ('A12345678', 'Societat Unió Musical Alberic (SUMA)', 'Alberic')";
    if ($db->query($consulta)) {
        print "    <p>Registro de Asociación creado correctamente.</p>\n";
        print "\n";
    } else {
        print "    <p class=\"aviso\">Error al crear el registro de Asociación.</p>\n";
        print "\n";
    }
    $consulta = "INSERT INTO $dbTablaAsociacion (CIF, asociacion, poblacion) VALUES
    ('C12345678', 'Lira Castellonera', 'Villanueva de Castellón')";
    if ($db->query($consulta)) {
    print "    <p>Registro de Asociación creado correctamente.</p>\n";
    print "\n";
    } else {
    print "    <p class=\"aviso\">Error al crear el registro de Asociación.</p>\n";
    print "\n";
    }

    // Inserta Instrumentos
    $consulta = "INSERT INTO $dbTablaInstrumento (instrumento, subfamilia) VALUES
        ('Flautin', 'Flauta'),
        ('Flauta1', 'Flauta'),
        ('Flauta2', 'Flauta'),
        ('ClarineteMib', 'Clarinete'),
        ('ClarineteSib1', 'Clarinete'),
        ('ClarineteSib2', 'Clarinete'),
        ('ClarineteSib3', 'Clarinete'),
        ('ClarineteBajo', 'Clarinete'),
        ('SaxoAltoMib1', 'Saxo'),
        ('SaxoAltoMib2', 'Saxo'),
        ('SaxoTenorSib', 'Saxo'),
        ('SaxoBaritono', 'Saxo'),
        ('Oboe1', 'Oboe'),
        ('Oboe2', 'Oboe'),
        ('Fagot', 'Fagot'),
        ('TrompaF1', 'Trompa'),
        ('TrompaF2', 'Trompa'),
        ('TrompaF3', 'Trompa'),
        ('FliscornoSib1', 'Trompeta'),
        ('FliscornoSib2', 'Trompeta'),
        ('TrompetaSib1', 'Trompeta'),
        ('TrompetaSib2', 'Trompeta'),
        ('TrompetaSib3', 'Trompeta'),
        ('TrombonDo1', 'Trombón'),
        ('TrombonDo2', 'Trombón'),
        ('TrombonDo3', 'Trombón'),
        ('TrombonSib1', 'Trombón'),
        ('TrombonSib2', 'Trombón'),
        ('TrombonSib3', 'Trombón'),
        ('BombardinoDo1', 'Tuba'),
        ('BombardinoDo2', 'Tuba'),
        ('BombardinoSib1', 'Tuba'),
        ('BombardinoSib2', 'Tuba'),
        ('TubaDo', 'Tuba'),
        ('TubaSib', 'Tuba'),
        ('Violonchelo', 'Cello'),
        ('Contrabajo', 'Cello'),
        ('Timbales', 'Percusión'),
        ('Caja', 'Percusión'),
        ('Platillos', 'Percusión'),
        ('Bombo', 'Percusión'),
        ('Director', 'Score')";
    if ($db->query($consulta)) {
        print "    <p>Registros de Instrumentos creados correctamente.</p>\n";
        print "\n";
    } else {
        print "    <p class=\"aviso\">Error al crear los registros de Instrumentos.</p>\n";
        print "\n";
    }

    // Inserta Músicos
    $consulta = "INSERT INTO $dbTablaMusico (DNI, nombre, apellidos, email, usuario, subfamilia, asociacion) VALUES
    ('20808684D', 'David', 'Martínez de la Casa García', 'dmartinezdelacasa@gmail.com', 2, 'Trompeta', 'B12345678'),
    ('12345678D', 'Bartolomé', 'Sintes Marco', 'bartolome.sintes@gmail.com', 3, 'Violín', 'B12345678'),
    ('12345678C', 'Lucía', 'Álvarez Alonso', 'luciadjc@gmail.com', 5, 'Flauta', 'B12345678')";
    if ($db->query($consulta)) {
        print "    <p>Registros de Músicos creados correctamente.</p>\n";
        print "\n";
    } else {
        print "    <p class=\"aviso\">Error al crear los registros de Músicos.</p>\n";
        print "\n";
    }
    // Inserta Partituras
    $consulta = "INSERT INTO $dbTablaPartitura (titulo, instrumento, subfamilia, archivo) VALUES
    ('La Fallera', 'ClarineteMib', 'Clarinete', 'La Fallera-ClarineteMib.pdf'),
    ('La Fallera', 'Oboe1', 'Oboe', 'La Fallera-Oboe1.pdf'),
    ('La Fallera', 'Timbales', 'Percusión', 'La Fallera-Timbales.pdf'),
    ('La Fallera', 'TrompaF2', 'Trompa', 'La Fallera-TrompaF2.pdf')";
    if ($db->query($consulta)) {
        print "    <p>Registros de Partituras creados correctamente.</p>\n";
        print "\n";
    } else {
        print "    <p class=\"aviso\">Error al crear los registros de Partituras.</p>\n";
        print "\n";
    }

}
