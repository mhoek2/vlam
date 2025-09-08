Installation
============

Setting up a fresh install

Requirements
------------
1. Hosting environemnt with ``PHP>8.2`` and ``ext-intl`` extension enabled.
2. A fresh copy containing core files from the github repository.

Setup
-----

#. Install `Composer<https://getcomposer.org/>`_
#. From the downloaded .zip, unzip all contents in the subfolder which contains composer.json to the project folder in your web environment.
#. Open a terminal of choice and change current directory to the root directory of the project folder.
#. Run the following command
    .. code-block:: bash
	
        # This will install the dependencies set in composer.json
        composer install
		
#. Or, manually 
    .. code-block:: bash
   
   		# This will not install dev-tools
        composer create-project codeigniter4/appstarter vlam
        composer require phpdocumentor/shim
        composer require codeigniter4/shield:dev-develop
        php spark shield:setup
	  
#. Create a Mysql database with PhpMyAdmin and import ``sql/vlam.sql``
#. Modify file: app/Config/App.php and match $baseURL with your desired url 
#. Modify file: app/Config/Database.php and enter database credentials
#. Give valid permissions to writable folder and subfolders
    .. code-block:: bash
   
   		# This will add permissions, use valid user, commoly www-data for apache2 servers
		sudo chown -R www-data writable




.. tip::

	For **development** use a local web server such as `XAMPP<https://www.apachefriends.org/>`_, or just apache with php and MySQL if you prefer custom installation.
	
	- Instead of **step 2**. Clone the repository using your preferred **GIT** workflow for version control.

.. tip::

	The Login controller is a clone of Shield's, preventing your custom login page from being overwritten.
	Ensure ``Controllers\LoginController::loginView()`` matches ``CodeIgniter\Shield\Controllers\LoginController::loginView()``.

`Proceed to: Configure <configure.rst>`_