<?php
App::uses('AppModel', 'Model');

class AffiliateType extends AppModel 
{
	public $belongsTo = array(
        'Affiliate' => array(
            'className' => 'Affiliate'
        )
    );
}