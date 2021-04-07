# BIBLIOTECA - COSAS POR HACER

Estas son algunas de las cosas que me quedan por hacer y que podrían hacerse en biblioteca-4

* [2021-04-06] Cuando tenga PHP 7 en el servidor de mclibre y pueda declarar constantes arrays, podría definir $cfg con como contante y así poder quitar los global de las funciones.

* [2021-04-06] Añadir log opcional de las consultas que modifican la base de datos (incluyendo el usuario que las ordenó y la fecha y la hora). No sé qué se podría hacer con las consultas preparadas (guardar las consultas y los parámetros). O quizás es mejor utilizar el log de mysql.

* [2021-04-06] Si se cambian valores de configuración que afectan a la base de datos, habría que rehacer la base de datos. ¿Cómo gestionar esa situación?

* [2021-04-07] Añadir una variable de configuración para que tenga en cuenta los límites en el número de registros o no.

## Función de comprobación de datos

* [2021-04-07] Hacer que login utilice también comprobación de datos

* [2021-04-07] La comprobación de datos que estoy haciendo no contempla que un campo se llame de la misma forma en dos tablas distintas. Por ejemplo, no se podría comprobar si existe un registro con el id recogido. La solución parece que tendrá que ser enviar la tabla y el campo.

* [2021-04-07] La comprobación de datos que estoy haciendo es individual. Si quiero hacer una comprobación de grupo (por ejemplo, que estén todos los campos rellenados), no podría hacerlo. Esas comprobaciones parece que se tendrían que gestionar al margen de las comprobaciones individuales.

* [2021-04-07] En las páginas, después de las comprobaciones campoOk hago a veces otras comprobaciones adicionales. Por ejemplo en borrar-2.php se comprueba que no se ha elegido el campo root. Esas comprobaciones también parece que se tendrían que gestionar al margen de las comprobaciones individuales.

## POR CLASIFICAR
- La fecha de préstamo es obligatoria. No se puede dejar a cero.
- Podría hacerse una función para comprobar que el DNI es correcto
- ¿Cómo funciona el NIE?
- préstamo > insertar-1: si una obra ya estuviera prestada, no debería salir en la lista
- préstamo > insertar-2: Si una persona coge la misma obra de nuevo, habría que comprobar que la fecha de préstamo no está dentro de las fechas de préstamo y devolución y que hay fecha de devolución (si el préstamo no se ha devuelto, creo que no se debería poder prestar ni antes ni después). Ahora sólo mira que la fecha de préstamo no sea la misma, independientemente de la fecha de devolución.
- préstamos > devolver-2: si ponía la fecha de devolución en la consulta preparada no funcionaba, así que la he insertado en la consulta (como he comprobado antes que es correcta, posiblemente no importe).
- obras > listar: podría indicar si las obras están prestadas
