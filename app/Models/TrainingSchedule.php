<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class TrainingSchedule extends Cases
{
    protected $table      = 'training_schedule';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'training_id', 'meeting_id', 'meeting_id'];
	
	public function getSchedule( int $training_id )
	{
		$schedule = $this->where('training_id', $training_id)->findAll();
		
		return array_reduce($schedule, function($result, $item) {
			if (!empty($item['date']) && $item['date'] !== '0000-00-00 00:00:00') {
				$time = new Time($item['date']);
				$result[$item['meeting_id']] = $time->format('Y-m-d H:i');
			} 
			else {
				//$result[$item['meeting_id']] = '';
			}

			return $result;
		},[]);
	}
}