<script src="/js/Libs/jquery.runner-min.js" type="text/javascript"></script>
<h1><?php echo $workout['Workout']['type']; ?></h1>


<div class="workout-template-details">
	Created : <?php echo date("F j, Y, g:i a" , strtotime($workout['Workout']['created'])); ?>
</div>

<div class="workout-template-details">
	<div class="workout-template-name"><?php echo str_replace('_', ' ', strtoupper($workout['WorkoutTemplate'][0]['template_name'])); ?>:</div>
	<div class="workout-template-details-container">
		<?php
			$totalTemplateDetails = count($workout['WorkoutTemplate'][0]['WorkoutTemplateDetail']);
			foreach($workout['WorkoutTemplate'][0]['WorkoutTemplateDetail'] as $workoutDetails)
			{
				?>
					<div class="workout-template-detail-block">
						<?php echo $workoutDetails['name']; ?> : 
						<?php echo $workoutDetails['value']; ?> / 
						<input type="text" value="" id="member-input-template" />
						<input type="hidden" value="<?php echo trim($workoutDetails['name']); ?>" id="workout_template_name" />
						<input type="hidden" value="<?php echo trim($workout['WorkoutTemplate'][0]['id']); ?>" id="workout_template_id" />
					</div>
				<?php
			}
		?>
	</div>
	<br /><br />
	<div class="workout-template-name">Previous Results:</div>
	<div class="workout-template-detail-attributes">
		<?php
			if(isset($workout['WorkoutTemplate'][0]['WorkoutUserTemplateDetail']) && count($workout['WorkoutTemplate'][0]['WorkoutUserTemplateDetail']) > 0)
				echo $this->element('previous-results', array('data' => $workout['WorkoutTemplate'][0]['WorkoutUserTemplateDetail']));
			else
				echo "No results logged";
		?>
	</div>
</div>

<div class="workout-template-details">
	<div class="workout-template-detail-attributes">
		<?php
			foreach($workout['WorkoutAttribute'] as $workoutAttributes)
			{
				?>
				<div class="main-attribute-block">
					<div class="workout-template-name"><?php echo strtoupper($workoutAttributes['name']); ?></div>
					<?php
						foreach($workoutAttributes['WorkoutAttributeDetail'] as $attributes)
						{
							?>
								<div class="workout-attributes-detail-block">
									<?php echo $attributes['name']; ?> : 
									<?php echo $attributes['value']; ?> / 
									<input type="text" value="" id="member-input" />
									<input type="hidden" value="<?php echo trim($attributes['name']); ?>" id="workout_attribute_name" />
									<input type="hidden" value="<?php echo trim($workoutAttributes['id']); ?>" id="workout_attribute_id" />
								</div>
							<?php
						}
					?>
					<br /><br />
					<div class="workout-template-name">Previous Results:</div>

					<?php

						if(isset($workoutAttributes['WorkoutUserAttributeDetail']) && count($workoutAttributes['WorkoutUserAttributeDetail']) > 0)
							echo $this->element('previous-results', array('data' => $workoutAttributes['WorkoutUserAttributeDetail']));
						else
							echo "No results logged";

					?>
						
				</div>
				<?php
			}
		?>
	</div>
</div>

<div class="workout-template-details">
	<div id="timer"></div>
</div>

<div class="save-workout-btn" id="workout-btn">
	Start Workout
</div>
<div class="save-workout-btn" id="workout-pause-btn" style="display:none;">
	Pause Workout
</div>

<script type="text/javascript">

	$(document).ready(function() {
		$('#timer').runner();
	});

	$('#workout-btn').click(function() {
	    $('#timer').runner('start');
	    $('#workout-pause-btn').show();
	});

	$('#workout-pause-btn').click(function() {
	    $('#timer').runner('stop');
	    $('#workout-pause-btn').hide();
	});
	
</script>

<div class="save-workout-btn" onclick="saveWorkoutUserValues(<?php echo $workout['Workout']['id']; ?>);">Save Workout</div>