<div class="template-content">
	<h1>Crossfit Template</h1>
	<div class="crossfit-header">
		<a href="#"><div class="workout-btns">Single Movement</div></a>
		<a href="#"><div class="workout-btns">Multiple Movements</div></a>
		<a href="#"><div class="workout-btns">Favourite Workouts</div></a>
		<a href="#"><div class="workout-btns">Popular Workouts</div></a>
		<div class="clear"></div>
	</div>

	<div class="workout-type"></div>

	<nav id="exerciseList">
	    <ul>
	        <?php
	            foreach($exercise_list as $exercise)
	            {
	                ?>
	                    <li class="exercise-type-selected" data-id="<?php echo $exercise['Exercise']['id']; ?>"><?php echo $exercise['Exercise']['name']; ?></li>
	                <?php
	            }
	        ?>
	    </ul>
	</nav>

	<div class="selected-exercise-type">
		<div class="selected-exercise-type-content"></div>
		<div class="clear"></div>
	</div>

	<div class="templates-btns">
        <div class="clear"></div>
	</div>

	<div class="selected-template-content"></div>

	<script type="text/javascript">

		function loadTemplates(type, temp)
		{
			_params = {
				type : type,
				template : temp
			}

			$.ajax({                    
			    url:'/members/templatesRender',
			    type:"POST",                                        
			    data:_params,
			    success: function(data) {
	      			$('.selected-template-content').html(data);
			    }
			});
		}

    </script>

</div>