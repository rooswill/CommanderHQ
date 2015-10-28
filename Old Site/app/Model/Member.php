<?php
    App::uses('AppModel', 'Model');

    class Member extends AppModel 
    {
        public $displayField = 'name';

        public $hasMany = array(
            'MemberDetail' => array(
                'className' => 'MemberDetail'
            ),
            'MemberSubscription' => array(
                'className' => 'MemberSubscription'
            ),
            'MemberWorkout' => array(
                'className' => 'MemberWorkout'
            )
        );

        public function login($username, $password)
        {
            $findUser = $this->find("all", array('conditions' => array(
                'LOWER(username)' => strtolower(addslashes($username))
            )));

            if (count($findUser) > 0) 
            {
                $user = $findUser;
                $salt = $findUser[0]['Member']['salt'];
                $user_id = $findUser[0]['Member']['id'];
                $db_password = $findUser[0]['Member']['password'];
                $verified = $findUser[0]['Member']['verified'];
                $hashed_password = $this->hashPassword($password, $salt);

                if($hashed_password == $db_password) 
                {
                    $this->id = $user_id;
                    $member['Member']['last_login'] = date("Y-m-d H:i:s");
                    $this->save($member);

                    return array($user_id, $verified);
                } 
                else 
                    return false;
            } 
            else 
                return false;
        }

        public function _verifyUser($id)
        {
            $this->id = $id;
            $data['Member']['verified'] = 1;

            if($this->save($data))
                return true;
            else
                return false;
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

        public function getDescription($Id) {

            $SQL = '
                SELECT CW.WorkoutName, 
                E.Exercise, 
                E.Acronym, 
                A.Attribute, 
                CD.AttributeValue, 
                CD.RoundNo,
                CD.OrderBy,
                (SELECT MAX(RoundNo) FROM CustomDetails WHERE CustomWorkoutId = "' . $Id . '") AS TotalRounds,
                WT.WorkoutType,
                CW.Notes
                FROM CustomDetails CD
                LEFT JOIN CustomWorkouts CW ON CW.recid = CD.CustomWorkoutId
                LEFT JOIN Exercises E ON E.recid = CD.ExerciseId
                LEFT JOIN Attributes A ON A.recid = CD.AttributeId
                LEFT JOIN WorkoutRoutineTypes WT ON WT.recid = CW.WorkoutRoutineTypeId
                WHERE CW.MemberId = "' . $_COOKIE['UID'] . '"
                AND CW.recid = "' . $Id . '"
                ORDER BY RoundNo, CD.OrderBy, Exercise, Attribute
            ';

            return $this->MakeDescription($SQL);
        }

        public function MakeDescription($SQL) {
            $db = new DatabaseManager(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_CUSTOM_DATABASE);
            $db->setQuery($SQL);
            $Result = $db->loadObjectList();
            //var_dump($SQL);
            $Description = '';
            $Exercise = '';
            $TotalRounds = '';
            $WorkoutType = '';
            foreach ($Result AS $Row) 
            {
                if ($Exercise != $Row->Exercise) 
                {
                    if ($Description == '') 
                    {
                        if ($Row->TotalRounds > 1) 
                        {
                            $TotalRounds = '' . $Row->TotalRounds . ' Rounds | ';
                        }

                        if ($Row->WorkoutType == 'Timed')
                            $WorkoutType = 'For Time | ';
                        else if ($Row->WorkoutType != 'AMRAP Rounds')
                            $WorkoutType = '' . $Row->WorkoutType . ' | ';
                    }

                    $Exercise = $Row->Exercise;
                }

                switch ($Row->Attribute) 
                {
                    case 'Reps':
                        if($Row->AttributeValue > 0)
                            $Description .= '' . $Row->AttributeValue . ' ' . $Row->Exercise . ' | ';
                        break;
                    case (!"Timed");
                        $Description .= '' . $Row->Exercise . ' | ';
                        break;
                    case 'Time';
                        $WorkoutType = 'AMRAP In ' . $Row->AttributeValue . ' | ';
                        break;
                    default:
                        break;
                }

            }
            //$Description .= $TotalRounds.$WorkoutType;
            return $TotalRounds . $WorkoutType . $Description;
        }

        public function getPersonalWorkouts() 
        {

            $SQL = '
                SELECT recid AS Id, 
                WorkoutName,
                Notes
                FROM CustomWorkouts
                WHERE MemberId = "' . CakeSession::read('UID') . '"
                ORDER BY WorkoutdateTime DESC
            ';

            $data = $this->query($SQL);

            return $data;
        }

        public function getWorkoutDetails($Id) {
            $db = new DatabaseManager(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_CUSTOM_DATABASE);

            if ($this->getGender() == 'M') {
                $AttributeValue = 'AttributeValueMale';
            } else {
                $AttributeValue = 'AttributeValueFemale';
            }
            //$SQL = 'SELECT WorkoutName, '.$DescriptionField.' AS WorkoutDescription, '.$InputFields.' AS InputFields, VideoId FROM BenchmarkWorkouts WHERE recid = '.$Id.'';

            $SQL = 'SELECT BW.recid AS Id,
                            BW.WorkoutName, 
                            E.Exercise,
                            E.recid AS ExerciseId, 
                            CASE 
                                WHEN E.Acronym <> ""
                                THEN E.Acronym
                                ELSE E.Exercise
                            END
                            AS InputFieldName,
                            A.Attribute, 
                            BD.' . $AttributeValue . ' AS AttributeValue, 
                            UOM.UnitOfMeasure,
                            UOM.ConversionFactor,    
                            VideoId, 
                            RoundNo,
                            (SELECT MAX(RoundNo) FROM CustomDetails WHERE CustomWorkoutId = "' . $Id . '") AS TotalRounds
                FROM CustomDetails BD
                LEFT JOIN CustomWorkouts BW ON BW.recid = BD.CustomWorkoutId
                LEFT JOIN Exercises E ON E.recid = BD.ExerciseId
                LEFT JOIN Attributes A ON A.recid = BD.AttributeId
                            LEFT JOIN UnitsOfMeasure UOM ON UOM.AttributeId = A.recid AND BD.UnitOfMeasureId = UOM.recid
                WHERE BD.CustomWorkoutId = ' . $Id . '
                            AND (Attribute = "Reps" OR SystemOfMeasure = "Metric")    
                ORDER BY RoundNo, BD.OrderBy, Exercise, Attribute';
            $db->setQuery($SQL);

            return $db->loadObjectList();
        }

        public function _log() {
            $db = new DatabaseManager(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_CUSTOM_DATABASE);
            $SetBaseline = false;
            if ($this->UserIsSubscribed()) {
                $ActivityFields = $this->getActivityFields();
                //var_dump($ActivityFields);
                if ($this->Message == '') {
                    if ($_REQUEST['WorkoutId'] != '') {
                        $ThisId = $_REQUEST['WorkoutId'];
                        $WorkoutTypeId = $_REQUEST['WodTypeId'];
                    }
                    if (count($ActivityFields) > 0) {
                        foreach ($ActivityFields AS $ActivityField) {
                            $AttributeValue = '';
                            //check to see if we must convert back to metric first for data storage
                            if ($ActivityField->Attribute == 'Height' || $ActivityField->Attribute == 'Distance' || $ActivityField->Attribute == 'Weight') {

                                if ($ActivityField->Attribute == 'Distance') {
                                    if ($this->getSystemOfMeasure() != 'Metric') {
                                        $AttributeValue = round($ActivityField->AttributeValue * 1.61, 2);
                                    }
                                } else if ($ActivityField->Attribute == 'Weight') {
                                    if ($this->getSystemOfMeasure() != 'Metric') {
                                        $AttributeValue = round($ActivityField->AttributeValue * 0.45, 2);
                                    }
                                } else if ($ActivityField->Attribute == 'Height') {
                                    if ($this->getSystemOfMeasure() != 'Metric') {
                                        $AttributeValue = round($ActivityField->AttributeValue * 2.54, 2);
                                    }
                                }
                            }
                            if ($AttributeValue == '') {
                                $AttributeValue = $ActivityField->AttributeValue;
                            }

                            if ($_REQUEST['origin'] == 'baseline') {
                                $SQL = 'INSERT INTO BaselineLog(MemberId, BaselineTypeId, ExerciseId, RoundNo, ActivityId, AttributeId, AttributeValue) 
                    VALUES("' . $_COOKIE['UID'] . '", "' . $WorkoutTypeId . '", "' . $ThisId . '", "' . $ActivityField->RoundNo . '", "' . $ActivityField->ExerciseId . '", "' . $ActivityField->AttributeId . '", "' . $AttributeValue . '")';
                                $db->setQuery($SQL);
                                $db->Query();
                            }
                            // ExerciseId only applies for benchmarks so we need it here!
                            $SQL = 'INSERT INTO WODLog(MemberId, WorkoutId, WodTypeId, RoutineNo, RoundNo, ExerciseId, AttributeId, AttributeValue, UnitOfMeasureId, OrderBy) 
                VALUES("' . $_COOKIE['UID'] . '", "' . $ThisId . '", "' . $WorkoutTypeId . '", "' . $ActivityField->RoutineNo . '", "' . $ActivityField->RoundNo . '", "' . $ActivityField->ExerciseId . '", "' . $ActivityField->AttributeId . '", "' . $AttributeValue . '", "' . $ActivityField->UnitOfMeasureId . '", "' . $ActivityField->OrderBy . '")';
                            $db->setQuery($SQL);
                            $db->Query();
                            //var_dump($SQL);
                        }
                    } else if (isset($_REQUEST['ActivityTime'])) {
                        $ExplodedKey = explode('_', $_REQUEST['ActivityId']);
                        $ExerciseId = $ExplodedKey[2];
                        $ActivityTime = $_REQUEST['ActivityTime'];
                        $SQL = 'INSERT INTO WODLog(MemberId, ExerciseId, WodTypeId, AttributeId, AttributeValue) 
                    VALUES("' . $_COOKIE['UID'] . '", "' . $ExerciseId . '", "' . $WorkoutTypeId . '", "' . $this->getAttributeId('TimeToComplete') . '", "' . $ActivityTime . '")';
                        $db->setQuery($SQL);
                        $db->Query();
                    }
                    $this->Message = 'Success';
                }
            } else {
                $this->Message = 'You are not subscribed!';
            }
            return $this->Message;
        }

        public function LevelAchieved($ExerciseObject) {
            $Level = 0;
            $Sql = 'SELECT SL.AttributeValue, SL.SkillsLevel
                        FROM SkillsLevels SL 
                        LEFT JOIN Attributes A ON A.recid = SL.AttributeId
                        LEFT JOIN Exercises E ON E.recid = SL.ExerciseId
                        WHERE A.Attribute = "' . $ExerciseObject->Attribute . '"
                        AND E.Exercise = "' . $ExerciseObject->Exercise . '"
                        AND (SL.Gender = "U" OR SL.Gender = "' . $this->getGender() . '")
                        ORDER BY SkillsLevel';

            $Result = mysql_query($Sql);
            while ($Row = mysql_fetch_assoc($Result)) {
                if ($ExerciseObject->Attribute == 'TimeToComplete') {
                    $ExplodedTime = explode(':', $ExerciseObject->AttributeValue);
                    $SecondsToComplete = ($ExplodedTime[0] * 60) + $ExplodedTime[1];
                    $ExplodedTime = explode(':', $Row['AttributeValue']);
                    $SecondsToCompare = ($ExplodedTime[0] * 60) + $ExplodedTime[1];
                    if ($SecondsToComplete < $SecondsToCompare)
                        $Level = $Row['SkillsLevel'];
                }
                else {
                    if ($ExerciseObject->AttributeValue > $Row['AttributeValue'])
                        $Level = $Row['SkillsLevel'];
                }
            }
        }

        public function OverallLevelAchieved() {
            $Level = 4;
            $CompletedExercises = array();
            $Sql = 'SELECT ExerciseId, MAX(LevelAchieved) FROM ExerciseLog WHERE MemberId = ' . $this->UID . ' GROUP BY ExerciseId';
            $Result = mysql_query($Sql);
            while ($Row = mysql_fetch_assoc($Result)) {
                if ($Row['LevelAchieved'] < $Level)
                    $Level = $Row['LevelAchieved'];
                array_push($CompletedExercises, $Row['ExerciseId']);
            }

            $PendingExercises = array();
            $AllExercises = $this->getExercises();
            foreach ($AllExercises AS $Exercise) {
                if (!in_array($Exercise->Id, $CompletedExercises))
                    array_push($PendingExercises, $Exercise->Id);
            }
            if (count($PendingExercises) == 0)
                return $Level;
            else
                return 0;
        }

        public function getHistory() {
            $db = new DatabaseManager(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_CUSTOM_DATABASE);
            $SQL = 'SELECT B.recid, B.WorkoutName, A.Attribute, L.AttributeValue, L.TimeCreated 
            FROM WODLog L 
                    LEFT JOIN CustomWorkouts B ON B.recid = L.ExerciseId 
                    LEFT JOIN Attributes A ON A.recid = L.AttributeId
                    LEFT JOIN WorkoutTypes ET ON ET.recid = L.WODTypeId
                    WHERE L.MemberId = ' . $_COOKIE['UID'] . ' 
                    AND ET.WorkoutType = "Custom"
                    AND A.Attribute = "TimeToComplete"
                    ORDER BY TimeCreated';
            $db->setQuery($SQL);

            return $db->loadObjectList();
        }

        public function DeleteWod($Id) {
            $db = new DatabaseManager(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_CUSTOM_DATABASE);
            $SQL = 'DELETE FROM CustomWorkouts WHERE recid = "' . $Id . '"';
            $db->setQuery($SQL);
            $db->Query();

            $SQL = 'DELETE FROM CustomDetails WHERE CustomWorkoutId = "' . $Id . '"';
            $db->setQuery($SQL);
            $db->Query();

            return 'WOD has been deleted';
        }

    }
?>