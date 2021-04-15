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

- La documentación oficial de Selenium es bastante pobre, sin casi ejemplos: [Selenium commands](https://www.selenium.dev/selenium-ide/docs/en/api/commands)
- En [Selenium IDE tests examples](https://github.com/SeleniumHQ/selenium-ide/tree/trunk/tests/examples) hay unos ejemplos.
- [How to use Wait commands in Selenium WebDriver](https://www.browserstack.com/guide/wait-commands-in-selenium-webdriver)
