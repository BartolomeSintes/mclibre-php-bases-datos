# BIBLIOTECA - CHANGELOG

Todos los cambios importantes de este proyecto se documentarán en este fichero.

El formato se basa en [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

Este changelog incluye los cambios hechos en Biblioteca-3, Biblioteca-4, etc.

## 2021-05-

### Added (Añadido)
- Si a la función recoge() le llega una matriz cuando esperaba un escalar o viceversa, descarta lo recibido y hace como si hubiera llegado en blanco (no genera ningún aviso, en la comprobación individual o general posterior ya se generará el aviso que toque por llegar un dato vacío).

### Changed (Modificado)
- Añado función incluyeValoresOriginalesEnAvisos() para guardar en $_SESSION los valores del registro elegido en modificar y que se puedan mostrar los valores originales en el formulario (cuando se deja todo vacío o cuando se escriben valores que coinciden con los de otro registro).
- Añado índice tabla a $_SESSION["avisosGenerales"], ahora la estructura es $_SESSION["avisosGenerales"][página][tabla]
- Unifico compruebaAvisosGenerales(), imprimeAvisosGenerales() y incluyeValoresOriginalesEnAvisos() poniendo como primer argumento la tabla y como segundo argumento la página de origen.
- Los dos primeros argumentos de compruebaAvisosIndividuales() e imprimeAvisosIndividuales() son también la tabla y la página de origen.

### Fixed (Corregido)
- Al devolver préstamo si se deja la fecha vacía ahora dice "No ha indicado la fecha.".


## 2021-05-08

### Changed (Modificado)
- Reescribo login-2.php para usar compruebaAvisosGenerales() y que el único aviso sea "Nombre de usuario y/o contraseña incorrectos."
- Cambio tratamiento del id. En avisoIndividual solo mira que no esté vacío. En avisoGeneral mira que exista todos los que se reciben.

### Fixed (Corregido)
- añado SORT_REGULAR a array_unique para que compare matrices.


## 2021-05-07

### Fixed (Corregido)
- Si no se conectaba a SQLite/MySQL, Error grave duplicaba las cabeceras.
- insertar-2. Elimino borraAvisos() después de hayErrores que no hace nada.
- usuarios > borrar-1. Ya no muestra al usuario root en la tabla.
- añado SORT_REGULAR a array_unique para que compare matrices.


## 2021-05-06

### Changed (Modificado)
- Cambio función recoge() para que tenga un único argumento, de manera que cuando el argumento termine en "[]" signifique que va a ser una matriz ("id" o "id[]").
- Añado variable de sesión $_SESSION["avisosGenerales"]["ocultaFormulario"] y función muestraFormulario() para no mostrar el formulario cuando sea necesario. La función imprimeAvisosImpresos() ya no devuelve nada (antes devolvía true o false) porque antes lo utilizaba para decidir si ponía o no el formulario (no era una buena idea porque el hecho de haber avisos generales no es suficiente para decidirlo).
- Modifico la estructura de $_SESSION["avisosGenerales"] para incluir clase de aviso ["claseAviso"] (por ahora, solo tengo definidas las clases aviso-error y aviso-info) y el texto ["texto"].

### Fixed (Corregido)
- Corrijo problema aviso duplicado (registro no seleccionado)
- Muevo función cabecera() para que no de errores con output_buffering


## 2021-05-03

### Fixed (Corregido)
- Borrar-1 generaba un aviso doble general cuando no se elegía ningún registro, porque se hacía una comprobación general registrosNoSeleccionados y la comprobación individual sobre id que también genera un aviso general. Lo he resuelto de dos maneras:
  - He quitado la comprobación del aviso general registrosNoSeleccionados en borrar-2 (de hecho en modificar-2 no se hacía y por eso no se duplicaba el aviso)
  - He añadido un array_unique en imprimeAvisosGenerales() para que elimine los avisos repetidos (con este cambio, si se generan avisos duplicados, no me enteraré nunca)


## 2021-05-01

### Added (Añadido)
- Cambio el nombre de la clase "aviso" a "aviso-error".
- Añado clase "aviso-info" para los mensajes de operaciones completadas correctamente.

### Changed (Modificado)
- Divido tablas-comprobaciones.php en dos ficheros: funciones generales (comprobaciones-general.php) y particulares (comprobaciones-particular.php).


## 2021-04-22

### Added (Añadido)
- Añado función printSesion() para que me escriba $_SESSION en un &lt;details&gt; (para usarla mientras programo resolviendo errores).

### Changed (Modificado)
- Cambio la estructura de $_SESSION para recoger los errores individuales y generales. Ahora es S_SESSSION[avisosIndividuales][pagina][tabla][control] y S_SESSSION[avisosGenerales][pagina].
- Utilizo esa nueva estructura en todas las páginas.
- Al insertar un registro (insertar-2 y modificar-3), compara con lower() para que no se puedan guardar.


## 2021-04-17

### Added (Añadido)
- Añado argumento nombreDeTabla en segunda posición de compruebaAvisosIndividuales() (que se guarda en $_SESSION de manera que lo que antes era $_SESSION["error"][$campo] ahora es $_SESSION["error"][$tabla[$campo].
- Añado función printVariables() para que me escriba el valor de una variable (para usarla mientras programo resolviendo errores).
- Renombro borraAvisos() a borraAvisosExcepto() puesto que el argumento son las páginas de origen de los avisos que no quiero borrar.


## 2021-04-14

### Added (Añadido)
- Añado tests de Selenium para testear la aplicación (por el momento, prueba las opciones básicas de la tabla Personas). Añado atributo data-test-id=\"desconectarse\" a enlace Desconectar para que lo use Selenium (para detectar si está conectado al iniciar el test y en ese caso desconectar).


## 2021-04-11

### Changed (Modificado)
- El límite del número de registros por tabla se puede activar o desactivar con $cfg["maxRegTablaActivado"].
- Gran parte de las comprobaciones iniciales se hacen ahora a través de funciones (en comunes/comprobaciones-general.php)
    - compruebaAvisosIndividuales(): recoge y comprueba cada control (menos las matrices de ids)
    - compruebaAvisosGenerales(): hace comprobaciones generales (que no haya todavía registros, que se haya superado el límite de registros, que sean todos vacíos, etc.)
- Si se generan avisos al recibir un formulario, se redirecciona al formulario y se muestran en él. Falta incluir los avisos relacionados con los ids (no se han seleccionado registros, no se encuentran, etc.)
- Creo funciones compruebaSesion() y compruebaNoSesion() para comprobar el nivel de usuario y redireccionar si no tiene el nivel suficiente.
- Login utiliza sesiones para mostrar errores.
- En el menú Administrador > Borrar todo, añado la opción de incluir o no los registros de prueba.

### Fixed (Corregido)
- [sqlite] Añado PRAGMA foreign_keys para que haga caso de las restricciones ON ... CASCADE


## 2021-04-08

### Changed (Modificado)
- Incorporo los cambios hechos en biblioteca-3
    - Paso $tamFecha a constante TAM_FECHA.
    - Hago que el usuario de NIVEL_2 pueda ver las páginas de listar y buscar de Personas, Obras y Préstamos.
    - Mejoro la comprobación del nivel de cada página haciendo una comparación de desigualdad (en vez de distinto). Incluyo la comparación en todas las páginas (antes no había comparación en las páginas de NIVEL_1, el nivel mínimo).
    - Defino la profundidad de nivel de las páginas como constantes (PROFUNDIDAD_0, etc.) para que al llamar a la función cabecera el argumento se entienda mejor.
    - Las constantes de nivel de usuario (NIVEL_) estaban definidas como cadenas ("1", etc). Las cambio a enterros (1, etc.).


## 2021-04-06

### Changed (Modificado)
- Biblioteca-4 está hecho a partir de Biblioteca-3 de los apuntes de PHP


## 2021-04-06

### Changed (Modificado)
- Biblioteca-3 está hecho a partir de Biblioteca-2 de los apuntes de PHP
- Las páginas que gestionan las tablas las he movido a un directorio tablas
- Cambio hash para que se puedan añadir otros tipos de hashs
- He eliminado muchas constantes y variables simples de configuración para crear una matriz $cfg, pero no he eliminado todas las constantes.
- He simplificado la función borraTodo, creando una matriz de consultas. De paso he añadido la creación de registros de prueba para rellenar las tablas (seleccionable con una variable de configuración).
- Las variables que tiene que ver con la base de datos las he unido en una matriz $db. La conexión con la base de datos la he llamado $pdo.
