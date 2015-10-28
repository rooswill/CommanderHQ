<?php

App::uses('AppController', 'Controller');
CakePlugin::load('Uploader');
App::import('Vendor', 'Uploader.Uploader');

class MembersController extends AppController 
{

	public $scaffold = 'admin';

	public $uses = array();
	public $components = array('RequestHandler', 'Sms', 'Facebook');
	public $html;
	public $workout;


	public function beforeFilter()
	{
		parent::beforeFilter();
		$memberStatus = $this->memberStatus();
		
		// if($memberStatus['type'] != 'success' && $this->view != 'login' && $this->view != 'signup' && $this->view != 'verify')
		// 	$this->redirect('/members/login');

		if (isset($this->request->query['WorkoutId']) && $this->request->query['WorkoutId'] > 0) 
        {
            if (!isset($this->request->query['WorkoutTypeId']) || $this->request->query['WorkoutTypeId'] == 1) 
                $this->workout = $this->Member->getCustomDetails($this->request->query['WorkoutId']);
        }

  //       App::uses('Paypal', 'Paypal.Lib');

  //       $this->Paypal = new Paypal(array(
		//     'sandboxMode' => true,
		//     'nvpUsername' => 'will.roos-selling_api1.ogilvy.co.za',
		//     'nvpPassword' => '6M7TDUZ3D99SCF2T',
		//     'nvpSignature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AQC-r0UBkjXyg2Yvvo9zmfRkVDIG'
		// ));
	}

	// admin functions 

	public function admin_index()
	{
		$this->layout = 'admin';
		$user = CakeSession::read('admin_user');
		$this->set('user', $user[0]['Admin']);

		$this->Member->recursive = 2;

        $this->paginate = array(
            'order' => array('created' => 'desc')
        );

        $this->set('members', $this->paginate());

        if (isset($this->request->params['paging']['Member']['page'])) {
            $this->Session->write('page', $this->request->params['paging']['Member']['page']);
        }

	}

	public function admin_view($id = null) 
    {
    	$this->layout = 'admin';
		$user = CakeSession::read('admin_user');
		$this->set('user', $user[0]['Admin']);

        if(CakeSession::read('admin_user'))
        {
            if (!$this->Member->exists($id)) {
                throw new NotFoundException(__('Invalid User'));
            }
            $this->set('member', $this->Member->find('first'));
        }
        else
            $this->redirect('/admin');
    }

	public function index() 
	{
		$title_for_layout = 'Commander HQ | Member Home';
		$memberStatus = $this->memberStatus();
		if($memberStatus['type'] == 'success')
		{
			$userID = $_COOKIE['UID'];
			$findUser = $this->Member->find('all', array('conditions' => array('id' => $userID)));

			CakeSession::write('userDetails', $findUser[0]);

			if($findUser[0]['MemberSubscription'][0]['active'] == 1)
				$this->set('subscribed', 1);
			else
				$this->set('subscribed', 0);
		}
		else
		{
			$this->redirect('/members/login');
		}
	}

	public function baseline()
	{
		$title_for_layout = 'Commander HQ | Member Baselines';	
	}

	public function cancellation()
	{
		$title_for_layout = 'Commander HQ | Member Cancellation';	
	}

	public function wod_completed()
	{
		$title_for_layout = 'Commander HQ | Completed Workouts of the Day';	
	}

	public function wod_custom()
	{
		$title_for_layout = 'Commander HQ | Custom Workout Of The Day';	
	}

	public function forgot()
	{
		$title_for_layout = 'Commander HQ | Forgot Password';	
	}

	public function goals()
	{
		$title_for_layout = 'Commander HQ | Member Goals';	
	}

	public function invalid_access()
	{
		$title_for_layout = 'Commander HQ | Invalid Access';	
	}

	public function login()
	{
		$title_for_layout = 'Commander HQ | Member Login';

		if($this->request->is('post'))
		{
			if($this->request->data)
			{
				if($this->request->data['username'] != '' && $this->request->data['password'] != '')
				{
					$data = $this->Member->login($this->request->data['username'], $this->request->data['password']);

					if (!$data[0]) 
					{
						$message = array(
				            'text' => __('user_details_not_found'),
				            'type' => 'failed',
				            'data' => 'Hmm, we don\'t seem to recognise you. It may just be all the workouts, but please try again.'
				        );
				        $this->set('error_message', $message);
					} 
					else if($data[1] == 0 || $data[1] == NULL) 
					{
						$message = array(
				            'text' => __('user_not_verified'),
				            'type' => 'failed',
				            'data' => 'Hmm, it doesn\'t seem you have verified your account yet. It may just be all the workouts, but make sure you have verified your account first and then please try login again.'
				        );
				        $this->set('error_message', $message);
					} 
					else 
					{
						
						if(isset($this->request->data['remember']) && $this->request->data['remember'] == true)
						{
							CakeSession::write('remember', $data[0]);
							CakeSession::write('UID', $data[0]);
							setcookie("UID", $data[0], time() + (20 * 365 * 24 * 60 * 60), '/', 'commander.local', false, false);
						}
						else
						{
							CakeSession::write('UID', $data[0]);
							setcookie("UID", $data[0], time() + (20 * 365 * 24 * 60 * 60), '/', 'commander.local', false, false);
						}

						$this->redirect('/members');
					}
				}
				else
				{
					$message = array(
			            'text' => __('no_details_received'),
			            'type' => 'failed',
			            'data' => NULL
			        );
				}
			}
			else
			{
				$message = array(
		            'text' => __('no_details_received'),
		            'type' => 'failed',
		            'data' => NULL
		        );
			}
		}
	}

	public function logout()
	{
		$title_for_layout = 'Commander HQ | Member Logout';	
	}

	public function my_gym()
	{
		$title_for_layout = 'Commander HQ | My Gym';	
	}

	public function wod_personal()
	{
		$title_for_layout = 'Commander HQ | Personal Workout Of The Day';	
	}

	public function profile()
	{
		$title_for_layout = 'Commander HQ | Member Profile';
		$userID = $_COOKIE['UID'];

		setcookie("user_id", "fasfsdfd", time() + (20 * 365 * 24 * 60 * 60), '/', 'commander.local', false, false);

		$this->Member->recursive = 2;
		$findUser = $this->Member->find('all', array('conditions' => array('id' => $userID)));
		$this->loadModel('Workout');
		$user_workouts = $this->Workout->find('count', array('conditions' => array('member_id' => $userID)));
		$this->set('user_workouts', $user_workouts);

		if($findUser[0]['MemberSubscription'][0]['affiliate_id'] != NULL || $findUser[0]['MemberSubscription'][0]['affiliate_id'] != '')
		{
			$this->loadModel('Affiliate');
			$member_gym = $this->Affiliate->find('list', array('conditions' => array('id' => $findUser[0]['MemberSubscription'][0]['affiliate_id'])));
			
			foreach($member_gym as $key => $name)
				$gym_name = $name;

			$this->set('member_gym', $gym_name);
		}

		//pr($findUser);

		if(count($findUser) > 0)
		{
			$message = array(
	            'text' => __('user_found'),
	            'type' => 'success',
	            'data' => $findUser[0]
	        );
		}
		else
		{
			$message = array(
	            'text' => __('user_id_not_found'),
	            'type' => 'failed',
	            'data' => NULL
	        );
		}

		$this->set('profile', $message);

	}

	public function edit($id = NULL)
	{
        $this->Member->id = $id;

        // if (!$this->Member->exists()) {
        //     throw new NotFoundException(__('Invalid option submission'));
        // }

        $data_found = $this->Member->read(null, $id);
        $this->set('profile', $data_found);

        //$this->request->data = $this->Member->read(null, $id);

		if($this->request->is('post'))
		{
			$memberUpdate['Member']['id'] = $id;
			$memberUpdate['Member']['name'] = $this->request->data['name'];
			$memberUpdate['Member']['surname'] = $this->request->data['surname'];
			$memberUpdate['Member']['username'] = $this->request->data['username'];
			$memberUpdate['Member']['cellphone'] = $this->request->data['cellphone'];
			$memberUpdate['Member']['email'] = $this->request->data['email'];
			$memberUpdate['Member']['dob'] = $this->request->data['dob'];
			$memberUpdate['Member']['gender'] = $this->request->data['gender'];

			$this->Uploader = new Uploader();
            $this->Uploader->setup(array('uploadDir' => 'img/profile-pictures', 'tempDir' => 'upload'));

            if ($_FILES['profile_picture']['name']) {
                if ($data = $this->Uploader->upload('profile_picture')) {
                    // Upload successful, do whatever
                    $memberUpdate['Member']['profile_picture'] = $data['path'];
                } else {
                    $memberUpdate['Member']['profile_picture'] = $data_found['Member']['profile_picture'];
                }
            } else {
                $memberUpdate['Member']['profile_picture'] = $data_found['Member']['profile_picture'];
            }

			if($this->Member->save($memberUpdate))
			{

				if(isset($this->request->data['affiliate_id']) && $this->request->data['affiliate_id'] != '')
				{
					$this->loadModel('MemberSubscription');
					$find_member_subscription = $this->MemberSubscription->find('all', array('conditions' => array('member_id' => $id)));
					$memberSubscription['MemberSubscription']['id'] = $find_member_subscription[0]['MemberSubscription']['id'];
					$memberSubscription['MemberSubscription']['affiliate_id'] = $this->request->data['affiliate_id'];
					$this->MemberSubscription->save($memberSubscription);
				}

				$this->loadModel('MemberDetail');

				$find_member_details = $this->MemberDetail->find('all', array('conditions' => array('member_id' => $id)));

				$memberDetails['MemberDetail']['id'] = $find_member_details[0]['MemberDetail']['id'];
				$memberDetails['MemberDetail']['system_of_measurement'] = $this->request->data['system_of_measure'];
				$memberDetails['MemberDetail']['weight'] = $this->request->data['weight'];
				$memberDetails['MemberDetail']['height'] = $this->request->data['height'];

				if($this->MemberDetail->save($memberDetails))
					$response = TRUE;
				else
					$response = FALSE;
			}
			else
				$response = FALSE;
			
			if($response)
			{
				$message = array(
		            'text' => __('user_profile_updated'),
		            'type' => 'success',
		            'data' => ''
		        );
			}
			else
			{
				$message = array(
		            'text' => __('user_profile_update_failed'),
		            'type' => 'failed',
		            'data' => ''
		        );
			}

			CakeSession::write('message', $message);
			$this->redirect('/members/profile');

		}

	}

	public function updatePassword()
	{
		if($this->request->is('post'))
		{
			$salt = $this->generateSalt();
			$password = $this->hashPassword($this->request->query['password'], $salt);

			$query = "UPDATE Members SET 
				`PassWord` = '".$password."'
				WHERE 
				`UserId` = ".$this->request->query['UserId'];

			$response = $this->Member->query($query);

			if($response)
			{
				$message = array(
		            'text' => __('password_updated'),
		            'type' => 'success',
		            'data' => ''
		        );
			}
			else
			{
				$message = array(
		            'text' => __('password_could_not_update'),
		            'type' => 'failed',
		            'data' => ''
		        );
			}
		}
	}

	public function progress($attribute = NULL, $details = NULL)
	{
		$title_for_layout = 'Commander HQ | Member Progress';
		if(isset($attribute))
		{
			if(isset($details))
			{
				$this->set('title', ucfirst($attribute));
				$this->render('progress_details');
			}
			else
			{
				$this->set('title', ucfirst($attribute));
				$this->render('progress_summary');
			}
		}
	}

	public function register_gym()
	{
		$title_for_layout = 'Commander HQ | Register Gym';	
	}

	public function reset()
	{
		$title_for_layout = 'Commander HQ | Password Reset';	
	}

	public function signup()
	{
		$title_for_layout = 'Commander HQ | Member Signup';

		if($this->request->is('post'))
		{
			if($this->request->data)
			{
				$checkUser = $this->Member->find('all', array('conditions' => array('email' => addslashes($this->request->data['Email']))));
				if(count($checkUser) > 0)
				{
					$message = array(
			            'text' => __('User found in DB'),
			            'type' => 'failed',
			            'data' => $checkUser
			        );
					CakeSession::write('UID', $checkUser);
					setcookie("UID", $checkUser, time() + (20 * 365 * 24 * 60 * 60), '/', 'commander.local', false, false);

				}
				else
				{
					$verificationCode = substr(number_format(time() * rand(), 0, '', ''), 0, 8);

					$salt = $this->generateSalt();
					$password = $this->hashPassword($this->request->data['PassWord'], $salt);

					$data['Member']['name']  = $this->request->data['FirstName'];
					$data['Member']['surname'] = $this->request->data['LastName'];
					$data['Member']['cellphone'] = $this->request->data['Cell'];
					$data['Member']['email'] = $this->request->data['Email'];
					$data['Member']['gender'] = $this->request->data['Gender'];
					$data['Member']['username'] = $this->request->data['UserName'];
					$data['Member']['password'] = $password;
					$data['Member']['salt'] = $salt ;
					$data['Member']['verification_code'] = $verificationCode;
					$data['Member']['terms'] = 0;

					$system_of_measurement = $this->request->data['SystemOfMeasure'];

					// save user details
					$this->Member->create();
					if($this->Member->save($data))
					{
						$id = $this->Member->id;

						$this->loadModel('MemberDetail');
						$this->loadModel('MemberSubscription');

						$memberDetail['MemberDetail']['member_id'] = $id;
						$memberDetail['MemberDetail']['skill_level'] = 1;
						$memberDetail['MemberDetail']['system_of_measurement'] = $system_of_measurement;
						$this->MemberDetail->save($memberDetail);

						$memberSubscription['MemberSubscription']['member_id'] = $id;
						$memberSubscription['MemberSubscription']['active'] = 0;
						$this->MemberSubscription->save($memberSubscription);

						$textMessage = 'So are you ready to be part of Commander HQ? Your verification code to get started is ' . $verificationCode . '. What are you waiting for? ';
						$textMessage .= "\n";
						$textMessage .= 'To complete your registration visit ' . $this->getTinyUrl('http://'.THIS_DOMAIN.'/members/verify?id=' . $id);

						$sms = $this->Sms->setValues(1222, trim($this->request->data['Cell']), $textMessage, 3, 0, SMS_FROM_NUMBER, 0, null, null);
						$smsResult = $this->Sms->Send();

						$message = array(
				            'text' => __('User created'),
				            'type' => 'success',
				            'data' => $data
				        );

				        CakeSession::write('UID', $id);
				        setcookie("UID", $id, time() + (20 * 365 * 24 * 60 * 60), '/', 'commander.local', false, false);

					}
				}
			}
			echo json_encode($message);
			die();
		}
	}

	public function verify($user_id = NULL, $code = NULL)
	{
		$title_for_layout = 'Commander HQ | Member Verification';
		if(isset($user_id) && isset($code))
		{
			$user = $this->Member->find('all', array('conditions' => array('id' => $user_id)));
			foreach($user as $u)
			{
				$this->Member->id = $u['Member']['id'];
				if($u['Member']['verification_code'] == $code)
				{
					$results = $this->Member->_verifyUser($u['Member']['id']);
					if($results)
						$this->set('status_message', 'Your account has been verified, thank you.');
					else
						$this->set('status_message', 'Your account could not be verified, please try again later.');
				}
			}
		}
		else
		{
			$this->set('status_message', 'Hold on! That account couldn\'t be found, please make sure you have clicked on the correct link in the sms.');
		}
	}

	public function templatesRender()
	{
		$template = $this->request->data['template'];
		
		if($template != '' && $template != NULL)
			return $this->render('/Elements/workouts/'.$template);
		else
			return false;

		die();
	}

	public function workouts($page = NULL)
	{
		$title_for_layout = 'Commander HQ | Workout Of The Day';

		$this->set('activities', $this->activities);
		$this->set('exercise_list', $this->exercise);
		$this->set('templates', $this->templates);

		if(isset($page))
		{
			$data = NULL;
			switch ($page) {
				case 'personal':
					$data = $this->personalWodOutput();
					break;
				case 'completed':
					$data = $this->completedWorkouts();
					break;
				case 'custom':
					if($this->request->is('post'))
					{
						$this->loadModel('Workout');
						$data['Workout']['name'] = $this->request->data['workout_name'];
						$data['Workout']['notes'] = $this->request->data['workout_description'];
						$data['Workout']['member_id'] = $_COOKIE['UID'];
						
						if(isset($this->request->data['is_amrap']))
						{
							$data['Workout']['is_amrap'] = $this->request->data['is_amrap'];

							if($this->request->data['amrapTime'] != '' && $this->request->data['amrapTime'] != NULL)
								$data['Workout']['amrap_time'] = $this->request->data['amrap_time'];
						}

						$check_workouts = $this->Workout->find('list', array('conditions' => array('name' => $this->request->data['workout_name'])));
						
						if(count($check_workouts) <= 0)
						{
							if($this->Workout->save($data))
								$this->set('message', 'Workout saved');
						}
						else
							$this->set('message', 'Workout already in our database, <a href="/members/workouts/custom/edit/'.$check_workouts[0]['id'].'">edit previous workout</a>.');
					}
					break;
				
				default:
					$data = NULL;
					// no functions needed.
					break;
			}

			$this->set('data', $data);
			$this->render($page);
		}
	}

	public function completedWorkouts()
	{
		$this->loadModel('Workout');
		$data = $this->Workout->find('all', array('conditions' => array('member_id' => $_COOKIE['UID'])));
		return $data;
	}

	public function memberStatus()
	{
		if(isset($_COOKIE['UID']))
		{
			$message = array(
	            'text' => __('User Found'),
	            'type' => 'success',
	            'data' => $_COOKIE['UID']
	        );
		}
		else
		{
			$message = array(
	            'text' => __('User Not Found'),
	            'type' => 'failed',
	            'data' => 'no_user_found'
	        );
		}

		return $message;
	}

	public function checksubscription()
	{
		$userID = $_COOKIE['UID'];
		$memberDetails = $this->Member->query('SELECT Members.UserId, Members.FirstName, Members.LastName, MemberDetails.MemberId, MemberDetails.Subscribed FROM Members JOIN MemberDetails ON MemberDetails.MemberId = Members.UserId WHERE Members.UserId = '.$userID);

		pr($memberDetails);

		die();
	}

	public function subscribe()
	{

		$order = array(
		    'description' => 'Your purchase with Acme clothes store',
		    'currency' => 'GBP',
		    'return' => 'http://commander.local/members/subscribe',
		    'cancel' => 'https://www.my-amazing-clothes-store.com/checkout.php',
		    'custom' => 'bingbong',
		    'shipping' => '4.50',
		    'items' => array(
		        0 => array(
		            'name' => 'Blue shoes',
		            'description' => 'A pair of really great blue shoes',
		            'tax' => 2.00,
		            'subtotal' => 8.00,
		            'qty' => 1,
		        ),
		        1 => array(
		            'name' => 'Red trousers',
		            'description' => 'Tight pair of red pants, look good with a hat.',
		            'tax' => 1.50,
		            'subtotal' => 6.00,
		            'qty' => 3,
		        ),
		    )
		);

		if(!isset($this->request->query['token']) && !isset($this->request->query['PayerID']))
		{
		 	try 
		 	{
			    $data = $this->Paypal->setExpressCheckout($order);
			    $this->redirect($data);
			} 
			catch (Exception $e) 
			{
				echo $e->getMessage();
			}
		}

		if(isset($this->request->query['token']))
		{
			$token = $this->request->query['token'];
			$paymentDetails = $this->Paypal->getExpressCheckoutDetails($token);

			if($this->request->query['PayerID'])
			{
				$payerId = $this->request->query['PayerID'];
				try 
				{
				    $data = $this->Paypal->doExpressCheckoutPayment($order, $token, $payerId);
				    pr($data);
				} 
				catch (PaypalRedirectException $e) 
				{
				    $this->redirect($e->getMessage());
				} 
				catch (Exception $e) {
				    // $e->getMessage();
				}
			}
		} 

		die();
	}

	public function wod_output($DuplicateAmrapRound = 0, $WorkoutId = NULL, $WodTypeId = NULL, $historyLimit = 15, $workOutPage = NULL) 
	{
		$this->html = '';
		
		$WorkoutId = $WorkoutId;
		$WodTypeId = (int)$WodTypeId;
		$Model->setIsAmrap($WorkoutId, $WodTypeId);
		
		$BaselineId = $Model->IsBaselineWOD($WorkoutId, $WodTypeId);
		$OldWodTypeId = $WodTypeId;
		
		if($BaselineId > 0) {
			$WodTypeId = 7;
		}
		
		switch($WodTypeId) {
			case 1: // Custom
				$this->Workout = $this->Member->getCustomDetails($WorkoutId);
				break;
			case 2: // Well Rounded
			case 4: // Advanced
			case 6: // Challenge
				$this->Workout = $this->Member->getWODDetails($WodTypeId, $WorkoutId);
				break;
			case 3: // Benchmark
				$this->Workout = $this->Member->getBenchmarkDetails($WorkoutId);
				break;
			case 7:
				$this->Workout = $this->Member->getBaselineDetails($BaselineId, $WorkoutId, $OldWodTypeId);
				$WodTypeId = $OldWodTypeId; // Put the old WOD Type back otherwise we are going to have WODs flying into black holes!
				break;
		}
		switch($workOutPage) 
		{
			case 'progress':
				$this->html .= $this->TopSelection(false);

                if ($DuplicateAmrapRound == 1) 
					return $this->BuildWorkout($this->Workout, $WodTypeId, $WorkoutId, '', true);
                else 
					$this->html .= $this->BuildWorkout($this->Workout, $WodTypeId, $WorkoutId, '', false);

				$this->html .= $this->MakeWODFooter($WorkoutId, $WodTypeId, count($this->Workout), null, $Model->isAmrap, $this->Workout[0]->Category);
				break;
			default:
				$this->html .= $this->TopSelection(false);

                if ($DuplicateAmrapRound == 1) 
                	return $this->BuildWorkout($this->Workout, $WodTypeId, $WorkoutId, '', true);
                else 
					$this->html .= $this->BuildWorkout($this->Workout, $WodTypeId, $WorkoutId, '', false);

				$this->html .= $this->MakeWODFooter($WorkoutId, $WodTypeId, count($this->Workout), null, $Model->isAmrap, $this->Workout[0]->Category);
				break;
		}
		return $this->html;
	}

	function TopSelection($DisplayHeading=true) {
		$this->html = $DisplayHeading ? '<h1 class="ui-li-heading">' . $this->Workout[0]->WorkoutName . '</h1>' : '';
		#$this->html .= $this->MakeDescription($this->Workout[0]->Notes);
		return $this->html;
	}

	public function test_sms()
	{
		$textMessage = 'So are you ready to be part of Commander HQ? Your verification code to get started is 34256457653. What are you waiting for? ';
		$textMessage .= "\n";
		$textMessage .= 'To complete your registration visit ' . $this->getTinyUrl('http://commander.local/members/verify?id=324234');

		$sms = $this->Sms->setValues(1222, '+27810255611', $textMessage, 3, 0, SMS_FROM_NUMBER, 0, null, null);
		$smsResult = $this->Sms->Send();

		pr($smsResult);
		die();
	}

	public function benchmark($id = NULL)
	{
		$this->loadModel('Benchmark');
		$counter = 0;
		if($id != NULL)
		{
			$this->Benchmark->recursive = 2;
			$benchmark = $this->Benchmark->find('all', array('conditions' => array('id' => $id)));

			foreach($benchmark[0]['Exercise'] as $exercise)
			{
				$exercise_array['round'][$exercise['BenchmarkDetail']['round_nr']][$counter] = $exercise;
				$counter++;
			}
			$this->set('benchmark_details', $benchmark);
			$this->set('exercise_details', $exercise_array);
		}
		else
		{
			$this->Benchmark->recursive = 0;
			$benchmark = $this->Benchmark->find('all');
			$this->set('benchmarks', $benchmark);
		}
	}

	public function getWorkoutList($Category) 
	{
		$this->loadModel('Benchmark');
		$counter = 0;

		foreach ($Category AS $Workout) 
		{
			$Description = $this->Benchmark->getBenchmarkDescription($Workout['BW']['Id']);

			$data[$counter]['id'] = $Workout['BW']['Id'];
			$data[$counter]['category'] = $Workout['BC']['Category'];
			$data[$counter]['workout_name'] = $Workout['BW']['WorkoutName'];
			$data[$counter]['description'] = $Description;

			$counter++;
		}

		return $data;
	}

	public function getCustomMemberWorkouts() {
		$this->html = '';
		$this->loadModel('Benchmark');
		$CustomMemberWorkouts = $this->Benchmark->getCustomMemberWorkouts();
		if (empty($CustomMemberWorkouts)) {
			$this->html .= '<br/>Oops! You have not recorded any Custom Workouts yet.';
		} else {
			$this->html .= '<ul class="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';
			foreach ($CustomMemberWorkouts AS $Workout) {
				$Description = $this->Benchmark->getCustomDescription($Workout->recid);
				$this->html .= '<li>';
				$this->html .= '<a href="" onclick="getCustomDetails(\'' . $Workout->recid . '\', \'' . $this->Origin . '\');">' . $Workout->WorkoutName . ':<br/><span style="font-size:small">' . $Description . '</span></a>';
				$this->html .= '</li>';
			}
			$this->html .= '</ul><br/>';
		}
		return $this->html;
	}

	public function getCustomPublicWorkouts() {
		$this->html = '';

		$CustomPublicWorkouts = $Model->getCustomPublicWorkouts();

		if (empty($CustomPublicWorkouts)) 
		{
			$this->html .= '<br/>Looks like there are none yet!';
		} 
		else 
		{
			$this->html .= '<ul class="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="none">';
			foreach ($CustomPublicWorkouts AS $Workout) {
				$Description = $this->Benchmark->getCustomDescription($Workout->recid);
				$this->html .= '<li>';
				$this->html .= '<a href="" onclick="getCustomDetails(\'' . $Workout->recid . '\', \'' . $this->Origin . '\');">' . $Workout->WorkoutName . ':<br/><span style="font-size:small">' . $Description . '</span></a>';
				$this->html .= '</li>';
			}
			$this->html .= '</ul><br/>';
		}
		return $this->html;
	}

	public function getHistory() {
		$HistoricalData = $this->Benchmark->getHistory();
		if (empty($HistoricalData)) {
			$History = 'Oops! You have not recorded any Benchmark workouts yet.';
		} else {
			foreach ($HistoricalData AS $Data) {
				$History.='' . $Data->TimeCreated . ' : ' . $Data->Name . ' : ' . $Data->AttributeValue . '<br/>';
			}
		}
		return $History;
	}

	public function topBenchmarkSelection() {

		$Description = $this->Benchmark->getBenchmarkDescription($this->Benchmark->Id);
		$this->html = '<h1>WOD: ' . $this->Benchmark->WorkoutName . '</h1>';
		return $this->html;
	}

	public function getRoutineBenchmark($routine = NULL)
	{
		$counter = 0;
		foreach($routine as $benchmark)
		{
			//pr($benchmark);
			$returnData['workout_id'] = $benchmark['BW']['Id'];
			$returnData['workout_name'] = $benchmark['BW']['WorkoutName'];
			$returnData['workout_isamrap'] = $benchmark['BW']['IsAmrap'];
			$returnData['workout_amrap_time'] = $benchmark['BW']['AmrapTime'];
			$returnData['workout_amrap_notes'] = $benchmark['BW']['Notes'];
			$returnData['workout_video_id'] = $benchmark['BW']['VideoId'];
			$returnData['workout_category'] = $benchmark['BC']['Category'];

			$returnData['workout_exercises']['routine_'.$benchmark[0]['RoutineNo']]['round_'.$benchmark['BD']['RoundNo']][$counter]['exercise_name'] = $benchmark['E']['Exercise'];
			$returnData['workout_exercises']['routine_'.$benchmark[0]['RoutineNo']]['round_'.$benchmark['BD']['RoundNo']][$counter]['exercise_id'] = $benchmark['E']['ExerciseId'];
			$returnData['workout_exercises']['routine_'.$benchmark[0]['RoutineNo']]['round_'.$benchmark['BD']['RoundNo']][$counter]['workout_type_id'] = $benchmark[0]['WodTypeId'];
			$returnData['workout_exercises']['routine_'.$benchmark[0]['RoutineNo']]['round_'.$benchmark['BD']['RoundNo']][$counter]['exercise_routine_nr'] = $benchmark[0]['RoutineNo'];
			$returnData['workout_exercises']['routine_'.$benchmark[0]['RoutineNo']]['round_'.$benchmark['BD']['RoundNo']][$counter]['exercise_total_rounds'] = $benchmark[0]['TotalRounds'];
			$returnData['workout_exercises']['routine_'.$benchmark[0]['RoutineNo']]['round_'.$benchmark['BD']['RoundNo']][$counter]['exercise_attributes'] = $benchmark['A']['Attribute'];
			$returnData['workout_exercises']['routine_'.$benchmark[0]['RoutineNo']]['round_'.$benchmark['BD']['RoundNo']][$counter]['exercise_attribute_value'] = $benchmark['BD']['AttributeValue'];
			$returnData['workout_exercises']['routine_'.$benchmark[0]['RoutineNo']]['round_'.$benchmark['BD']['RoundNo']][$counter]['exercise_unit_of_measurement_id'] = $benchmark['BD']['UnitOfMeasureId'];
			$returnData['workout_exercises']['routine_'.$benchmark[0]['RoutineNo']]['round_'.$benchmark['BD']['RoundNo']][$counter]['exercise_round_nr'] = $benchmark['BD']['RoundNo'];
			$returnData['workout_exercises']['routine_'.$benchmark[0]['RoutineNo']]['round_'.$benchmark['BD']['RoundNo']][$counter]['exercise_order_by'] = $benchmark['BD']['OrderBy'];
			$returnData['workout_exercises']['routine_'.$benchmark[0]['RoutineNo']]['round_'.$benchmark['BD']['RoundNo']][$counter]['exercise_default_order_by'] = $benchmark['BD']['DefaultOrderBy'];
			$returnData['workout_exercises']['routine_'.$benchmark[0]['RoutineNo']]['round_'.$benchmark['BD']['RoundNo']][$counter]['exercise_unit_of_measurement'] = $benchmark['UOM']['UnitOfMeasure'];
			$returnData['workout_exercises']['routine_'.$benchmark[0]['RoutineNo']]['round_'.$benchmark['BD']['RoundNo']][$counter]['exercise_conversion_factor'] = $benchmark['UOM']['ConversionFactor'];

			$counter++;
		}

		return $returnData;
	}

	public function BuildWorkout($WodDetails, $WorkoutTypeId, $WorkoutId, $escape = '', $DuplicateAmrapRound = false) 
	{
		if (isset($this->request->query['WorkoutPage']) and $this->request->query['WorkoutPage'] == 'progress') {
			$report_type = $this->getWodTypeName($WorkoutTypeId);
			MixpanelUtil::trackWODReportPulled($_COOKIE['UID'], $this->UsersName(), $report_type, $this->getWorkoutName($WorkoutId, $WorkoutTypeId));
		}

		$this->html = '';
		$ThisRoutineNo = '';
		$ThisRoundNo = '';
		$ThisOrderBy = '';
		$Attributes = array();
		$ThisExerciseId = 0;
		$i = 0;
		$j = 0;
		$RoutineCounter = 0;
		$RoundCounter = 0;
		$WorkoutName = $WodDetails[0]['BW']['WorkoutName'];
		$Notes = $WodDetails[0]['BW']['Notes'];
		$IsAmrap = $WodDetails[0]['BW']['IsAmrap'];
		$AmrapTime = '';
		$AttributeCount = 0;

		if ($IsAmrap) {
			$AmrapTime = ' (' . $this->Benchmark->formatMilliseconds($WodDetails[0]['BW']['AmrapTime']) . ')';
			$AttributeCount = $this->Benchmark->getAttributeCount($WorkoutId, $WorkoutTypeId);
		}

		// // Display the <h2> heading where applicable
		$this->html .= $WorkoutName <> '' ? '<h2>' . strtoupper($WorkoutName) . $AmrapTime . '</h2>' : '';

		// // Display the description where applicable
		$this->html .= $Notes;
		
		$this->html .= '<div data-role="collapsible" data-collapsed="false" data-iconpos="right" data-collapsed-icon="arrow-r" and data-expanded-icon="arrow-d" class="RoutineBlock">';
		foreach ($WodDetails as $Detail) 
		{
			if ($Detail['BD']['UnitOfMeasureId'] == null || $Detail['BD']['UnitOfMeasureId'] == 0) 
			{
				$UnitOfMeasureId = 0;
				$ConversionFactor = 1;
			} 
			else 
			{
				$UnitOfMeasureId = $Detail['BD']['UnitOfMeasureId'];
				if ($Detail['UOM']['ConversionFactor'] == null || $Detail['UOM']['ConversionFactor'] == 0) 
				{
					$ConversionFactor = 1;
				} 
				else 
				{
					$ConversionFactor = $Detail['UOM']['ConversionFactor'];
				}
			}

			if ($Detail['BD']['AttributeValue'] == '' || $Detail['BD']['AttributeValue'] == 0 || $Detail['BD']['AttributeValue'] == '-') 
			{
				$AttributeValue = 'Max';
			} 
			else 
			{
				$AttributeValue = $Detail['BD']['AttributeValue'] * $ConversionFactor;
			}

			if ($Detail['A']['Attribute'] != 'TimeToComplete') 
			{
				if ($ThisRoutineNo != $Detail[0]['RoutineNo']) 
				{
					if ($Detail['E']['ExerciseId'] != null && $i > 0) 
					{
						$this->html.= $this->setHistoryLine($WorkoutTypeId, $ThisRoutineNo, $ThisRoundNo, $ThisOrderBy, $ThisExerciseId, $WorkoutId, $DefaultOrderBy, $IsAmrap);
						$j = 0;
						if ($this->request->query['WorkoutPage'] !== 'completed') 
						{
							list($Attribute, $this->html_input) = $this->MakeExerciseInputBoxes($WorkoutId, $ThisRoutineNo, $ThisRoundNo, $ThisOrderBy, $ThisExerciseId, $Attributes, $IsAmrap);
							$this->html .= $this->html_input;
							$Attributes = array();
							$this->html .= $this->MakeSaveActivityButton($ThisRoutineNo, $ThisRoundNo, $ThisExerciseId, $ThisOrderBy, $escape, $WorkoutId, $WorkoutTypeId);
							$this->html .= '</div><!--AttributeContainer-->';
							$this->html .= $this->MakeCloseActivityAttributes();
						}
						$this->html .= $this->MakeFlipTimerButton($ThisRoutineNo, $WorkoutTypeId, $WorkoutId, $escape);
					}
					$RoutineCounter++;
					$RoundCounter = 1;
					$this->html.= $RoutineCounter == 1 ? '' : '</div><!--RoutineBlock ' . ($RoutineCounter - 1) . '--><div data-role="collapsible" data-collapsed="false" data-iconpos="right" data-collapsed-icon="arrow-r" and data-expanded-icon="arrow-d" class="RoutineBlock">';
					$this->html.= $this->MakeRoutine($RoutineCounter, $WorkoutId);
					$this->html.= $this->MakeRound($RoundCounter);

					if ($DuplicateAmrapRound) 
					{
						$this->html = '';
					}

					$this->html.= $this->MakeExerciseHeader($RoutineCounter, $RoundCounter, $Detail['E']['ExerciseId'], $Detail['BD']['OrderBy'], $Detail['E']['Exercise']);
				} 
				else if ($Detail[0]['TotalRounds'] > 1 && $Detail[0]['RoutineNo'] > 0 && $ThisRoundNo != $Detail[0]['RoutineNo']) 
				{
					if ($Detail['E']['ExerciseId'] != null && $i > 0) 
					{
						$this->html.= $this->setHistoryLine($WorkoutTypeId, $ThisRoutineNo, $ThisRoundNo, $ThisOrderBy, $ThisExerciseId, $WorkoutId, $DefaultOrderBy, $IsAmrap);
						$j = 0;

						if (isset($this->request->query['WorkoutPage']) && $this->request->query['WorkoutPage'] !== 'completed') 
						{
							list($Attribute, $this->html_input) = $this->MakeExerciseInputBoxes($WorkoutId, $ThisRoutineNo, $ThisRoundNo, $ThisOrderBy, $ThisExerciseId, $Attributes, $IsAmrap);
							$this->html .= $this->html_input;
							$Attributes = array();
							$this->html .= $this->MakeSaveActivityButton($ThisRoutineNo, $ThisRoundNo, $ThisExerciseId, $ThisOrderBy, $escape, $WorkoutId, $WorkoutTypeId);
							$this->html .= '</div><!--AttributeContainer-->';
						}

						$this->html .= $this->MakeCloseActivityAttributes();
					}

					$RoundCounter++;
					$this->html.= $this->MakeRound($RoundCounter);

					if ($DuplicateAmrapRound) 
					{
						$this->html = '';
					}

					$this->html.= $this->MakeExerciseHeader($RoutineCounter, $RoundCounter, $Detail['E']['ExerciseId'], $Detail['BD']['OrderBy'], $Detail['E']['Exercise']);
				} 
				else if ($ThisExerciseId != $Detail['E']['ExerciseId'] || $ThisOrderBy != $Detail['BD']['OrderBy']) 
				{
					if ($Detail['E']['ExerciseId'] != null && $i > 0) 
					{
						$this->html .= $this->setHistoryLine($WorkoutTypeId, $ThisRoutineNo, $ThisRoundNo, $ThisOrderBy, $ThisExerciseId, $WorkoutId, $DefaultOrderBy, $IsAmrap);
						$j = 0;

						if (isset($this->request->query['WorkoutPage']) && $this->request->query['WorkoutPage'] !== 'completed') 
						{
							list($Attribute, $this->html_input) = $this->MakeExerciseInputBoxes($WorkoutId, $ThisRoutineNo, $ThisRoundNo, $ThisOrderBy, $ThisExerciseId, $Attributes, $IsAmrap);
							$this->html .= $this->html_input;
							$Attributes = array();
							$this->html .= $this->MakeSaveActivityButton($ThisRoutineNo, $ThisRoundNo, $ThisExerciseId, $ThisOrderBy, $escape, $WorkoutId, $WorkoutTypeId);
							$this->html .= '</div><!--AttributeContainer-->';
						}

						$this->html .= $this->MakeCloseActivityAttributes();
					}
					$this->html .= $this->MakeExerciseHeader($RoutineCounter, $RoundCounter, $Detail['E']['ExerciseId'], $Detail['BD']['OrderBy'], $Detail['E']['Exercise']);
				} 
				else 
				{
					$this->html .='&nbsp;';
				}
				// Set the attributes inside the collapsible block <h4> header
				$DefaultOrderBy = $Detail['BD']['DefaultOrderBy'];
				$this->html .= $this->setDefaultAttributesLine($AttributeValue, $Detail, $UnitOfMeasureId, $WorkoutId, $WorkoutTypeId, $DefaultOrderBy, $IsAmrap);
				$Attributes['' . $Detail['A']['Attribute'] . ''] = $AttributeValue != "-" ? $Detail['UOM']['UnitOfMeasure'] . "|" . $Detail['BD']['UnitOfMeasureId'] : "";
				$ThisRoutineNo = $Detail[0]['RoutineNo'];
				$ThisRoundNo = $Detail['BD']['RoundNo'];
				$ThisOrderBy = $Detail['BD']['OrderBy'];
				$ThisExerciseId = isset($Detail['E']['ExerciseId']) ? $Detail['E']['ExerciseId'] : 0;
			}
			$i++;
		}
		if ($ThisExerciseId != null && $i > 0 && $Attribute != 'TimeToComplete') 
		{
			$this->html .= $this->setHistoryLine($WorkoutTypeId, $ThisRoutineNo, $ThisRoundNo, $ThisOrderBy, $ThisExerciseId, $WorkoutId, $DefaultOrderBy, $IsAmrap);
			$j = 0;

			if (isset($this->request->query['WorkoutPage']) && $this->request->query['WorkoutPage'] !== 'completed') 
			{
				list($Attribute, $this->html_input) = $this->MakeExerciseInputBoxes($WorkoutId, $ThisRoutineNo, $ThisRoundNo, $ThisOrderBy, $ThisExerciseId, $Attributes, $IsAmrap);
				$this->html .= $this->html_input;
				$Attributes = array();
				$this->html .= $this->MakeSaveActivityButton($ThisRoutineNo, $ThisRoundNo, $ThisExerciseId, $ThisOrderBy, $escape, $WorkoutId, $WorkoutTypeId);
				$this->html .= '</div><!--AttributeContainer-->';
			}
		}
		$this->html .= $this->MakeCloseActivityAttributes();

		if ($DuplicateAmrapRound) 
		{
			return $this->html;
		}

		$this->html .= $this->MakeFlipTimerButton($ThisRoutineNo, $WorkoutTypeId, $WorkoutId, $escape);
		$this->html .='<div class="clear"></div>';
		$this->html .='</div><!--RoutineBlock ' . $ThisRoutineNo . '-->';

		return $this->html;
	}

	public function MakeCloseActivityAttributes() {
		if (isset($this->request->query['WorkoutPage']) and $this->request->query['WorkoutPage'] == 'progress') {
			$this->html = '';
		} else {
			$this->html = '</form></div><!--ActivityAttributes--><div class="clear"></div>';
		}
		return $this->html;
	}

	public function MakeFlipTimerButton($ThisRoutineNo, $WorkoutTypeId, $WorkoutId, $escape) {

		$full_access_mode = $this->fullaccess ? 0 : 4;
		if (isset($this->request->query['WorkoutPage']) and ($this->request->query['WorkoutPage'] == 'progress' or $this->request->query['WorkoutPage'] == 'completed')) {
			$TimeToCompleteArr = $this->Benchmark->getWODTimesHistory($WorkoutTypeId, $WorkoutId, $ThisRoutineNo, $this->request->query['HistoryLimit'], $full_access_mode);
			if (sizeof($TimeToCompleteArr) > 0) {
				$this->html = '<div class="time-created">';
				$this->html .= '<div class="time-created-header">Routine completed on the following dates:</div>';
				foreach ($TimeToCompleteArr as $Detail) {
					if ($ThisRoutineNo == $Detail->RoutineNo)
						$this->html .= '<div class="timer-history-line"><span class="time-created-date"><strong>Date:</strong>&nbsp;' . $Detail->TimeCreated . '</span><span class="time-created-time"><strong>Time:</strong>&nbsp;' . $this->Benchmark->formatMilliseconds($Detail->AttributeValue) . '</span></div>';
				}
				$this->html .= '</div><!--timer-history-->';
			} else
				$this->html = '';
		} else {
			$this->html = '<div class="StopwatchContainer" id="' . $ThisRoutineNo . '_timerContainer"></div>';
			$selected_html = '';
			$TimeToComplete = $this->Benchmark->getWODTimes($WorkoutTypeId, $WorkoutId, $ThisRoutineNo, $full_access_mode);
			if (sizeof($TimeToComplete) > 0 or $this->isTimedBenchmark($WorkoutId, $WorkoutTypeId))
				$selected_html = 'selected="true"';
			$this->html.='<div class="ShowHideClock"><label for="fliptimer_' . $ThisRoutineNo . '">Timer:</label><select onchange="DisplayStopwatch(' . $escape . '\'mygym' . $escape . '\', ' . $escape . '\'' . $WorkoutTypeId . '_' . $WorkoutId . '_' . $ThisRoutineNo . '' . $escape . '\', true);" class="fliptimer" name="fliptimer_' . $ThisRoutineNo . '" id="fliptimer_' . $ThisRoutineNo . '" data-role="slider"><option value="0">N/A</option><option value="1" ' . $selected_html . '>On</option></select></div><div class="clear"></div>';
		}
		return $this->html;
	}

	public function MakeRoutine($RoutineCounter, $WorkoutId) {
		$full_access_mode = $this->fullaccess ? 0 : 4;
		list($milliseconds, $prettytime) = $this->getSavedTimeToComplete($WorkoutId, $RoutineCounter, $full_access_mode);
		$this->html = '<h2>Routine ' . $RoutineCounter . '<input type="hidden" name="RoutineTimer_' . $RoutineCounter . '" id="RoutineTimer_' . $RoutineCounter . '" value="' . $prettytime . '" /><input type="hidden" name="RoutineTimerMilli_' . $RoutineCounter . '" id="RoutineTimerMilli_' . $RoutineCounter . '" value="' . $milliseconds . '" /></h2>';
		return $this->html;
	}

	public function isTimedBenchmark($WorkoutId, $WorkoutTypeId) 
	{
		if ($WorkoutTypeId == 3) {
			$is_timed_benchmark = $this->Benchmark->getTimedBenchMark($WorkoutId, $WorkoutTypeId);
		} else
			$is_timed_benchmark = false;
		return $is_timed_benchmark;
	}

	function formatMilliseconds($milliseconds, $DisplayMilliseconds = true, $DisplayHours = false) {
		if(strstr($milliseconds,":") > -1) 
		{
			return $milliseconds;
		}
		if ($milliseconds == '' or $milliseconds == null or (int) $milliseconds == 0) {
			if ($DisplayMilliseconds)
				return '00:00:0';
			else if ($DisplayHours)
				return '00h00';
			else
				return '00:00';
		}
		$seconds = floor($milliseconds / 1000);
		$minutes = floor($seconds / 60);
		$hours = floor($minutes / 60);
		$milliseconds = $milliseconds % 1000;
		$seconds = $seconds % 60;
		$minutes = $minutes % 60;
		if ($DisplayMilliseconds) {
			$format = '%02u:%02u:%01u';
			$time = sprintf($format, $minutes, $seconds, floor($milliseconds / 100));
		} else if ($DisplayHours) {
			$format = '%01uh%02u';
			$time = sprintf($format, $hours, $minutes);
		} else {
			$format = '%02u:%02u';
			$time = sprintf($format, $minutes, $seconds);
		}
		return $time;
	}
	
	function formatBackToMilliseconds($time) {
		$ExplodedTime = explode(":", $time);
		$min = (int)$ExplodedTime[0];
		$sec = (int)$ExplodedTime[1];
		$mil = (int)$ExplodedTime[2];
		$RawTimestamp = ($min * 60000) + ($sec * 1000) + ($mil * 100);
		return $RawTimestamp;
	}

	function HasMultipleWODEntries($WorkoutTypeId) {
		$val = null;
		switch ((int) $WorkoutTypeId) {
			case 1: // Custom
			case 3: // Benchmark
			case 5: // Skills
				$val = true;
				break;
			case 2: // Well Rounded
			case 4: // Advanced
			case 5: // Challenge
				$val = false;
				break;
		}
		return $val;
	}

	function MakeRound($RoundCounter) {
		return '<h3>Round ' . $RoundCounter . '</h3>';
	}

	function MakeExerciseHeader($RoutineNo, $RoundNo, $ExerciseId, $OrderBy, $Exercise) {
		$this->html = '<div data-role="collapsible" data-iconpos="right" class="collapse_' . $RoutineNo . '_' . $RoundNo . '_' . $ExerciseId . '_' . $OrderBy . '">';
		$this->html.= '<h4>' . $Exercise . '<br/>';
		return $this->html;
	}

	function MakeExerciseInputBoxes($WorkoutId, $ThisRoutineNo, $ThisRoundNo, $ThisOrderBy, $ThisExerciseId, $Attributes, $IsAmrap = false) {
		$this->html = '';
		if (isset($this->request->query['WorkoutPage']) and $this->request->query['WorkoutPage'] == 'progress') {
			#$this->html .= '<div class="ActivityAttributes" data-role="fieldcontain"><form id="' . $ThisRoutineNo . '_' . $ThisRoundNo . '_' . $ThisOrderBy . '_' . $ThisExerciseId . '" name="' . $ThisRoutineNo . '_' . $ThisRoundNo . '_' . $ThisOrderBy . '_' . $ThisExerciseId . '">';
			$this->html .= '';
		} else {
			$this->html .= '<div class="ActivityAttributes" data-role="fieldcontain"><form id="' . $ThisRoutineNo . '_' . $ThisRoundNo . '_' . $ThisOrderBy . '_' . $ThisExerciseId . '" name="' . $ThisRoutineNo . '_' . $ThisRoundNo . '_' . $ThisOrderBy . '_' . $ThisExerciseId . '">';
			foreach ($Attributes as $Attribute => $Val) {
				$ValExploded = explode("|", $Val);
				$UOM = $ValExploded[0];
				$UnitOfMeasureId = $ValExploded[1];
				if ($UnitOfMeasureId == '')
					$UnitOfMeasureId = 0;
				if ($j > 0)
					$TheseAttributes.='_';
				$TheseAttributes.=$Attribute;
				$this->html.=$this->setAttributeInputs($WorkoutId, $Attribute, $UOM, $ThisRoutineNo, $ThisRoundNo, $ThisExerciseId, $UnitOfMeasureId, $ThisOrderBy, $IsAmrap);
				$j++;
			}
		}
		return array($Attribute, $this->html);
	}

	function setDefaultAttributesLine($AttributeValue, $Detail, $UnitOfMeasureId, $WorkoutId, $WorkoutTypeId, $DefaultOrderBy, $IsAmrap = 0) 
	{
		$AttributeValue = $IsAmrap ? $this->setDefaultAttributeValue($WorkoutId, $WorkoutTypeId, $Detail['A']['Attribute'], $DefaultOrderBy) : $AttributeValue;
		$AttributeValue = $Detail['A']['Attribute'] == 'Time' ? $this->Benchmark->formatMilliseconds($AttributeValue) : $AttributeValue;
		
		$uom_html = $AttributeValue == 'Max' ? '' : '<span style="font-size:small;font-weight:normal">' . $Detail['UOM']['UnitOfMeasure'] . '</span>';
		
		if($Detail['A']['Attribute'] == 'Time') $uom_html = '';
		
		$this->html ='<span style="font-size:small">' . $this->setAttributeName($Detail['A']['Attribute']) . ':</span><span style="font-size:small;font-weight:normal" id="' . $Detail['BD']['RoundNo'] . '_' . $Detail['E']['ExerciseId'] . '_' . $Detail['A']['Attribute'] . '_html">' . $AttributeValue . '</span>' . $uom_html;
		$this->html.='<input type="hidden" class="' . $Detail[0]['RoutineNo'] . '_' . $Detail['BD']['RoundNo'] . '_' . $Detail['E']['ExerciseId'] . '_' . $Detail['BD']['OrderBy'] . '" id="' . $Detail[0]['RoutineNo'] . '_' . $Detail['BD']['RoundNo'] . '_' . $Detail['E']['ExerciseId'] . '_' . $Detail['BD']['OrderBy'] . '_' . $Detail['A']['Attribute'] . '" name="' . $Detail['BD']['RoundNo'] . '_' . $Detail['E']['ExerciseId'] . '_' . $Detail['A']['Attribute'] . '_' . $UnitOfMeasureId . '_' . $Detail['BD']['OrderBy'] . '"';
		
		if ($AttributeValue == 'Max') {
			$this->html.='placeholder="' . $AttributeValue . '" value="">';
		} else {
			$this->html.='value="' . $AttributeValue . '">';
		}
		return $this->html;
	}

	function setAttributeName($Attribute) {
		switch ($Attribute) {
			case "Weight":
				$text = "Wt";
				break;
			case "Height":
				$text = "Ht";
				break;
			case "Distance":
				$text = "Dist";
				break;
			case 'TimeToComplete':
				$text = 'Time';
				break;
			default:
				$text = $Attribute;
				break;
		}
		return $text;
	}

	function setHistoryLine($WorkoutTypeId, $ThisRoutineNo, $ThisRoundNo, $ThisOrderBy, $ThisExerciseId, $ThisWodId, $DefaultOrderBy, $IsAmrap = false) {
		list($history_html_line, $history_html_inner) = $this->UpdateHistory($WorkoutTypeId, $ThisExerciseId, $ThisRoutineNo, $ThisRoundNo, $ThisOrderBy, $ThisWodId, $DefaultOrderBy, $IsAmrap);
		return '<div id="' . $ThisRoutineNo . '_' . $ThisRoundNo . '_' . $ThisOrderBy . '_' . $ThisExerciseId . '_History" class="activityhistory">' . $history_html_line . '</div></h4><div id="' . $ThisRoutineNo . '_' . $ThisRoundNo . '_' . $ThisOrderBy . '_' . $ThisExerciseId . '_HistoryInner" class="HistoryInner">' . $history_html_inner . '</div>';
	}

	function UpdateHistory($WorkoutTypeId, $ExerciseId, $RoutineNo, $RoundNo, $OrderBy, $WorkoutId, $DefaultOrderBy, $IsAmrap = false) 
	{
		$HasMultipleWODEntries = $this->HasMultipleWODEntries($WorkoutTypeId);

		if (isset($this->request->query['WorkoutPage']) and $this->request->query['WorkoutPage'] == 'progress') 
		{
			$limit = $this->request->query['HistoryLimit'];
		} 
		else if (isset($this->request->query['WorkoutPage']) and $this->request->query['WorkoutPage'] == 'baseline') 
		{
			$limit = 3;
		} 
		else 
		{
			$limit = $HasMultipleWODEntries ? 3 : 1;
		}
		//$OrderBy = $IsAmrap ? $DefaultOrderBy : $OrderBy;
		$full_access_mode = $this->fullaccess ? 0 : 4;
		$Attributes = $this->Benchmark->getExerciseIdAttributes($ExerciseId);
		$ExerciseHistory = $this->Benchmark->getExerciseHistory($ExerciseId, false, $RoutineNo, $RoundNo, $OrderBy, $WorkoutId, $WorkoutTypeId, $limit, $IsAmrap, $full_access_mode);
		$this->html = $this->html_inner = $this->html_line = '';
		if (count($ExerciseHistory) == 0 || ($IsAmrap and $module == 'completed')) 
		{
			$this->html_inner = '';
			$this->html_line = '';
		} 
		else 
		{
			$NumAttributes = count($Attributes);
			$NumRows = count($ExerciseHistory);

			$this->html = $NumRows > 0 ? '<div class="SavedActivity" style="color:green;[margin]">' : '';
			for ($x = 0; $x < $NumAttributes; $x++) 
			{
				$Detail = $ExerciseHistory[$x];
				$uom_html = /* $Detail->IsMaxValue == 1 ? '' : */$Detail->UnitOfMeasure;

				if (isset($this->request->query['WorkoutPage']) and $this->request->query['WorkoutPage'] == 'progress')
					$uom_html = $Detail->UnitOfMeasure;

				$AttributeValue = /* $Detail->IsMaxValue == 1 ? 'Max' : */$Detail->AttributeValue;

				if (isset($this->request->query['WorkoutPage']) and $this->request->query['WorkoutPage'] == 'progress')
					$AttributeValue = $Detail->AttributeValue;

				$DetailedValue = $Detail->Attribute == 'Time' ? $Model->formatMilliseconds($AttributeValue) : $AttributeValue . $uom_html;
				$this->html.='<span style="font-weight:bold;font-size:small">' . $this->setAttributeName($Detail->Attribute) . ':</span><span style="font-weight:normal;font-size:small">' . $DetailedValue . '</span>&nbsp;';
			}

			$this->html .= $NumRows > 0 ? '</div>' : '';
			$this->html_line = str_replace("[margin]", "", $this->html);

			$this->html = $NumRows > 0 ? '<div class="SavedActivity" style="color:green;[margin]">' : '';
			for ($y = $NumAttributes; $y < $NumRows; $y++) 
			{
				$Detail = $ExerciseHistory[$y];
				$uom_html = /* $Detail->IsMaxValue == 1 ? '' : */$Detail->UnitOfMeasure;

				if (isset($this->request->query['WorkoutPage']) and $this->request->query['WorkoutPage'] == 'progress')
					$uom_html = $Detail->UnitOfMeasure;

				$AttributeValue = /* $Detail->IsMaxValue == 1 ? 'Max' : */$Detail->AttributeValue;

				if (isset($this->request->query['WorkoutPage']) and $this->request->query['WorkoutPage'] == 'progress')
					$AttributeValue = $Detail->AttributeValue;

				$DetailedValue = $Detail->Attribute == 'Time' ? $Model->formatMilliseconds($AttributeValue) : $AttributeValue . $uom_html;
				$this->html.='<span style="font-weight:bold;font-size:small">' . $this->setAttributeName($Detail->Attribute) . ':</span><span style="font-weight:normal;font-size:small">' . $DetailedValue . '</span>&nbsp;';
				
				if (($y + 1) % $NumAttributes == 0)
					$this->html .= '</div><div class="SavedActivity" style="color:green;[margin]">';
			}

			$this->html .= $NumRows > 0 ? '</div>' : '';
			$this->html_inner = $this->html_inner .= str_replace("[margin]", "margin-left:5px;", $this->html);
		}

		if (isset($this->request->query['WorkoutPage']) && ($this->request->query['WorkoutPage'] == 'progress' || $this->request->query['WorkoutPage'] == 'completed') && ((count($ExerciseHistory) == 0) || ($NumAttributes % count($ExerciseHistory) == 0))) {
			$this->html_inner = '<div class="noresultsprogress">No other history found for this activity.</div>';
		}

		return array($this->html_line, $this->html_inner);
	}

	public function MakeWODFooter($WorkoutId, $WodTypeId, $count, $escape = '', $IsAmrap = 0, $benchmarkCategory = '') 
	{
		if (isset($this->request->query['WorkoutPage']) && $this->request->query['WorkoutPage'] == 'progress') 
		{
			$this->html = '';
		} 
		else 
		{
			if ($count > 0) {
				$checked_html = $this->IsBaselineWOD($WorkoutId, $WodTypeId) ? ' checked="true"' : '';
				if (isset($this->request->query['WorkoutPage']) && $this->request->query['WorkoutPage'] == 'completed') 
				{
					$wodModule = 'personal';
					switch ($WodTypeId) 
					{
						case 1:
							$wodModule = 'personal';
							break;
						case 2:
							$wodModule = 'mygym';
							break;
						case 3:
							$wodModule = 'benchmark';
							break;
						case 4:
							$wodModule = 'mygym';
							break;
						case 7:
							$wodModule = 'baseline';
							break;
						default:
							break;
					}
					$this->html .= '<div class="wodfooter">';
					$this->html .= '<div class="wodfooterbuttondiv"><input class="buttongroup" data-theme="b" type="button" onClick="GotoWorkout(' . $WorkoutId . ', ' . $WodTypeId . ', \'' . $benchmarkCategory . '\', \'' . $wodModule . '\')" value="Go to Workout"/></div>';
					$this->html .= '</div><!--wodfooter-->';
					$this->html .= '<div class="clear"></div>';
				} 
				else if ($this->canDeleteWOD($WodTypeId)) 
				{
					$this->html .= '<div class="wodfooter">';
					$this->html .= '<div class="wodfooterlabeldiv"><label><input' . $checked_html . ' class="checkbox checkboxnarrow" type="checkbox" id="baseline" name="baseline"/>Baseline</label></div>';
					if ($IsAmrap == 1) 
					{
						$this->html .= '<div class="wodfooterbuttondiv"><input class="buttongroup" data-theme="c" type="button" onClick="AddAmrapRound(' . $WorkoutId . ');" value="Add Round"/></div>';
					}
					$this->html .= '<div class="clear"></div>';
					$this->html .= '<div class="wodfooterlabeldiv"><input class="buttongroup" data-theme="a" type="button" onClick="deleteWOD(' . $WorkoutId . ', ' . $WodTypeId . ')" value="Delete"/></div>';
					$this->html .= '<div class="wodfooterbuttondiv"><input id="SaveWODResults" class="buttongroup" data-theme="b" type="button" onClick="SaveWODResults(' . $escape . '\'personal' . $escape . '\', ' . $WorkoutId . ', ' . $WodTypeId . ')" value="Done"/></div>';
					$this->html .= '</div><!--wodfooter-->';
					$this->html .= '<div class="clear"></div>';
				} 
				else 
				{
					$this->html .= '<div class="wodfooter">';
					$this->html .= '<div class="wodfooterlabeldiv"><label><input' . $checked_html . ' class="checkbox checkboxnarrow" type="checkbox" id="baseline" name="baseline"/>Baseline</label></div>';
					if ($IsAmrap == 1) {
						$this->html .= '<div class="wodfooterbuttondiv"><input class="buttongroup" data-theme="c" type="button" onClick="AddAmrapRound(' . $WorkoutId . ');" value="Add Round"/></div>';
						$this->html .= '<div class="clear"></div>';
					}
					$this->html .= '<div class="wodfooterbuttondiv"><input id="SaveWODResults" class="buttongroup" data-theme="b" type="button" onClick="SaveWODResults(' . $escape . '\'personal' . $escape . '\', ' . $WorkoutId . ', ' . $WodTypeId . ')" value="Done"/></div>';
					$this->html .= '</div><!--wodfooter-->';
					$this->html .= '<div class="clear"></div>';
				}
			}
		}

		return $this->html;
	}

	public function IsBaselineWOD($WorkoutId, $WodTypeId) 
	{
		if (!isset($this->BaselineId)) {
			$this->BaselineId = $this->Benchmark->IsBaselineWOD($WorkoutId, $WodTypeId);
		}
		return $this->BaselineId > 0 ? true : false;
	}

	public function canDeleteWOD($WodTypeId) {
		$val = false;
		switch ((int) $WodTypeId) {
			case 1:
			case 9:
				$val = true;
				break;
		}
		if (isset($_REQUEST['BaselineId']))
			$val = true;
		return $val;
	}

	function personalWodOutput($DuplicateAmrapRound=0) 
	{
		$html = '';

		$member_id = $_COOKIE['UID'];
		$this->loadModel('Workout');
		$workouts = $this->Workout->find('all', array('conditions' => array('member_id' => $member_id)));

		if (count($workouts) == 0) 
		{
			$message = array(
	            'text' => __('no_personal_workouts_found'),
	            'type' => 'failed',
	            'data' => NULL
	        );
		}
		else 
		{
			$message = array(
	            'text' => __('personal_workouts_found'),
	            'type' => 'success',
	            'data' => $workouts
	        );
		}

		return $message;
	}

	public function facebook($action = NULL)
	{
		if($action != NULL)
		{
			if($action == 'login')
			{
				$user = $this->Facebook->login();

				if(isset($user))
				{
					// check if user is registered in DB
					$user_check = $this->Member->find('all', array('conditions' => array('email' => $user->email)));
					if(count($user_check) > 0)
					{
						// user found by facebook id
						$data['Member']['id'] = $user_check[0]['Member']['id'];
						$data['Member']['facebook_id'] = $user->id;
						$data['Member']['access_token'] = CakeSession::read('access_token');
						$data['Member']['login_count'] = $user_check[0]['Member']['login_count'] + 1;
						$data['Member']['last_login'] = date("Y-m-d H:i:s");

						if($this->Member->save($data))
						{
							CakeSession::write('UID', $user_check[0]['Member']['id']);
							setcookie("UID", $user_check[0]['Member']['id'], time() + (20 * 365 * 24 * 60 * 60), '/', 'commander.local', false, false);
							$this->redirect('/members');
						}
					}
					else
					{
						// check against facebook ID
						$user_check = $this->Member->find('all', array('conditions' => array('facebook_id' => $user->id)));
						if(count($user_check) > 0)
						{
							// user found by facebook id
							$data['Member']['id'] = $user_check[0]['Member']['id'];
							$data['Member']['facebook_id'] = $user->id;
							$data['Member']['access_token'] = CakeSession::read('access_token');
							$data['Member']['login_count'] = $user_check[0]['Member']['login_count'] + 1;
							$data['Member']['last_login'] = date("Y-m-d H:i:s");

							if($this->Member->save($data))
							{
								CakeSession::write('UID', $user_check[0]['Member']['id']);
								setcookie("UID", $user_check[0]['Member']['id'], time() + (20 * 365 * 24 * 60 * 60), '/', 'commander.local', false, false);
								$this->redirect('/members');
							}
						}
						else
						{

							$data['Member']['facebook_id']  = $user->id;
							$data['Member']['access_token']  = CakeSession::read('access_token');
							$data['Member']['name']  = $user->first_name;
							$data['Member']['surname'] = $user->last_name;

							if(isset($user->email))
								$data['Member']['email'] = $user->email;

							if($user->gender == 'male')
								$data['Member']['gender'] = 'M';
							else
								$data['Member']['gender'] = 'F';

							$data['Member']['terms'] = 0;

							$system_of_measurement = 'Metric';

							// save user details
							$this->Member->create();
							if($this->Member->save($data))
							{
								$id = $this->Member->id;

								$this->loadModel('MemberDetail');
								$this->loadModel('MemberSubscription');

								$memberDetail['MemberDetail']['member_id'] = $id;
								$memberDetail['MemberDetail']['skill_level'] = 1;
								$memberDetail['MemberDetail']['system_of_measurement'] = $system_of_measurement;
								$this->MemberDetail->save($memberDetail);

								$memberSubscription['MemberSubscription']['member_id'] = $id;
								$memberSubscription['MemberSubscription']['active'] = 0;
								$this->MemberSubscription->save($memberSubscription);

						        CakeSession::write('UID', $id);
						        setcookie("UID", $id, time() + (20 * 365 * 24 * 60 * 60), '/', 'commander.local', false, false);

						        $this->redirect('/members');

							}

						}

					}
				}
			}
			die();
		}
		else
			die('Oops! you found something on the site you weren\'t suppose to. Please let us know if you run into this issue again');
	}
}
