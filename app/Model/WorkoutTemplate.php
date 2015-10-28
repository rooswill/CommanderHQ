<?php
App::uses('AppModel', 'Model');

class WorkoutTemplate extends AppModel 
{
    // public $belongsTo = array(
    //     'Workout' => array(
    //         'className' => 'Workout'
    //     )
    // );

    public $hasMany = array(
        'WorkoutTemplateDetail' => array(
            'className' => 'WorkoutTemplateDetail'
        ),
        'WorkoutUserTemplateDetail' => array(
            'className' => 'WorkoutUserTemplateDetail'
        ),
    );
}