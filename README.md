TorPi - Panel de Control
=========
TorPi Panel de Control es una aplicación web que proporciona información del estado de la Raspberry Pi y la posibilidad de reiniciar, apagar el dispositivo y cambiar el estado del servicio TOR. 


**Capturas:**

![alt tag](https://i.ibb.co/RBjFnLV/login-torpiweb.png)

![alt tag](https://i.ibb.co/ZHR19fY/torpi-control-panel.png)


Instalación
--------------

Para poder ejectuarlo correctamente se necesitan los siguientes programas.

Instalar Apache y PHP
```
apt -y install apache2 php php-common
```
Una vez instado hay que realizar el git clone en la siguiente ruta
```
cd /var/www/html/

git clone https://github.com/carellan/torpiweb.git
```
A continuación debemos añadir el usuario www-data en el fichero /etc/sudoers
```
vi /etc/sudoers
```
```
www-data ALL=NOPASSWD: ALL
```
Seguidamente, ya podemos acceder a nuestro servidor web indicando al final de este /torpiweb

