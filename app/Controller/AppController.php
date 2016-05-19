<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
CakePlugin::load('Paypal');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller 
{

	public $components = array('Cookie', 'Session');
	public $activities;
	public $exercise;
	public $templates;
	public $user_info;

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->loadModel('Member');
		if(isset($_COOKIE['UID']))
		{
			$userId = $_COOKIE['UID'];
			$this->user_info = $this->Member->find('all', array('conditions' => array('id' => $userId)));
			CakeSession::write('global_user_info', $this->user_info);
		}

		// set activities
		$this->loadModel('Activity');
		$this->activities = $this->Activity->find('all', array('order' => array('name' => 'ASC')));

		// set exercises
		$this->loadModel('Exercise');
		$this->exercise = $this->Exercise->find('all', array('order' => array('name' => 'ASC')));

		// set templates
		$this->loadModel('Template');
		$this->templates = $this->Template->find('all', array('order' => array('name' => 'ASC')));

	}

	public function hashPassword($password, $salt) 
	{
		return hash('sha512', $password . $salt);
	}

	public function generateSalt() 
	{
		mt_srand($this->makeSeed());
		$salt = md5(mt_rand() . microtime());

		return $salt;
	}

	public function makeSeed() 
	{
		list($usec, $sec) = explode(' ', microtime());

		return (float) $sec + ((float) $usec * 100000);
	}

	public function getTinyUrl($url) 
	{
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url=' . $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);

		return $data;
	}

	public function CheckEmailAddress($email) 
	{
		return $valid = preg_match("/^([0-9a-z]+[-._+&])*[0-9a-z]+@([-0-9a-z]+[.])+[a-z]{2,6}$/i", $email);
	}

	public function CheckMobileNumber($mobileNo) 
	{
		return preg_match("/^\+\d{2,3}[0-9]{9}$/", $mobileNo);
	}

	// get difference between two dates.
	function dateDifference($check, $current)
	{
		$datediff = strtotime($current) - strtotime($check);
		return floor($datediff / (60 * 60 * 24));
	}

}
