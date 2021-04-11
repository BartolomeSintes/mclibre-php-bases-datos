# BIBLIOTECA - COSAS POR HACER

Estas son algunas de las cosas que me quedan por hacer y que podrían hacerse en biblioteca-4

* [2021-04-06] Cuando tenga PHP 7 en el servidor de mclibre y pueda declarar constantes arrays, podría definir $cfg con como contante y así poder quitar los global de las funciones.

* [2021-04-06] Añadir log opcional de las consultas que modifican la base de datos (incluyendo el usuario que las ordenó y la fecha y la hora). No sé qué se podría hacer con las consultas preparadas (guardar las consultas y los parámetros). O quizás es mejor utilizar el log de mysql.

* [2021-04-06] Si se cambian valores de configuración que afectan a la base de datos, habría que rehacer la base de datos. ¿Cómo gestionar esa situación?

* [2021-04-08] La profundidad de nivel de las páginas posiblemente se pueda calcular a partir de la url. Así no podría equivocarme al poner el valor (u olvidarme de cambiarlo si muevo una página de nivel).

* [2021-04-10] El bloque inicial de comprobación de nivel, ¿podría ser una función?

* [2021-04-10] El comentario que tengo en modificar-3 sobre mayúsculas y minúsculas en MySQL lo tendría que revisar a ver si sigue siendo cierto o tiene solución.

* [2021-04-11] En Borrar todo podría preguntar si se quieren insertar registros de prueba.

* [2021-04-11] La funión existenTablas() supone que existen y cambia a no. Igual sería mejor suponer que no existen y asegurarse que existen todas. Aunque realmente es lo mismo.

## Funciones de comprobación de datos (tablas-comprobaciones.php)

* [2021-04-07] Hacer que login utilice también comprobación de datos

* [2021-04-07] La comprobación de datos que estoy haciendo no contempla que un campo se llame de la misma forma en dos tablas distintas. Por ejemplo, no se podría comprobar si existe un registro con el id recogido. La solución parece que tendrá que ser enviar la tabla y el campo.

* [2021-04-09] En las páginas, después de las comprobaciones campoOk hago a veces otras comprobaciones adicionales. Por ejemplo en borrar-2.php se comprueba que no se ha elegido el registro root. Esas comprobaciones también parece que se tendrían que gestionar al margen de las comprobaciones individuales.

* [2021-04-09] Los avisos generales deberían ser una matriz, porque puede haber varios.

* [2021-04-09] Aclarar qué hacer con las comprobaciones de id (si existe un registro, por ejemplo). Tendría que enviar el nombre de la tabla.

* [2021-04-09] Tanto compruebaAvisosIndividuales como compruebaAvisosGenerales recogen los datos.

* [2021-04-09] Igual en las comprobaciones habría que distinguir entre errores (error en la consulta, por ejemplo) y avisos (falta un campo, etc.) y hacer un log de los errores

* [2021-04-09] Estaría bien que al volver a un formulario por detectar errores, el cursor se colocara en el primer campo incorrecto, no en el primer campo del formulario.

* [2021-04-10] La gestión de los avisos no tiene en cuenta la tabla que los ha generado. A la hora de descartar los avisos, igual sería conveniente que se tuviera en cuenta no sólo la página, si no también la tabla.

* [2021-04-10] Las comprobaciones individuales no son siempre las mismas. Por ejemplo, en Usuarios para insertar los campos no pueden estar vacíos, pero para buscar sí. Lo que he hecho es dejar buscar-2, como estaba, sin usar comprobacionesIndividuales(), ya que simplemente se usaba recoge(). Pero para otras situaciones debería distinguir cada caso.

## POR CLASIFICAR
- La fecha de préstamo es obligatoria. No se puede dejar a cero.
- Podría hacerse una función para comprobar que el DNI es correcto
- ¿Cómo funciona el NIE?
- préstamo > insertar-1: si una obra ya estuviera prestada, no debería salir en la lista
- préstamo > insertar-2: Si una persona coge la misma obra de nuevo, habría que comprobar que la fecha de préstamo no está dentro de las fechas de préstamo y devolución y que hay fecha de devolución (si el préstamo no se ha devuelto, creo que no se debería poder prestar ni antes ni después). Ahora sólo mira que la fecha de préstamo no sea la misma, independientemente de la fecha de devolución.
- préstamos > devolver-2: si ponía la fecha de devolución en la consulta preparada no funcionaba, así que la he insertado en la consulta (como he comprobado antes que es correcta, posiblemente no importe).
- obras > listar: podría indicar si las obras están prestadas
