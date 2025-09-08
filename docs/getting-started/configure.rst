Configure
=========

#. Set variable ``$baseURL`` in ``app/Config/App.php`` to the proper root url. eg: http://example.com/
#. Ensure database connection variables are correctly set in ``app/Config/Database.php``
#. Ensure 'csrf' is uncommented in ``$globals`` ``app/Config/Filters.php``
#. Ensure services are in place in ``app/Config/Services.php`` 

#. Give valid permissions to writable folder and subfolders
    .. code-block:: bash

        # This will add permissions, use valid user, commonly www-data for apache2 servers
        sudo chown -R www-data writable

#. Enable modrewrite
    .. code-block:: bash

        # Check if modrewrite is enabled:
        apache2ctl -M | grep rewrite

        # when nothing returns, enable using:
        sudo a2enmod rewrite
        sudo systemctl restart apache2

#. Create Virtual Host 
    .. code-block:: bash

        # When you don't have this set up already, add a vhost.
        # sudo nano /etc/apache2/sites-available/vlam.your-domain.com.conf
        <VirtualHost *:80>
            ServerName vlam.your-domain.com

            ServerAdmin webmaster@localhost
            DocumentRoot /var/www/html/vlam/public

            <Directory /var/www/html/vlam/public>
                Options Indexes FollowSymLinks
                AllowOverride All
                Require all granted
            </Directory>

            ErrorLog ${APACHE_LOG_DIR}/vlam_error.log
            CustomLog ${APACHE_LOG_DIR}/vlam_access.log combined
        </VirtualHost>

        # save & exit
        sudo a2ensite vlam.your-domain.com.conf
        sudo systemctl reload apache2

        # disable default vhost:
        sudo a2dissite 000-default.conf
        sudo systemctl reload apache2

#. TIP: Temporary enable error printing:
    .. code-block:: bash

        nano app/Config/Boot/production.php
        # Change:
        ini_set('display_errors', '0');
        # To:
        ini_set('display_errors', '1');

You should have a correctly setup cloned version