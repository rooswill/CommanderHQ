<h1>Progress / <?php echo $title; ?></h1>

<div class="progress-current-date" data-fulldate="<?php echo date("Y-m-d"); ?>">
	<?php echo date('F Y'); ?>
</div>

<div class="progress-change-date" data-fulldate="<?php echo date("Y-m-d"); ?>">
	Change
</div>

<script type="text/javascript">
window.onload = function () {
	var chart = new CanvasJS.Chart("chartContainer",
	{
		animationEnabled: true,
		title:{
			text: "<?php echo $title; ?> Completed Chart"
		},
		data: [
		{
			type: "column", //change type to bar, line, area, pie, etc
			dataPoints: [
				{ x: 10, y: 71 },
				{ x: 20, y: 55 },
				{ x: 30, y: 50 },
				{ x: 40, y: 65 },
				{ x: 50, y: 95 },
				{ x: 60, y: 68 },
				{ x: 70, y: 28 },
				{ x: 80, y: 34 },
				{ x: 90, y: 14 }
			]
		}
		]
	});

	chart.render();
}
</script>
<script type="text/javascript" src="/js/Libs/canvasjs.min.js"></script>
<div id="chartContainer" style="height: 300px; width: 95%;"></div>

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