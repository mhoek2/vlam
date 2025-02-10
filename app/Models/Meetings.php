<?php

namespace App\Models;

use CodeIgniter\Model;

class Meetings extends Model
{
	public function get_all_meetings() 
	{
		$db = db_connect();
		$builder = $db->table('meetings');	
		$query = $builder->get();

		return $query->getResult();
	}

	public function get_meeting( $id ) 
	{
		$db = db_connect();
		$query = $db->table('meetings')->getWhere(
			['id' => (int)$id], 1, 0
		);

		if ($query->getNumRows() > 0) {
			return $query->getRow();
		} else {
			log_message('error', 'No meeting found with ID ' . $id);
			return false;
		}
	}

	public function set_meeting( $id, $data )
	{
		// check for admin again?
		$db = db_connect();
		$builder = $db->table('meetings');
		$builder->where('id', $id);
		$builder->update($data);

		if ($db->affectedRows() > 0) {
			return true;
		}

		return false;
	}
}

