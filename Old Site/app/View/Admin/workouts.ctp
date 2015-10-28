<h1>Create WOD</h1>

<div class="loadnewwod-header-button" id="workout-tyoe" onclick="setWodType(2, false)">Well rounded WOD</div>
<div class="loadnewwod-header-button" id="workout-type" onclick="setWodType(4, false)">Advanced WOD</div>

<div class="clear"></div>

<div class="admin-workout-add">
	<div class="workout-info">
		<div class="info-top-row">
			<div class="info-workout-type">
				<select name="workout_type" id="workout-type">
					<option value='0'>Select WOD Type</option>
					<option value='1'>Well Rounded</option>
					<option value='2'>Advanced</option>
				</select>
			</div>
			<div class="info-workout-coach">
				<input type="text" name="workout_coach" value="" placeholder="COACH'S NAME" />
			</div>
			<div class="info-workout-start-date">
				<input type="text" id="mydate" gldp-id="mydate" />
    			<div gldp-el="mydate" style="width:400px; height:300px; position:absolute; top:70px; left:100px;"></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="info-workout-description">
			<textarea placeholder="DESCRIPTION"></textarea>
		</div>
	</div>
</div>

<div class="workout-data">
	<div class="RoutineList" id="RoutineBlock1">
		<div class="RoutineLabel" id="Routine1Label">
			<h2>Routine 1</h2>
			<input class="smlBtnRed" type="button" value="Remove Routine" onclick="RemoveRoutine(1)">
		</div>
		<table class="activitytableheader">
			<thead>
				<tr>
					<th align="center" style="min-width:190px;text-align:left">Activity</th>
					<th align="center" style="min-width:60px;text-align:center">Hght(m)</th>
					<th align="center" style="min-width:60px;text-align:center">Hght(f)</th>
					<th align="center" style="min-width:60px;text-align:center">Wght(m)</th>
					<th align="center" style="min-width:60px;text-align:center">Wght(f)</th>
					<th align="center" style="min-width:60px;text-align:center">Dist</th>
					<th align="center" style="min-width:76px;text-align:center">Time Limit</th>
					<th align="center" style="min-width:60px;text-align:center">Calories</th>
					<th align="center" style="min-width:60px;text-align:center">Reps</th>
					<th align="center" style="min-width:72px;">
						<input type="button" class="EditAttribute" onclick="ToggleEditAttributes()" value="Edit Values">
					</th>
				</tr>
			</thead>
		</table>
		<input type="hidden" class="smlBtnRed ActivityCounterInput" name="Routine1Round1Counter" id="Routine1Round1Counter" value="0">
		<input type="hidden" name="Routine1RoundCounter" id="Routine1RoundCounter" value="1" class="RoundCounterInput">
		<div id="activity1list" class="ActivityListBlock"></div> 
	</div>
</div>


<div class="workout-admin-panel">
	<div class="workout-admin-input-fields">
		<div class="select-workout-activity">
			<select name="exercise">
				<?php
					foreach($exercises as $k => $v)
						echo "<option value='".$k."'>".$v."</option>";
				?>
			</select>
		</div>
		<div class="workout-activity-input-fields"></div>
	</div>
	<div class="workout-buttons">
		<div class="workout-btn-activity">
			<input class="workout-btn-green" id="CustomActivity" type="button" value="Custom Activity" onclick="addNewActivity();">
		</div>
		<div class="workout-btn-benchmark">
			<select class="select buttongroup" data-role="none" id="benchmark" name="benchmark" onchange="AddBenchmark(this.value)">
				<?php
					foreach($benchmarks as $k => $v)
						echo "<option value='".$k."'>".$v."</option>";
				?>
			</select>
		</div>
		<div class="workout-btn-copy-round">
			<input class="workout-btn-green" type="button" name="copyround" value="Copy Last Round" onclick="CopyLastRound();">
		</div>
		<div class="workout-btn-add-round">
			<input class="workout-btn-green" type="button" name="addround" value="Add Round" onclick="AddRound();">
		</div>
		<div class="workout-btn-copy-activity">
			<input class="workout-btn-green" type="button" name="addroutine" value="Copy Activity" onclick="CopyActivity();">
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="main-workout-btns">
	<div class="main-workout-btn-add-routine">
		<input id="submit" class="AddRoutine" type="button" name="addroutine" value="Add Routine" onclick="AddRoutine();">
	</div>
	<div class="main-workout-btn-copy-routine">
		<input id="submit" class="AddRoutine" type="button" name="copyroutine" value="Copy Last Routine" onclick="CopyLastRoutine();">
	</div>
	<div class="main-workout-btn-amrap">
		<label>
			<input id="chkAmrap" class="AddRoutine" type="checkbox" name="amrap" onclick="return IsAmrap();">AMRAP
		</label>
	</div>
	<div class="main-workout-btn-save-workout">
		<input id="submit" class="SaveWod" type="button" name="btnsubmit" value="Save WOD" onclick="PublishWod()">
	</div>
</div>

