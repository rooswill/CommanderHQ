<?php
App::uses('AppModel', 'Model');

class WorkoutUserTemplateDetail extends AppModel 
{
    public $belongsTo = array(
        'WorkoutTemplate' => array(
            'className' => 'WorkoutTemplate'
		)
    );
}