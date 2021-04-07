# BIBLIOTECA 3 - COSAS POR HACER

Estas son algunas de las cosas que me quedan por hacer y que podrían hacerse en biblioteca-4

* [2021-04-06] Cuando tenga PHP 7 en el servidor de mclibre y pueda declarar constantes arrays, podría definir $cfg con como contante y así poder quitar los global de las funciones.

* [2021-04-06] Añadir log opcional de las consultas que modifican la base de datos (incluyendo el usuario que las ordenó y la fecha y la hora). No sé qué se podría hacer con las consultas preparadas (guardar las consultas y los parámetros). O quizás es mejor utilizar el log de mysql.

* [2021-04-06] Si se cambian valores de configuración que afectan a la base de datos, habría que rehacer la base de datos. ¿Cómo gestionar esa situación?


## POR CLASIFICAR
- La fecha de préstamo es obligatoria. No se puede dejar a cero.
- Podría hacerse una función para comprobar que el DNI es correcto
- ¿Cómo funciona el NIE?
- préstamo > insertar-1: si una obra ya estuviera prestada, no debería salir en la lista
- préstamo > insertar-2: Si una persona coge la misma obra de nuevo, habría que comprobar que la fecha de préstamo no está dentro de las fechas de préstamo y devolución y que hay fecha de devolución (si el préstamo no se ha devuelto, creo que no se debería poder prestar ni antes ni después). Ahora sólo mira que la fecha de préstamo no sea la misma, independientemente de la fecha de devolución.
- préstamos > devolver-2: si ponía la fecha de devolución en la consulta preparada no funcionaba, así que la he insertado en la consulta (como he comprobado antes que es correcta, posiblemente no importe).
- obras > listar: podría indicar si las obras están prestadas
