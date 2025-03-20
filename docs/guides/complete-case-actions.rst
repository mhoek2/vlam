Complete Case Actions
=====================

Quick overview on how complete case actions are intended

Use-case
-------
Post-save logic for storing custom data via service('user_meta') after case/assignment completion.

Because custom logic may be required to store additional user-specific information in certain scenarios.

These modules allow to retrieve the user input of a case, and parse and store them to the developers intent

Workflow
--------
In the back-office, there is a drop-down selector in the ``Case Settings``.

This will list available classes which are located in: app/Controllers/Front/CompleteCaseActions.

Only files with ``Controller`` suffix are listed.

In the application itself, when a training member completes a case, the index() function is executed.
The general idea is that it redirects after completion. (parsing and storing user specific data)

Example module
--------------
.. code-block:: php
	namespace App\Controllers\Front\CompleteCaseActions;

	use App\Controllers\Front\BaseController;

	class ExamplePostSaveController extends BaseController
	{
		public function index( int $meeting_id, int $assignment_id, int $case_id )
		{
			// service('user_meta') example:
			// $user_meta = service('user_meta');
			// $user_meta->save( 'key', 'value', /*(Optional) user_id*/ );
			// $record = $user_meta->find( 'key', /*(Optional) user_id*/ );

			$meeting_id 	= (int) $meeting_id;
			$assignment_id 	= (int) $assignment_id;
			$case_id 		= (int) $case_id;

			$case = $this->get_case( $assignment_id, $case_id );
			$result = $this->get_case_results( $case_id );

			$training_meta = service('user_meta');
			$training_meta->save( 'case_meta', json_encode($result) );

			// redirect, this is just a post action
			$this->response->redirect( base_url(route_to('front.meeting', $meeting_id )) );
			return "";
		}
	}	