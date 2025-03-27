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
#. composer.json
    .. code-block:: bash
   
        composer install
		
#. Or, manually
    .. code-block:: bash
   
        composer create-project codeigniter4/appstarter vlam
        composer require phpdocumentor/shim
        composer require codeigniter4/shield:dev-develop
        php spark shield:setup
	  
#. Create a Mysql database with PhpMyAdmin and import ``sql/vlam.sql``

.. tip::

	For **development** use a local web server such as `XAMPP<https://www.apachefriends.org/>`_, or just apache with php and MySQL if you prefer custom installation.
	
	- Instead of **step 2**. Clone the repository using your preferred **GIT** workflow for version control.

`Proceed to: Configure <configure.rst>`_