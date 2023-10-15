# Developement local

change to brant dev

    git switch dev
    git merge <branch>

add in composer.json:

    "repositories": [
        {
            "type": "path",
            "url": "scriptpage",
            "options": {
                "symlink": true
            }
        }
    ],

add volume in app container(sail-docker-compose.yml):

    - ../framework:/var/www/scriptpage

add in your project to dev:

    composer require scriptpagex/framework:dev-main
