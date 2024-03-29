<?php
require_once "biblioteca.php";
header("Content-type: text/css");
?>
/* PROGRAMACION WEB EN PHP                  */
/* Bartolome Sintes Marco                   */
/* https://www.mclibre.org                   */
/*                                          */
/* CSS ejercicios proyectos                 */
/*                                          */
/* 29 de abril de 2021                      */
/*                                          */

/* Esta parte es comun a todos los ejercicios proyectos */

html, body {
  margin: 0;
  padding: 0;
  background-color: hsl(<?= $cfg["color"] ?>, 80%, 95%);
  color: black;
  font-family: sans-serif;
}

h1 {
  margin: 0;
  padding: 5px 20px;
  background-color: hsl(<?= $cfg["color"] ?>, 80%, 60%);
  color: white;
  text-transform: uppercase;
}

nav {
  margin: 0;
  background-color: hsl(<?= $cfg["color"] ?>, 80%, 75%);
  color: white;
}

nav ul {
  margin: 0;
  padding: 5px;
  list-style-type: none;
}

nav li {
  display: inline;
  padding: 0 15px;
}

nav a {
  background-color: hsl(<?= $cfg["color"] ?>, 80%, 75%);
  color: white;
  font-weight: bold;
}

main {
  display: block; /* lo necesita IE9 IE10 IE11 */
  padding: 10px 20px;
}

input {
  font-family: monospace;
}

.boton-invisible {
  border: none;
  padding: 0;
  background-color: transparent;
}

.aviso-error {
  color: red;
}

.aviso-info {
  color: blue;
}

.centrado {
  text-align: center;
}

a img {
  border: none;
}

table.conborde, table.conborde td, table.conborde th {
  border: black 1px solid;
}

thead tr, table.franjas tbody tr:nth-child(even) {
  background-color: hsl(<?= $cfg["color"] ?>, 80%, 85%);
  color: black;
}

td, th {
  padding-left: 5px;
  padding-right: 5px;
}

footer {
  clear: both;
  border-top: black solid 1px;
  margin: 30px 20px 0;
}

footer cite {
  font-weight: bold;
}

/* Esta parte es especifica de este ejercicio */

table.calendario {
}

table.calendario caption {
  margin-left: auto;
  margin-right: auto;
  padding-bottom: 3px;
}

table.calendario th {
  background-color: hsl(<?= $cfg["color"] ?>, 80%, 85%);
  color: black;
  font-weight: bold;
}

table.calendario td {
  text-align: center;
  padding: 5px 10px;
}

table.calendario td.enlace {
  background-color: hsl(<?= $cfg["color"] ?>, 80%, 85%);
  color: blue;
}

table.calendario a {
  color: blue;
  font-weight: bold;
  text-decoration: none;
}

