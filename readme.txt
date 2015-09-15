1. Instalacja bazy danych.

W katalogu db schema jest skrytp stawiajacy baz� danych o nazwie db.sql.
UWAGA: 
1. Skrypt nie zawiera instrukcji create database.
2. W ostatniej lini skryptu jest instrukcja insert, ktora wstawia do tabeli admin
u�ytkownika o loginie test i ha�le test. Ze wzgl�d�w bezpiecze�stwa nale�y to zmieni� na cos innego.

a) Instalacja �wie�ej bazy danych.
Po��czy� si� z mysql. Utowrzy� now� baz� danych i wybra� j� jako baz� robocz� np.:
create database wste_rejestracja;
use wste_rejestracja;

wykona� skrypt.

b) Instalacja w istniej�cej bazie danych.

Wybra� odpowiedni� baz� jako baz� robocz� i wykonac skrypt.
UWAGA: w bazie nie mo�e by� tabel kandydat i admin

2. Instalacja aplikacji.

2.1.  Rozpakowa� wszystko w jakim� katalogu.

2.2.  Mo�na rozpakowa� wszystko w katalogu dost�pnym dla serwera www np. apache, nie jest to jednak post�powanie zalecane
      ze wzgl�dow bezpiecze�stwa.
      
2.3.  Dokona� konfiguracji po��czenia z baz� danych w pliku /config/databases.yml (linie 16, 17, 18)

2.4. Skonfigurowa� serwer www i ewentualnie dns tak �eby przez www dost�pny by� tylko katalog web projektu.

2.5. Ustawi� uprawnienia katalog�w:
  * najpierw wszystko na 755
  * katalogi cache, log na 777
  
2.6. Przyk�adowa konfiguracja hosta wirtualnego w apache

<VirtualHost *:80>
  ServerName rekrutacja.wste.edu.pl
  DocumentRoot "/home/rekrutacja/sciezka_do_ktorej_rozpakowano/web"
  DirectoryIndex index.php
  <Directory "/home/rekrutacja/sciezka_do_ktorej_rozpakowano/web">
     AllowOverride All
     Allow from All
  </Directory>
  Alias /sf /home/rekrutacja/sciezka_do_ktorej_rozpakowano/web/sf
  <Directory "/home/rekrutacja/sciezka_do_ktorej_rozpakowano/web/sf">
     AllowOverride All
     Allow from All
  </Directory>
</VirtualHost> 

Przy tej konfiguracji powinni�my miec rekrutacj� pod:
http://rekrutacja.wste.edu.pl

i panel admina pod:
http://rekrutacja.wste.edu.pl/backend.php

3. Uwagi:
  * wersja minimalna PHP 5.2.4 (zalecana lepsza)
  * modu�y php: pdo, pdo_mysql, gd2, mbstring
  * zainstalowany mod rewrite w Apache
  * Przy pozy�szej konfiguracji i wykonaniu tych krok�w wszystko dzia�a na: http://wste.dopary.pl
