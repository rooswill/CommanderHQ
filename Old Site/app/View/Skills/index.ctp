<div class="ui-listview" id="topselection">
	<h1 class="ui-li-heading">Skills Levels</h1>
</div>

<div class="skills-section" id="AjaxOutput">
	<ul data-dividertheme="d" data-theme="c" data-inset="true" data-role="listview" id="toplist" class="ui-listview ui-listview-inset ui-corner-all ui-shadow">
		<?php
			if(isset($skills))
			{
				$counter = 0;
				foreach($skills as $skill)
				{
					if($counter == 0)
						$class = 'ui-first-child';
					else
					{
						if($counter == (count($skills) - 1))
							$class = 'ui-last-child';
						else
							$class = NULL;
					}
					?>
						<li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li <?php echo $class; ?> ui-btn-up-c">
							<div class="ui-btn-inner ui-li">
								<div class="ui-btn-text">
									<a href="/skills/<?php echo $skill['SkillLevel']['id']; ?>" class="ui-link-inherit">Level <?php echo $skill['SkillLevel']['level']; ?></a>
								</div>
								<span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span>
							</div>
						</li>
					<?php
					$counter++;
				}
			}
			else
			{
				if(isset($exersice_list))
				{
					$counter = 0;
					foreach($exersice_list as $id => $exercise)
					{
						if($counter == 0)
							$class = 'ui-first-child';
						else
						{
							if($counter == (count($exersice_list) - 1))
								$class = 'ui-last-child';
							else
								$class = NULL;
						}

						?>
							<li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li <?php echo $class; ?> ui-btn-up-c">
								<div class="ui-btn-inner ui-li">
									<div class="ui-btn-text">
										<a href="/skills/<?php echo $exersice_level; ?>/<?php echo $id; ?>" class="ui-link-inherit"><?php echo $exercise; ?></a>
									</div>
									<span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span>
								</div>
							</li>
						<?php
						$counter++;

					}
				}


				if(isset($skill_details))
				{
					$counter = 0;
					?>
						<ul id="skillslist" data-role="listview" data-inset="true" class="ui-listview ui-listview-inset ui-corner-all ui-shadow">
							<?php
								//pr($skill_details);
								foreach($skill_details as $exersice_values)
								{
									//pr($exersice_values);
									if($counter == 0)
										$class = 'ui-first-child';
									else
									{
										if($counter == (count($skill_details) - 1))
											$class = 'ui-last-child';
										else
											$class = NULL;
									}

									?>
										<li class="ui-li ui-li-static ui-btn-up-c <?php echo $class; ?>">
											<h3 class="ui-li-heading">
												<?php echo $exersice_values['Exercise']['name']; ?>
												<br>
												<span style="font-size:small">
													<strong>
														<?php echo $exersice_values['Attribute']['name']; ?>:
													</strong>
													<?php echo $exersice_values['SkillLevelDetail']['value']; ?>
												</span>
											</h3>
										</li>
									<?php
									$counter++;
								}
							?>
						</ul>
					<?php
				}

			}
		?>
	</ul>
</div>