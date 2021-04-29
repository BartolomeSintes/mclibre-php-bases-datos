<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Prueba 1 Selenium</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    .aviso-error { color: red; }
    .aviso-info { color: blue; }
  </style>
</head>

<body>
  <h1>Prueba 1 Selenium</h1>

<?php
function recoge($var, $m = "")
{
    if (!isset($_REQUEST[$var])) {
        $tmp = (is_array($m)) ? [] : "";
    } elseif (!is_array($_REQUEST[$var])) {
        $tmp = trim(htmlspecialchars($_REQUEST[$var], ENT_QUOTES, "UTF-8"));
    } else {
        $tmp = $_REQUEST[$var];
        array_walk_recursive($tmp, function (&$valor) {
            $valor = trim(htmlspecialchars($valor, ENT_QUOTES, "UTF-8"));
        });
    }
    return $tmp;
}

function randomString()
{
    $palabras = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
    return substr($palabras, 0, rand(strlen($palabras) / 2, strlen($palabras)));
}

$p = recoge("p");       // Número de párrafos clase aviso-error
$s = recoge("s");       // Número de span clase aviso-error
$f = recoge("f");       // Número de span clase aviso-info
$r = recoge("r");       // Número de párrafos sin clase aviso

$elementos = [];
for ($i = 0; $i < $p; $i++) {
    $elementos[] = "  <p class=\"aviso-error\">" . randomString() . "</p>\n\n";
}
for ($i = 0; $i < $s; $i++) {
    $elementos[] = "  <p>" . randomString() . " <span class=\"aviso-error\">" . randomString() . "</span> " . randomString() . "</p>\n\n";
}
for ($i = 0; $i < $f; $i++) {
    $elementos[] = "  <p class=\"aviso-info\">" . randomString() . "</p>\n\n";
}
for ($i = 0; $i < $r; $i++) {
    $elementos[] = "  <p>" . randomString() . "</p>\n\n";
}
shuffle($elementos);

foreach ($elementos as $parrafo) {
    print $parrafo;
}

?>
  <footer>
    <p class="ultmod">
      Última modificación de esta página:
      <time datetime="2021-04-29">29 de abril de 2021</time>
    </p>
  </footer>
</body>
</html>

