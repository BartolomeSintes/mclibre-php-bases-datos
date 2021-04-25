# Selenium para Biblioteca-4

Este documento describe las pruebas definidas en biblioteca-4.side.json, escitas para la aplicación Biblioteca-4.

## Tests de preparación

 Aquí solo hay dos tests, pensados para que estén al principio de cualquier suite de tests:

 - Desconexión inicial: que se desconecta si al abrir la página está conectado.

 - Borrar todo: se conecta como root y reincia la base de datos con los registros de ejemplo.

## Tests de conexión

Aquí hay tres tests, que comprueban el funcionamiento para los usuarios root, basico y avanzado.

- root: comprueba que puede entrar en el menú Administrador

- basico:
