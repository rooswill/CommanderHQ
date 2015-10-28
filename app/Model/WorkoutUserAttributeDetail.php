<?php
App::uses('AppModel', 'Model');

class WorkoutUserAttributeDetail extends AppModel 
{
    public $belongsTo = array(
        'WorkoutAttribute' => array(
            'className' => 'WorkoutAttribute'
        )
    );
}