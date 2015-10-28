<?php


App::uses('AppController', 'Controller');

class ConverterController extends AppController 
{

	public $scaffold = 'admin';

	public function index($converter = NULL) 
	{
		$title_for_layout = 'Commander HQ | Member Home';
		if(isset($converter))
			$this->render('converter_'.$converter);
	}

}
