<?php


App::uses('Controller', 'Controller');

class AttributesController extends Controller 
{
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->layout = 'admin_small';
	}

	public function admin_index()
	{
		$user = CakeSession::read('admin_user');
		$this->set('user', $user[0]['Admin']);

		$attributes = $this->Attribute->find('all');
		pr($attributes);
	}

}
