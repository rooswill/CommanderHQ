<?php


App::uses('AppController', 'Controller');

class ReferController extends AppController 
{

	public $scaffold = 'admin';

	public $components = array('RequestHandler', 'Sms');

	public function index() 
	{
		$title_for_layout = 'Commander HQ | Member Home';
		if($this->request->is('post'))
		{
			if($this->request->data)
			{
				$response = $this->Validate($this->request->data);

		        if($response == 'Success')
		        {
		        	$results = $this->Refer->ReferFriend($this->request->data);
		        	if($results['response'] == 'success')
		        	{
		        		$sms = $this->Sms->setValues(1222, trim($results['FriendCell']), $results['SmsMessage'], 3, 0, SMS_FROM_NUMBER, 0, null, null);
						$smsResult = $this->Sms->Send();
						pr($smsResult);
		        	}
		        }
		            
		        else
		        	$this->set('response', $response);
			}
		}
	}

	public function Validate($value = NULL)
    {	
        $Message = 'Success';

        if($value['FriendName'] == '')
            $Message = 'We need to know who we\'re sending this to. Please enter your friend\'s name.';
        else if($value['FriendEmail'] != '' && !$this->CheckEmailAddress($value['FriendEmail']))
            $Message = 'We don\'t think we\'ll reach them with that email address. Please check it again!';        
        else if(!$this->CheckMobileNumber($value['FriendCell']))
            $Message = 'Make sure we\'ve got a valid cell number to contact your friend on.'; 
        else if($this->Refer->CheckFriendExists($value['FriendEmail'], $value['FriendCell']))
            $Message = 'You\'ve already invited this friend. Guessing you want them to join quite a lot?';
            
        return $Message;
    }
}
