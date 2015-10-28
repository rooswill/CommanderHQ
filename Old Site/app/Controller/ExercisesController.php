<?php


App::uses('AppController', 'Controller');

class ExercisesController extends AppController 
{

	public $scaffold = 'admin';

	public function find_all() 
	{
		$return = '<li style="font-style:italic;color:#C83006" class="activity ui-li ui-li-static ui-btn-up-c ui-first-child" id="0">Create New Activity</li>';
		$data = $this->Exercise->find('all', array('conditions' => array('Exercise.name LIKE' => '%'.$this->request->data['keyword'].'%'), 'limit' => 10));
		$total = count($data);
		$counter = 0;
		foreach($data as $d)
		{
			if($counter == ($total - 1))
				$class = 'ui-last-child';
			else
				$class = NULL;

			$return .= '<li class="activity ui-li ui-li-static ui-btn-up-c '.$class.'" id="'.$d['Exercise']['id'].'" onclick="loadExercise(\''.$d['Exercise']['name'].'\', '.$d['Exercise']['id'].')">'.$d['Exercise']['name'].'</li>';
			$counter++;
		}

		echo json_encode($return);

		die();
	}

	public function load_exercise_date() 
	{
		$data = $this->Exercise->find('all', array('conditions' => array('Exercise.id' => $this->request->data['exercise_id'])));
		$counter = 0;

		$attribute = '<div class="ActivityAttributes" data-role="fieldcontain">';

		foreach($data as $d)
		{
			$return['exercise_id'] = $d['Exercise']['id'];
			$return['exercise_name'] = $d['Exercise']['name'];
			$return['exercise_type_id'] = $d['ExerciseType']['id'];
			$return['exercise_type'] = $d['ExerciseType']['type'];
			foreach($d['Attribute'] as $attributes)
			{
				$attribute .= '<div class="AttributeContainer">';
					$attribute .= '<input type="hidden" class="exercise_details" name="exercise_'.$counter.'_name" id="exercise_'.$counter.'_name" value="'.$d['Exercise']['name'].'" />';
					$attribute .= '<input type="hidden" class="exercise_details" name="attribute_'.$counter.'_name" id="attribute_'.$counter.'_name" value="'.$attributes['name'].'" />';
					$attribute .= '<input type="hidden" class="exercise_details" name="attribute_'.$counter.'_id" id="attribute_'.$counter.'_id" value="'.$attributes['id'].'" />';
					$attribute .= '<span class="AttributeLabel">'.$attributes['name'].' : </span>';
					$attribute .= '<span class="AttributeInput">';
						$attribute .= '<div class="ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c">';
							$attribute .= '<input class="textinput ui-input-text ui-body-c exercise_details" type="text" id="attribute_value_'.$counter.'" name="'.str_replace(" ", "_", strtolower($attributes['name'])).'">';
						$attribute .= '</div>';
					$attribute .= '</span>';
					$attribute .= '<div style="clear:both;"></div>';
				$attribute .= '</div>';
				$counter++;
			}
		}

		$attribute .= '<div class="SaveActivity">';
			$attribute .= '<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="b" data-mini="true" data-disabled="false" class="ui-btn ui-btn-up-b ui-shadow ui-btn-corner-all ui-mini" aria-disabled="false">';
				$attribute .= '<span class="ui-btn-inner">';
					$attribute .= '<span class="ui-btn-text">Add Activity</span>';
				$attribute .= '</span><input data-theme="b" data-mini="true" class="buttongroup ui-btn-hidden" type="button" id="" name="btn" onclick="AddActivity();" value="Add Activity" data-disabled="false">';
			$attribute .= '</div>';
		$attribute .= '</div>';
		$attribute .= '<div style="clear:both;"></div>';
		$attribute .= '</div>';

		echo json_encode($attribute);

		die();
	}

	public function admin_index()
	{
		$user = CakeSession::read('admin_user');
		$this->set('user', $user[0]['Admin']);
		
		$this->layout = 'admin_small';

		$exercises = $this->Exercise->find('all');
		$this->set('exercises', $exercises);
	}

	public function delete_exercise_attribute()
	{
		if($this->request->is('post'))
		{
			if($this->request->data)
			{
				$this->loadModel('ExerciseAttribute');
				if($this->ExerciseAttribute->delete($this->request->data['attribute_id']))
					$data['success'] = 'true';
				else
					$data['success'] = 'false';
			}
		}
		else
			$data['success'] = 'false';

		echo json_encode($data);
		die();
	}

}
