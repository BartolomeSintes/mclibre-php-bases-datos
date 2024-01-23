# SELENIUM - CHANGELOG

Todos los cambios importantes de este proyecto se documentarán en este fichero.

El formato se basa en [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

Este changelog incluye los cambios hechos en ficheros de test para Selenium, en principio de Biblioteca-4 .

## 2021-04-26

### Changed (Modificado)
- biblioteca-4-1. Intento definir tests de tareas concretas para reutilizarlos. Creo un test que llama a las funciones. La suite está formada por ese test y todas las funciones. Pero con Selenium IDE no es fácil hacer que unos tests se llamen a otros (no es exactamente como utilizar funciones en un lenguaje de programación), así que dejo este fichero y continuo el trabajo en un segundo fichero sin tantas llamadas a funciones. Cuando deje de utilizar el IDE y ejecute los tests desde Python lo volveré a intentar.

### Added (Añadido)
- biblioteca-4-2. Creo un segundo json para escribir los tests, sin preocuparme de reutilizar demasiado el código.
- biblioteca-4-pruebas-1. Creo este json para ver la diferencia entre llamar a los tests con run o con una suite. Las conclusiones que he sacado las he añadido en las explicaciones sobre Selenium.

## 2021-04-25

### Changed (Modificado)
- Añado tests

### Added (Añadido)
- Escribo un programa en Python que cargar el side.json y renumerara los pasos de los tests siguiendo el patrón idTest-NN.

