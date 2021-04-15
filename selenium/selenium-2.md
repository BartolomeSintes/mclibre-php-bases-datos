# Comandos de Selenium

Este documento describe los comandos de Selenium que he utilizado para las pruebas de mis aplicaciones web.

En la página [Estructura del fichero](selenium-1.md) comento la estructura general del fichero json .side que utiliza Selenium IDE.

Los objetos **commands** tienen que contener al menos cuatro claves: **id**, **command**, **target** y **value**, aunque en algunos casos se dejen en blanco.

## open: Abre página

```json
{
    "id": "open-1",
    "command": "open",
    "target": "/mclibre/consultar/php-bases-datos/biblioteca-4/index.php",
    "value": ""
}
```

## pause: Pausa

Detiene Selenium un tiempo (para dar tiempo a realizar la tarea antes de que se muestre la página). El tiempo se indica en milisegundos en la clave **target**.

Lo he utilizado en la página BorrarTodo para esperar a que termine la creación de la base de datos. El problema es que el es un tiempo fijo y puede ser demasiado largo o demasiado. Creo que podría sustituirlo por alguno de los comandos **wait**, pero tengo que probarlo.

```json
{
    "id": "pause-1",
    "command": "pause",
    "target": "3000",
    "value": ""
}
```

## click: Hace click en un enlace

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

## type: Escribe en un formulario

```json
{
    "id": "type-1",
    "command": "type",
    "target": "name=usuario",
    "value": "basico"
}
```

## assertText: Comprueba que existe un texto

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

## assertElementPresent: Comprueba que existe un elemento

```json
{
    "id": "assertElementPresent-1",
    "comment": "Aquí compruebo que existe el elemento y compruebo su contenido.",
    "command": "assertElementPresent",
    "target": "xpath=//li[a='Listar']",
    "value": ""
}
```

## assertElementNotPresent: Comprueba que NO existe un elemento

```json
{
    "id": "assertElementNotPresent-1",
    "comment": "Aquí compruebo que el elemento no existe.",
    "command": "assertElementNotPresent",
    "target": "xpath=//li[a='Borrar']",
    "value": ""
}
```

## verify checked: Comprueba que está marcada una casilla de verificación o un botón radio

```json
{
    "id": "mclibre-b4-t3-8",
    "command": "verify checked",
    "target": "name=demo",
    "value": ""
}
```



