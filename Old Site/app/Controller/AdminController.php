<?php


App::uses('Controller', 'Controller');

class AdminController extends Controller 
{
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->layout = 'admin';
	}

	public function index()
	{

	}

	public function login()
	{
		//echo hash('sha512', 'TransF0rm3rs');
		if($this->request->is('post'))
		{
			$username = stripslashes($this->request->data['username']);
			$password = stripslashes(hash('sha512', stripslashes($this->request->data['password'])));

			$conditions = array(
				'conditions' => array(
					'username' => $username,
					'password' => $password
				)
			);

			$admin = $this->Admin->find('all', $conditions);

			if(count($admin) > 0)
			{
				// admin user found;
				$this->Session->setFlash(__('Yay! You have been logged in.'));
				CakeSession::write('admin_user', $admin);
				$this->redirect('/admin/reports');
			}
			else
			{
				$this->loadModel('AffiliateMember');
				$this->AffiliateMember->recursive = 2;
				$admin = $this->AffiliateMember->find('all');
				if(count($admin) > 0)
				{
					$this->Session->setFlash(__('Yay! You have been logged in.'));
					CakeSession::write('admin_user', $admin);
					$this->redirect('/admin/reports');
				}
				else
				{
					$this->Session->setFlash(__('Oops! The user account could not be found.'));
				}
			}
		}
	}

	public function workouts()
	{
		$this->layout = 'admin_small';
		if(CakeSession::read('admin_user'))
		{
			$user = CakeSession::read('admin_user');
			$this->set('user', $user[0]['Admin']);

			$this->loadModel('Exercise');
			$data = $this->Exercise->find('list');
			$this->set('exercises', $data);

			$this->loadModel('Benchmark');
			$data = $this->Benchmark->find('list');
			$this->set('benchmarks', $data);

		}
		else
			$this->redirect('/admin/login');
	}
}
