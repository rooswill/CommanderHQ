<?php

require 'facebook/facebook.php';

App::uses('Component', 'Controller');


Class FacebookComponent extends Component
{
	public $app_id = APP_ID;
	public $app_secret = APP_SECRET;
	public $my_url = REDIRECT_URL;

	public function startup(Controller $controller)
	{
		$this->Controller = $controller;
	}

	public function __redirectFunc($url)
	{
		$this->Controller->redirect($url);
	}

	public function login()
	{
		if(isset($this->Controller->request->query['code']))
				$code = $this->Controller->request->query['code'];	

		if(isset($this->Controller->request->query['state']))
			$state_request = $this->Controller->request->query['state'];

		if(empty($code)) 
		{
			CakeSession::write('state', md5(uniqid(rand(), TRUE)));
			$state_session = CakeSession::read('state');

			 // CSRF protection
			$dialog_url = "https://www.facebook.com/dialog/oauth?client_id=".$this->app_id."&redirect_uri=".urlencode($this->my_url)."&state=".$state_session."&scope=email";
			$this->__redirectFunc($dialog_url);
		}

		if(CakeSession::read('state') && (CakeSession::read('state') === $state_request)) 
		{
			$token_url = "https://graph.facebook.com/oauth/access_token?client_id=".$this->app_id."&redirect_uri=".urlencode($this->my_url)."&client_secret=".$this->app_secret."&code=".$code;

			$response = file_get_contents($token_url);

			parse_str($response, $params);

			CakeSession::write('access_token', $params['access_token']);

			$graph_url = "https://graph.facebook.com/me?access_token=".CakeSession::read('access_token');

			$user = json_decode(file_get_contents($graph_url));
			
			return $user;   
		}
		else 
		{
			echo("The state does not match. You may be a victim of CSRF.");
		}   
    
    }
}