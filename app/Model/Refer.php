<?php
    App::uses('AppModel', 'Model');

    class Refer extends AppModel 
    {
        public $displayField = 'level';

        public function CheckFriendExists($email, $cell) 
        {
            $SQL = 'SELECT MemberId
                    FROM MemberInvites 
                    WHERE NewMemberEmail = "' . $email . '"
                    OR NewMemberCell = "' . $cell . '"';
            
            $results = $this->query($SQL);
            if (count($results) > 0)
                return true;
            else
                return false;
        }

        public function ReferFriend($data = NULL) 
        {
            $ReturnMessage = '';
            $message = '';
            $InvCode = base_convert(time(), 10, 16);
            $userID = CakeSession::read('UID');
            
            $SQL = 'INSERT INTO MemberInvites(MemberId, NewMemberName, NewMemberEmail, NewMemberCell) 
                    VALUES("' . $userID . '", "' . $data['FriendName'] . '", "' . $data['FriendEmail'] . '", "' . $data['FriendCell'] . '")';
            
            $this->query($SQL);

            $SQL = 'SELECT FirstName FROM Members WHERE UserId = "' . $userID . '"';
            $userDetails = $this->query($SQL);

            $FirstName = $userDetails[0]['Members']['FirstName'];

            //Lameez 6/11: Copy to use for sms: Hi {NAME}, {NAME} reckons you’ll love the CommanderHQ App. Log your WODs, track your progress & more. Check it out here. Lennie said link is already in code.


            $url_prep = 'http://' . THIS_DOMAIN . '/?module=signup&Cell=' . trim($data['FriendCell']) . '&Email=' . trim($data['FriendEmail']);
            $new_url = $this->getTinyUrl($url_prep);

            // $message_email .= '<p>Hi ' . $data['FriendName'] . ',</p>';
            // $message_email .= '';
            // $message_email .= '<p>' . $FirstName . ' reckons you\'ll love the Commander HQ App.</p>';
            // $message_email .= '';
            // $message_email .= '<p>Log your WODs, track your progress & more. <a href="' . $url_prep . '">Check it out here</a></p>';
            // $message_email .= '';

            $message_sms = 'Hi ' . $data['FriendName'] . ',';
            $message_sms .= ' ' . $FirstName . ' reckons you’ll love the Commander HQ App.';
            $message_sms .= ' Log your WODs, track your progress & more. ' . $new_url . '';

            // $MailResult = true;
            // $SmsResult = true;

            // if ($data['FriendEmail'] != '') 
            // {
            //     $mail = new Rmail();
            //     $mail->setFrom('Commander HQ<info@be-mobile.co.za>');
            //     $mail->setSubject('Take control with Commander HQ');
            //     $mail->setPriority('normal');
            //     $mail->setHTML($message_email);
            //     $MailResult = $mail->send(array($data['FriendEmail']));

            //     // if ($MailResult) {
            //     //     MixpanelUtil::ReferalEmail($_COOKIE['UID'], $this->getUsersName(), $data['FriendName'], $data['FriendEmail']);
            //     // }
            // }

            // App::import('Component','SmsComponent');
            // $sms = new SmsComponent();

            // $sms->setValues(1222, trim($data['FriendCell']), $message_sms, 3, 0, SMS_FROM_NUMBER, 0, null, null);
            // $smsResult = $sms->Send();

            // $SMS = new SmsManager(SITE_ID, trim($data['FriendCell']), $message_sms, 3, 0, SMS_FROM_NUMBER, 0, null, null);
            // $SmsResult = $SMS->Send();

            // if ($SmsResult) {
            //     MixpanelUtil::ReferalSMS($_COOKIE['UID'], $this->getUsersName(), $data['FriendName'], $data['FriendCell']);
            // }
            
            // if (!$MailResult || !$SmsResult)
            //     $ReturnMessage .= 'Something went wrong with your referral - please try again a little later.';
            // else
            //     $ReturnMessage .= 'Success! Hopefully your friend will be joining you soon.';

            $returnData['response'] = 'success';
            $returnData['FriendCell'] = $data['FriendCell'];
            $returnData['UserName'] = $FirstName;
            $returnData['SmsMessage'] = $message_sms;

            return $returnData;
        }

    }
?>