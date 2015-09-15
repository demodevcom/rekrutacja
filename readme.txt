1. Instalacja bazy danych.

W katalogu db schema jest skrytp stawiajacy bazê danych o nazwie db.sql.
UWAGA: 
1. Skrypt nie zawiera instrukcji create database.
2. W ostatniej lini skryptu jest instrukcja insert, ktora wstawia do tabeli admin
u¿ytkownika o loginie test i haœle test. Ze wzglêdów bezpieczeñstwa nale¿y to zmieniæ na cos innego.

a) Instalacja œwie¿ej bazy danych.
Po³¹czyæ siê z mysql. Utowrzyæ now¹ bazê danych i wybraæ j¹ jako bazê robocz¹ np.:
create database wste_rejestracja;
use wste_rejestracja;

wykonaæ skrypt.

b) Instalacja w istniej¹cej bazie danych.

Wybraæ odpowiedni¹ bazê jako bazê robocz¹ i wykonac skrypt.
UWAGA: w bazie nie mo¿e byæ tabel kandydat i admin

2. Instalacja aplikacji.

2.1.  Rozpakowaæ wszystko w jakimœ katalogu.

2.2.  Mo¿na rozpakowaæ wszystko w katalogu dostêpnym dla serwera www np. apache, nie jest to jednak postêpowanie zalecane
      ze wzglêdow bezpieczeñstwa.
      
2.3.  Dokonaæ konfiguracji po³¹czenia z baz¹ danych w pliku /config/databases.yml (linie 16, 17, 18)

2.4. Skonfigurowaæ serwer www i ewentualnie dns tak ¿eby przez www dostêpny by³ tylko katalog web projektu.

2.5. Ustawiæ uprawnienia katalogów:
  * najpierw wszystko na 755
  * katalogi cache, log na 777
  
2.6. Przyk³adowa konfiguracja hosta wirtualnego w apache

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

Przy tej konfiguracji powinniœmy miec rekrutacjê pod:
http://rekrutacja.wste.edu.pl

i panel admina pod:
http://rekrutacja.wste.edu.pl/backend.php

3. Uwagi:
  * wersja minimalna PHP 5.2.4 (zalecana lepsza)
  * modu³y php: pdo, pdo_mysql, gd2, mbstring
  * zainstalowany mod rewrite w Apache
  * Przy pozy¿szej konfiguracji i wykonaniu tych kroków wszystko dzia³a na: http://wste.dopary.pl
