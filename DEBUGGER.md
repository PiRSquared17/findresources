# Introduction #

Uso de el debugger.

# Instalacion en el server #
0. bajar el archivo ZendDebugger.dll
1. mover el ZendDebugger.dll en E:\wamp\tools
2. Ir al icono tray del wampp> PHP > php.ini
3. agregar las lineas:
zend\_extension\_ts=E:\wamp\tools\ZendDebugger.dll
zend\_debugger.allow\_hosts=127.0.0.1
zend\_debugger.expose\_remotely=always
4. bajar el archivo dummy.php
5. moverlo a E:\wamp\www

4. restart

[ZendDebugger](ZendDebugger.md)