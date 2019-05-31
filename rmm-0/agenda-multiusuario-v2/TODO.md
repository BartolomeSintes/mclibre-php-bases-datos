# RMM-0 Agenda

## Cosas por hacer

* 2019-05-18. El programa de servidor envía json, pero no como application/json
* 2019-05-18. Los tamaños de los campos están en los dos ficheros de configuración config.php
  ¿Esos datos deberían pedirse al servidor? ¿cómo?
* 2019-05-18. Para reordenar las tablas de registros añado campos en la url.
  ¿debería hacerlo con javascript
* 2019-05-18. file_get_contents() necesita directiva allow_url_open y he leído que tiene riesgos de seguridad
  ¿la manera cómo la utilizo es segura o no?
* 2019-05-18. Podría hacer que los formularios (insertar-1, modificar-2, modificar-2) también se construyeran a partir de la información recibida
* 2019-05-18. Al no poder conectar con la base de datos podría devolver mensajes más concretos (servidor no disponible, usuario y contraseña erróneos, etc.)
* 2019-05-18. Confirmar que cuando una llamada hace varias acciones, el "resultado" global es OK si todas las acciones individuales son OK
* 2019-05-18. No sé si la dirección del servidor debería estar en config.php

* 2019-05-25. Tal y como está ahora, la respuesta del servidor tiene un campo "resultado", que puede ser KO o KO. ¿Qué pasa si no se recibe ese campo? ¿cómo tendría que reaccionar la página?
* 2019-05-25. "estructura"/"columnas" no da nombre a los campos, [0] es el nombre en la tabla, [1] es el tamaño, etc. ¿debería poner nombre a esos campos?
* 2019-05-25. Al mostrar la tabla de registros, las columnas van en el orden que aparecen en el json.  ¿Siempre voy a querer ese orden?
* 2019-05-25. ¿Cómo poner autofocus en el primer campo del formulario? ¿Añadiendo "autofocus" en "estructura"?

* 2019-05-27. ¿Podría proteger el fichero instalar.php para que sólo se pudiera ejecutar desde localhost? El problema es que sin navegador no se podría realizar la instalación.
* 2019-05-27. Hay cosas duplicadas en la configuración del cliente y del servidor. Debería indicarlo para que si se cambia uno, que se cambie el otro.

* 2019-05-27. Buscar 999 para pensar y corregir (nivel de usuarios en json)
* 2019-05-27. No tengo claro que sea buena idea pasar los valores de password al listar
* 2019-05-27. Al mostrar nivel, muestra valores numéricos no palabras.

* 2019-05-30. Cosas para hacer en este orden:
** pasar a html5
** sigo sin aclararme si tengo que separar en la api "estructura" de "registros". Por ejemplo, para hacer un formulario de insertar registros, si uno de los campos es una clave externa, ¿es mejor incluir los posibles valores en la misma llamada a la api o hacer una llamada aparte? Parece que es mejor hacerlo aparte, es más flexible. Pues lo mismo con la petición de la estructura. Pero entonces hay que hacer varias peticiones para construir una página. Cuando lo hablé con Vicente Forner me dio la idea de enviar varias acciones en la misma petición.

