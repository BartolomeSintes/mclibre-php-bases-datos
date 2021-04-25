# Selenium. Estructura general

[Selenium IDE](https://www.selenium.dev/selenium-ide/) te permite grabar lo que hace el usuario en una web y repetir podteriormente lo que haya hecho el usuario. Los pasos realizados se pueden guardar en un fichero json con extensión .side.

Este documento describe la estructura simplificada del fichero json que guarda Selenium IDE. El fichero que guarda Selenium tiene más campos, pero lo que he hecho ha sido simplificarlo al máximo para poder editarlo manualmente de forma más cómoda.

En la página [Comandos de Selenium](selenium-2.md) comento los comandos.

## Estructura general

La estructura general del json es la siguiente:
- id: identificador del archivo
- versión: versión
- name: nombre del grupo de pruebas
- url: url base para las páginas que se vayan a abrir
- test: colección de pruebas
- suites: grupos de tests para ejecutarlos uno detrás de otros

```json
{
    "id": "mclibre-biblioteca-4-tests",
    "version": "2.0",
    "name": "biblioteca-4",
    "url": "http://localhost",
    "tests": [],
    "suites": [],
}
```

## Matriz tests

La matriz **tests** está formada por objetos con la siguiente estructura:
- id: identificador del test
- name: texto que muestra Selenium IDE
- comment: comentario
- commands: pasos del test

**Nota**: No tengo claro que se puedan incluir claves *comment*  al test, porque cuando guardo un proyecto Selenium IDE borra esos comentarios.

```json
"tests": [
    {
        "id": "mclibre-b4-test-1",
        "name": "Desconexión inicial",
        "comment": "Se desconecta haciendo clic en Desconectar (si existe).",
        "commands": []
    },
    {
        "id": "mclibre-b4-test-2-1",
        "name": "Conexión y desconexión como root",
        "comment": "Se conecta como root / root. Se desconecta.",
        "commands": []
    }
]
```

## Matriz commands

La matriz **commands** está formada por objetos con la siguiente estructura:
- id: identificador del test
- command: uno de los [comandos de Selenium](https://www.selenium.dev/selenium-ide/docs/en/api/commands)
- target: depende del comando, pero suele el elemento de la página sobre el que se realiza el comando
- value: depende del comando, por ejemplo es el texto que el comando **type** escribe en un control de un formulario

```json
"commands": [
    {
        "id": "mclibre-b4-t2-2-1",
        "command": "open",
        "target": "/mclibre/consultar/php-bases-datos/biblioteca-4/index.php",
        "value": ""
    },
    {
        "id": "mclibre-b4-t2-2-2",
        "command": "pause",
        "target": "3000",
        "value": ""
    },
```

## Matriz suites

La matriz **suites** está formada por objetos con la siguiente estructura:

```json
"suites": [
    {
        "id": "suite-1",
        "name": "Default Suite",
        "persistSession": false,
        "parallel": false,
        "timeout": 300,
        "tests": [
            "mclibre-b4-test-1",
            "mclibre-b4-test-2-1"
        ]
    }
]
```

## Otros

- Como los valores de texto en json se delimitan con comillas dobles, si hay que escribir comillas dobles en un valor de texto se pueden utilizar comillas simples, aunque Selenium IDE escapa las comillas dobles (\\") al guardar un proyecto.

## Referencias

- Repositorios GitHub de Selenium
    - [GitHub Selenium](https://github.com/SeleniumHQ/selenium). Están haciendo la versión 4, de la que han sacado alguna beta. En principio, mantiene la compatibilidad con la versión 3. No hay roadmap.
    - [GitHub Selenium IDE 3](https://github.com/SeleniumHQ/selenium-ide/tree/v3): La versión actual que se utiliza como extensión de Firefox o Chrome. No hay roadmap.
    - [GitHub Selenium IDE 4](https://github.com/SeleniumHQ/selenium-ide): La versión futura, que será una aplicación Electron. No hay roadmap.

- La documentación oficial de Selenium es bastante pobre, sin casi ejemplos: [Selenium commands](https://www.selenium.dev/selenium-ide/docs/en/api/commands)
- En [Selenium IDE tests examples](https://github.com/SeleniumHQ/selenium-ide/tree/trunk/tests/examples) hay unos ejemplos.

- [How to use Wait commands in Selenium WebDriver](https://www.browserstack.com/guide/wait-commands-in-selenium-webdriver)

- Al tener instalado Selenium en la consola de las herramientas del navegador sale un aviso "El objeto Components está desaprobado. Pronto será eliminado.". Los de Selenium dicen en [la issue 598 (mayo 2019)](https://github.com/SeleniumHQ/selenium-ide/issues/598) que ya se arreglará cuando hagan la versión en Electron, que de todas formas si quitan el objeto del navegador, Selenium IDE seguirá funcionando. A saber...
