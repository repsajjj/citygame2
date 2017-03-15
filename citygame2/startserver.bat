@echo off
color 02
grunt assets & title CityGame managment server & php -S 0.0.0.0:8080 -t public public/index.php
