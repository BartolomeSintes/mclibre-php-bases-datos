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

* 2019-05-25. Tal y como está ahora, la respuesta del servidor tiene un campo "resultado", que puede ser OKO o NOK. ¿Qué pasa si no se recibe ese campo? ¿cómo tendría que reaccionar la página?
* 2019-05-25. "estructura"/"columnas" no da nombre a los campos, [0] es el nombre en la tabla, [1] es el tamaño, etc. ¿debería poner nombre a esos campos?
* 2019-05-25. Al mostrar la tabla de registros, las columnas van en el orden que aparecen en el json.  ¿Siempre voy a querer ese orden?
* 2019-05-25. ¿Cómo poner autofocus en el primer campo del formulario? ¿Añadiendo "autofocus" en "estructura"?

