# Citygame



## Install the Application

fork or download this repo
then you can run `prepare.bat` or do the following commands yourself
```powershell
npm Install
composer Install
bower install
```
## css and JS

all css code should go in `assets/scss/**/*.css`
all js code should go in `assets/js/**/*.js`
using the `grunt` command in powershell these files should be added after the foundation-sites files and be put in:
 - public/scss/app.scss
 - public/js/app.js

from here they are available for public
the grunt command will also be performed when starting the `startserver.bat`

when working on css or js, you can run the `grunt watch` command to let grunt automaticly remake these files if you changed some stuff.

## Run the PHP server

Run `startserver.bat` that is present in the folder or enter `composer start` in Powershell that is running in the root directory off the project.
