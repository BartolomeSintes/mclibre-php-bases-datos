# SELENIUM

Estas son algunas de las cosas que podría hacer para Selenium

* [2021-04-30] Si una página hace una redirección, habría que comprobar la página de destino.

* [2021-04-30] No pruebo el funcionamiento de los botones "Reiniciar formulario", pero creo que no hace falta.

* [2021-04-24] Los elementos que utilizo de forma repetida deberían ser variables. Por ejemplos los xpath de los Targets o incluso los Values.

* [2021-04-24] Los assertNotText son un poco peligrosos, porque puedo estar mirando el elemento que no toca. No he visto cómo buscar un texto en cualquier lugar de la página.

* [2021-04-26] Debería ver si se pueden crear variables de array y hacer bucles que iteren sobre ellas. Lo necesitaría para crear una función Insertar general, porque cada tabla tiene un número de campos distintos.

* [2021-04-29] He intentado sumar dos variables creadas con **store** para guardarlas en otra variable y no lo he conseguido. En Internet hacen todo el rato referencia a storeEval que no funciona en Selenium IDE 3 y con Javascript dicen de usar la matriz storedVars (storedvars['nombreVariable']), pero el IDE dice que storedVars no existe.

* [2021-05-14] Averiguar si Selenium puede mirar en el código fuente de la página. Por ejemplo, para localizar mensajes de error de PHP que según en qué punto de la página se creen (dentro de una etiqueta, entre < y >, por ejemplo), igual no se ven en el navegador, pero sí están en el código fuente.

## utilidades.py

* [2021-04-26] Que compruebe si los nombres de los tests utilizados en las suites existen.

* [2021-04-29] Al renumerar los test, podría tener en cuenta tests con comentarios para saltar de 100 en 100. O al menos los comentarios que empezarán por alguna palabra que significara que empieza un bloque de tests. Antes de eso tendría que comprobar que saltar de 100 en 100 es suficiente.


## Pruebas para Biblioteca-4

* [2021-05-05] ¿Desde Selenium se podrá conocer la configuración del servidor? Me refiero a error_reporting y a output_buffering. Si es XAMPP Se podría hacer abriendo http://localhost/dashboard/phpinfo.php y buscando los valores en la tabla

* [2021-05-03] Tendría que hacer las pruebas con el límite de registros activado y un número bajo. Serían unas pruebas aparte.

* [2021-05-06] Tendría que hacer las pruebas sin base de datos para ver mensajes de error.

* [2021-05-06] Añadir en la comprobación de avisos la comprobación de la clase aviso-error, aviso-info, etc.

* [2021-05-07] Para comprobar que no duplica la cabecera podría contar el número de h1.

* [2021-05-07] Podría dividir las pruebas en:
  - uso normal de la aplicación
  - intentos de manipular modificando la url
  - uso caótico de la aplicación (¿fuzzy testing?). Esto sólo tendría sentido hacerlo por programa, pero aparte de hacer clic a lo loco, no se me ocurre qué debería hacerse y el problema es saber qué tiene que hacer la aplicación.

* [2021-05-10] He añadido a la función recoge() que si llega dato en forma de matriz cuando esperaba un escalar o viceversa, deja el dato vacío (no hace ningún aviso especial, es como si no hubiera llegado nada). Pero en las pruebas no pruebo ese error en ningún sitio. El 2021-05-08 me di cuenta de que al no hacer esa comprobación podían ocurrir cosas curiosas como por ejemplo si en borrar-2 se enviaba id=10000. Como la página espera una matriz marcaba varias casillas porque en vez de mirar posiciones en la matriz miraba posiciones en la cadena.

* [2021-05-11] Si no encuentra registros al buscar, vuelve al formulario y escribe los valores de búsqueda que no dieron resultado, pero Selenium eso no lo comprueba. En modificar creo que si comprueba que reescribe los valores originales o los de la modificación, pero no estoy seguro.

* [2021-05-11] Otra comprobación a a añadir a todas las páginas sería ver que no hay mensajes de error de PHp (Fatal error, Warning, Notice, etc.)

* [2021-05-11] Otra comprobación a a añadir a todas las páginas sería ver que no hay ningún printSesion() o printValores() olvidado. Tendría que añadir un mensaje en esas funciones para que fuera lo que detectara.

* [2022-01-04] He añadido un if else en borrar todo de bases de datos 2-3 para que detecte los mensajes de MySQL o los de SQLite, pero no en biblioteca-4.

* [2021-01-04] Lo que no parece tener remedio es el problema de los acentos en SQLite ya que no tiene un COLLATE para idiomas distintos del inglés, como mucho hace COLLATE de mayúsculas y minúsculas.


### Pruebas a realizar en cada página

- Niveles de usuario
  - Que cada usuario puede o no puede entrar en cada página del sitio.
  - Mensajes de error al hacer login
- Administrador > Borrar todo
  - Hacer clic en No
- Pruebas comunes
  - Listar / Borrar / Modificar: <s>Aviso general: sinRegistros. No hay registros para mostrar.</s>
- Listar
  - <s>Muestra los registros</s>
  - <s>Ordena los registros por cada uno de los criterios de ordenación.</s>
  - Si no le llega criterio de ordenación, que ordene por criterio predeterminado.
- Insertar-1
  - Aviso general: limiteNumeroRegistros. Se ha superado el límite de registros.
- Insertar-2
  - <s>Inserta registro correctamente.</s>
  - <s>Aviso general: todosVacios. Se han dejado todos los campos vacíos.</s>
  - Aviso general: limiteNumeroRegistros. Se ha superado el límite de registros.
  - <s>Aviso general: yaExisteRegistro. Se intenta guardar un registro repetido.</s>
  - Aviso individual: El campo es obligatorio.
    - TODO: ver en qué formularios hay campos obligatorios (ususarios, prestamos, etc).
  - <s>Aviso individual: Texto demasiado largo. Hacerlo para cada uno y para todos</s>
- Borrar-1
  - <s>Al reordenar registros no se pierden las casillas marcadas.</s>
  - Reordenar registros lo he hecho con una sola casilla marcada, igual debería añadir un par de registros y marcar un par de registros.
- Borrar-2
  - <s>Borra 1 registro correctamente.</s>
  - <s>Borra varios registros correctamente.</s>
  - <s>Aviso general: registrosNoSeleccionados. No se ha seleccionado ningún registro.</s>
  - <s>Aviso individual: No existe el registro (no existe uno, no existe uno de dos elegidos o no existen dos de dos elegidos).</s>
- Buscar-1
  - <s>Aviso general: sinRegistros. No hay registros para mostrar.</s>
- Buscar-2
  - <s>Encuentra registros correctamente.</s>
  - <s>Aviso general: No encuentra registros.</s>
  - <s>Aviso individual: Texto demasiado largo. [No se comprueba, así que no tiene demasiado sentido probarlo, pero lo he puesto. Sale el mensaje "No se han encontrado registros."]</s>
  - Reordena correctamente los resultados de la búsqueda (añadir un tercer registro, pero que solo salgan dos en la búsqueda).
- Modificar-1
  - <s>Al reordenar registros no se pierde la casilla marcada.</s>
- Modificar-2
  - <s>Aviso individual: No existe el registro con ese id.</s>
  - <s>Aviso general: No se indica el id.</s>
- Modificar-3
  - <s>Modifica registro correctamente.</s>
  - <s>Aviso general: No se indica el id.</s>
  - <s>Aviso general: No existe el registro (con ese id).</s>
  - <s>Aviso general: yaExisteRegistroConOtroId. Se intenta guardar un registro repetido.</s>
  - <s>Aviso general: todosVacios. Se han dejado todos los campos vacíos.</s>
  - Aviso individual: El campo es obligatorio.
  - <s>Aviso individual: Texto demasiado largo.</s>

Errores detectados:
  - He puesto ATENCION en el "comment" del json cuando hace algo mal y el test no lo detecta (había puesto verify y la comprobación de lo que debería hacer, para que me señale el error pero termine el test pero cuando hay errores el IDE no presenta la información de forma fácil, así que he dejado assert y la comprobación de lo que hace, pero con el aviso ATENCION).
  - Cuando se marcan varios registros para borrar saca varias veces el mensaje "Registro borrado correctamente.". Lo tengo marcado con ATENCION. Realmente no es incorrecto, pero queda raro. Quizás debería incluir campos del registro en el mensaje para que se viera que cada mensaje corresponde a cada uno de los registros borrados. O quizás sería mejor sacar un único mensaje


## Test de las tablas

* [2021-04-26] Averiguar cómo comprobar que los mensajes no están repetidos (salvo si se borran varios registros a la vez, por ejemplo).

* [2021-04-26] Averiguar cómo comprobar que dentro del main sólo está el avisoGeneral que se busca (para los casos en que sólo se tiene que mostrar un aviso general).

* [2021-04-27] El tamaño de los campos es configurable. Al probar si detecta los campos demasiado largos habría que asegurarse de que prueba con cadenas lo suficientemente largas.

* [2022-01-31] Una fuente de error es que si me dedico a borrar y crear registros, los ids pueden no coincidir en MySQL y SQlite porque MySQL tiene AUTO_INCREMENT y SQLite no (y auqnue lo tuvieran los dos tampoco está garantizado). Así que chequear el id de los registros puede fallar.
