<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingAssignments extends Model
{
    protected $table      = 'training_assignments';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'training_id', 'meeting_id', 'name', 'sort_order', 'intro', 'info', 'sub_assignment', 'created_at'];
	
	protected $trainingId = NULL;
	
    public function setTrainingId( int $trainingId )
    {
        $this->trainingId = (int) $trainingId;
        
		// uncomment to test when user loads assignment from a training the user is not in ..
		//$this->trainingId = -1;
    }
	
    // override
    public function where( $key, $value = null )
    {
        if ( $this->trainingId !== NULL ) 
            $this->builder()->where('training_id', $this->trainingId);

        return parent::where($key, $value);
    }

	// override
    public function findAll( $limit = null, $offset = 0 )
    {
        if ( $this->trainingId !== NULL ) 
            $this->builder()->where('training_id', $this->trainingId);

        return parent::findAll($limit, $offset);
    }	
	
	// override
    public function find($id = null)
    {
        if ( $this->trainingId !== NULL ) 
            $this->builder()->where('training_id', $this->trainingId);

        return parent::find($id);
    }
}