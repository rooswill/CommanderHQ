<h1>Every Minute On The Minute</h1>
<div class="emotm-container">
	<div class="emotm-row" data-row="1">
		<div class="template-details cols-4">
			<div class="attribute-label">EVERY (time)</div>
			<div class="attribute-input"><input type="text" value="" placeholder="#" id="sets" /></div>
		</div>
		<div class="template-details cols-4">
			<div class="attribute-label">REPS</div>
			<div class="attribute-input"><input type="text" value="" placeholder="#" id="reps" /></div>
		</div>
		<div class="template-details cols-4">
			<div class="attribute-label">WEIGHT</div>
			<div class="attribute-input"><input type="text" value="" placeholder="#" id="weight" /></div>
		</div>
		<div class="template-details cols-4">
			<div class="attribute-label">NUMBER OF SETS</div>
			<div class="attribute-input"><input type="text" value="" placeholder="#" id="reps" /></div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="add-emotm-set" id="addRow">ADD SET</div>

<a href="#exerciseList"><div class="workout-btns">Add Activity</div></a>
<div class="clear"></div>
<div class="selected-exercise-type">
	<div class="selected-exercise-type-content"></div>
	<div class="clear"></div>
</div>

<div class="saved-exercise-list">
	<div class="clear"></div>
</div>

<div class="save-workout-btn" onclick="saveWorkout();">Save Workout</div>

<script type="text/javascript">
	$(document).ready(function(){

		$('#addRow').click(function(){
			var html = "";		
			var n = $('.emotm-row').length + 1;
			html += '<div class="emotm-row" data-row="'+n+'">';
				html += '<div class="template-details cols-4">';
					html += '<div class="attribute-label">EVERY (time)</div>';
					html += '<div class="attribute-input"><input type="text" value="" placeholder="#" id="sets" /></div>';
				html += '</div>';
				html += '<div class="template-details cols-4">';
					html += '<div class="attribute-label">REPS</div>';
					html += '<div class="attribute-input"><input type="text" value="" placeholder="#" id="reps" /></div>';
				html += '</div>';
				html += '<div class="template-details cols-4">';
					html += '<div class="attribute-label">WEIGHT</div>';
					html += '<div class="attribute-input"><input type="text" value="" placeholder="#" id="weight" /></div>';
				html += '</div>';
				html += '<div class="template-details cols-4">';
					html += '<div class="attribute-label">NUMBER OF SETS</div>';
					html += '<div class="attribute-input"><input type="text" value="" placeholder="#" id="reps" /></div>';
				html += '</div>';
				html += '<div class="clear"></div>';
			html += '</div>';

			$('.emotm-container').append(html);
		});
	});
</script>