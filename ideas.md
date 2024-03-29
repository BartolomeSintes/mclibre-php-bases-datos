# BIBLIOTECA - IDEAS

## Para mirar

* [Stairway to SQL Server Security](https://www.sqlservercentral.com/stairways/stairway-to-sql-server-security)


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

[Database Naming Convention](https://web.archive.org/web/20110714090713/http://www.interaktonline.com/Support/Articles/Details/Design+Your+Database-Database+Naming+Convention.html?id_art=24&id_asc=221) de la empresa InterAKT que Adobe compró hace años.


## Metadatos

The ISO/IEC 11179 Metadata Registry (MDR) standard is an international ISO standard for representing metadata for an organization in a metadata registry. It documents the standardization and registration of metadata to make data understandable and shareable.

[ISO/IEC 11179 wikipedia](https://en.wikipedia.org/wiki/ISO/IEC_11179)

[Normas ISO públicas](https://standards.iso.org/ittf/PubliclyAvailableStandards/)


## Estilo de las consultas

* [Mozilla](https://docs.telemetry.mozilla.org/concepts/sql_style.html)

* [Simon Holywell](https://www.sqlstyle.guide/)

* {GitLab](https://about.gitlab.com/handbook/business-technology/data-team/platform/sql-style-guide/)}


## Sobre fechas

* [Bad Habits to Kick : Mis-handling date / range queries](https://sqlblog.org/2009/10/16/bad-habits-to-kick-mis-handling-date-range-queries)


## Sobre avisos

* [IBM Cognos Analytics: Understanding logging levels](https://www.ibm.com/docs/en/cognos-analytics/10.2.2?topic=SSEP7J_10.2.2/com.ibm.swg.ba.cognos.ug_rtm_wb.10.2.2.doc/c_n30e74.html)
