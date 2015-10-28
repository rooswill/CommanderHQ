<h1>TIME EACH ROUND</h1>
<div class="tabata-container">
	<div class="tabata-row" data-row="1">
		<div class="template-details cols-1">
			<div class="attribute-label">ROUNDS</div>
			<div class="attribute-input">
				<span class="add-rounds">+</span> / <span class="remove-rounds">-</span>
				<div class="rounds-for-time-rounds">0</div>
			</div>
		</div>
		<div class="clear"></div>

		<div class="template-details cols-1">
			<div class="attribute-label">REST BETWEEN ROUNDS</div>
			<div class="attribute-input">
				<input type="input" value="" placeholder="#" id="sets" />
			</div>
		</div>
		<div class="clear"></div>

		<div class="template-details cols-2">
			<div class="attribute-label">TOTAL TIME</div>
		</div>
		<div class="template-details cols-2">
			<div class="attribute-input">
				1: <input type="input" value="" placeholder="#" id="sets" />
			</div>
		</div>
		<div class="clear"></div>

		<div class="template-details cols-1">
			<div class="attribute-label">AS PERSCRIBED</div>
			<div class="attribute-input"><input type="checkbox" value="1" placeholder="#" id="sets" /></div>
		</div>
		<div class="template-details cols-1">
			<div class="attribute-label">MODIFIED</div>
			<div class="attribute-input"><input type="checkbox" value="1" placeholder="#" id="sets" /></div>
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
	
</div>

<div class="save-workout-btn" onclick="saveWorkout();">Save Workout</div>

<script type="text/javascript">

	$(document).ready(function(){
		
		$('.add-rounds').click(function(){
			var value = parseInt($('.rounds-for-time-rounds').html());
			rounds = value + 1;
			$('.rounds-for-time-rounds').html(rounds);
		});

		$('.remove-rounds').click(function(){
			var value = parseInt($('.rounds-for-time-rounds').html());
			rounds = value - 1;
			$('.rounds-for-time-rounds').html(rounds);
		});

	});

</script>