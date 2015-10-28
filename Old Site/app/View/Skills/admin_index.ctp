<h1>SKILLS</h1><br /><br />
<div class="clear"></div>
<div class="admin-exercise-list">
	<?php
		foreach($skills as $skill)
		{
			?>
				<div class="exercise-box">
					<div class="exercise-name-box">
						Skill Level <?php echo $skill['SkillLevel']['level']; ?>
						<div class="attribute-list" style="display:none;" id="attribute-list-<?php echo $skill['SkillLevel']['id']; ?>">
							<?php
								foreach($skill['SkillLevelDetail'] as $skillLevelDetail)
								{
									//pr($skillLevelDetail);
									?>
										<div class="attribute-item-block" id="attribute-item-box-<?php echo $skillLevelDetail['id']; ?>">
											<div class="attribute-list-item">
												Gender : <?php echo $skillLevelDetail['gender']; ?><br />
												Description : <?php echo $skillLevelDetail['value']; ?><br />
												Attribute : <?php echo (isset($skillLevelDetail['Attribute']['name']) ? $skillLevelDetail['Attribute']['name'] : 'N/A'); ?><br />
												Exercise Type : <?php echo (isset($skillLevelDetail['Exercise']['name']) ? $skillLevelDetail['Exercise']['name'] : 'N/A'); ?>
											</div>
											<div class="attribute-list-action">
												<a onclick="deleteAttribute(<?php echo $skillLevelDetail['id']; ?>);" style="color:#c82114;">Delete</a>
											</div>
											<div class="clear"></div>
										</div>
									<?php
								}
							?>
						</div>
					</div>
					<div class="exercise-action-box">
						<a style="color:#c82114;" onclick="$('#attribute-list-<?php echo $skill['SkillLevel']['id']; ?>').toggle();">View</a> | 
						<a href="" style="color:#c82114;" onclick="deleteExercise(<?php echo $skill['SkillLevel']['id']; ?>);">Delete</a> | 
						<a href="" style="color:#c82114;">Edit</a>
					</div>
					<div class="clear"></div>
				</div>
			<?php
		}
	?>
</div>