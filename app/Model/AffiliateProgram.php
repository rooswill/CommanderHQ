<?php
App::uses('AppModel', 'Model');

class AffiliateProgram extends AppModel 
{
	public $belongsTo = array(
        'Affiliate' => array(
            'className' => 'Affiliate'
        )
    );
}