@echo off & echo "preparing the system" & npm install & composer install & bower install & echo "ready for launch, if the enviroment variables are good then you can start it up" & pause
// the reason that this is all on one line is that npm install stops a scripts when finished (if multiline)
