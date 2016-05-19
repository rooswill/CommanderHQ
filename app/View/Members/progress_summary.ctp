<h1>Progress / <?php echo $title; ?></h1>

<div class="progress-current-date" data-fulldate="<?php echo date("Y-m-d"); ?>">
	<?php echo date('F Y'); ?>
</div>

<div class="progress-change-date" data-fulldate="<?php echo date("Y-m-d"); ?>">
	Change
</div>

<?php
	$data = '';
?>

<script type="text/javascript">
window.onload = function () {
	var chart = new CanvasJS.Chart("chartContainer",
	{
		animationEnabled: true,
		title:{
			text: "<?php echo urldecode($title); ?> Completed Chart"
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

<?php
	foreach($activityCount as $key => $value)
	{
		?>
			<div class="progress-container" data-link="<?php echo urlencode($key); ?>">
				<div class="progress-icon">
					<img src="/img/640/menu/myGym.png" />
				</div>
				<div class="progress-activity">
					<span><?php echo $key; ?></span>
				</div>
				<div class="progress-total">
					<?php echo $value; ?>
				</div>
				<div class="progress-marker">
					<img src="/img/arrow-icon.png" />
				</div>
				<div class="clear"></div>
			</div>
		<?php
	}
?>