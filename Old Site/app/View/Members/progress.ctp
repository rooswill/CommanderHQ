<div class="ui-listview" id="topselection">
	<h1 class="ui-li-heading">Progress</h1>
</div>

<div class="progress-container" data-link="workouts">
	<div class="progress-icon">
		<img src="/img/640/menu/myGym.png" />
	</div>
	<div class="progress-activity">
		<span>Completed</span> Workouts
	</div>
	<div class="progress-total">
		100
	</div>
	<div class="progress-marker">
		<img src="/img/arrow-icon.png" />
	</div>
	<div class="clear"></div>
</div>

<div class="progress-container" data-link="activities">
	<div class="progress-icon">
		<img src="/img/640/menu/myGym.png" />
	</div>
	<div class="progress-activity">
		<span>Activities</span> Done
	</div>
	<div class="progress-total">
		56
	</div>
	<div class="progress-marker">
		<img src="/img/arrow-icon.png" />
	</div>
	<div class="clear"></div>
</div>

<div class="progress-container" data-link="strength">
	<div class="progress-icon">
		<img src="/img/640/menu/myGym.png" />
	</div>
	<div class="progress-activity">
		<span>Strength</span>
	</div>
	<div class="progress-bar">
		<?php echo $this->element('progress_bar'); ?>
	</div>
	<div class="progress-marker">
		<img src="/img/arrow-icon.png" />
	</div>
	<div class="clear"></div>
</div>