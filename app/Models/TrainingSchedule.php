<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

use App\Models\Trainings;
use App\Models\Meetings;

class TrainingSchedule extends Cases
{
    protected $table      = 'training_schedule';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'training_id', 'meeting_id', 'meeting_id'];
	
	public function getScheduleRaw( int $training_id )
	{
		$meetings = new Meetings;
		$trainings = new Trainings;
		
		return $this->select(
				$this->table . '.*, ' .
				$meetings->table . '.name as meeting_name, ' . 
				$meetings->table . '.info as meeting_info, ' . 
				$trainings->table . '.name as training_name, '
			)
			->join($trainings->table, $trainings->table . '.id = '. $this->table .'.training_id', 'left')
			->join($meetings->table, $meetings->table . '.id = '. $this->table .'.meeting_id', 'left')
			->where( $this->table . '.training_id', $training_id)
		->findAll(); 
	}
	public function getSchedule( int $training_id )
	{
		$schedule = $this->getScheduleRaw( $training_id );
		
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