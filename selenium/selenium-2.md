# Comandos de Selenium

Este documento describe los comandos de Selenium que he utilizado para las pruebas de mis aplicaciones web.

En la página [Estructura del fichero](selenium-1.md) comento la estructura general del fichero json .side que utiliza Selenium IDE.

Los objetos **commands** tienen que contener al menos cuatro claves: **id**, **command**, **target** y **value**, aunque en algunos casos se dejen en blanco.

## Detalles

- Para encontrar las expresiones XPath de un elemento, se pueden utilizar las herramientas para desarrolladores web de Firefox o Chrome. Con el inspector se seleciona el elemento y haciendo clic derecho sobre la etiqueta en la vista de código fuente se puede elegir Copiar &gt; XPath.

- Las expresiones XPath pueden ser expresiones lógicas. Por ejemplo en Borrar todo 1 de 3 5 y posteriores hay una casilla y un botón con value "Sí" así que para hacer que haga clic en el botón he tenido que poner "xpath=//input[@value='Sí' and @name='borrar']".
El 0&/02/2024 lo he cambiado a "target": "xpath=//input[@name='borrar']", y funciona bien porque marca el primero pero lo he dejado con la condición con and "xpath=//input[@name='borrar' and @value='Sí']", para mayor seguridad (si no estuviera antes, marcaría el no).
En las páginas en las que sólo están los botones Sí/No lo he dejado "xpath=//input[@value='Sí']" ya que en esta página me da lo mismo cómo se llame el control ya que no hay ambigüedad.

- Para contar cuántos resultados encuentra una expresión xpath, en las herramientas de desarrollador de Firefox se puede utilizar la siguiente expresión javaScript:

```javascript
new XPathEvaluator().evaluate("//*[@class='aviso-error']", document, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE).snapshotLength;
````

- En una expresión XPath si se busca el n-ésimo elemento consecutivo hay que añadir [n] después del elemento.

- Con XPath parece que no se puede localizar texto (tendría que hacer más pruebas), pero he encontrado una solución con JvaScript...

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
},
```

### select: Selecciona un option de un select

```json
{
    "id": "correo-usuarios-5-12",
    "command": "select",
    "target": "name=nivel",
    "value": "label=Administrador"
},
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
    "comment": "El uso de los números no tengo claro cómo funciona ... En Borrar todo cuando busco párrafos, empiezan a contar en 1, pero en Listar cuando busco filas o celdas, empieza a contar en 0.",
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

### assert: Busca y comprueba que existe un texto

```json
{
    "id": "assert-1-a",
    "comment": "Aquí busco con javascript. Devuelve true o false",
    "command": "executeScript",
    "target": "return(document.body.innerHTML.includes('Las contraseñas no coinciden.'))",
    "value": "${detectadaCadena}"
},

```json
{
    "id": "assert-1-b",
    "comment": "Aquí busco con javascript. Devuelve la posición de la cadena o -1 si no lo encuentra",
    "command": "executeScript",
    "target": "return(document.body.innerHTML.search('Las contraseñas no coinciden.') > -1)",
    "value": "${detectadaCadena}"
},


{
    "id": "assert-2",
    "comment": "Aquí compruebo que lo ha encontrado",
    "command": "assert",
    "target": "${detectadaCadena}",
    "value": "true"
},
```

### assert: Busca y comprueba que existe un texto en una celda (que no está vacía)


```json
{
    "id": "numero-registros-usuario-1-6",
    "command": "storeText",
    "target": "xpath=//tr[1]/td[4]",
    "value": "contenidoCelda",
    "comment": "Guarda el contenido de una celda"
},
{
    "id": "numero-registros-usuario-1-7",
    "command": "executeScript",
    "target": "return(${contenidoCelda} != '')",
    "value": "contenidoCeldaVacio"
},
{
    "id": "numero-registros-usuario-1-8",
    "command": "assert",
    "target": "contenidoCeldaVacio",
    "value": "true"
},
```
[2024-02-09] Poniendo "comment" en todos los ficheros he llegado a bases-de-datos-3-b-numero-registros-usuario-minimo.side en el que usaba el ejemplo de antes y me parece que no funciona. No sé si es porque estoy con v4 y el ejemplo lo usé con v3, pero el caso es que lo he sustiutido por esto.
La diferencia es que en el ejemplo anterior no importa el valor de la celda, mientras que en el segundo hay que saber el contenido de la celda. Y otra cosa es que el nombre de la variable no me gusta porque vale true cuando no es vacía.
```json
{
    "id": "numero-registros-usuario-1-6",
    "command": "assertText",
    "target": "xpath=//tr[1]/td[4]",
    "value": "5",
    "comment": "La cuarta celda de la primera fila de la tabla contiene '5'"
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

### verifyNotText: Comprueba que un texto no existe.

Lo utilizaba en borrar-2 cuando no marcaba ninguna casilla, pero como desde 2024-01-24 compruebo siempre $id, ahora escribe el mensaje "No se ha seleccionado ningún registro.", así que lo he cambiado por un assertText.

Podría utilizarlo para verificar que no hay warnings ni errores en las páginas.

```json
{
    "id": "borrar-3-5",
    "command": "verifyNotText",
    "target": "xpath=//p",
    "value": "Registro borrado correctamente (si existía)."
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

### Condiciones

Las expresiones lógicas que se utilizan en las condiciones son expresiones de JavaScript.

```json
{
    "id": "condiciones-1",
    "command": "executeScript",
    "target": "return (document.querySelectorAll('[data-test-id=\"desconectarse\"]').length != 0)",
    "value": "test"
},
{
    "id": "condiciones-2",
    "command": "executeScript",
    "target": "return (document.body.innerHTML.includes('index.php\">Volver</a>'))",
    "value": "detectadoVolver"
}
```

## Otros

- [Selenium Tutorial: Testing Strategies](https://www.protechtraining.com/content/selenium_tutorial-testing_strategies)

