<?php


App::uses('AppController', 'Controller');

class WorkoutsController extends AppController 
{
	public $scaffold = 'admin';

	public function view($id) 
	{
		$title_for_layout = 'Commander HQ | Member Home';
		$this->Workout->recursive = 2;
		$workoutData = $this->Workout->find('all', array('conditions' => array('id' => $id)));
		$this->set('workout', $workoutData[0]);
	}
}