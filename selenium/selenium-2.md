# Comandos de Selenium

Este documento describe los comandos de Selenium que he utilizado para las pruebas de mis aplicaciones web.

En la página [Estructura del fichero](selenium-1.md) comento la estructura general del fichero json .side que utiliza Selenium IDE.

Los objetos **commands** tienen que contener al menos cuatro claves: **id**, **command**, **target** y **value**, aunque en algunos casos se dejen en blanco.

## Detalles

- Para encontrar las expresiones XPath de un elemento, se pueden utilizar las herramientas para desarrolladores web de Firefox o Chrome. Con el inspector se seleciona el elemento y haciendo clic derecho sobre la etiqueta en la vista de código fuente se puede elegir Copiar &gt; XPath.

- No he visto la manera de buscar un texto en toda la página, de manera que pueda estar seguro de que no está, porque parece que Selenium trabaja con elementos. Igual se puede hacer con JvaScript...

## Comandos

### store: Define variable

Las variables se definen con **store**: **value** es el nombre de la variable y **target** el valor almacenado. Para usar la variable en un comando posterior se escribe **${nombreVariable}**.

Las variables definidas en un test se pueden utilizar en un test posterior.

```json
{
    "id": "store-1",
    "command": "store",
    "target": "http://www.mclibre.org",
    "value": "urlBase"
},
{
    "id": "store-2",
    "command": "open",
    "target": "${urlBase}",
    "value": ""
},
{
    "id": "store-3",
    "command": "open",
    "target": "${urlBase}/consultar/informatica/",
    "value": ""
}
```

### run: Ejecutar otros tests

El comando **run** permite ejecutar otros tests. La clave *target** debe contener la clave **test** del test que se quiere ejecutar (no la clave **id**).

```json
"tests": [
    {
        "id": "test-1",
        "name": "Test nº 1",
        "commands": [
            {
                "id": "1",
                "command": "store",
                "target": "http://www.mclibre.org/",
                "value": "urlBase"
            }
        ]
    },
    {
        "id": "test-2",
        "name": "test nº 2",
        "commands": [
            {
                "id": "1",
                "command": "run",
                "target": "Test nº 1",
                "value": ""
            },
            {
                "id": "2",
                "command": "open",
                "target": "${urlBase}",
                "value": ""
            },
    }
]
```

### open: Abre página

El comando **open** abre la url indicada en la clave **target**.

La clave **url** general es la que se utiliza para las direcciones relativas, pero se pueden utilizar direcciones absolutas.

```json
// En la parte general
"url": "http://www.mclibre.org",
// En un test
{
    "id": "open-1",
    "command": "open",
    "target": "/consultar/python/",
    "value": ""
},
{
    "id": "open-2",
    "command": "open",
    "target": "http://www.google.com/",
    "value": ""
}
```

### pause: Pausa

Detiene Selenium un tiempo (para dar tiempo a realizar la tarea antes de que se muestre la página). El tiempo se indica en milisegundos en la clave **target**.

Lo utilicé al principio en la página BorrarTodo para esperar a que termine la creación de la base de datos. El problema es que es un tiempo fijo y puede ser demasiado largo o demasiado corto, por eso lo he sustituido por el comando **waitForElementPresent**.

```json
{
    "id": "pause-1",
    "command": "pause",
    "target": "3000",
    "value": ""
}
```

### waitForElementPresent

Detiene Selenium hasta que la página contenga un elemento. La clave **target** establece el elemento y la clave **value** establece el tiempo máximo de espera.

```json
{
    "id": "3",
    "command": "waitForElementPresent",
    "target": "xpath=//main",
    "value": "20000"
}
```

### click: Hace click en un enlace

```json
{
    "id": "click-1",
    "command": "click",
    "target": "linkText=Conectarse",
    "value": ""
},
{
    "id": "click-2",
    "command": "click",
    "target": "xpath=//input[@value='Identificar']",
    "value": ""
},
{
    "id": "click-3",
    "command": "click",
    "target": "xpath=//button[@value='nombre ASC']",
    "value": ""
},
```

### type: Escribe en un formulario

```json
{
    "id": "type-1",
    "command": "type",
    "target": "name=usuario",
    "value": "basico"
}
```

### assertText: Comprueba que existe un texto

```json
{
    "id": "assertText-1",
    "comment": "Aquí selecciono el elemento y compruebo su contenido. Si el elemento no existiera, daría error",
    "command": "assertText",
    "target": "xpath=//li[a='Listar']",
    "value": "Listar"
}
{
    "id": "assertText-2",
    "comment": "El uso de los números no tengo claro cómo funciona ... No sé si cuenta desde 0 o desde 1.",
    "command": "assertText",
    "target": "xpath=//tr[2]/td[1]",
    "value": "Juan"
},
{
    "id": "assertText-3",
    "command": "assertText",
    "target": "xpath=//p",
    "value": "No se han encontrado registros."
},
{
    "id": "assertText-4",
    "comment": "Aquí compruebo que existe el elemento y compruebo su contenido.",
    "command": "assertText",
    "target": "xpath=//p[1]",
    "value": "Escriba el criterio de búsqueda (caracteres o números):"
},
```

### assertElementPresent: Comprueba que existe un elemento

```json
{
    "id": "assertElementPresent-1",
    "comment": "Aquí compruebo que existe el elemento y compruebo su contenido.",
    "command": "assertElementPresent",
    "target": "xpath=//li[a='Listar']",
    "value": ""
}
```

### assertElementNotPresent: Comprueba que NO existe un elemento

```json
{
    "id": "assertElementNotPresent-1",
    "comment": "Aquí compruebo que el elemento no existe.",
    "command": "assertElementNotPresent",
    "target": "xpath=//li[a='Borrar']",
    "value": ""
}
```

### verify checked: Comprueba que está marcada una casilla de verificación o un botón radio

```json
{
    "id": "verifyChecked",
    "command": "verify checked",
    "target": "name=demo",
    "value": ""
}
```

## Estructuras de control

### Estructura if

Un **if** se define con los comandos **if** y **end**. La condición se tiene que poner como una variable.

He tenido que usar una condición en el primer test de toda la batería de pruebas. Ese primer test lo que hace es desconectarse de la aplicación, porque al abrir la página podría ocurrir que el usuario estuviera conectado a la aplicación (si hay una ventana del navegador abierta en la aplicación). Si está conectado vería el menú inicial de ese usuario (con la opción Desconectarse). Si no, se vería el menú Conectarse.

Como no se trata de confirmar o descartar creo que no se puede utilizar assert, lo que hago es buscar con javascript si existe el elemento. Para localizarlo, he añadido un id especial [https://developer.mozilla.org/es/docs/Web/HTML/Global_attributes/data-*](data-test-id) a la opción Desconectarse y si existe, simplemente hace clic en ella.

```json
{
    "id": "if-1-1",
    "command": "executeScript",
    "target": "return (document.querySelectorAll('[data-test-id=\"desconectarse\"]').length != 0)",
    "value": "test"
},
{
    "id": "if-1-2",
    "command": "if",
    "target": "${test}",
    "value": ""
},
{
    "id": "if-1-3",
    "command": "click",
    "target": "linkText=${text1}",
    "value": ""
},
{
    "id": "if-1-4",
    "command": "end",
    "target": "",
    "value": ""
}
```


## Otros

- [Selenium Tutorial: Testing Strategies](https://www.protechtraining.com/content/selenium_tutorial-testing_strategies)

