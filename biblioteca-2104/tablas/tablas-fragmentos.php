<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

function fragmentos($tabla, $pagina, $numero, $argumentos)
{
    global $cfg, $usuariosNiveles;

    if ($tabla == "usuarios" && $pagina == "insertar-1-a" && $numero == 1) {
        print "          <tr>\n";
        print "            <td>Usuario:</td>\n";
        print "            <td><input type=\"text\" name=\"usuario\" size=\"$cfg[tamUsuariosUsuario]\" maxlength=\"$cfg[tamUsuariosUsuario]\" autofocus></td>\n";
        print "          </tr>\n";
        print "          <tr>\n";
        print "            <td>Contraseña:</td>\n";
        print "            <td><input type=\"text\" name=\"password\" size=\"$cfg[tamUsuariosPassword]\" maxlength=\"$cfg[tamUsuariosPassword]\"></td>\n";
        print "          </tr>\n";
        print "          <tr>\n";
        print "            <td>Nivel:</td>\n";
        print "            <td>\n";
        print "              <select name=\"nivel\">\n";
        foreach ($usuariosNiveles as $indice => $valor) {
            print "                <option value=\"$valor\">$indice</option>\n";
        }
        print "              </select>\n";
        print "            </td>\n";
        print "          </tr>\n";
    }
    if ($tabla == "usuarios" && $pagina == "listar" && $numero == 1) {
        foreach ($argumentos["result"] as $valor) {
            print "          <tr>\n";
            print "            <td>$valor[usuario]</td>\n";
            print "            <td>$valor[password]</td>\n";
            print "            <td>" . array_search($valor["nivel"], $usuariosNiveles) . "</td>\n";
            print "          </tr>\n";
        }
    }

    if ($tabla == "obras" && $pagina == "insertar-1-a" && $numero == 1) {
        print "          <tr>\n";
        print "            <td>Autor:</td>\n";
        print "            <td><input type=\"text\" name=\"autor\" size=\"$cfg[tamObrasAutor]\" maxlength=\"$cfg[tamObrasAutor]\" autofocus></td>\n";
        print "          </tr>\n";
        print "          <tr>\n";
        print "            <td>Título:</td>\n";
        print "            <td><input type=\"text\" name=\"titulo\" size=\"$cfg[tamObrasTitulo]\" maxlength=\"$cfg[tamObrasTitulo]\"></td>\n";
        print "          </tr>\n";
        print "          <tr>\n";
        print "            <td>Editorial:</td>\n";
        print "            <td><input type=\"text\" name=\"editorial\" size=\"$cfg[tamObrasEditorial]\" maxlength=\"$cfg[tamObrasEditorial]\"></td>\n";
        print "          </tr>\n";
    }
    if ($tabla == "obras" && $pagina == "listar" && $numero == 1) {
        foreach ($argumentos["result"] as $valor) {
            print "          <tr>\n";
            foreach ($argumentos["campos"] as $campo) {
                print "            <td>" . $valor[$campo["campo"]] . "</td>\n";
            }
            print "          </tr>\n";
        }
    }

    if ($tabla == "personas" && $pagina == "insertar-1-a" && $numero == 1) {
        print "          <tr>\n";
        print "            <td>Nombre:</td>\n";
        print "            <td><input type=\"text\" name=\"nombre\" size=\"$cfg[tamPersonasNombre]\" maxlength=\"$cfg[tamPersonasNombre]\" autofocus></td>\n";
        print "          </tr>\n";
        print "          <tr>\n";
        print "            <td>Apellidos:</td>\n";
        print "            <td><input type=\"text\" name=\"apellidos\" size=\"$cfg[tamPersonasApellidos]\" maxlength=\"$cfg[tamPersonasApellidos]\"></td>\n";
        print "          </tr>\n";
        print "          <tr>\n";
        print "            <td>DNI:</td>\n";
        print "            <td><input type=\"text\" name=\"dni\" size=\"$cfg[tamPersonasDni]\" maxlength=\"$cfg[tamPersonasDni]\"></td>\n";
        print "          </tr>\n";
    }
    if ($tabla == "personas" && $pagina == "listar" && $numero == 1) {
        foreach ($argumentos["result"] as $valor) {
            print "          <tr>\n";
            foreach ($argumentos["campos"] as $campo) {
                print "            <td>" . $valor[$campo["campo"]] . "</td>\n";
            }
            print "          </tr>\n";
        }
    }

    if ($tabla == "prestamos" && $pagina == "insertar-1-a" && $numero == 1) {
        print "          <tr>\n";
        print "            <td>Persona:</td>\n";
        print "            <td>\n";
        print "            <select name=\"id_persona\">\n";
        print "                <option value=\"\"></option>\n";
        foreach ($result2 as $valor) {
            print "                <option value=\"$valor[id]\">$valor[nombre] $valor[apellidos]</option>\n";
        }
        print "              </select>\n";
        print "            </td>\n";
        print "          </tr>\n";
        print "          <tr>\n";
        print "            <td>Obra:</td>\n";
        print "            <td>\n";
        print "            <select name=\"id_obra\">\n";
        print "                <option value=\"\"></option>\n";
        foreach ($result3 as $valor) {
            print "                <option value=\"$valor[id]\">$valor[autor] - $valor[titulo]</option>\n";
        }
        print "              </select>\n";
        print "            </td>\n";
        print "          </tr>\n";
        print "          <tr>\n";
        print "            <td>Fecha de préstamo:</td>\n";
        print "            <td><input type=\"date\" name=\"prestado\" value=\"" . date("Y-m-j") . "\"></td>\n";
        print "          </tr>\n";
    }
    if ($tabla == "prestamos" && $pagina == "listar" && $numero == 1) {
        foreach ($argumentos["result"] as $valor) {
            print "          <tr>\n";
            print "            <td>$valor[nombre] $valor[apellidos]</td>\n";
            print "            <td>$valor[autor] - $valor[titulo]</td>\n";
            print "            <td>";
            if ($valor["prestado"] != "0000-00-00") {
                print $valor["prestado"];
            }
            print "</td>\n";
            print "            <td>";
            if ($valor["devuelto"] != "0000-00-00") {
                print $valor["devuelto"];
            }
            print "</td>\n";
            print "          </tr>\n";
        }
    }
}
