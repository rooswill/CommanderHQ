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

	public function save_custom_workout()
	{
		CakeSession::write('custom_workout', $this->request->data);
		die();
	}

	public function update_attributes()
	{
		$data = CakeSession::read('custom_workout');
		//CakeSession::write('custom_workout', $this->request->data);

		$data['attributes'][] = $this->request->data;

		pr($data);
		CakeSession::write('custom_workout', $data);
		die();
	}

	public function save_workout_complete()
	{
		$workoutData = CakeSession::read('custom_workout');
		$templateData = $this->request->data;

		$redirect = true;

		$userID = $_COOKIE['UID'];
		$this->loadModel('Member');
		$findUser = $this->Member->find('all', array('conditions' => array('id' => $userID)));

		$this->loadModel('Workout');
		$this->loadModel('WorkoutAttribute');
		$this->loadModel('WorkoutTemplate');
		$this->loadModel('WorkoutAttributeDetail');
		$this->loadModel('WorkoutTemplateDetail');

		if(CakeSession::read('saved_workout'))
			$workD['Workout']['id'] = CakeSession::read('saved_workout');

		$workD['Workout']['member_id'] = $findUser[0]['Member']['id'];
		$workD['Workout']['type'] = $workoutData['exercise_type'];

		if($this->Workout->save($workD))
		{
			$workoutID = $this->Workout->id;
			CakeSession::write('saved_workout', $workoutID);

			if(CakeSession::read('saved_workout_template_id'))
				$workoutTemplateData['WorkoutTemplate']['id'] = CakeSession::read('saved_workout_template_id');

			$workoutTemplateData['WorkoutTemplate']['workout_id'] = $workoutID;
			$workoutTemplateData['WorkoutTemplate']['template_name'] = $workoutData['template_name'];

			if($this->WorkoutTemplate->save($workoutTemplateData))
			{

				$workoutTemplateID = $this->WorkoutTemplate->id;
				CakeSession::write('saved_workout_template_id', $workoutTemplateID);

				foreach($templateData['template_details'] as $tempData)
				{
					$this->WorkoutTemplateDetail->create();
					$workoutTemplateDetailsData['WorkoutTemplateDetail']['workout_template_id'] = $workoutTemplateID;
					$workoutTemplateDetailsData['WorkoutTemplateDetail']['name'] = $tempData['name'];
					$workoutTemplateDetailsData['WorkoutTemplateDetail']['value'] = $tempData['value'];
					$this->WorkoutTemplateDetail->save($workoutTemplateDetailsData);
				}
			}
			else
				$redirect = false;

			foreach($workoutData['attributes'] as $attributes)
			{
				$attributeData['WorkoutAttribute']['workout_id'] = $workoutID;
				$attributeData['WorkoutAttribute']['name'] = $attributes['name'];
				$this->WorkoutAttribute->create();
				if($this->WorkoutAttribute->save($attributeData))
				{
					$workoutAttributeID = $this->WorkoutAttribute->id;
					foreach($attributes['attribute'] as $a)
					{
						$this->WorkoutAttributeDetail->create();
						$aData['WorkoutAttributeDetail']['workout_attribute_id'] = $workoutAttributeID;
						$aData['WorkoutAttributeDetail']['name'] = $a['name'];
						$aData['WorkoutAttributeDetail']['value'] = $a['value'];
						$this->WorkoutAttributeDetail->save($aData);
					}
				}
				else
					$redirect = false;
			}
		}
		else
			$redirect = false;

		CakeSession::destroy('custom_workout');
		CakeSession::destroy('saved_workout_template_id');
		CakeSession::destroy('saved_workout');

		echo json_encode($redirect);

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
					$attribute .= '<span class="AttributeLabel">'.$attributes['name'].' : </span>';
					$attribute .= '<span class="AttributeInput">';
							$attribute .= '<input class="textinput ui-input-text ui-body-c exercise_details" type="text" id="attribute_value_'.$counter.'" name="'.str_replace(" ", "_", strtolower($attributes['name'])).'">';
					$attribute .= '</span>';
					$attribute .= '<div style="clear:both;"></div>';
				$attribute .= '</div>';
				$counter++;
			}

			$attribute .= "<div class='save-activity' onclick='saveActivity(this);'>Save Activity</div>";


		}

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

	public function save_updated_workout()
	{
		if(isset($this->request->data))
		{
			$randomGroup['WorkoutUserTemplateDetail'] = $this->generateRandomString();
			$randomGroup['WorkoutUserAttributeDetail'] = $this->generateRandomString();

			foreach($this->request->data as $key => $data)
			{
				if($key == 'workoutID')
				{
					$this->loadModel('Workout');
					$updateWorkout['Workout']['id'] = $data;
					$updateWorkout['Workout']['complete'] = 1;
					$this->Workout->save($updateWorkout);
				}
				else
				{
					$this->loadModel($key);

					foreach($data as $d)
					{
						$this->{$key}->create();
						foreach($d as $dKey => $dValue)
						{
							$update[$key]['group'] = $randomGroup[$key];
							$update[$key][$dKey] = $dValue;
						}
						$this->{$key}->save($update);
					}
				}
			}

			die();
		}
	}

	public function generateRandomString($length = 10) 
	{
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

}