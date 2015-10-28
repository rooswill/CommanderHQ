<?php


App::uses('AppController', 'Controller');

class RecipesController extends AppController 
{

	public $scaffold = 'admin';

	public function index() 
	{
		$title_for_layout = 'Commander HQ | Member Home';
	}

}
