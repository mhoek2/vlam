<?php

namespace App\Controllers\Front;

use App\Controllers\Front\BaseController;


class CaseController extends BaseController
{
	
	public function get_assignment( $assignment_id )
	{
		$assignment = $this->assignments->find($assignment_id);
		
		if ( is_null($assignment) ){
			die("Assignment not found.");
		}
		
		return $assignment;
	}
	
	private function get_case( $assignment_id, $case_id )
	{
		$case = $this->cases->find($case_id);

		if ( !$case || (int)$case['assignment_id'] !== (int)$assignment_id) {
			die("Case not found.");
		}
		
		return $case;
	}
		
	private function is_complete_action( $controller_name )
	{
		$controller_class = "App\Controllers\Front\CompleteCaseActions\\" . $controller_name;
		
		if (is_null($controller_name) || $controller_name === 'default')
			return NULL;
		
		if (class_exists($controller_class))
			return $controller_name;
	}
	
	private function has_complete_action( $case )
	{
		if (is_null($case))
			return false;

		return $this->is_complete_action( $case['complete_action'] ) ? $case['complete_action'] : false;
	}
	
	private function get_complete_action( $controller_name )
	{
		$controller_class = "App\Controllers\Front\CompleteCaseActions\\" . $controller_name;
		
		// redundant check validity
		if ( !$this->is_complete_action( $controller_name ) )	
			return NULL;
		
		if (class_exists($controller_class)) {
			$request = \Config\Services::request();
			$response = \Config\Services::response();
			$logger = \Config\Services::logger();

			$controller = new $controller_class();
			$controller->initController( $request, $response, $logger );
			
			return $controller;
		} 
		
		die('can not load sub assignment');
	}
	
	public function save( $meeting_id, $assignment_id, $case_id, $entry_num )
	{
		$warnings = [];
		
		$meeting_id 	= (int) $meeting_id;
		$assignment_id 	= (int) $assignment_id;
		$case_id 		= (int) $case_id;
		$entry_num 		= (int) $entry_num;
		
		// check if case if valid
		$case = $this->get_case( $assignment_id, $case_id );
		
        $user = $this->user->getUserInfo();
		
        $entry_id = $this->request->getPost('entry_id');
        $property_id = $this->request->getPost('property_id');
		
		$entry = $this->caseEntry->find($entry_id);
		$entry_type_group = $this->caseEntry->find_group($entry['type']);
		
		// check if entry type exists!
		if (!$this->caseEntry->valid_type($entry['type']))
		{
			array_push( $warnings, "entry type '".$entry['type']."' does not exist!" );
			return $this->response->setJSON(['status' => 'error', 'warnings' => $warnings]);
		}
		
		$value = NULL;	// stores list of property ids (integer list), or dynamic user-defined inputs (strings)
		
		if ($entry['type'] === "text_input") {
			$value = $property_id;
			$property_id = NULL;
		}
			
		if ( $entry_type_group == 'mcq' ){

			if ( is_array($property_id) )
			{
				if ( !preg_match('/^mcq-(\d+)$/', $entry['type'], $matches) ) {
					array_push( $warnings, "entry type '".$entry['type']."' does not match valid multi-selectable type of 'mcq-(int)'.." );
					return $this->response->setJSON(['status' => 'error', 'warnings' => $warnings]);
				}

				if ( count($property_id) > (int)$matches[1] )
				{
					array_push( $warnings, "count does not match with entry! .. what are you trying to do mate?" );
					return $this->response->setJSON(['status' => 'error', 'warnings' => $warnings]);
				}

				// use array_slice as fail-safe, for non matching property-counts
				$value = json_encode(array_map('intval', array_slice($property_id, 0, (int)$matches[1])));	// store as integers
			}
			else
				$value = json_encode([(int)$property_id]);	// store as integer

			$property_id = 1; // used to check if value is list of properties or a user-defined value
		}
		
		$this->caseResult->replace([ 
			'user_id' 		=> $user['id'], 
			'assignment_id' => $assignment_id,
			'case_id' 		=> $case_id,
			'entry_id' 		=> $entry_id,
			'property_id' 	=> $property_id,
			'value'			=> $value
			]
		);
        	
		return $this->response->setJSON(['status' => 'success']);
	}
	
	public function complete( $meeting_id, $assignment_id, $case_id )
	{
		$assignment = $this->get_assignment( $assignment_id );
		$case = $this->get_case( $assignment_id, $case_id );
		
		// Post complete action
		$complete_action = $this->has_complete_action($case);

		if ( $complete_action )
		{
			$controller = $this->get_complete_action( $complete_action );

			if (!is_null($controller))
				$controller->index( $meeting_id, $assignment_id, $case_id );
		}
		
		return redirect()->to(route_to('front.assignment', $meeting_id, $assignment_id));
	}
	
	public function outro( $meeting_id, $assignment_id, $case_id )
	{
		$meeting_id 	= (int) $meeting_id;
		$assignment_id 	= (int) $assignment_id;
		$case_id 		= (int) $case_id;
		
        // Meeting
        $this->data['meeting'] = $this->meetings->find( $meeting_id );
        $this->data["current_meeting"] = $this->data["meeting"] != false ? $meeting_id : false;

        // Assignment
        $this->data['assignments'] = $this->assignments->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
		$this->data['assignment'] = $this->get_assignment( $assignment_id );
		
        // Cases
        $this->data['cases'] = $this->cases->where('assignment_id', $assignment_id)->orderBy('sort_order', 'ASC')->findAll();
		$this->data['case'] = $this->get_case( $assignment_id, $case_id );
		
		// previous and next urls
		$this->data['case_reset_url'] = base_url(route_to('front.case.entry', $meeting_id, $assignment_id, $case_id, 0));
		$this->data['case_complete_url'] = base_url(route_to('front.case.complete', $meeting_id, $assignment_id, $case_id));
			
		load_header( $this->data );
		load_footer( $this->data );
		load_sidebar( $this->data );
		
        return view('front/case_outro', $this->data);		
	}
	
	public function entry( $meeting_id, $assignment_id, $case_id, $entry_num )
	{		
		$meeting_id 	= (int) $meeting_id;
		$assignment_id 	= (int) $assignment_id;
		$case_id 		= (int) $case_id;
		$entry_num 		= (int) $entry_num;
		
        // Meeting
        $this->data['meeting'] = $this->meetings->find( $meeting_id );
        $this->data["current_meeting"] = $this->data["meeting"] != false ? $meeting_id : false;

        // Assignment
        $this->data['assignments'] = $this->assignments->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
		$this->data['assignment'] = $this->get_assignment( $assignment_id );
		
        // Cases
        $this->data['cases'] = $this->cases->where('assignment_id', $assignment_id)->orderBy('sort_order', 'ASC')->findAll();
		$this->data['case'] = $this->get_case( $assignment_id, $case_id );
		
        // Entries
		$this->data['entries'] = $this->caseEntry->where('case_id', $case_id)->orderBy('sort_order', 'ASC')->findAll();	// to draw progressbar		
		$this->data['entry'] = $this->caseEntry->where('case_id', $case_id)->orderBy('sort_order', 'ASC')->offset($entry_num)->limit(1)->first();
		$this->data['entry_num'] = $entry_num;
		$this->data['entry_types'] = $this->caseEntry->type_enum;
		
		if (is_null($this->data['entry'])){
			die("Invalid case entry!");
		}
		
		// Entry properties
		$this->data['properties'] = $this->caseEntryProperties->where('entry_id', $this->data['entry']['id'])->orderBy('sort_order', 'ASC')->findAll();
		
		// Get saved user property ids and values
		// create array $saved_results with structure:
		// [entry_id] => property_id !== null) ? (array)json_decode(property_id) : value<br>
		// if property_id is set to 1 (mcq), value contains integer list of selected property_id's
		$saved_properties = $this->caseResult->where('user_id', $this->data['user']['id'])->where([
				'assignment_id' => $assignment_id,
				'case_id' 		=> $case_id,
			])->select(['property_id', 'entry_id', 'value'])->get()->getResultArray();
        $saved_results = array_reduce($saved_properties, function ($result, $property) {
			$result[$property['entry_id']] = !is_null($property['property_id']) ? json_decode($property['value'], true) : $property['value'];
			return $result;
		}, []);	
		
		$this->data['entry']['properties'] = array();
		foreach( $this->data['properties'] as $property ){
			if ( $property['entry_id'] !== $this->data['entry']['id'] )
				continue;

			if (!isset($this->data['entry']['properties']))
				$this->data['entry']['properties'] = array();

			// Mark a property as selected if matched with saved property
			$property['selected'] = isset($saved_results[$this->data['entry']['id']]) && is_array($saved_results[$this->data['entry']['id']]) && 
				in_array($property['id'], $saved_results[$this->data['entry']['id']]);
			
			array_push( $this->data['entry']['properties'], $property );
		}
	
		// previous and next urls
		if ($entry_num > 0)
			$this->data['entry_prev_url'] = base_url(route_to('front.case.entry', $meeting_id, $assignment_id, $case_id, ($entry_num - 1)));
		else
			$this->data['entry_prev_url'] = base_url(route_to('front.case', $meeting_id, $assignment_id, $case_id));
		
		if( ($entry_num + 1) < count($this->data['entries']))
			$this->data['entry_next_url'] = base_url(route_to('front.case.entry', $meeting_id, $assignment_id, $case_id, ($entry_num + 1)));
		else
			$this->data['entry_next_url'] = base_url(route_to('front.case.end', $meeting_id, $assignment_id, $case_id));

		load_header( $this->data );
		load_footer( $this->data );
		load_sidebar( $this->data );
		
        return view('front/case_entry', $this->data);		
	}

    public function index( $meeting_id, $assignment_id, $case_id ): string
    {
		$meeting_id 	= (int) $meeting_id;
		$assignment_id 	= (int) $assignment_id;
		$case_id 		= (int) $case_id;
		
        // Meeting
        $this->data['meeting'] = $this->meetings->find( $meeting_id );
        $this->data["current_meeting"] = $this->data["meeting"] != false ? $meeting_id : false;

        // Assignment
        $this->data['assignments'] = $this->assignments->where('meeting_id', $meeting_id)->orderBy('sort_order', 'ASC')->findAll();
		$this->data['assignment'] = $this->get_assignment( $assignment_id );
		
        // Cases
        $this->data['cases'] = $this->cases->where('assignment_id', $assignment_id)->orderBy('sort_order', 'ASC')->findAll();
		$this->data['case'] = $this->get_case( $assignment_id, $case_id );

		// Entry
		$entries = $this->caseEntry->where('case_id', $case_id)->orderBy('sort_order', 'ASC')->findAll();

		// previous and next urls
		$this->data['prev_url'] = base_url(route_to('front.assignment', $meeting_id, $assignment_id));
		
		$this->data['start_url'] = count($entries) > 0 ? base_url(route_to('front.case.entry', $meeting_id, $assignment_id, $case_id, 0)) : NULL;
		
		load_header( $this->data );
		load_footer( $this->data );
		load_sidebar( $this->data );
		
        return view('front/case', $this->data);
    }
}
