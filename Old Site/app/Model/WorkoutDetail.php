<?php
App::uses('AppModel', 'Model');

class WorkoutDetail extends AppModel 
{
    public $belongsTo = array(
        'Workout' => array(
            'className' => 'Workout'
        )
    );
}