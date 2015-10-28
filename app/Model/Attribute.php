<?php
App::uses('AppModel', 'Model');

class Attribute extends AppModel 
{
	public $hasOne = array(
        'SkillLevelDetail' => array(
            'className' => 'SkillLevelDetail'
        )
    );
}