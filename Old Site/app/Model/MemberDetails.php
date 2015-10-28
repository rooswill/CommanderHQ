<?php
    App::uses('AppModel', 'Model');

    class MemberDetail extends AppModel 
    {
        public $displayField = 'name';

        public $belongsTo = array(
            'Member' => array(
                'className' => 'Member'
            )
        );
    }
?>