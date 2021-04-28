# SELENIUM

Estas son algunas de las cosas que podría hacer para Selenium

* [2021-04-24] Los elementos que utilizo de forma repetida deberían ser variables. Por ejemplos los xpath de los Targets o incluso los Values.

* [2021-04-24] Los assertNotText son un poco peligrosos, porque puedo estar mirando el elemento que no toca. No he visto cómo buscar un texto en cualquier lugar de la página.

* [2021-04-26] Debería ver si se pueden crear variables de array y hacer bubles que iteren sobre ellas. Lo necesitaría para crear una función Insertar general, porque cada tabla tiene un número de campos distintos.

## utilidades.py

* [2021-04-26] Que compruebe si los nombres de los tests utilizados en las suites existen.

## Pruebas a realizar en cada página
- Niveles de usuario
  - Que cada usuario puede o no puede entrar en cada página.
- Listar
  - <s>Muestra los registros</s>
  - <s>Ordena los registros por cada uno de los criterios de ordenación.</s>
  - <s>Aviso general: sinRegistros. No hay registros para mostrar.</s>
  - Si no le llega criterio de ordenación, que ordene por criterio predeterminado.
- Insertar-1
  - Aviso general: limiteNumeroRegistros. Se ha superado el límite de registros.
- Insertar-2
  - <s>Inserta registro correctamente.</s>
  - <s>Aviso general: todosVacios. Se han dejado todos los cmapos vacíos.</s>
  - Aviso general: limiteNumeroRegistros. Se ha superado el límite de registros.
  - <s>Aviso general: yaExisteRegistro. Se intenta guardar un registro repetido.</s>
  - Aviso individual: El campo es obligatorio.
    - TODO: ver en qué formularios hay campos obligatorios (ususarios, prestamos, etc).
  - <s>Aviso individual: Texto demasiado largo. Hacerlo para cada uno y para todos</s>
- Borrar-1
  - <s>Aviso general: sinRegistros. No hay registros para mostrar.</s>
  - <s>Al reordenar registros no se pierden las casillas marcadas.</s>
- Borrar-2
  - <s>Borra 1 registro correctamente.</s>
  - <s>Borra varios registros correctamente.</s>
  - <s>Aviso general: registrosNoSeleccionados. No se ha seleccionado ningún registro.</s>
  - <s>Aviso individual: No existe el registro.</s>
- Buscar-1
  - Aviso general: sinRegistros. No hay registros para mostrar.
- Buscar-2
  - Encuentra registros correctamente.
  - Aviso general: No encuentra registros.
  - Aviso individual: Texto demasiado largo.
- Modificar-1
  - Aviso general: sinRegistros. No hay registros para mostrar.
  - Al reordenar registros no se pierde la casilla marcada.
- Modificar-2
  - Aviso individual: No existe el registro.
- Modificar-3
  - Modifica registro correctamente.
  - Aviso general: No existe el registro (con ese id).
  - Aviso general: yaExisteRegistroConOtroId. Se intenta guardar un registro repetido.
  - Aviso individual: El campo es obligatorio.
  - Aviso individual: Texto demasiado largo.

Errores detectados:
  - He puesto ATENCION en el "comment" del json cuando hace algo mal y el test no lo detecta
  - En Borrar, si no se selecciona ningún registro, se muestran dos avisos: "No se ha creado todavía ningún registro." y "No se ha creado todavía ningún registro."


## Test de las tablas

* [2021-04-26] Averiguar cómo comprobar que los mensajes no están repetidos (salvo si se borran varios registros a la vez, por ejemplo).

* [2021-04-26] Averiguar cómo comprobar que dentro del main sólo está el avisoGeneral que se busca (para los casos en que sólo se tiene que mostrar un aviso general).

* [2021-04-27] El tamaño de los campos es configurable. Al probar si detecta los campos demasiado largos habría que asegurarse de que prueba con cadenas lo suficientemente largas.

