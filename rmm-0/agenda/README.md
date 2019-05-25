# RMM-0 Agenda

RMM-0 Agenda está hecho a partir de Monolítica Agenda

RMM-0 es Richardson Maturity Model Level 0
https://martinfowler.com/articles/richardsonMaturityModel.html
es decir, RPC clásico, separando la parte que trabaja con la base de datos (servidor) de la que ve el cliente.

Cliente y servidor intercambian cadenas JSON

## Estructura de la API
Petición
* "accion" : posibles valores:
  * borrar-todo
  * comprobar-limite-registros
  * insertar-registro
  * seleccionar-registros-todos
  * borrar-registros-id
  * seleccionar-registro-id
  * modificar-registro
  * contar-registros-todos
  * buscar-registros
  * "id" (puede ser un valor o una matriz de valores), "nombre", "apellidos", "telefono", "columna", "orden"

Respuesta
* "resultado": OK / KO
* "mensajes": matriz de mensajes, cada mensaje es una matriz ["resultado" : OK/KO, "texto" : texto]
* "registros": matriz de registros
  * [valor numérico] para consultas COUNT
  * [columna1 : valor1, columna2 : valor2, etc.]
