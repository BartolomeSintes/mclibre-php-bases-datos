# RMM-0 Agenda

## Cosas por hacer

* 2019-05-18. El programa de servidor envía json, pero no como application/json
* 2019-05-18. Los tamaños de los campos están en los dos ficheros de configuración config.php
  ¿Esos datos deberían pedirse al servidor? ¿cómo?
  Podría hacer una petición info-db que devolviera información sobre la tabla
* 2019-05-18. Para reordenar las tablas de registros añado campos en la url.
  ¿debería hacerlo con javascript
* 2019-05-18. file_get_contents() necesita directiva allow_url_open y he leído que tiene riesgos de seguridad
  ¿la manera cómo la utilizo es segura o no?
* 2019-05-18. Podría hacer que los listados (listar, borrar-1, buscar-2, modificar-1) se construyeran a partir de la información recibida, para que fuera fácil reutilizarlos con otras tablas.
  ¿Podría hacer algo parecido con los formularios (insertar-1, modificar-2, modificar-2), que también se construyeran a partir de la información recibida?
