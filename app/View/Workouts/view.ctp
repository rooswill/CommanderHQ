<h1><?php echo $workout['Workout']['type']; ?></h1>

<div class="workout-template-details">
	Created : <?php echo date("F j, Y, g:i a" , strtotime($workout['Workout']['created'])); ?>
</div>

<div class="workout-template-details">
	<div class="workout-template-name"><?php echo str_replace('_', ' ', strtoupper($workout['WorkoutTemplate'][0]['template_name'])); ?>:</div>
	<div class="workout-template-detail-attributes">
		<?php
			$totalTemplateDetails = count($workout['WorkoutTemplate'][0]['WorkoutTemplateDetail']);
			foreach($workout['WorkoutTemplate'][0]['WorkoutTemplateDetail'] as $workoutDetails)
			{
				?>
					<div class="workout-template-detail-block">
						<?php echo $workoutDetails['name']; ?> : 
						<?php echo $workoutDetails['value']; ?> / 
						<input type="text" value="" id="member-input-template" />
						<input type="hidden" value="<?php echo trim($workoutDetails['value']); ?>" id="original-template-value" />
						<input type="hidden" value="<?php echo trim($workoutDetails['name']); ?>" id="original-template-name" />
					</div>
				<?php
			}
		?>
	</div>
	<br /><br />
	<div class="workout-template-name">Previous Results:</div>
	<div class="workout-template-detail-attributes">
		<div class="workout-template-user-block">
		<?php
			
			$count = 1;
			$totalUserCount = count($workout['WorkoutTemplate'][0]['WorkoutUserTemplateDetail']);

			$totalUserCountDetails = 0;
			
			foreach($workout['WorkoutTemplate'][0]['WorkoutUserTemplateDetail'] as $workoutUserDetails)
			{
				?>
					<div class="workout-template-detail-block">
						<?php echo $workoutUserDetails['name']; ?> : <?php echo $workoutUserDetails['value']; ?>
					</div>
				<?php

				if($count == $totalTemplateDetails)
				{
					if($totalUserCountDetails == ($totalUserCount - 1))
					{
						echo "</div>";
						$count = 0;
					}
					else
					{
						echo "</div><div class='workout-template-user-block'>";
						$count = 0;
					}
				}

				$count++;
				$totalUserCountDetails++;
			}
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
								<div class="workout-template-detail-block">
									<?php echo $attributes['name']; ?> : 
									<?php echo $attributes['value']; ?> / 
									<input type="text" value="" id="member-input" />
									<input type="hidden" value="<?php echo trim($attributes['value']); ?>" id="original-input" />
									<input type="hidden" value="<?php echo trim($attributes['name']); ?>" id="original-attribute" />
								</div>
							<?php
						}
					?>
					<br /><br />
					<div class="workout-template-name">Previous Results:</div>

					<?php

						$userData = '';

						if(count($workoutAttributes['WorkoutUserAttributeDetail']) >= 0)
						{
							$createdData = $workoutAttributes['WorkoutUserAttributeDetail'][0]['created'];

							foreach($workoutAttributes['WorkoutUserAttributeDetail'] as $userAttributes)
								$userData .= $userAttributes['name'].' : '.$userAttributes['value'].', ';

						}
						else
							$userData = 'You have not recorded any information yet.';

					?>
						<div class="workout-template-detail-block">
							Created : <?php echo date("F j, Y, g:i a" , strtotime($createdData)); ?><br />
							Results: <?php echo $userData; ?>
						</div>
				</div>
				<?php
			}
		?>
	</div>
</div>

<div class="save-workout-btn" onclick="saveWorkout();">Save Workout</div>