<?php
App::uses('AppModel', 'Model');

class Exercise extends AppModel 
{
    public $belongsTo = array(
        'ExerciseType' => array(
            'className' => 'ExerciseType'
        )
	);

	public $hasAndBelongsToMany = array(
		'Attribute' => array(
			'className' => 'Attribute',
			'joinTable' => 'exercise_attributes',
			'foreignKey' => 'exercise_id',
			'associationForeignKey' => 'attribute_id',
            'unique' => 'keepExisting',
		),
	);


	public function _getExerciseStats()
	{

		$types = array("Endurance", "Strength", "Balance", "Flexibility");
		$base_stat_amount = array();
		$count = 0;

		$this->recursive = -1;

		$exercises = $this->find('all');

		foreach($types as $t)
		{
			$data = $this->find('all', array('conditions' => array('base_stat' => $t)));
			$dataCount = $this->find('count', array('conditions' => array('base_stat' => $t)));
			$base_stat_amount[$count][$t]['total_exercises'] = $dataCount;

			foreach($data as $d)
				$base_stat_amount[$count][$t]['base_stat_total'] += $d['Exercise']['base_stat_value'];

			$count++;
		}

		return $base_stat_amount;
	}
}