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
		$count = 0;

		if(isset($workoutData[0]['WorkoutAttribute']))
		{
			foreach($workoutData[0]['WorkoutAttribute'] as $userAttributes)
			{
				if(isset($userAttributes['WorkoutUserAttributeDetail']))
				{
					foreach($userAttributes['WorkoutUserAttributeDetail'] as $attributes)
					{
						$data[$attributes['group']]['created'] = date("F j, Y, g:i a" , strtotime($attributes['created']));
						$data[$attributes['group']]['data'][] = $attributes;
					}
						

					$workoutData[0]['WorkoutAttribute'][$count]['WorkoutUserAttributeDetail'] = $data;
					$data = NULL;
				}
				$count++;
			}
		}

		$count = 0;
		if(isset($workoutData[0]['WorkoutTemplate']))
		{
			foreach($workoutData[0]['WorkoutTemplate'] as $userTemplate)
			{
				if(isset($userTemplate['WorkoutUserTemplateDetail']))
				{

					foreach($userTemplate['WorkoutUserTemplateDetail'] as $template)
					{
						$dataTemplate[$template['group']]['created'] = date("F j, Y, g:i a" , strtotime($template['created']));
						$dataTemplate[$template['group']]['data'][] = $template;
					}

					$workoutData[0]['WorkoutTemplate'][$count]['WorkoutUserTemplateDetail'] = $dataTemplate;
					$dataTemplate = NULL;
				}
				$count++;
			}
		}

		$this->set('workout', $workoutData[0]);
	}
}