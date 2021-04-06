# BIBLIOTECA 3 - CHANGELOG

Todos los cambios importantes de este proyecto se documentarán en este fichero.

El formato se basa en [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## 2021-04-06
### Changed (Modificado)
- Biblioteca-3 está hecho a partir de Biblioteca-2 de los apuntes de PHP
- Las páginas que gestionan las tablas las he movido a un directorio tablas
- Cambio hash para que se puedan añadir otros tipos de hashs
- He eliminado muchas constantes y variables simples de configuración para crear una matriz $cfg, pero no he eliminado todas las constantes.
- He simplificado la función borraTodo, creando una matriz de consultas. De paso he añadido la creación de registros de prueba para rellenar las tablas (seleccionable con una variable de configuración).
- Las variables que tiene que ver con la base de datos las he unido en una matriz $db. La conexión con la base de datos la he llamado $pdo.
