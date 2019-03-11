cd a_package && ./configure-skeleton.sh

Inside Laravel 
        "psr-4": {
            "Pkboom\\SpotifyApis\\": "a_package/src/",
            "App\\": "app/"
        }

        Pkboom\SpotifyApis\SpotifyApisServiceProvider::class,

cd .. && composer dump-autoload

set up package service provider

move files

fix namespaces if necessary

run tests from laravel application, not from package

delete namespace from laravel-application composer.json
"Pkboom\\{package_namespace}\\": "a_package/src/",

delete from config/app.php 
Pkboom\Calm\{{Your package}}ServiceProvider::class,

test the package

create a laravel application

composer-link ../packages/{package}

composer require pkboom/{package}

if test's good, continue

delete a_package
when deleting a_package, it will only delete link
when deleting files, it will actually files in the package folder

git remote remove origin

from package
git remote add origin git@github.com:pkboom/{{your-package}}
wip
git push -u origin master -f

create README.md

