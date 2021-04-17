# BIBLIOTECA - IDEAS

## Nombres de los campos en las tablas de la base de datos

Es inevitable que dos campos de dos tablas distintas acaben llamándose igual.

| Tabla              | Campo 1 | Campo 2  |     Campo 3       |
|--------------------|---------|----------|-------------------|
| Tabla 1 (personas) | id      | nombre   |                   |
| Tabla 2 (empresas) | id      | nombre   | jefe (id_persona) |

Si haces el diseño desde cero, puedes evitarlo añadiendo referencia a la tabla en el nombre del campo.

| Tabla              | Campo 1    | Campo 2        | Campo 3                      |
|--------------------|------------|----------------|------------------------------|
| Tabla 1 (personas) | id_persona | nombre_persona |                              |
| Tabla 2 (empresas) | id_empresa | nombre_empresa | jefe_id_persona (id_persona) |




