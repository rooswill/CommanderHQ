<?php
App::uses('AppModel', 'Model');

class Workout extends AppModel 
{
    public $hasMany = array(
        'WorkoutDetail' => array(
            'className' => 'WorkoutDetail'
        ),
        'MemberWorkout' => array(
            'className' => 'MemberWorkout'
        ),
    );
}