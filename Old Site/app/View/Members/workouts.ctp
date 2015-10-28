<div class="home-content-block">
    <a href=""><img src="/img/640/preloaded-workouts.jpg" class="img-responsive" /></a>
</div>

<div class="home-content-block">
    <a href="#activities"><img src="/img/640/create-workout.jpg" class="img-responsive" /></a>
</div>

<div class="home-content-block">
    <a href=""><img src="/img/640/view-personal-workouts.jpg" class="img-responsive" /></a>
</div>

<div class="home-content-block">
    <a href=""><img src="/img/640/completed-workouts.jpg" class="img-responsive" /></a>
</div>

<nav id="activities">
    <ul>
        <?php
            foreach($activities as $activity)
            {
                ?>
                    <li><a href="/members/workouts/custom/?t=<?php echo $activity['Activity']['template']; ?>"><?php echo $activity['Activity']['name']; ?></a></li>
                <?php
            }
        ?>
    </ul>
</nav>