<?php
    App::uses('AppModel', 'Model');

    class MemberSubscription extends AppModel 
    {
        public $displayField = 'member_id';

        public $belongsTo = array(
            'Member' => array(
                'className' => 'Member'
            )
        );
    }
?>