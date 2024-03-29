# BIBLIOTECA 3 - CHANGELOG

Todos los cambios importantes de este proyecto se documentarán en este fichero.

El formato se basa en [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## 2021-04-08
### Changed (Modificado)
- Paso $tamFecha a constante TAM_FECHA.
- Hago que el usuario de NIVEL_2 pueda ver las páginas de listar y buscar de Personas, Obras y Préstamos.
- Mejoro la comprobación del nivel de cada página haciendo una comparación de desigualdad (en vez de distinto). Incluyo la comparación en todas las páginas (antes no había comparación en las páginas de NIVEL_1, el nivel mínimo).
- Defino la profundidad de nivel de las páginas como constantes (PROFUNDIDAD_0, etc.) para que al llamar a la función cabecera el argumento se entienda mejor.
- Las constantes de nivel de usuario (NIVEL_) estaban definidas como cadenas ("1", etc). Las cambio a enteros (1, etc.).

## 2021-04-06
### Changed (Modificado)
- Biblioteca-3 está hecho a partir de Biblioteca-2 de los apuntes de PHP.
- Las páginas que gestionan las tablas las he movido a un directorio tablas.
- Cambio hash para que se puedan añadir otros tipos de hashs.
- He eliminado muchas constantes y variables simples de configuración para crear una matriz $cfg, pero no he eliminado todas las constantes.
- He simplificado la función borraTodo, creando una matriz de consultas. De paso he añadido la creación de registros de prueba para rellenar las tablas (seleccionable con una variable de configuración).
- Las variables que tiene que ver con la base de datos las he unido en una matriz $db. La conexión con la base de datos la he llamado $pdo.
