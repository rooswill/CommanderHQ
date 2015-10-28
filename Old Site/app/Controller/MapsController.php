<?php


App::uses('AppController', 'Controller');

class MapsController extends AppController 
{

	public $scaffold = 'admin';

	public function index() 
	{
		$title_for_layout = 'Commander HQ | Member Home';
	}

}
