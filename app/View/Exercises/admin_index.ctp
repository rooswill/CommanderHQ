<h1>EXERCISES</h1><br /><br />
<div class="clear"></div>
<div class="admin-exercise-list">
	<?php
		foreach($exercises as $exercise)
		{
			?>
				<div class="exercise-box">
					<div class="exercise-name-box">
						<?php echo $exercise['Exercise']['name']; ?>
						<div class="attribute-list" style="display:none;" id="attribute-list-<?php echo $exercise['Exercise']['id']; ?>">
							<?php
								foreach($exercise['Attribute'] as $attr)
								{
									?>
										<div class="attribute-item-block" id="attribute-item-box-<?php echo $attr['ExerciseAttribute']['id']; ?>">
											<div class="attribute-list-item"><?php echo $attr['name']; ?></div>
											<div class="attribute-list-action"><a onclick="deleteAttribute(<?php echo $attr['ExerciseAttribute']['id']; ?>);" style="color:#c82114;">Delete</a></div>
											<div class="clear"></div>
										</div>
									<?php
								}
							?>
						</div>
					</div>
					<div class="exercise-action-box">
						<a style="color:#c82114;" onclick="$('#attribute-list-<?php echo $exercise['Exercise']['id']; ?>').toggle();">View</a> | 
						<a href="" style="color:#c82114;" onclick="deleteExercise(<?php echo $exercise['Exercise']['id']; ?>);">Delete</a> | 
						<a href="" style="color:#c82114;">Edit</a>
					</div>
					<div class="clear"></div>
				</div>
			<?php
		}
	?>
</div>