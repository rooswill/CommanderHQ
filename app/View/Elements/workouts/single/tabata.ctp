<h1>Tabata</h1>
<div class="tabata-container">
	<div class="tabata-row" data-row="1">
		<div class="template-details cols-3">
			<div class="attribute-label">NUMBER</div>
			<div class="attribute-input"><input type="text" value="" placeholder="#" id="number" /></div>
		</div>
		<div class="template-details cols-3">
			<div class="attribute-label">REPS</div>
			<div class="attribute-input"><input type="text" value="" placeholder="#" id="reps" class="adding-values" /></div>
		</div>
		<div class="template-details cols-3">
			<div class="attribute-label">WEIGHT</div>
			<div class="attribute-input"><input type="text" value="" placeholder="#" id="weight" class="adding-values" /></div>
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="tabata-totals">
	<div class="template-details cols-2">
		<div class="attribute-label">TOTAL REPS</div>
		<div class="attribute-input" id="total-reps-value"></div>
	</div>
	<div class="template-details cols-2">
		<div class="attribute-label">TOTAL WEIGHT</div>
		<div class="attribute-input" id="total-weight-value"></div>
	</div>
	<div class="clear"></div>
</div>

<div class="add-tabata-set" id="addTabataRow">ADD SET</div>

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
		$('#addTabataRow').click(function(){
			var html = "";		
			var n = $('.tabata-row').length + 1;
			html += '<div class="tabata-row" data-row="'+n+'">';
				html += '<div class="template-details cols-3">';
					html += '<div class="attribute-label">NUMBER</div>';
					html += '<div class="attribute-input"><input type="text" value="" placeholder="#" id="number" /></div>';
				html += '</div>';
				html += '<div class="template-details cols-3">';
					html += '<div class="attribute-label">REPS</div>';
					html += '<div class="attribute-input"><input type="text" value="" placeholder="#" id="reps" class="adding-values" /></div>';
				html += '</div>';
				html += '<div class="template-details cols-3">';
					html += '<div class="attribute-label">WEIGHT</div>';
					html += '<div class="attribute-input"><input type="text" value="" placeholder="#" id="weight" class="adding-values" /></div>';
				html += '</div>';
				html += '<div class="clear"></div>';
			html += '</div>';
			$('.tabata-container').append(html);
		});

		$(".adding-values").keyup(function() {
	  		if(!isNaN(parseInt(this.value)))
	  		{
	  			var value = parseInt($('#total-'+this.id+'-value').html());
	  			
	  			if(isNaN(value))
	  				value = 0

	  			var new_value = parseInt(this.value) + value;

	  			$('#total-'+this.id+'-value').html(new_value);
	  		}
		});

	});
</script>