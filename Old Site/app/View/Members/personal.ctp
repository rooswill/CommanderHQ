<div class="ui-listview" id="topselection">
	<h1 class="ui-li-heading">My Personal WODs</h1>
</div>

<div class="AjaxOutputForWODs" id="AjaxOutput">
	<div class="listingblock">
		<?php
			if(isset($data) && ($data['type'] == 'success'))
			{
				?>
					<ul data-dividertheme="d" data-theme="c" data-inset="true" data-role="listview" class="listview ui-listview ui-listview-inset ui-corner-all ui-shadow">
						<?php
							foreach($data['data'] as $workout)
							{
								?>
									<li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-first-child ui-btn-up-c">
										<div class="ui-btn-inner ui-li">
											<div class="ui-btn-text">
												<a href="/members/workouts/personal/edit/<?php echo $workout['Workout']['id']; ?>" class="ui-link-inherit"><?php echo $workout['Workout']['name']; ?>:<br>
													<span style="font-size:small"><?php echo $workout['Workout']['notes']; ?></span>
												</a>
											</div>
											<span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span>
										</div>
									</li>
								<?php
							}
						?>
					</ul>
				<?php
			}
			else
				echo "<p>Your have not logged any personal WOD's yet.</p>";
		?>
		<div class="clear"></div>
		<br>
	</div>
	<div class="clear"></div>
	<br>
</div>