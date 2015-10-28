<!-- <div class="ui-listview" id="topselection">
	<h1 class="ui-li-heading">Create Personal WOD</h1>
</div>

<div class="custom-section" id="AjaxOutput">       
	
	<form name="form" id="customform" action="/members/workouts/custom" method="post">
		<div class="ui-grid-a">
			<div style="width:45%;" class="ui-block-a">
				<div class="ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c">
					<input type="text" value="" placeholder="WOD Name" id="CustomName" name="workout_name" class="textinput ui-input-text ui-body-c">
				</div>
			</div>
			<div style="text-align:right;margin:3px 7px 0 0;width:45%;float:right" class="ui-block-b">2015-05-04</div>
		</div>

		<textarea placeholder="Describe Your WOD" name="workout_description" id="descr" class="ui-input-text ui-body-c ui-corner-all ui-shadow-inset" style="height: 52px;"></textarea>
		
		<!-- Routines go here -->

		<!--<div class="routines">
			
		</div>

		<div class="AddActivityBlock">
			<div id="CenterButtonText">
				<div id="add_exercise"></div>
				<div class="autocompleteinput">
					<form class="ui-listview-filter ui-bar-d ui-listview-filter-inset" role="search">
						<div class="ui-input-search ui-shadow-inset ui-btn-corner-all ui-btn-shadow ui-icon-searchfield ui-body-d">
							<input placeholder="Add Activity..." data-type="search" class="ui-input-text ui-body-d" id="add-exercise">
							<a title="clear text" class="ui-input-clear ui-btn ui-btn-up-d ui-shadow ui-btn-corner-all ui-fullsize ui-btn-icon-notext ui-input-clear-hidden" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-icon="delete" data-iconpos="notext" data-theme="d" data-mini="false">
								<span class="ui-btn-inner">
									<span class="ui-btn-text">clear text</span>
									<span class="ui-icon ui-icon-delete ui-icon-shadow">&nbsp;</span>
								</span>
							</a>
						</div>
					</form>
					<ul data-filter-theme="d" data-filter-placeholder="Add Activity..." data-filter="true" data-inset="true" data-role="listview" id="autocomplete" class="ui-listview ui-listview-inset ui-corner-all ui-shadow"></ul>
					<a data-iconpos="notext" data-theme="e" data-icon="info" data-transition="pop" data-inline="true" class="ui-icon-alt infotip ui-btn ui-btn-up-e ui-shadow ui-btn-corner-all ui-btn-inline ui-btn-icon-notext" data-role="button" data-rel="popup" data-position-to="window" onclick="return SetPopupData()" href="#popupInfo" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" aria-haspopup="true" aria-owns="#popupInfo" title=""><span class="ui-btn-inner"><span class="ui-btn-text"></span><span class="ui-icon ui-icon-info ui-icon-shadow">&nbsp;</span></span></a>
					<div style="display: none;"><!-- placeholder for popupInfo --></div>
					<!--<div id="ExerciseInputs"></div>
					<br>
					<div class="ui-grid-a amrapBlock">
						<div class="ui-block-a">
							<div class="ui-checkbox">
								<label data-corners="true" data-shadow="false" data-iconshadow="true" data-wrapperels="span" data-icon="checkbox-off" data-theme="c" data-mini="false" class="ui-checkbox-off ui-btn ui-btn-up-c ui-btn-corner-all ui-fullsize ui-btn-icon-left">
									<span class="ui-btn-inner">
										<span class="ui-btn-text">AMRAP</span>
										<span class="ui-icon ui-icon-checkbox-off ui-icon-shadow">&nbsp;</span>
									</span>
								</label>
								<input type="checkbox" onclick="return IsAmrap();" name="is_amrap" class="AddRoutine checkbox checkboxnarrow" id="chkAmrap">
							</div>
						</div>
						<div style="display: none;" class="ui-block-b amrapTimeContainer">
							<div onclick="EnterAmrapTime()" class="clock amrapclock">Enter time limit</div>
							<input type="hidden" class="amrap_time" name="amrapTime" id="amrapTime">
						</div>
					</div><!-- Close ui-grid-a -->
					<!--<div class="ui-grid-a">
						<div class="ui-block-a">
							<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="d" data-disabled="false" class="ui-btn ui-btn-up-d ui-shadow ui-btn-corner-all" aria-disabled="false">
								<span class="ui-btn-inner">
									<span class="ui-btn-text">Copy Last Activity</span>
								</span>
								<button onclick="DuplicateLastActivity();" type="button" id="DuplicateActivity" data-theme="d" class="ui-btn-hidden" data-disabled="false">Copy Last Activity</button>
							</div>
						</div>
						<div class="ui-block-b benchmarkdropdown">
							<div class="ui-select">
								<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-icon="false" data-iconpos="false" data-theme="d" class="ui-btn ui-btn-up-d ui-shadow ui-btn-corner-all">
									<span class="ui-btn-inner">
										<span class="ui-btn-text">
											<span>Add Benchmark</span>
										</span>
									</span>
									<select onchange="AddBenchmark(this.value)" name="benchmark" id="benchmark" style="float:right" data-icon="false" data-theme="d">
										<option value="none">Add Benchmark</option>
										<option value="235">Amanda</option>
										<option value="216">Angie</option>
										<option value="217">Annie</option>
										<option value="218">Barbara</option>
										<option value="239">Cindy</option>
										<option value="219">Diane</option>
										<option value="220">Elizabeth</option>
										<option value="231">Eva</option>
										<option value="221">Fight Gone Bad - 3 Rounds</option>
										<option value="222">Fight Gone Bad - 5 Rounds</option>
										<option value="238">Filthy Fifty</option>
										<option value="223">Fran</option>
										<option value="224">Grace</option>
										<option value="225">Helen</option>
										<option value="226">Isabel</option>
										<option value="227">Jackie</option>
										<option value="228">Karen</option>
										<option value="232">Kelly</option>
										<option value="229">Linda</option>
										<option value="233">Lynne</option>
										<option value="240">Mary</option>
										<option value="230">Nancy</option>
										<option value="234">Nasty Girls</option>
										<option value="241">Nicole</option>
										<option value="236">Run 5km</option>
										<option value="237">Sprint 400m</option>
									</select>
								</div>
							</div>
						</div>
					</div><!-- Close ui-grid-a -->
					<!--<div class="ui-grid-a">
						<div class="ui-block-a">
							<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="e" data-disabled="false" class="ui-btn ui-btn-up-e ui-shadow ui-btn-corner-all" aria-disabled="false">
								<span class="ui-btn-inner">
									<span class="ui-btn-text">Add a Round</span>
								</span>
								<button onclick="AddRound(null,true);" type="button" data-theme="e" class="ui-btn-hidden" data-disabled="false">Add a Round</button>
							</div>
						</div>
						<div class="ui-block-b">
							<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="e" data-disabled="false" class="ui-btn ui-btn-up-e ui-shadow ui-btn-corner-all" aria-disabled="false">
								<span class="ui-btn-inner">
									<span class="ui-btn-text">Copy Last Round</span>
								</span>
								<button onclick="AddRound();" type="button" data-theme="e" class="ui-btn-hidden" data-disabled="false">Copy Last Round</button>
							</div>
						</div>
					</div><!-- Close ui-grid-a -->
					<!--<div class="ui-grid-a">
						<div class="ui-block-a">
							<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="a" data-disabled="false" class="ui-btn ui-btn-up-a ui-shadow ui-btn-corner-all" aria-disabled="false">
								<span class="ui-btn-inner">
									<span class="ui-btn-text">Add a Routine</span>
								</span>
								<button onclick="AddRoutine();" type="button" id="DuplicateActivity" data-theme="a" class="ui-btn-hidden" data-disabled="false">Add a Routine</button>
							</div>
						</div>
						<div class="ui-block-b">
							<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="a" data-disabled="false" class="ui-btn ui-btn-up-a ui-shadow ui-btn-corner-all" aria-disabled="false">
								<span class="ui-btn-inner">
									<span class="ui-btn-text">Copy Last Routine</span>
								</span>
								<button onclick="AddRoutine(false,true);" type="button" data-theme="a" class="ui-btn-hidden" data-disabled="false">Copy Last Routine</button>
							</div>
						</div>
					</div><!-- Close ui-grid-a -->
				<!--</div>
				<input type="submit" value="Save" />
			</div>
			<div class="clear"></div>
		</div><!-- Close AddActivityBlock -->
	<!--</form>
</div>
 -->

<?php
	if(isset($this->request->query['t']))
	{
		$template = 'templates/'.$this->request->query['t'];
		if($this->elementExists($template))
			echo $this->element($template);
		else
			echo "The Template you are looking for could not be found.";
	}
	else
		echo "<p>No Template Selected</p>";
?>