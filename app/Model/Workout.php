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
}