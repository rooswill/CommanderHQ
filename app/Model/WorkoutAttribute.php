<?php
App::uses('AppModel', 'Model');

class WorkoutAttribute extends AppModel 
{
    // public $belongsTo = array(
    //     'Workout' => array(
    //         'className' => 'Workout'
    //     )
    // );

    public $hasMany = array(
        'WorkoutAttributeDetail' => array(
            'className' => 'WorkoutAttributeDetail'
        ),
        'WorkoutUserAttributeDetail' => array(
            'className' => 'WorkoutUserAttributeDetail'
        )
    );
}