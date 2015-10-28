<?php
App::uses('AppModel', 'Model');

class AffiliateMember extends AppModel 
{
	public $belongsTo = array(
        'Affiliate' => array(
            'className' => 'Affiliate'
        )
    );
}