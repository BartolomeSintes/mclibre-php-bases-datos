# BASES DE DATOS - COSAS POR HACER

-   [2022-01-09] Una cosa que no me gusta son las comprobaciones de máximo de registros superado o de registros ya existente que siguen estando después de las comprobaciones de datos recibidos correctos.

    Lo que no tengo claro es cómo tratarlas. Ahora las tengo anidadas, hace una comprobación y si pasa, hace la siguiente. Una opción sería crear nuevas variables Ok, una por comprobación, y que se comprueben todas. La otra opción sería hacer una única variable $otrosOk que agrupara las comprobaciones. La ventaja de mantenerlas separadas es que es más fácil quitar y poner alguna.

    En listar, borrar o modificar, también está la comprobación de que existe algún registro, que no tiene Ok asociada.

-   [2022-01-09] En vez de dibujos, para las flechas podría utilizar caracteres Unicode. Por ejemplo, &#x1f781;  &#x290a; &#x23f6; &#x25b2;  &#x25bc;  &#x2b9d;  &#x2bc5; &#x1f702; Los mejores creo que son &#x25b2; y &#x25bc;

-   [2022-01-09] La forma que tengo de tratar los errores no es correcta. Deberían ser excepciones.

-   [2022-01-09] En caso de que no pueda conectarse con la base de datos debería sacar una página completa, no una simple línea.

-   [2022-01-09] Aclararme con [PDO::ATTR_EMULATE_PREPARES](https://www.php.net/manual/en/pdo.setattribute.php). Es para que las sentencias preparadas las haga PDO o las haga el driver de PDO. Mirar esta explicación: [stackoverflow](https://stackoverflow.com/questions/10113562/pdo-mysql-use-pdoattr-emulate-prepares-or-not). Lo que me tengo que aclarar es si es mejor que esté en true o en false y qué valor tiene por defecto.

-   [2022-01-09] Aclararme con try catch para usar PDO con excepciones.

    He visto varias preguntas en stackoverflow, pero realmente no dan alternativas

    -   [Is using nested try-catch blocks an anti-pattern?](https://softwareengineering.stackexchange.com/questions/118788/is-using-nested-try-catch-blocks-an-anti-pattern)
    -   [Pattern to avoid nested try catch blocks?](https://stackoverflow.com/questions/7796420/pattern-to-avoid-nested-try-catch-blocks)
    -   [Avoid nested try-catch blocks](https://stackoverflow.com/questions/41007524/avoid-nested-try-catch-blocks)
    -   [Nested try/catch with PDO in PHP](https://codereview.stackexchange.com/questions/64697/nested-try-catch-with-pdo-in-php)

-   [2022-01-12] He retocado las comprobaciones de las consultas preparadas. Al final he primado el criterio de reducir el anidamiento.

    Antes lo hacía así:

    ```php
    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
        print "\n";
    } else {
        $resultado->execute([":nombre" => "%$nombre%", ":apellidos" => "%$apellidos%"]);
        if (!$resultado) {
            print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
        } else {
    ```

    Pero lo he cambiado a:

    ```php
    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
        print "\n";
    } elseif (!$resultado->execute([":nombre" => "%$nombre%", ":apellidos" => "%$apellidos%"])) {
        print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
    ```

    La segunda forma tiene menos anidamiento y menos líneas pero el execute está metido dentro del if.

    Lo he hecho incluso cuando el segundo if incluye una asignación. Por ejemplo:

    ```php
    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":nombre" => "%$nombre%", ":apellidos" => "%$apellidos%", ":telefono" => "%$telefono%", ":correo" => "%$correo%"])) {
        print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!count($resultado = $resultado->fetchAll())) {
        print "    <p class=\"aviso\">No se han encontrado registros.</p>\n";
    } else {
    ```

    Hay gente a la que no le gusta hacer esto porque un error típico en los if es hacer asignaciones en vez de comparaciones. En este caso, no me importa hacerlo porque hay un count que deja claro (al menos para mí) que se trataba de una asignación.

    Lo que no he hecho ha sido hacer lo mismo con la preparación. Me refiero a que no he hecho esto:

    ```php
    if (!($resultado = $pdo->prepare($consulta))) {
        print "    <p class=\"aviso\">Error al preparar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":nombre" => "%$nombre%", ":apellidos" => "%$apellidos%", ":telefono" => "%$telefono%", ":correo" => "%$correo%"])) {
        print "    <p class=\"aviso\">Error al ejecutar la consulta. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!count($resultado = $resultado->fetchAll())) {
        print "    <p class=\"aviso\">No se han encontrado registros.</p>\n";
    } else {
    ```

    En este caso solo me ahorro una línea y no reduzco el anidamiento y en este caso sí que podría confundirse con una comparación (aunque la comparación no tendría sentido).

-   [2022-01-31] AUTO_INCREMENT en claves primarias. En SQLite no uso AUTO_INCREMENT al definir la clave primaria, pero en MySQL sí. Con AUTO_INCREMENT se supone que los valores siempre crecen (sin AUTO_INCREMENT SQLite puede reutilizar valores inferiores no utilizados, por ejemplo por haber borrado un registro. Igual tendría que uunificarlo (poniendo AUTO_INCREMENT para las dos bases de datos o no ponerlo en ninguna).
Le he preguntado a Cristina y a Pau si ella aconseja usar AUTO_INCREMENT o no y Pau dice que sí (pero en clase no lo usa porque no lo explica) y Cristina dice que no (en general, Cristina prefiere usar algún campo como clave primaria más que añadir claves primarias).
Lo único que está claro es que MySQL necesita AUTO_INCREMENT porque si no al insertar un registro hace falta darle el valor o se genera el error SQLSTATE[23000]: Duplicate entry '0' for key 'PRIMARY' (al no darle valor, le da el valor 0 y al insertar otro registro se produce el error). Sin embargo SQLite cuando no tiene AUTO_INCREMENT inserta sin problemas.
parece que lo más fácil sería poner AUTO_INCREMENT a SQLite, aunque el manual dice que el rendimiento es peor.
De todas formas aunque use AUTO_INCREMENT en las dos no está garantizado que las dos bases de datos pongan el mismo id porque a veces se saltan valores (dice el manual de SQLite).

-   [2022-01-31] En lo avisos de error de conectaDb() aparece la clase aviso, pero si no hay enlace a la hoja de estilo no se ve nada. Quizás debería añadir el estilo con style.

-   [2022-01-31] 
