# BIBLIOTECA - COSAS POR HACER

Estas son algunas de las cosas que me quedan por hacer y que podrían hacerse en biblioteca-4

## Ideas para Biblioteca-5

* [2021-04-10] Hacer una página para que el usuario pueda cambiar la configuración. Para ello, la configuración debería estar en un fichero json (clave, valor, comentario) para poder guardarlo.

* [2021-04-27] Si algún campo es obligatorio en un formulario, indicarlo con asterisco (\*). Los campos obligatorios se podrían indicar al crear la base de datos y crear una matriz con ellos. Supongo que habrá una manera de consultar para saber si hay campos obligatorios y se puede crear esa matriz automáticamente.

* [2021-04-27] Añadir función de comprobación de DNI (tener en cuenta el carnet de extranjeros). Pregutnarle a Fina qué documentos de identificación presenta la gente al matricularase en el instituto.

* [2021-04-29] La matriz $dbTablas igual habría alguna manera de que se generara automáticamente.

* [2021-04-29] Los avisos generales son tanto info (No se ha creado todavía ningún registro) con error. Debería distinguirlos (añadiendo un campo clase a la matriz sería suficiente).

* [2021-04-29] Al buscar, si no encuentra registros no reescribe los términos de búsqueda. Tendría que pensar si hacerlo o no.

* [2021-04-29] Al buscar, no comprueba si lo que ha escrito el usuario se podría haber insertado (es decir, por ahora si el texto es demasiado largo)

## Próximos pasos

* [2021-04-10] Los select no muestran el valor elegido por el usuario cuando se detectan errores y se vuelve al formulario.

## Para corregir (más importante)

* [2021-04-20] La aplicación no deja modificar el usuario root. Igual tendría que dejar cambiar la contraseña, pero no el nombre ni el nivel.

* [2021-04-20] Al modificar la contraseña, si se deja en blanco para mantenerla (como dice modificar-2), sale un mensaje de error diciendo que no se puede dejar en blanco. Tendría que incluir el origen en la comprobación de la contraseña y hacer dos comprobaciones distintas.

## Para corregir (menos importante)

* [2021-04-20] En Usuarios &gt; Buscar el nivel no ofrece la posibilidad de dejarlo en blanco (que querría decir que te da lo mismo el nivel).

* [2021-04-27] Al detectar un aviso en insertar-2, puede ser más lógico que no se muestre el formualrio. Por ejemplo si se ha superado el número de registros al insertar o si no hay registros al buscar. En selenium habría que detectar que no se han mostrado esos elementos.

* [2021-04-28] Al borrar registros si se envían id que no corresponden a registros, no borra ninguno y se muestran tantos avisos como registros no encontrados. Debería sacar un único mensaje de error que dijera "Alguno de los registros que ha solicitado borrar no existe. No se ha borrado ningún registro." Aunque en realidad eso solo ocurre cuando se manipula la barra de dirección.

* [2021-04-28] Al borrar varios registros a la vez escribe "Registro borrado correctamente" tantas veces como registros borrados. Debería escribir simplemente "Registro borrado correctamente" o "Registros borrados correctamente" si son varios.

## Mejoras

* [2021-04-22] La función calendario envía la fecha en la dirección. Podría cambiar a botones como en las flechas de ordenación d elos listados.

## Para pensar

* [2021-04-21] Al modificar un préstamo comprueba que no coincida todo, pero en biblioteca-3 solo comprobaba que no coincidiera obra y persona.

* [2021-04-21] Al hacer un préstamo habría que comprobar más cosas: que el libro no estuviera prestado

* [2021-04-21] No tengo en cuena que puede haber dos ejemplares del mismo libro.

* [2021-04-23] PDO fetch devuelve cada fila con los campos duplicados (con índice numérico y asociativo) por defecto. Se puede hacer que sólo devuelva la matriz asociativa haciendo fetch(PDO::FETCH_ASSOC), pero no sé si mejorará algo el rendimiento. Lo he añadido donde uso fetch, pero no he mirado si accediendo con foreach se puede obtener solo la asociativa.

* [2021-04-23] Si al modificar un registro no se cambia nada dice "Registro modificado". Igual debería avisar que no se ha cambiado nada.

## Sin ordenar

* [2021-04-06] Cuando tenga PHP 7 en el servidor de mclibre y pueda declarar constantes arrays, podría definir $cfg con como contante y así poder quitar los global de las funciones.

* [2021-04-06] Añadir log opcional de las consultas que modifican la base de datos (incluyendo el usuario que las ordenó y la fecha y la hora). No sé qué se podría hacer con las consultas preparadas (guardar las consultas y los parámetros). O quizás es mejor utilizar el log de mysql.

* [2021-04-06] Si se cambian valores de configuración que afectan a la base de datos, habría que rehacer la base de datos. ¿Cómo gestionar esa situación?

* [2021-04-08] La profundidad de nivel de las páginas posiblemente se pueda calcular a partir de la url. Así no podría equivocarme al poner el valor (u olvidarme de cambiarlo si muevo una página de nivel) y posiblemente unificar las funciones compruebaSesion() y compruebaNoSesion().

* [2021-04-10] El comentario que tengo en modificar-3 sobre mayúsculas y minúsculas en MySQL lo tendría que revisar a ver si sigue siendo cierto o tiene solución.

* [2021-04-11] La funión existenTablas() supone que existen y cambia a no. Igual sería mejor suponer que no existen y asegurarse que existen todas. Aunque realmente es lo mismo.

* [2021-04-11] Al hacer login, si no se puede conectar con MySQL, la cabecera sale dos veces. Arreglarlo.

* [2021-04-11] Al modificar fechas, creo que no se pueden dejar en blanco de nuevo. Comprobarlo y arreglarlo.

* [2021-04-17] En la definición de la tabla préstamos podría añadir un CONSTRAINT CHECK (prestado < devuelto). Y pensar más restricciones de este tipo. De todas formas, las comprobaciones en el programa las tendría que hacer igual, para que se avise al usuario en caso de error, pero la base de datos estaría más protegida ante modificaciones manuales con phpMyAdmin o similares. Otra restricción podría ser que al modificar un registro se obtenga uno que ya existe (UNIQUE).

* [2021-04-17] En PHP 8 añadieron los [argumentos de funciones](https://www.php.net/manual/es/functions.arguments.php). Cuando pueda utilizar PHP 8 en glup debería utilizarlos para simplificar las funciones. Pero pasará tiempo, porque actualmente [no está incluido en ninguna distribución](https://www.mclibre.org/consultar/php/otros/historia-cuadros.html#distribuciones).


## Funciones de comprobación de datos (comprobaciones-general.php)

* [2021-04-07] La comprobación de datos que estoy haciendo no contempla que un campo se llame de la misma forma en dos tablas distintas. Por ejemplo, no se podría comprobar si existe un registro con el id recogido. La solución parece que tendrá que ser enviar la tabla y el campo.

* [2021-04-09] Aclarar qué hacer con las comprobaciones de id (si existe un registro, por ejemplo). Tendría que enviar el nombre de la tabla.

* [2021-04-09] Tanto compruebaAvisosIndividuales como compruebaAvisosGenerales recogen los datos.

* [2021-04-09] Igual en las comprobaciones habría que distinguir entre errores (error en la consulta, por ejemplo) y avisos (falta un campo, etc.) y hacer un log de los errores

* [2021-04-09] Estaría bien que al volver a un formulario por detectar errores, el cursor se colocara en el primer campo incorrecto, no en el primer campo del formulario.

* [2021-04-10] Las comprobaciones individuales no son siempre las mismas. Por ejemplo, en Usuarios para insertar los campos no pueden estar vacíos, pero para buscar sí. Lo que he hecho es dejar buscar-2, como estaba, sin usar comprobacionesIndividuales(), ya que simplemente se usaba recoge(). Pero para otras situaciones debería distinguir cada caso.

* [2021-04-19] No es fácil decidir qué tiene que hacer modificar-2 cuando le llegan avisos desde modificar-3. Lo que he hecho es que si hay avisos generales (que son que esté todo vacío o que ya exista el registro modificado), muestra los valores originales. Pero si hay avisos individuales muestra los modificados junto con los avisos individuales.

* [2021-04-20] Podría hacer una función hayErroresIndividuales() y que la función hayErrores() hiciera hayErroresIndividuales() || hayErroresGenerales().


## Problemas

* [2021-04-19] El problema de las variantes mayúsculas/minúsculas (Pepe vs pepe). No tengo claro si se puede resolver con COLLATE en MySQL/SQLite. Lo que he hecho en insertar-2 es utilizar lower() al hacer la comparación en AvisoGeneral yaExisteRegistro. En modificar-3 lo que tengo hecho es que comprueba que el id sea distinto para permitir cambiar las mayúsculas/minúsculas de un registro. - [MySQL Case Sensitivity in String Searches](https://dev.mysql.com/doc/refman/8.0/en/case-sensitivity.html) - [MySQL Character Sets, Collations, Unicode](https://dev.mysql.com/doc/refman/5.7/en/charset.html)

* [2021-04-19] El problema de las variantes acentos/sin acentos (Jose vs José). En el caso de las acentos / sin acentos creo que SQLite no tiene una solución general. Igual me toca hacer una tabla de sustitución de caracteres. - [How to remove accents in MySQL?](https://stackoverflow.com/questions/4813620/how-to-remove-accents-in-mysql) - [MySQL Cast Functions and Operators](https://dev.mysql.com/doc/refman/8.0/en/cast-functions.html)

## Por clasificar
- La fecha de préstamo es obligatoria. No se puede dejar a cero.
- Podría hacerse una función para comprobar que el DNI es correcto
- ¿Cómo funciona el NIE?
- préstamo > insertar-1: si una obra ya estuviera prestada, no debería salir en la lista
- préstamo > insertar-2: Si una persona coge la misma obra de nuevo, habría que comprobar que la fecha de préstamo no está dentro de las fechas de préstamo y devolución y que hay fecha de devolución (si el préstamo no se ha devuelto, creo que no se debería poder prestar ni antes ni después). Ahora sólo mira que la fecha de préstamo no sea la misma, independientemente de la fecha de devolución.
- préstamos > devolver-2: si ponía la fecha de devolución en la consulta preparada no funcionaba, así que la he insertado en la consulta (como he comprobado antes que es correcta, posiblemente no importe).
- obras > listar: podría indicar si las obras están prestadas

## Dudas SQL
* [2021-04-19] Parece ser que ni MySQL ni SQLite permiten proteger una fila para que no se pueda borrar. Eso se llama [Row-level secutity](https://www.sqlservercentral.com/steps/stairway-to-sql-server-security-level-10-row-level-security)

* [2021-04-20] He leído un consejo que decía que campos muy comunes no debían enlazar a otras tablas (nombres de países, etc) sino incluirse directamente en la tabla, para simplificar después las consultas. ¿Bastaría quizás con que en el momento de la inserción se comprobara que el valor es correcto?

