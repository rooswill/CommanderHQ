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
		$this->loadModel('Workout');
		$this->loadModel('Exercise');

		$base_stats = $this->Exercise->_getExerciseStats();

		pr($base_stats);

		if(isset($attribute))
		{
			if(isset($details))
			{
				$attribute = urldecode($attribute);
				$this->set('activityCount', $this->Workout->_activityDetails($attribute));
				$this->set('title', ucfirst($attribute));
				$this->render('progress_details');
			}
			else
			{
				$this->set('title', ucfirst($attribute));
				$this->set('activityCount', $this->Workout->_activityCount($_COOKIE['UID']));
				$this->render('progress_summary');
			}
		}
		else
		{
			$this->set('totalWorkouts', $this->Workout->_totalWorkouts());
			$this->set('completedWorkouts', $this->Workout->_countCompletedWorkouts());
			$this->set('activityCount', $this->Workout->_activityCount($_COOKIE['UID']));
			$this->set('movementTypeWorkouts', $this->Workout->_movementTypeWorkouts($_COOKIE['UID']));
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
		$type = $this->request->data['type'];

		if(CakeSession::read('custom_workout'))
			CakeSession::write('custom_workout.template_name', $template);
		
		if($template != '' && $template != NULL)
			return $this->render('/Elements/workouts/'.$type.'/'.$template);
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
					pr($this->request->params['pass']);
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
