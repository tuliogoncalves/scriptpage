# Developement local

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
