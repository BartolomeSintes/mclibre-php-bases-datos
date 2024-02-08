# Otros temas

[2023-01-14] Para la elaboración de las pruebas para las bases de datos, especialmente cuando hay que hacer modificaciones o añadir detalles que se me van ocurriendo, me toca comparar los archivos. Hace unos años que uso KDiff, pero con archivos tan grandes se hace un lío. Pero hoy he probado WinMerge que hacía tiempo que no usaba y he descubierto que en las opciones de Editar > configuración > Comparar > General dejan probar otros algoritmos de comparación y el **paciente** funciona mucho mejor.

[2023-01-25] La detección de párrafos me vuelve loco. En el ejercicios de datos repetidos, al comprobar los mensajes de error sale un aviso y una frase.
````
{
    "id": "personas-insertar-2-3",
    "command": "assertText",
    "target": "xpath=//p",
    "value": "Existe un registro con datos similares."
},
{
    "id": "personas-insertar-2-4",
    "command": "assertText",
    "target": "xpath=//p[1]",
    "value": "Por favor, confirme que desea insertar el registro."
},
````
Aunque he probado varias combinaciones (p, p[1]. p[2]), no hay manera de que identifique el segundo párrafo. Lo he acabado haciendo con javascript

````
{
    "id": "personas-insertar-2-3",
    "command": "assertText",
    "target": "xpath=//p",
    "value": "Existe un registro con datos similares."
},
{
    "id": "personas-insertar-2-4",
    "command": "executeScript",
    "target": "return (document.body.innerHTML.includes('Por favor, confirme que desea insertar el registro.'))",
    "value": "${detectadaCadena}"
},
````
[2024-02-08] Hoy he encontrado una forma de hacer lo anterior y consiste en añadir form en el XPath

`````
{
    "id": "datos-repetidos-5-3",
    "command": "assertText",
    "target": "xpath=//p",
    "value": "Existe un registro con datos similares."
},
{
    "id": "datos-repetidos-5-6",
    "command": "assertText",
    "target": "xpath=//form/p[1]",
    "value": "Por favor, confirme que desea insertar el registro.",
    "comment": "Muestra mensaje: 'Por favor, confirme que desea insertar el registro.'"
},

````
