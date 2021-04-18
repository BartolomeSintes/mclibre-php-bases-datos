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

[StackExchange (2012): Why is prefixing column names considered bad practice?](https://softwareengineering.stackexchange.com/questions/85764/why-is-prefixing-column-names-considered-bad-practice)

[Stack Overflow (2012): Is prefixing each field name in a table with abbreviated table name a good practice?](https://stackoverflow.com/questions/465136/is-prefixing-each-field-name-in-a-table-with-abbreviated-table-name-a-good-practi)

Parece que no hay un criterio universal.

The ISO/IEC 11179 Metadata Registry (MDR) standard is an international ISO standard for representing metadata for an organization in a metadata registry. It documents the standardization and registration of metadata to make data understandable and shareable.

[ISO/IEC 11179 wikipedia](https://en.wikipedia.org/wiki/ISO/IEC_11179)

[Normas ISO públicas](https://standards.iso.org/ittf/PubliclyAvailableStandards/)

