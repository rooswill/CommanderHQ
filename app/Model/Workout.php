<?php
App::uses('AppModel', 'Model');

class Workout extends AppModel 
{
    public $hasMany = array(
        'WorkoutAttribute' => array(
            'className' => 'WorkoutAttribute'
        ),
        'WorkoutTemplate' => array(
            'className' => 'WorkoutTemplate'
        )
    );

    public function _totalWorkouts()
    {
    	$data = $this->find('count');
    	return $data;
    }

    public function _countCompletedWorkouts()
    {
    	$data = $this->find('count', array('conditions' => array('complete' => 1)));
    	return $data;
    }

    public function _activityCount($memberID = NULL)
    {
    	$this->recursive = 2;
    	$data = $this->find('all', array('conditions' => array('member_id' => $memberID)));
    	foreach($data as $d)
    	{
    		foreach($d['WorkoutAttribute'] as $attributes)
    		{
    			if(isset($attributes['WorkoutUserAttributeDetail']) && count($attributes['WorkoutUserAttributeDetail']) > 0)
    			{
    				$returnData[] = $attributes['name'];
    			}
    		}
    	}

    	$attributes_count = array_count_values($returnData);

    	return $attributes_count;
    }

    public function _movementTypeWorkouts($memberID = NULL)
    {
    	$this->recursive = 2;
    	$data = $this->find('all', array('conditions' => array('member_id' => $memberID)));
    	foreach($data as $d)
    	{
    		$returnData[] = $d['Workout']['type'];
    	}

    	$movement_count = array_count_values($returnData);

    	return $movement_count;
    }
}