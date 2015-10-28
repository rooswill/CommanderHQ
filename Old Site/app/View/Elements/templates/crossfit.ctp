<div class="template-content">
	<h1>Crossfit Template</h1>
	<div class="crossfit-header">
		<a href="#exerciseList"><div class="workout-btns">Single Movement</div></a>
		<a href="#exerciseList"><div class="workout-btns">Multiple Movements</div></a>
		<a href="#exerciseList"><div class="workout-btns">Favourite Workouts</div></a>
		<a href="#exerciseList"><div class="workout-btns">Popular Workouts</div></a>
		<div class="clear"></div>
	</div>

	<div class="workout-type"></div>

	<nav id="exerciseList">
	    <ul>
	        <?php
	            foreach($exercise_list as $exercise)
	            {
	                ?>
	                    <li class="exercise-type-selected"><?php echo $exercise['Exercise']['name']; ?></li>
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
		<?php
            foreach($templates as $template)
            {
                ?>
                    <div class="main-template-btn" data-template="<?php echo $template['Template']['template']; ?>"><?php echo $template['Template']['name']; ?></div>
                <?php
            }
        ?>
        <div class="clear"></div>
	</div>

	<div class="selected-template-content"></div>

</div>