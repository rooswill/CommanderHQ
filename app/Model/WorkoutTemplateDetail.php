<?php
App::uses('AppModel', 'Model');

class WorkoutTemplateDetail extends AppModel 
{
    public $belongsTo = array(
        'WorkoutTemplate' => array(
            'className' => 'WorkoutTemplate'
		)
    );
}