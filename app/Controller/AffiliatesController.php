<?php


App::uses('Controller', 'Controller');

class AffiliatesController extends Controller 
{
	public $html;
	public $counter;
	
	public function find_all()
	{
		if($this->request->is('post'))
		{
			if($this->request->data)
			{
				$this->loadModel('Affiliate');
				$data = $this->Affiliate->find('list', array('conditions' => array('name LIKE' => '%'.$this->request->data['keyword'].'%'), 'limit' => 10));
				$total = count($data);
				foreach($data as $id => $name)
				{

					if($this->counter == ($total - 1))
						$class = 'ui-last-child';
					else
						$class = NULL;

					$this->html .= '<li class="activity ui-li ui-li-static ui-btn-up-c '.$class.'" id="'.$id.'" onclick="addMemberGym('.$id.', \''.$name.'\')">'.$name.'</li>';
					$this->counter++;
				}
			}
			else
				$this->html = NULL;
		}
		else
			$this->html = NULL;

		echo json_encode($this->html);
		die();
	}
}