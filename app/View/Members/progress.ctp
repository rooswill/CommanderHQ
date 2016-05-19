<div class="ui-listview" id="topselection">
	<h1 class="ui-li-heading">Progress</h1>
</div>

<div class="progress-container" data-link="workouts">
	<div class="progress-icon">
		<img src="/img/640/menu/myGym.png" />
	</div>
	<div class="progress-activity">
		<span>Total</span> Workouts
	</div>
	<div class="progress-total">
		<?php echo $totalWorkouts; ?>
	</div>
	<div class="progress-marker">
		<img src="/img/arrow-icon.png" />
	</div>
	<div class="clear"></div>
</div>

<script type="text/javascript">
window.onload = function () {
	var chart = new CanvasJS.Chart("chartContainer",
	{
		animationEnabled: true,
		title:{
			text: "Activities"
		},
		data: [
			{
				type: "pie", //change type to bar, line, area, pie, etc
				dataPoints: [
					<?php
						foreach($activityCount as $aKey => $aValue)
							echo '{label: "'.$aKey.'", y: '.(int)$aValue.'},';
					?>
				]
			}
		]
	});

	chart.render();
}
</script>
<script type="text/javascript" src="/js/Libs/canvasjs.min.js"></script>
<div id="chartContainer" style="height: 400px; width: 95%;"></div>

<!-- <div class="progress-container" data-link="workouts">
	<div class="progress-icon">
		<img src="/img/640/menu/myGym.png" />
	</div>
	<div class="progress-activity">
		<span>Completed</span> Workouts
	</div>
	<div class="progress-total">
		<?php echo $completedWorkouts; ?>
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
		<?php echo count($activityCount); ?>
	</div>
	<div class="progress-marker">
		<img src="/img/arrow-icon.png" />
	</div>
	<div class="clear"></div>
</div>

<?php
	if(isset($movementTypeWorkouts))
	{
		foreach($movementTypeWorkouts as $m_type_key => $m_type_value)
		{
			?>
				<div class="progress-container" data-link="activities">
					<div class="progress-icon">
						<img src="/img/640/menu/myGym.png" />
					</div>
					<div class="progress-activity">
						<span><?php echo $m_type_key; ?></span> Done
					</div>
					<div class="progress-total">
						<?php echo $m_type_value; ?>
					</div>
					<div class="progress-marker">
						<img src="/img/arrow-icon.png" />
					</div>
					<div class="clear"></div>
				</div>
			<?php
		}
	}
?> -->