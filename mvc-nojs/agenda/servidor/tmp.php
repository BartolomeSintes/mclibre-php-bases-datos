<?php
$camino = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/";
$directorio = basename($camino);
$urlServidor = preg_replace("/" . $directorio . "\/$/", "", $camino) . "servidor/servidor.php";


print "<p>$camino</p>";

print "<p>$directorio</p>";

print "<p>$urlServidor</p>";
