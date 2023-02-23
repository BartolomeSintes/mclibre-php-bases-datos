
# Ejercicios de bases de datos

## Historia

En los apuntes de PHP para la parte de bases de datos antiguamente llegué a tener varias aplicaciones que veíamos en clase, pero desde que se implantó el ciclo ASIR he tenido que reducirlo a una única aplicación, Agenda, con una sola tabla (y una versión de Agenda con control de usuarios que tiene otra tabla independiente de usuarios de la aplicación).

Para los alumnos que en su proyecto necesitan trabajar con una base de datos de varias tablas, tenía una aplicación Biblioteca, con tres tablas. La diferencia entre Biblioteca-1 y Biblioteca-2 es el calendario y la búsqueda de préstamos.

En abril/mayo de 2021 empecé a programar una versión biblioteca-4 con sesiones. La idea principal de esa versión era intentar que fuera más fácil trabajar con varias tablas. No conseguí terminarla, y no sé si el enfoque es el adecuado, pero por el camino mejoré otras cosas.

En el curso 2020/21 he incorporado algunas de las cosas que hice en biblioteca-4 en las

Bases de datos 2
-   Añado IF EXISTS en DROP TABLE y DROP DATABASE


agenda para webapps es como Base de datos 2-3

## Temas pendientes

-   El problema de que los índices hay que ponerlos entre comillas si aparecen dentro de una cadena pero sin comillas si aparecen fuera lo podría resolver así, pero no me acaba de gustar
```php
<?php
define("ABC", "ABC");
$a[ABC] = 5;
print "<p>$a[ABC] - " . $a[ABC] . "</p>";
?>
```
-   ...
