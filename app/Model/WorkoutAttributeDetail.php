<?php
App::uses('AppModel', 'Model');

class WorkoutAttributeDetail extends AppModel 
{
    public $belongsTo = array(
        'WorkoutAttribute' => array(
            'className' => 'WorkoutAttribute'
        )
    );
}