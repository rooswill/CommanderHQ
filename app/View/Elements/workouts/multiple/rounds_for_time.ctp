<h1>Rounds For Time</h1>
<div class="tabata-container">
	<div class="tabata-row" data-row="1">
		<div class="template-details cols-2">
			<div class="attribute-label">ROUNDS</div>
			<div class="attribute-input">
				<span class="add-rounds">+</span> / <span class="remove-rounds">-</span>
				<input type="text" value="0" placeholder="0" id="rounds" />
			</div>
		</div>
		<div class="template-details cols-2">
			<div class="attribute-label">TIME / NOT TIMED</div>
			<div class="attribute-input"><input type="text" value="" placeholder="00:00" id="time" /></div>
		</div>
		<div class="clear"></div>
		<div class="template-details cols-1">
			<div class="attribute-label">AS PERSCRIBED</div>
			<div class="attribute-input"><input type="checkbox" value="1" placeholder="#" id="as_perscribed" /></div>
		</div>
		<div class="template-details cols-1">
			<div class="attribute-label">MODIFIED</div>
			<div class="attribute-input"><input type="checkbox" value="1" placeholder="#" id="modified" /></div>
		</div>
		<div class="clear"></div>
	</div>

	<a href="#exerciseList"><div class="workout-btns">Add Activity</div></a>
	<div class="clear"></div>
	<div class="selected-exercise-type">
		<div class="selected-exercise-type-content"></div>
		<div class="clear"></div>
	</div>

</div>

<div class="saved-exercise-list">
	<div class="clear"></div>
</div>

<div class="save-workout-btn" onclick="saveWorkout();">Save Workout</div>

<script type="text/javascript">

	$(document).ready(function(){
		
		$('.add-rounds').click(function(){
			var value = parseInt($('#rounds').val());
			rounds = value + 1;
			$('#rounds').attr('value', rounds);
		});

		$('.remove-rounds').click(function(){
			var value = parseInt($('#rounds').val());
			rounds = value - 1;
			$('#rounds').attr('value', rounds);
		});

	});

</script>