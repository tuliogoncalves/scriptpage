# Developement local

1) change to brant dev

    git switch dev
    git merge <branch>

2) add in composer.json on your project:

    "repositories": [
        {
            "type": "path",
            "url": "scriptpage",
            "options": {
                "symlink": true
            }
        }
    ],

3) create simbolic link:

    ln -s ../../framework ./scriptpage

4) add volume in app container php (sail-docker-compose.yml):

    - ../framework:/var/www/scriptpage

5) add in your project to dev:

    composer require scriptpagex/framework:dev-main
