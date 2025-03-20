Entry types
===========

Quick overview on how to modify or extend Case or Assignment entry types

Entry types allow question variants.
Like multiple-choice question, or a textare where user can type.

These types can be grouped, take mcq (multiple-choice-question) for example.
There can be scenarios where the user is only allowed to select one answer, Or maybe 2 out of 4.

By grouping, in the back-office, there will be a dropdown. Allowing the admin to choose a variant.

Reference
---------
Located in Model: ``app/Models/AssignmentEntry.php`` and ``app/Models/CaseEntry.php``

.. code-block:: php
    public $type_enum = [ 
        ['type' => 'mcq',               'group' => 'mcq', 	'name' => 'Keuze'],
        ['type' => 'mcq-2',             'group' => 'mcq', 	'name' => 'Keuze uit 2'],
        ['type' => 'mcq-3',             'group' => 'mcq', 	'name' => 'Keuze uit 3'],
        ['type' => 'text_input',        'group' => NULL, 	'name' => 'Text Input'], 
        ['type' => 'text_separator',    'group' => NULL, 	'name' => 'Text Separator']
    ];
	
Note
----
This is linked to the database, so.

Do not change or remove existing type/group 'type' identifiers. This can have negative impact on existing training data.

If required, make sure to update the database enum (for the changed Model) and all database records that reference that type!

When adding types, make sure to add the new 'type' to the enum in the database.