<?php


App::uses('AppController', 'Controller');

class SkillsController extends AppController 
{
	public $scaffold = 'admin';
	public $uses = array('SkillLevel');

	public function index($id = NULL, $type = NULL) 
	{

		if(CakeSession::read('userDetails'))
		{
			$user = CakeSession::read('userDetails');
			$gender = $user['Member']['gender'];
		}
		else
			$gender = 'M';

		$title_for_layout = 'Commander HQ | Member Home';
		if(!isset($id) && !isset($type))
		{
			$this->SkillLevel->recursive = 2;
			$skillLevels = $this->SkillLevel->find('all');
			$this->set('skills', $skillLevels);
		}
		else
		{
			if($id != NULL)
			{
				if($type != NULL)
				{
					$counter = 0;
					$this->SkillLevel->SkillLevelDetail->recursive = 2;

					$conditions = array(
						'conditions' => array(
							'SkillLevelDetail.skill_level_id' => $id,
							'SkillLevelDetail.gender' => $gender
						)
					);

					$skillLevels = $this->SkillLevel->SkillLevelDetail->find('all', $conditions);

					//pr($type);

					foreach($skillLevels as $skill)
					{
						if(isset($skill['Exercise']['ExerciseType']))
						{
							if($skill['Exercise']['ExerciseType']['id'] == $type)
								$return[$counter] = $skill;

							$counter++;
						}
					}

					$this->set('skill_details', $return);

				}
				else
				{
					$this->loadModel('ExerciseType');
					$data = $this->ExerciseType->find('list', array('conditions' => array('active' => 1)));
					$this->set('exersice_level', $id);
					$this->set('exersice_list', $data);
				}
			}
		}
	}

	public function admin_index()
	{
		$user = CakeSession::read('admin_user');
		$this->set('user', $user[0]['Admin']);
		
		$this->layout = 'admin_small';
		$this->SkillLevel->recursive = 2;
		$skills = $this->SkillLevel->find('all');
		$this->set('skills', $skills);
	}

}
