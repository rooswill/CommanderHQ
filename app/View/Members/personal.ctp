<div class="ui-listview" id="topselection">
	<h1 class="ui-li-heading">My Personal WODs</h1>
</div>

<div class="AjaxOutputForWODs" id="AjaxOutput">
	<div class="listingblock">
		<?php
			if(isset($data) && ($data['type'] == 'success'))
			{
				?>
						<?php
							foreach($data['data'] as $workout)
							{
								?>
									<div class="main-workout-container">
										<a href="/workouts/view/<?php echo $workout['Workout']['id']; ?>"><?php echo $workout['Workout']['created']; ?> : <?php echo $workout['Workout']['type']; ?><br></a>
										<span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span>
									</div>
								<?php
							}
						?>
					</ul>
				<?php
			}
			else
				echo "<p>Your have not logged any personal workouts yet.</p>";
		?>
		<div class="clear"></div>
		<br>
	</div>
	<div class="clear"></div>
	<br>
</div>