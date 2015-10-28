<?php
    App::uses('AppModel', 'Model');

    class SkillLevelDetail extends AppModel 
    {
        public $belongsTo = array(
            'Attribute' => array(
                'className' => 'Attribute'
            ),
            'Exercise' => array(
                'className' => 'Exercise'
            )
        );
    }
?>