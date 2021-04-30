# SELENIUM

Estas son algunas de las cosas que podría hacer para Selenium

* [2021-04-30] Si una página hace una redirección, habría que comprobar la página de destino.

* [2021-04-30] No pruebo el funcionamiento de los botones "Reiniciar formulario", pero creo que no hace falta.

* [2021-04-24] Los elementos que utilizo de forma repetida deberían ser variables. Por ejemplos los xpath de los Targets o incluso los Values.

* [2021-04-24] Los assertNotText son un poco peligrosos, porque puedo estar mirando el elemento que no toca. No he visto cómo buscar un texto en cualquier lugar de la página.

* [2021-04-26] Debería ver si se pueden crear variables de array y hacer bubles que iteren sobre ellas. Lo necesitaría para crear una función Insertar general, porque cada tabla tiene un número de campos distintos.

* [2021-04-29] He intentado sumar dos variables creadas con **store** para guardarlas en otra variable y no lo he conseguido. En Internet hacen todo el rato referencia a storeEval que no funciona en Selenium IDE 3 y con Javascript dicen de usar la matriz storedVars (storedvars['nombreVariable']), pero el IDE dice que storedVars no existe.

## utilidades.py

* [2021-04-26] Que compruebe si los nombres de los tests utilizados en las suites existen.

* [2021-04-29] Al renumerar los test, podría tener en cuenta tests con comentarios para saltar de 100 en 100. O al menos los comentarios que empezarán por alguna palabra que significara que empieza un bloque de tests. Antes de eso tendría que comprobar que saltar de 100 en 100 es suficiente.

## Pruebas a realizar en cada página
- Niveles de usuario
  - Que cada usuario puede o no puede entrar en cada página.
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
  - <s>Aviso individual: No existe el registro con ese id).</s>
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
  - He puesto ATENCION en el "comment" del json cuando hace algo mal y el test no lo detecta (había puersto verify y la comprobación de lo que debería hacer, para que me señale el error pero termine el test pero cuando hay errores el IDE no presenta la información de forma fácil, así que he dejado assert y la comprobación de lo que hace, pero con el aviso ATENCION)
  - En Borrar, si no se selecciona ningún registro, se muestran dos avisos: "No se ha creado todavía ningún registro." y "No se ha creado todavía ningún registro."


## Test de las tablas

* [2021-04-26] Averiguar cómo comprobar que los mensajes no están repetidos (salvo si se borran varios registros a la vez, por ejemplo).

* [2021-04-26] Averiguar cómo comprobar que dentro del main sólo está el avisoGeneral que se busca (para los casos en que sólo se tiene que mostrar un aviso general).

* [2021-04-27] El tamaño de los campos es configurable. Al probar si detecta los campos demasiado largos habría que asegurarse de que prueba con cadenas lo suficientemente largas.

