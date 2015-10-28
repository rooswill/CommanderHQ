<?php


App::uses('Controller', 'Controller');

class TemplatesController extends Controller 
{
	public function getMovementTemplates()
	{
		$data = $this->Template->find('all', array('conditions' => array('type' => $this->request->data['template'])));
		$return = "";

		foreach($data as $d)
        	$return .= "<div class='main-template-btn' onclick='loadTemplates(\"".$d['Template']['type']."\", \"".$d['Template']['template']."\");'>".$d['Template']['name']."</div>";

        $return .= "<div class='clear'></div>";

        echo $return;

		die();
	}
}