<?php
    App::uses('AppModel', 'Model');

    class MemberWorkout extends AppModel 
    {
        public $displayField = 'name';

        public $belongsTo = array(
            'Member' => array(
                'className' => 'Member'
            ),
            'Workout' => array(
                'className' => 'Workout'
            )
        );
    }
?>