Sub Assignments
===============

Quick overview on how sub assignments are intended

Use-case
-------
Post-save logic for storing custom data via service('user_meta') after case/assignment completion.

Because custom logic may be required to store additional user-specific information in certain scenarios.

These modules allow to retrieve the user input of a case, and parse and store them to the developers intent

Differences from: Case Actions
---------------------------
Unlike cases, sub-assignments can replace a assignment completely. Because they support ``views``

To use it as replacement, entries(questions) should be left blank for this assignment.
Then it will load and render the sub-assignment directly in the application.

Otherwise, the index() function will be loaded after a assignment is completed.
The developer can choose to create a post action page, or like a case action parse, store and redirect.



Workflow
--------
In the back-office, there is a drop-down selector in the ``Assignment Settings``.

This will list available classes which are located in: app/Controllers/Front/SubAssignments.

- Linked views should be located in: app/Views/front/sub_assignments.

Only files with ``Controller`` suffix are listed.

In the application itself, if there are no entries for this assigment, the index() is called directly. Otherwise after the assigment is completed.

Example module
--------------
.. code-block:: php
	namespace App\Controllers\Front\SubAssignments;

	use App\Controllers\Front\BaseController;

	class ExamplePostSaveController extends BaseController
	{
		public function index( int $meeting_id, int $assignment_id )
		{
			// Post-save logic for storing custom data via service('user_meta') after case/assignment completion.
			// Custom logic may be required to store additional user-specific information in certain scenarios.
			//
			// example:
			// $user_meta = service('user_meta');
			// $user_meta->save( 'key', 'value', /*(Optional) user_id*/ );
			// $record = $user_meta->find( 'key', /*(Optional) user_id*/ );

			// Additionaly, For assignments only:
			// This can fully override an assignment if no entries exist. 
			// If selected, the Controller & View will be displayed directly, enabling a completely custom assignment.

			$meeting_id 	= (int) $meeting_id;
			$assignment_id 	= (int) $assignment_id;

			$assignment = $this->get_assignment($assignment_id);
			$result = $this->get_assignment_results($assignment_id);


			$training_meta = service('user_meta');
			$training_meta->save( 'assignment_meta', json_encode($result) );

			// redirect, this is just a post action
			$this->response->redirect( base_url(route_to('front.meeting', $meeting_id)) );
			return "";
		}
	}	