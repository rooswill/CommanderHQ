<div class="ui-listview" id="topselection">
	<h1 class="ui-li-heading">Benchmarks</h1>
</div>

<div class="AjaxOutputForWODs" id="AjaxOutput">
	<?php
	if(isset($benchmarks) && is_array($benchmarks))
	{
		?>
			<ul data-dividertheme="d" data-theme="c" data-inset="true" data-role="listview" class="listview ui-listview ui-listview-inset ui-corner-all ui-shadow">
				<?php
				$counter = 0;
				foreach($benchmarks as $benchmark)
				{
					if($counter <= 0)
						$class = 'ui-first-child';
					else
					{
						if($counter == (count($benchmarks) - 1))
							$class = 'ui-last-child';
						else
							$class = NULL;
					}

					?>
					<li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c" class="ui-btn ui-btn-icon-right ui-li-has-arrow <?php echo $class; ?> ui-li ui-btn-up-c">
						<div class="ui-btn-inner ui-li">
							<div class="ui-btn-text">
								<a href="/members/benchmark/<?php echo $benchmark['Benchmark']['id']; ?>" class="ui-link-inherit"><?php echo $benchmark['Benchmark']['name']; ?>:<br>
									<span style="font-size:small">
										<?php echo $benchmark['Benchmark']['male_description']; ?>
									</span>
								</a>
							</div>
							<span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span>
						</div>
					</li>
					<?php

					$counter++;
				}
				?>
			</ul>
			<div class="clear"></div><br>
		<?php
	}
	else
	{
		if(isset($benchmark_details))
		{
			?>
				<div id="AjaxOutput" class="AjaxOutputForWODs">
				<h2><?php echo $benchmark_details[0]['Benchmark']['name']; ?></h2>
				<div class="description ui-collapsible  ui-collapsible-inset ui-corner-all" data-role="collapsible" data-collapsed="false" data-iconpos="right" data-collapsed-icon="arrow-r" and="" data-expanded-icon="arrow-d">
					<h3 style="font-size:small" class="ui-collapsible-heading">
						<a href="#" class="ui-collapsible-heading-toggle ui-btn ui-btn-up-c ui-fullsize ui-btn-icon-right" data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="span" data-icon="arrow-r" data-iconpos="right" data-theme="c" data-mini="false">
							<span class="ui-btn-inner">
								<span class="ui-btn-text">
									Description
									<span class="ui-collapsible-heading-status"> click to collapse contents</span>
								</span>
								<span class="ui-icon ui-icon-shadow ui-icon-arrow-d">&nbsp;</span>
							</span>
						</a>
					</h3>
					<div class="ui-collapsible-content" aria-hidden="false">
						<span data-role="fieldcontain" style="font-size:small">
							<?php echo nl2br($benchmark_details[0]['Benchmark']['male_description']); ?>
						</span>
					</div>
				</div>
				<div data-role="collapsible" data-collapsed="false" data-iconpos="right" data-collapsed-icon="arrow-r" and="" data-expanded-icon="arrow-d" class="RoutineBlock ui-collapsible  ui-collapsible-inset ui-corner-all">
				
					<h2 class="ui-collapsible-heading">
						<a href="#" class="ui-collapsible-heading-toggle ui-btn ui-btn-up-c ui-fullsize ui-btn-icon-right" data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="span" data-icon="arrow-r" data-iconpos="right" data-theme="c" data-mini="false">
							<span class="ui-btn-inner">
								<span class="ui-btn-text">Routine 1
									<span class="ui-collapsible-heading-status"> click to collapse contents</span>
								</span>
								<span class="ui-icon ui-icon-shadow ui-icon-arrow-d">&nbsp;</span>
							</span>
						</a>
					</h2>
					<?php
					foreach($exercise_details as $exercise)
					{
						foreach($exercise as $round => $data)
						{
							?>
							<div class="ui-collapsible-content" aria-hidden="false">
								<h3>Round <?php echo $round; ?></h3>
								<?php
									foreach($data as $e)
									{
										?>
											<h4 class="ui-collapsible-heading ui-collapsible-heading-collapsed">
												<a href="#" class="ui-collapsible-heading-toggle ui-btn ui-btn-up-c ui-fullsize ui-btn-icon-right" data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="span" data-icon="plus" data-iconpos="right" data-theme="c" data-mini="false">
													<span class="ui-btn-inner">
														<span class="ui-btn-text"><?php echo $e['name']; ?><br>
															<?php
																foreach($e['Attribute'] as $att)
																{
																	?>
																		<span style="font-size:small"><?php echo $att['name']; ?>:</span>
																		<span style="font-size:small;font-weight:normal" id="1_22_Reps_html"><?php echo $e['BenchmarkDetail']['value_male']; ?></span>
																	<?php
																}
															?>
															<span class="ui-collapsible-heading-status"> click to expand contents</span>
														</span>
														<span class="ui-icon ui-icon-plus ui-icon-shadow">&nbsp;</span>
													</span>
												</a>
											</h4>
										<?php
									}
								?>
							</div>
							<div class="clear"></div>
						<?php
						}
					}
				?>
			</div>
			<?php
		}
	}
?>