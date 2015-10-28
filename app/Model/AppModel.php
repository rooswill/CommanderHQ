<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

	public $components = array('Sms');

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

}
