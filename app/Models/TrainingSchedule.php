<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

use App\Models\Trainings;
use App\Models\TrainingMeetings;

class TrainingSchedule extends Cases
{
    protected $table      = 'training_schedule';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'training_id', 'meeting_id', 'date'];
	
	public function getScheduleRaw( int $training_id )
	{
		$meetings = new TrainingMeetings;
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
	
	public function getMeetingSchedule( int $training_id )
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

	private static function get_day_name(string $day): ?string
	{
		// dont bother with locale now ..
		$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
		
		$dutch = ['Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag'];

		$index = array_search($day, $days);

		return $index !== false ? $dutch[$index] : null;
	}
	
	private static function get_month_name( int $month )
	{
		$months = array(
			1   =>  'Januari',
			2   =>  'Februari',
			3   =>  'Maart',
			4   =>  'April',
			5   =>  'Mei',
			6   =>  'Juni',
			7   =>  'Juli',
			8   =>  'Augustus',
			9   =>  'September',
			10  =>  'Oktober',
			11  =>  'November',
			12  =>  'December'
		);

		return $months[$month];
	}
	
	private function addUserScheduleItem( &$schedule, $title, $date )
	{
		$time = new Time( $date );

		// preferable use local, but this is not properly implemented yet..
		$month_name = $this->get_month_name( $time->format('m') );
		$day_name = $this->get_day_name( $time->format('l') );
		
		array_push( $schedule, [
			"title" 		=> $title,
			"date" 			=> $time->format('d/m/Y'),
			"time" 			=> $time->format('H:i'),
			"date_char" 	=> $day_name . " " . $time->format('d ') . strtolower( $month_name ) . $time->format(' Y'),
			"date_original" => $date,
		]);
	}
	
	public function getUserSchedule( int $training_id ) : array
	{
		$now = Time::now();
		$meeting_schedule = $this->getScheduleRaw( $training_id );
		
		$result = [];

		foreach( $meeting_schedule as $item )
		{
			if (!empty($item['date']) && $item['date'] !== '0000-00-00 00:00:00') {
				$time = new Time( $item['date'] );

				if ( !$time->isAfter( $now ) )
					continue;

				$this->addUserScheduleItem( $result, $item['meeting_info'], $item['date'] );
			}
		}
		
		//
		// allow for future items to be added here
		//
		//$this->addUserScheduleItem( $result, "Test appointment", $result[0]['date_original'] );

		usort($result, function($a, $b) {
			$time_a = strtotime($a['date_original']);
			$time_b = strtotime($b['date_original']);
			return $time_a <=> $time_b;
		});
		
		return $result;
	}
}