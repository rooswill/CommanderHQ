<?php


App::uses('Controller', 'Controller');


class ReportsController extends Controller 
{

	public $scaffold = 'admin';
	public $uses = array('Member', 'Workout');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->layout = 'admin_small';
	}

	public function admin_index()
	{
		$user = CakeSession::read('admin_user');
		$this->set('user', $user[0]['Admin']);

		$conditions = array(
			'joins' => array(
		        array(
		            'alias' => 'MemberSubscription',
		            'table' => 'member_subscriptions',
		            'foreignKey' => false,
		            'conditions' => array('MemberSubscription.member_id = Member.id'),
		        ),
		    ),
		    'conditions' => array(
		        'MemberSubscription.active' => 1,
		    ),
		);

		$active_member_count = $this->Member->find('count', $conditions);
		$this->set('active_members', $active_member_count);
	}
}
