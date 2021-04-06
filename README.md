# mclibre-php-bases-datos
Ejercicios de Bases de Datos en PHP (experimentos)

## biblioteca-3



## biblioteca-2104

Esta versión la hice en abril de 2021 a partir del ejercicio biblioteca-2 de los apuntes. Probé a unificar las páginas de administración de las tablas, pero sin éxito. Aunque las páginas de edición de las tablas básicas se parecen mucho, hay diferencias en muchos detalles que obligan a crear muchas cosas en paralelo (las tablas, las consultas, la recogida de datos). Y en las tablas que contienen referencias a otras tablas hay más diferencias todavía. Total, que lo he dejado.

Lo único que quizás puedo reutilizar sea la idea de utilizar matrices en vez de constantes y variables simples.

Otro inconeveniente que no he conseguido resolver adecudamente es que si hay bibliotecas que hacen include a ficheros que están en otros directorios (en este caso, comunes/biblioteca llama a tablas/tablas-*) se producen errores al llamar a la biblioteca. El motivo es que las llamadas de biblioteca a tablas se interpretan desde el directorio de la página que incluye a biblioteca. Si se llama desde el directorio raíz el include(tablas) no tiene que tener ../, pero si lo llamas desde un subdirectorio, tiene que tener ../. La solución que he encontrado es guardar el camino absoluto a la aplicación $cfg["urlBase"], pero no me gusta nada.



