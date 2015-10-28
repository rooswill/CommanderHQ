<?php

    App::uses('AppModel', 'Model');

    class Benchmark extends AppModel 
    {

    	public $Message;
		public $hasMultipleWODEntries;
		public $isAmrap;
		public $topAMRAPTime;
		public $topAMRAPTotalRounds;
		public $topAMRAPWorkoutId;
		public $topAMRAPWODTypeId;

		public $hasAndBelongsToMany = array(
			'Exercise' => array(
				'className' => 'Exercise',
				'joinTable' => 'benchmark_details',
				'foreignKey' => 'benchmark_id',
				'associationForeignKey' => 'exercise_id',
	            'unique' => 'keepExisting',
			),
			'Attribute' => array(
				'className' => 'Attribute',
				'joinTable' => 'benchmark_details',
				'foreignKey' => 'benchmark_id',
				'associationForeignKey' => 'attribute_id',
	            'unique' => 'keepExisting',
			),
		);

		public function getCategory($Id) {
			$db = new DatabaseManager(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_CUSTOM_DATABASE);
			$SQL = 'SELECT Category FROM BenchmarkCategories WHERE recid = ' . $Id . '';
			$db->setQuery($SQL);

			return $db->loadResult();
		}

		public function getCustomMemberWorkouts() {
			$db = new DatabaseManager(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_CUSTOM_DATABASE);
			$SQL = 'SELECT recid,
	                DATE_FORMAT(TimeCreated, "%d %M %Y") AS WorkoutName,
	                TimeCreated
	                FROM CustomWorkouts
	                WHERE MemberId = "' . $_COOKIE['UID'] . '"
	                GROUP BY TimeCreated   
	                ORDER BY TimeCreated';
			$db->setQuery($SQL);

			return $db->loadObjectList();
		}

		public function getCustomPublicWorkouts() {
			$db = new DatabaseManager(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_CUSTOM_DATABASE);
			$SQL = 'SELECT DATE_FORMAT(CD.TimeCreated, "%d %M %Y") AS CD.WorkoutName,
	                DATE_FORMAT(CD.TimeCreated, "%Y-%m-%d") AS CD.TimeCreated
	                FROM CustomDetails CD
	                LEFT JOIN MemberDetails MD ON MD.MemberId = CD.MemberId
	                WHERE MD.CustomWorkouts = "Public"
	                AND CD.MemberId <> "' . $_COOKIE['UID'] . '"
	                GROUP BY WorkoutName    
	                ORDER BY WorkoutName';
			$db->setQuery($SQL);

			return $db->loadObjectList();
		}

		public function getCustomDescription($Id) {
			$Filter = '';
			if ($Id != '') {
				$Filter = ' AND CW.recid = "' . $Id . '"';
			}
			$SQL = 'SELECT DATE_FORMAT(CW.TimeCreated, "%d %M %Y") AS WorkoutName, E.Exercise, 
	                E.Acronym, 
	                A.Attribute, 
	                CD.AttributeValue, 
	                CD.RoundNo,
	                WT.WorkoutType,
	                CW.TimeCreated,
	                CW.Notes
	                FROM CustomDetails CD
	                LEFT JOIN CustomWorkouts CW ON CW.recid = CD.CustomWorkoutId
	                LEFT JOIN Exercises E ON E.recid = CD.ExerciseId
	                LEFT JOIN Attributes A ON A.recid = CD.AttributeId
	                LEFT JOIN WorkoutRoutineTypes WT ON WT.recid = CW.WorkoutRoutineTypeId
	                WHERE CW.MemberId = "' . $_COOKIE['UID'] . '"
	                    ' . $Filter . '
	                ORDER BY TimeCreated, RoundNo, Exercise';
			return $this->MakeDescription($SQL);
		}

		public function getBenchmarkDescription($Id) {

			if ($this->getGender() == 'M') 
				$DescriptionField = 'DescriptionMale';
			else 
				$DescriptionField = 'DescriptionFemale';

			$SQL = 'SELECT ' . $DescriptionField . ' AS Description FROM BenchmarkWorkouts BW WHERE BW.recid = "' . $Id . '"';

			$data = $this->query($SQL);

			return $data[0]['BW']['Description'];
		}

		public function MakeDescription($SQL) {
			$db = new DatabaseManager(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_CUSTOM_DATABASE);
			$db->setQuery($SQL);
			$Result = $db->loadObjectList();
			$Description = '';
			$Exercise = '';
			$TotalRounds = '';
			$WorkoutType = '';
			foreach ($Result AS $Row) {
				if ($Exercise != $Row->Exercise) {
					if ($Description == '') {
						if ($Row->TotalRounds > 1) {
							$TotalRounds = '' . $Row->TotalRounds . ' Rounds | ';
						}
						if ($Row->WorkoutType == 'Timed')
							$WorkoutType = 'For Time | ';
						else if ($Row->WorkoutType != 'AMRAP Rounds')
							$WorkoutType = '' . $Row->WorkoutType . ' | ';
					}

					$Exercise = $Row->Exercise;
				}
				if ($Row->Attribute == 'Reps' && $Row->AttributeValue > 0) {
					$Description .= '' . $Row->AttributeValue . ' ' . $Row->Exercise . ' | ';
				} else if ($Row->Exercise != 'Timed') {
					$Description .= '' . $Row->Exercise . ' | ';
				} else if ($Row->Attribute == 'Weight') {
					//$Description .= ' ';
					// $Description .= $Row->AttributeValue;
					//if($this->getSystemOfMeasure() == 'Metric')
					//    $Description .= 'kg';
					//else if($this->getSystemOfMeasure() == 'Imperial')
					//    $Description .= 'lbs';
				} else if ($Row->Attribute == 'Height') {
					
				} else if ($Row->Attribute == 'Distance') {
					
				} else if ($Row->Attribute == 'TimeToComplete') {
					
				} else if ($Row->Attribute == 'CountDown') {
					
				} else if ($Row->Attribute == 'Rounds') {
					
				} else if ($Row->Attribute == 'Calories') {
					
				} else if ($Row->Attribute == 'Time')
					$WorkoutType = 'AMRAP In ' . $Row->AttributeValue . ' | ';
			}
			//$Description .= $TotalRounds.$WorkoutType;
			return $TotalRounds . $WorkoutType . $Description;
		}

		public function getBMWS() 
		{
			$SQL = 'SELECT BW.recid AS Id, BW.WorkoutName, BW.VideoId, BC.Category 
                FROM BenchmarkWorkouts BW
                JOIN BenchmarkCategories BC ON BC.recid = BW.CategoryId
                WHERE Published = 1
                ORDER BY WorkoutName';

			$data = $this->query($SQL);

			return $data;
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
	                LEFT JOIN BenchmarkWorkouts B ON B.recid = L.ExerciseId 
	                LEFT JOIN Attributes A ON A.recid = L.AttributeId
	                LEFT JOIN WorkoutTypes ET ON ET.recid = L.WODTypeId
	                WHERE L.MemberId = ' . $_COOKIE['UID'] . ' 
	                AND ET.WorkoutType = "Benchmark"
	                AND A.Attribute = "TimeToComplete"
	                ORDER BY TimeCreated';
			$db->setQuery($SQL);

			return $db->loadObjectList();
		}

		function getGender() 
		{
			$userId = CakeSession::read('UID');
			$SQL = 'SELECT Gender FROM Members WHERE UserId = "' . $userId . '"';
			
			$data = $this->query($SQL);

			return $data[0]['Members']['Gender'];
		}

		function getBenchmarkDetails($Id, $RoutineNo = "1") 
		{
			$benchmark_type_id = '3';
			$excludedIds = '7, 10';

			if (isset($this->request->query['WorkoutPage']) && $this->request->query['WorkoutPage'] == 'progress') 
				$total_rounds_sql = $this->isAmrap ? $this->topAMRAPTotalRounds : '(SELECT MAX(RoundNo) FROM BenchmarkDetails WHERE BenchmarkId = "' . $Id . '")';
			else 
				$total_rounds_sql = '(SELECT MAX(RoundNo) FROM BenchmarkDetails WHERE BenchmarkId = "' . $Id . '")';

			if ($this->getGender() == 'M') 
			{
				$AttributeValue = 'AttributeValueMale';
				$gender = 'Male';
			} 
			else 
			{
				$AttributeValue = 'AttributeValueFemale';
				$gender = 'Female';
			}

			if (isset($this->request->query['WorkoutPage']) && ($this->request->query['WorkoutPage'] == 'progress' || $this->request->query['WorkoutPage'] == 'completed') && $this->isAmrap) {
				$SQL = '
				SELECT WL.WorkoutId AS Id, BW.WorkoutName, E.Exercise, E.recid AS ExerciseId, 
				CASE WHEN E.Acronym <>  ""
				THEN E.Acronym
				ELSE E.Exercise
				END AS InputFieldName,
				BW.IsAmrap, 
				BW.AmrapTime, 
				A.Attribute, 
				WL.AttributeValue, 
				WL.UnitOfMeasureId, 
				UOM.UnitOfMeasure, 
				UOM.ConversionFactor, 
				"1" AS RoutineNo,
				WL.RoundNo, 
				WL.OrderBy,
				WL.DefaultOrderBy,
				' . $total_rounds_sql . ' AS TotalRounds
				FROM WODLog WL
				INNER JOIN BenchmarkWorkouts BW ON BW.recid = WL.WorkoutId
				LEFT JOIN Exercises E ON E.recid = WL.ExerciseId
				LEFT JOIN Attributes A ON A.recid = WL.AttributeId
				LEFT JOIN UnitsOfMeasure UOM ON UOM.AttributeId = A.recid
				AND WL.UnitOfMeasureId = UOM.recid
				WHERE WL.MemberId = "' . CakeSession::read('UID') . '"
				AND WL.WorkoutId = "' . $Id . '"
				AND WL.WodTypeId = ' . $benchmark_type_id . '
				AND WL.TimeCreated = "' . $this->topAMRAPTime . '"
				AND WL.AttributeId NOT IN(' . $excludedIds . ')
				ORDER BY RoutineNo, RoundNo, OrderBy, Exercise, A.OrderBy			
				';
			} else {
				$SQL = '
				SELECT DISTINCT
					BW.recid AS Id,
					BW.WorkoutName, 
					BW.IsAmrap, 
					BW.AmrapTime, 
	        BC.Category,
					E.Exercise,
					"3" AS WodTypeId,
					E.recid AS ExerciseId, 
					CASE 
							WHEN E.Acronym <> ""
							THEN E.Acronym
							ELSE E.Exercise
					END
					AS InputFieldName,
					A.Attribute, 
					BW.Description' . $gender . ' AS Notes,
					BD.' . $AttributeValue . ' AS AttributeValue, 
					BD.UnitOfMeasureId,    
					UOM.UnitOfMeasure,
					UOM.ConversionFactor,    
					VideoId, 
					"' . $RoutineNo . '" AS RoutineNo,
					BD.RoundNo AS RoundNo,
					BD.OrderBy AS OrderBy,
					BD.OrderBy AS DefaultOrderBy,
					' . $total_rounds_sql . ' AS TotalRounds
				FROM BenchmarkDetails BD
				INNER JOIN BenchmarkWorkouts BW ON BW.recid = BD.BenchmarkId
				LEFT JOIN Exercises E ON E.recid = BD.ExerciseId
				LEFT JOIN Attributes A ON A.recid = BD.AttributeId
	                        LEFT JOIN UnitsOfMeasure UOM ON UOM.AttributeId = A.recid AND BD.UnitOfMeasureId = UOM.recid
	                        LEFT JOIN BenchmarkCategories BC ON BC.recId = BW.CategoryId 
				WHERE BD.BenchmarkId = ' . $Id . '
	                        AND (Attribute = "Reps" OR Attribute = "Calories" OR SystemOfMeasure = "' . $this->getSystemOfMeasure() . '")    
				ORDER BY RoutineNo, RoundNo, BD.OrderBy, Exercise, A.OrderBy';
			}
			#var_dump($SQL);
			$data = $this->query($SQL);
			return $data;
		}

		public function getSystemOfMeasure() 
		{
			$SQL = 'SELECT SystemOfMeasure FROM Members WHERE UserId = "' . CakeSession::read('UID') . '"';
			$data = $this->query($SQL);
			return $data[0]['Members']['SystemOfMeasure'];
		}

		public function getBaselineIdAndWodTypeId($WorkoutId) 
		{
			$userId = CakeSession::read('UID');
			$SQL = "SELECT recid, WodTypeId FROM MemberBaseline WHERE WorkoutId = $WorkoutId AND MemberId = ".$userId;
			$data = $this->query($SQL);
			return $data;
		}

		public function getLimitSQL($limit_type, $prefix = '') {
			switch ((int) $limit_type) {
				case 1:
					$limit = 31;
					break;
				case 2:
					$limit = 8;
					break;
				case 3:
					$limit = 1;
					break;
				case 4:
					$limit = 4;
					break;
				default:
					$limit = 0;
					break;
			}
			return $limit == 0 ? "" : "AND {$prefix}TimeCreated BETWEEN DATE_ADD( NOW( ) , INTERVAL -{$limit} DAY ) AND DATE_ADD( NOW( ) , INTERVAL -0 DAY ) ";
		}

		public function getAttributeId($attribute) {
			$SQL = 'SELECT recid FROM Attributes WHERE Attribute = "' . $attribute . '"';
			$data = $this->query($SQL);
			return $data[0]['Attributes']['recid'];
		}

		public function getExerciseIdAttributes($Id) {

			$SQL = 'SELECT DISTINCT E.recid AS ExerciseId, 
				E.Exercise AS ActivityName,
	                        CASE WHEN E.Acronym <> ""
	                        THEN E.Acronym
	                        ELSE E.Exercise
	                        END
	                        AS InputFieldName,
				A.Attribute,
				(SELECT recid FROM UnitsOfMeasure WHERE A.recid = AttributeId AND SystemOfMeasure = "' . $this->getSystemOfMeasure() . '" ORDER BY DefaultField DESC LIMIT 1)
				AS UOMId,
				(SELECT UnitOfMeasure FROM UnitsOfMeasure WHERE A.recid = AttributeId AND SystemOfMeasure = "' . $this->getSystemOfMeasure() . '" ORDER BY DefaultField DESC LIMIT 1)
				AS UOM
				FROM ExerciseAttributes EA
				LEFT JOIN Attributes A ON EA.AttributeId = A.recid
				LEFT JOIN Exercises E ON EA.ExerciseId = E.recid
				WHERE E.recid = "' . $Id . '"
	                        AND A.Attribute <> "TimeToComplete"
	                        AND A.Attribute <> "Rounds"
				ORDER BY A.OrderBy';
			$data = $this->query($SQL);
			return $data;
		}

		public function getExerciseHistory($ExerciseId, $exerciseOnly = true, $RoutineNo = 0, $RoundNo = 0, $OrderBy = 0, $WorkoutId = 0, $WorkoutTypeId = 0, $limit = 3, $IsAmrap = 0, $limit_type = 0) {

			// Get Baseline Routines as well
			$baseline_type_id = "7";
			$Baseline = $this->getBaselineIdAndWodTypeId($WorkoutId);

			if(count($Baseline) > 0)
				$BaselineId = $Baseline->recid;
			else
				$BaselineId = NULL;
			$WorkoutIds = $BaselineId > 0 ? $WorkoutId . ', ' . $BaselineId : $WorkoutId;
			$limit_sql = $this->getLimitSQL($limit_type, "WL.");
			if ($exerciseOnly == false) {
				$and_sql = '
	      AND WorkoutId IN(' . $WorkoutIds . ')
	      AND WodTypeId = ' . $WorkoutTypeId . '
	      AND RoutineNo = ' . $RoutineNo . '
	      AND RoundNo = ' . $RoundNo . '
	      AND WL.OrderBy = ' . $OrderBy . ' ' . $limit_sql;
				$reps_sql = '';
			} else {
				$and_sql = '';

				$reps_sql = 'AND (Attribute = "Reps" OR Attribute = "Calories" OR SystemOfMeasure = "' . $this->getSystemOfMeasure() . '")';
			}
			$LastThreeRecords = '';
			if ($BaselineId) {
				$table_name = $this->getOrginalBaselineTableName($Baseline->WodTypeId);
				$SQL = '
	      SELECT DISTINCT WL.TimeCreated AS ListItem
	      FROM WODLog WL
	      INNER JOIN ' . $table_name . 'Workouts W ON W.recid = WL.WorkoutId
	      WHERE WL.MemberId = "' . $_COOKIE['UID'] . '" 
	      AND WL.WorkoutId = "' . $WorkoutId . '"
	      AND WL.WodTypeId = ' . $Baseline->WodTypeId . '
	      AND WL.RoutineNo = ' . $RoutineNo . '
	      AND WL.RoundNo = ' . $RoundNo . '
	      AND WL.OrderBy = ' . $OrderBy . '
	      AND WL.ExerciseId = ' . $ExerciseId . '
	      ' . $limit_sql . '

	      UNION

	      SELECT DISTINCT WL.TimeCreated AS ListItem
	      FROM WODLog WL
	      INNER JOIN MemberBaseline W ON W.recid = WL.WorkoutId
	      WHERE WL.MemberId = "' . $_COOKIE['UID'] . '" 
	      AND WL.WorkoutId = "' . $BaselineId . '"
	      AND WL.WodTypeId = ' . $baseline_type_id . '
	      AND WL.RoutineNo = ' . $RoutineNo . '
	      AND WL.RoundNo = ' . $RoundNo . '
	      AND WL.OrderBy = ' . $OrderBy . '
	      AND WL.ExerciseId = ' . $ExerciseId . '
	      ' . $limit_sql . '
					
	      ORDER BY ListItem DESC LIMIT ' . $limit;
			} else {
				$SQL = '
	      SELECT DISTINCT TimeCreated AS ListItem
	      FROM WODLog WL
	      WHERE ExerciseId = ' . $ExerciseId . '
	      AND MemberId = "' . CakeSession::read('UID') . '" 
	      ' . $and_sql . '
	      ORDER BY TimeCreated DESC LIMIT ' . $limit;
			}
			#var_dump($SQL);
			$data = $this->query($SQL);
			if (count($data) > 0) {
				$LastThreeRecords = $data;
			}
			if ($BaselineId) {
				$baseline_sql = '
					UNION
					
					SELECT E.Exercise, 
						A.Attribute, 
						(TRIM(TRAILING "." FROM(CAST(TRIM(TRAILING "0" FROM TRUNCATE(WL.AttributeValue,1)) AS char)))) AS AttributeValue,
						UOM.UnitOfMeasure,
						WL.RoutineNo,
						WL.RoundNo,
						WL.OrderBy,
						WL.IsMaxValue,
						TimeCreated,
						(SELECT MAX(TimeCreated) FROM WODLog WL WHERE WL.ExerciseId = ' . $ExerciseId . '
	           AND (Attribute = "Reps" OR Attribute = "Calories" OR SystemOfMeasure = "' . $this->getSystemOfMeasure() . '")    
	           AND MemberId = "' . CakeSession::read('UID') . '") AS LastRecord,
						A.OrderBy AS AttributeOrderBy
	        FROM WODLog WL 
	        LEFT JOIN Attributes A ON A.recid = WL.AttributeId
	        LEFT JOIN UnitsOfMeasure UOM ON UOM.recid = WL.UnitOfMeasureId
	        LEFT JOIN Exercises E ON E.recid = WL.ExerciseId
	        WHERE WL.ExerciseId = ' . $ExerciseId . '
	        ' . $reps_sql . '
	        AND MemberId = "' . CakeSession::read('UID') . '"
					AND WorkoutId = "' . $BaselineId . '"
					AND WodTypeId = "' . $baseline_type_id . '"
					AND RoutineNo = ' . $RoutineNo . '
					AND RoundNo = ' . $RoundNo . '
					AND WL.OrderBy = ' . $OrderBy . '
	        AND TimeCreated IN ' . $LastThreeRecords;
			} else
				$baseline_sql = '';
			if ($LastThreeRecords != '') {
				$SQL = '
					SELECT E.Exercise, 
						A.Attribute, 
						(TRIM(TRAILING "." FROM(CAST(TRIM(TRAILING "0" FROM TRUNCATE(WL.AttributeValue,1)) AS char)))) AS AttributeValue,
						UOM.UnitOfMeasure,
						WL.RoutineNo,
						WL.RoundNo,
						WL.OrderBy,
						WL.IsMaxValue,
						TimeCreated,
						(SELECT MAX(TimeCreated) FROM WODLog WL WHERE WL.ExerciseId = ' . $ExerciseId . '
	           AND (Attribute = "Reps" OR Attribute = "Calories" OR SystemOfMeasure = "' . $this->getSystemOfMeasure() . '")    
	           AND MemberId = "' . CakeSession::read('UID') . '") AS LastRecord,
						A.OrderBy AS AttributeOrderBy
	        FROM WODLog WL 
	        LEFT JOIN Attributes A ON A.recid = WL.AttributeId
	        LEFT JOIN UnitsOfMeasure UOM ON UOM.recid = WL.UnitOfMeasureId
	        LEFT JOIN Exercises E ON E.recid = WL.ExerciseId
	        WHERE WL.ExerciseId = ' . $ExerciseId . '
	        ' . $reps_sql . '
	        AND MemberId = "' . CakeSession::read('UID') . '"
					AND WorkoutId =' . $WorkoutId . '
					AND WodTypeId = ' . $WorkoutTypeId . '
					AND RoutineNo = ' . $RoutineNo . '
					AND RoundNo = ' . $RoundNo . '
					AND WL.OrderBy = ' . $OrderBy . '
	        AND TimeCreated IN ' . $LastThreeRecords . '
						
					' . $baseline_sql . '
					
	        ORDER BY TimeCreated DESC, RoutineNo, RoundNo, OrderBy, AttributeOrderBy';
				#var_dump($SQL);
				$data = $this->query($SQL);
				return $data;
			} else {
				return null;
			}
		}

		public function getWODTimes($WodTypeId, $WorkoutId, $RoutineNo, $limit_type = 0) 
		{
			$BaselineId = $this->IsBaselineWOD($WorkoutId, $WodTypeId);
			$restriction_sql = $this->getLimitSQL($limit_type);

			if (count($BaselineId) > 0) 
			{
				$BaselineTypeId = 7;
				$SQL = '
				SELECT RoutineNo, AttributeValue
				FROM WODLog
				WHERE MemberId = ' . CakeSession::read('UID') . '
				AND WorkoutId = ' . $BaselineId . '
				AND WodTypeId = ' . $BaselineTypeId . '
				AND RoutineNo = ' . $RoutineNo . '
				AND AttributeId = 7
				' . $restriction_sql . '
				ORDER BY TimeCreated DESC
				LIMIT 1
				';
			} 
			else 
			{
				$SQL = '
				SELECT RoutineNo, AttributeValue
				FROM WODLog
				WHERE MemberId = ' . CakeSession::read('UID') . '
				AND WorkoutId = ' . $WorkoutId . '
				AND WodTypeId = ' . $WodTypeId . '
				AND RoutineNo = ' . $RoutineNo . '
				AND AttributeId = 7
				' . $restriction_sql . '
				ORDER BY TimeCreated DESC
				LIMIT 1';
			}

			$data = $this->query($SQL);
			return $data;
		}

		function IsBaselineWOD($WorkoutId, $WodTypeId) {
			$SQL = '
		    SELECT recid
		    FROM MemberBaseline
		    WHERE MemberId = ' . CakeSession::read('UID') . '
		    AND WorkoutId = ' . $WorkoutId . '
		    AND WodTypeId = ' . $WodTypeId . '
		    ';
			$data = $this->query($SQL);
			return $data;
		}

		public function getTimedBenchMark($WorkoutId) 
		{
			$SQL = "SELECT IsTimed FROM BenchmarkWorkouts WHERE recid = {$WorkoutId}";
			$data = $this->query($SQL);
			return $data;
		}

	}