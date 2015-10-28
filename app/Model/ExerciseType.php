<?php
App::uses('AppModel', 'Model');

class ExerciseType extends AppModel 
{
	public $displayField = 'type';

    public $hasMany = array(
        'Exercise' => array(
            'className' => 'Exercise'
        )
    );
}