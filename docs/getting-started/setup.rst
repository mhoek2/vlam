Setup
======

Setup Docker Package
--------------------
#. Clone the **deploy branch**
    .. code-block:: bash

        git clone --branch deploy https://github.com/mhoek2/vlam.git
        cd vlam

#. Adjust **docker-compose.yml** and **.env** to your needs
#. Compose
    .. code-block:: bash

        docker compose up -d --pull always

#. Setup Database

By default the sql/vlam.sql is imported. use phpmyadmin to import a local backup. Migrations are not supported for this project yet ..

#. Dashboard is now accessable using the url set in .env

Default Login
-------------
+------------------+-----+---------------+
| User             |     | Password      |
+==================+=====+===============+
| admin@vlam.nl    |     | xcGBN7=58$cf  |
+------------------+-----+---------------+
| user@vlam.nl     |     | 9$Di524Gw%)f  |
+------------------+-----+---------------+

Updating
--------
#. Update the containers
    .. code-block:: bash

        cd vlam


        # shutdown containers.
        # ALWAYS BACKUP DATABASE (phpmyadmin)
        # DO NOT USE "-v" flag in compose down!
        docker compose down

        # remove appdata volume (/var/www)
        # TODO: Get rid of this ..
        docker volume rm vlam_appdata

        # pull latest & compose
        docker compose up -d --pull always
        
        # update database if required ( not implemented )
        #docker exec -it vlam_app php spark migrate