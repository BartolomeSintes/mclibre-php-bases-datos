# Selenium. Estructura general

[Selenium IDE](https://www.selenium.dev/selenium-ide/) te permite grabar lo que hace el usuario en una web y repetir posteriormente lo que haya hecho el usuario. Los pasos realizados se pueden guardar en un fichero json con extensión .side.

Este documento describe la estructura simplificada del fichero json que guarda Selenium IDE. El fichero que guarda Selenium tiene más campos, pero lo que he hecho ha sido simplificarlo al máximo para poder editarlo manualmente de forma más cómoda.

En la página [Comandos de Selenium](selenium-2.md) comento los comandos.

## Nombre de fichero

Aunque sea un fichero json, el fichero tiene que tener la extensión .side. Si se deja con la extensión .json, al cargarlo desde Selenium IDE da error.


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

Si alguno de los tests de la suite ejecuta otro test mediante el comando **run**, no es necesario incluir este test en la suite.

## Suites vs **run**

Hay tres maneras de encadenar varios tests:
- ejecutándolos uno detrás de otro manualmente
- incluyéndolos en una suite de tests
- creando un test que vaya llamando a cada test mediante comandos **run**

La primera opción es un lata, pero puede venir bien para en algún momento para probar un detalle concreto.

La segunda es un poco latosa porque en Firefox el Selenium IDE te hace elegir el menú Test Suites, hacer clic en uno de los tests de la suite que queramos ejecutary después darle al botón Run all tests in suite.

La tercera puede que sea la más cómoda para después ejecutarla, pero es menos legible porque en la lista de tests cada test va en un comando **run** mientras que en la suite, van seguidos.

El problema es que la forma de ejecución no es exactamente la misma y eso obliga a escribir los tests de forma distinta.

Si los tests se encadenan en una suite, cada test debe empezar por un comando open para abrir la página, pero si los tests se encadenan con comandos **run**, entonces no hace falta. Lo que ahorras en un caso no teniendo que añadir **open** y **waitForElementPresent** en cada test, lo pierdes teniendo que crar un test con los run encadenados.

Con respecto a la definición de variables, tanto en un caso como en otro, con haberlas definido anteriormente es suficiente, no es necesario incluirlas en cada test (salvo que quieras ejecutar un test concreto de forma independiente, en cuyo caso sí que es necesario, porque no sirve ejecutar manualmente primero el test que define las variables y luego el que queramos ejecutar).

Otro detalle es que si el test se abre y la aplicación no se abre en la página adecuada, el test falla. Si se escribe el comando **open** en cada test, el navegador se abre y se cierra, por lo que la página en la que quedó el test anterior se pierde. Sin embargo si los tests se encadenan con *run** y no hay comando **open**, el navegador no se cierra y cada test empieza donde acabó el anterior.

Y si el navegador se cierra y se abre, se puede perder la sesión, con lo que si hay que identificarse para utilizar la aplicación, cada test debería empezar esciribendo el usuario y la contraseña. Como se trata de una extensión del navegador, lo normal es que el navegador esté abierto y entonces la sesión se suele mantener entre tests consecutivos independientemente de la forma de encadenarlos.

Pensando en general, está claro que es mejor que haya dos tipos de tests:
- los tests concebidos como una unidad completa e independiente, auqnue podamos ejectuar varios seguidos.
- los tests concebidos como un componente que nos ahorre repetir toda una serie de instrucciones cada vez, pero que no se tienen que intentar ejecutar de forma independiente porque fallarán.

Así que hay que tener claro cómo se van a utilizar los tests, porque hay que escribirlos de forma distinta. Quizás lo mejor sería escribirlos con la filosofía que tenga Selenium manejado desde un lenguaje de programación (no desde el IDE), pero como no lo he hecho todavía, no lo sé.

## Otros

- Como los valores de texto en json se delimitan con comillas dobles, si hay que escribir comillas dobles en un valor de texto se pueden utilizar comillas simples, aunque Selenium IDE escapa las comillas dobles (\\") al guardar un proyecto.

## Problemas de Selenium IDE

Hay veces, no sé por qué, que volver a cargar el proyecto no elimina el proyecto anterior. Como ocurre más a menudo de lo que debiera, al final estoy cerrando y abriendo Selenium IDE cada vez que cambio el proyecto. Tendría que abrir una issue en GitHub, pero como están haciendo la versión Electron independiente (que no sé si es una buena idea porque Electron cambia continuamente), cierran las issues que son exclusivas de la versión IDE.

## Referencias

- Repositorios GitHub de Selenium
    - [GitHub Selenium](https://github.com/SeleniumHQ/selenium). Están haciendo la versión 4, de la que han sacado alguna beta. En principio, mantiene la compatibilidad con la versión 3. No hay roadmap.
    - [GitHub Selenium IDE 3](https://github.com/SeleniumHQ/selenium-ide/tree/v3): La versión actual que se utiliza como extensión de Firefox o Chrome. No hay roadmap.
    - [GitHub Selenium IDE 4](https://github.com/SeleniumHQ/selenium-ide): La versión futura, que será una aplicación Electron. No hay roadmap.

- La documentación oficial de Selenium es bastante pobre, sin casi ejemplos: [Selenium commands](https://www.selenium.dev/selenium-ide/docs/en/api/commands)
- En [Selenium IDE tests examples](https://github.com/SeleniumHQ/selenium-ide/tree/trunk/tests/examples) hay unos ejemplos.

- [How to use Wait commands in Selenium WebDriver](https://www.browserstack.com/guide/wait-commands-in-selenium-webdriver)

- Al tener instalado Selenium en la consola de las herramientas del navegador sale un aviso "El objeto Components está desaprobado. Pronto será eliminado.". Los de Selenium dicen en [la issue 598 (mayo 2019)](https://github.com/SeleniumHQ/selenium-ide/issues/598) que ya se arreglará cuando hagan la versión en Electron, que de todas formas si quitan el objeto del navegador, Selenium IDE seguirá funcionando. A saber...
