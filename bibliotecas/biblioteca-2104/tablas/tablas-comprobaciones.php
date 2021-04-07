<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   http://www.gnu.org/licenses/agpl.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

function comprobaciones($campo, $valor)
{
    global $cfg, $usuariosNiveles;

    $campoOk = false;

    if ($campo == "usuario") {
        if (mb_strlen($valor, "UTF-8") > $cfg["tamUsuariosUsuario"]) {
            print "    <p class=\"aviso\">El nombre usuario no puede tener más de $cfg[tamUsuariosUsuario] caracteres.</p>\n";
            print "\n";
        } else {
            $campoOk = true;
        }
    } elseif ($campo == "password") {
        if (mb_strlen($valor, "UTF-8") > $cfg["tamUsuariosPassword"]) {
            print "    <p class=\"aviso\">La contraseña no puede tener más de $cfg[tamUsuariosPassword] caracteres.</p>\n";
            print "\n";
        } else {
            $campoOk = true;
        }
    } elseif ($campo = "nivel") {
        if (!in_array($valor, $usuariosNiveles)) {
            print "    <p class=\"aviso\">Nivel de usuario incorrecto.</p>\n";
            print "\n";
        } else {
            $campoOk = true;
        }
    }

    return $campoOk;
}

function compruebaConjunto($valores, $compruebaConjunto) {
    if ($compruebaConjunto == "algunoVacio") {
        // Devuelve true si algún valor es vacío
        $ok = false;
        foreach ($valores as $valor) {
            $ok = $ok || ($valor == "");
        }
        return $ok;
    }


}
