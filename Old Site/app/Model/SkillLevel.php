<?php
    App::uses('AppModel', 'Model');

    class SkillLevel extends AppModel 
    {
        public $uses = array('SkillLevel');

        public $hasMany = array(
            'SkillLevelDetail' => array(
                'className' => 'SkillLevelDetail'
            )
        );
    }
?>