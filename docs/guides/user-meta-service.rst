User Meta Service
=================

Quick overview on how complete case actions are intended

Use-case
-------
The ability to store user specific data is mandatory, like stats or specific assignment outcomes.
To do this, a simple yet effective method is to have dedicated a database table and logic to store or retrieve this data.

This is simply using a key/value pair, combined with the user id.

The user meta is split into two identical database tables

#. 'user_meta' table for admin users, allowing them to run the training is if they are a participant. But with the feature that the training data is in real-time
#. 'training_user_meta' table for participants, where the training data is static, and cloned when the training session is started.

Example usage
--------------
.. code-block:: php
	// load the service
	$meta = service('user_meta');
	
	// store info for current user, string, preferably JSON format
	$meta->save( 'key', 'string/json' );
	
	// retrieve the info using the key
	$value = $meta->find( 'key' );	