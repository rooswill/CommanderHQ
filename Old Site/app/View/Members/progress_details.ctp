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
			text: "<?php echo $title; ?> Detail Chart"
		},
		axisX: {
			interval:1,
			valueFormatString: "MMM-DD",
		},
		data: [
		{
			type: "column", //change type to bar, line, area, pie, etc
			showInLegend: true,        
			dataPoints: [
				{ x: new Date(2012,11,31) , y: 51 },
				{ x: new Date(2012,12,31) , y: 45},
				{ x: new Date(2012,09,31) , y: 50 },
				{ x: new Date(2012,08,31) , y: 62 },
				{ x: new Date(2012,03,31) , y: 95 },
				{ x: new Date(2012,05,31) , y: 66 },
				{ x: new Date(2013,11,31) , y: 24 },
				{ x: new Date(2013,10,31) , y: 32 },
				{ x: new Date(2014,15,31) , y: 16}
			]
			},
			{
			type: "spline",
			showInLegend: true,        
			dataPoints: [
				{ x: new Date(2012,11,31) , y: 51 },
				{ x: new Date(2012,12,31) , y: 45},
				{ x: new Date(2012,09,31) , y: 50 },
				{ x: new Date(2012,08,31) , y: 62 },
				{ x: new Date(2012,03,31) , y: 95 },
				{ x: new Date(2012,05,31) , y: 66 },
				{ x: new Date(2013,11,31) , y: 24 },
				{ x: new Date(2013,10,31) , y: 32 },
				{ x: new Date(2014,15,31) , y: 16}
			]
			}
		],
		legend: {
			cursor: "pointer",
			itemclick: function (e) {
				if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
					e.dataSeries.visible = false;
				} else {
					e.dataSeries.visible = true;
			}
			chart.render();
			}
		}
	});

	chart.render();
}
</script>
<script type="text/javascript" src="/js/Libs/canvasjs.min.js"></script>

<div id="chartContainer" style="height: 300px; width: 100%;"></div>

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