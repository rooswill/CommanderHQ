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
}