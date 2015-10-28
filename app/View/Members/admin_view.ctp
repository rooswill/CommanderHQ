<div class="report-user-details-header">
  <div class="report-tbl-row">
    <div class="report-tbl-item item-center">
      <img src="/img/admin/user.png">
    </div>
    <div class="report-tbl-item-userinfo">
      <span class="report-user-title orange-text">
        <?php echo $member['Member']['name']." ".$member['Member']['surname']; ?>
      </span>
      <br><br>
      <div class="report-tbl-row">
        <div class="report-tbl-item item-left">Height</div>
        <div class="user-tbl-item-colon">:</div>
        <div class="report-tbl-item item-right"><?php echo $member['MemberDetail'][0]['height']; ?> cm</div>
      </div>
      <div class="report-tbl-row">
        <div class="report-tbl-item item-left">Weight</div>
        <div class="user-tbl-item-colon">:</div>
        <div class="report-tbl-item item-right"><?php echo $member['MemberDetail'][0]['weight']; ?> kg</div>
      </div>
      <div class="report-tbl-row">
        <div class="report-tbl-item item-left">Member since</div>
        <div class="user-tbl-item-colon">:</div>
        <div class="report-tbl-item item-right"><?php echo $member['MemberSubscription'][0]['subscription_date']; ?></div>
      </div>
      <div class="report-tbl-row">
        <div class="report-tbl-item item-left">Logged WODs</div>
        <div class="user-tbl-item-colon">:</div>
        <div class="report-tbl-item item-right">0</div>
      </div>
    </div>
    <div class="report-user-total">
      <div class="report-tbl-item-workouts">
        <div class="report-tbl-row">
          <div class="user-tbl-dash-title">Workouts</div>
        </div>
        <div class="report-tbl-row">
          <div class="user-tbl-title-left">Fran</div>
          <div class="report-tbl-user-dash-item item-right">00:00</div>
        </div>
        <div class="report-tbl-row">
          <div class="user-tbl-title-left">Helen</div>
          <div class="report-tbl-user-dash-item item-right">00:00</div>
        </div>
        <div class="report-tbl-row">
          <div class="user-tbl-title-left">Grace</div>
          <div class="report-tbl-user-dash-item item-right">00:00</div>
        </div>
        <div class="report-tbl-row">
          <div class="user-tbl-title-left">Filthy Fifty</div>
          <div class="report-tbl-user-dash-item item-right">00:00</div>
        </div>
        <div class="report-tbl-row">
          <div class="user-tbl-title-left">Fight Gone Bad</div>
          <div class="report-tbl-user-dash-item item-right">02:00</div>
        </div>
        <div class="report-tbl-row">
          <div class="user-tbl-title-left">Sprint 400m</div>
          <div class="report-tbl-user-dash-item item-right">00:00</div>
        </div>
        <div class="report-tbl-row">
          <div class="user-tbl-title-left">Run 5K</div>
          <div class="report-tbl-user-dash-item item-right">00:00</div>
        </div>
      </div>
      <div class="report-tbl-item-maxes">
        <div class="report-tbl-row">
          <div class="user-tbl-dash-title">Maxes</div>
        </div>
        <div class="report-tbl-row">
          <div class="user-tbl-title-left">Clean And Jerk</div> 
          <div class="report-tbl-user-dash-item">0</div>
        </div>
        <div class="report-tbl-row">
          <div class="user-tbl-title-left">Snatch</div>         
          <div class="report-tbl-user-dash-item">0</div>
        </div>
        <div class="report-tbl-row">
          <div class="user-tbl-title-left">Deadlift</div>       
          <div class="report-tbl-user-dash-item">60</div>
        </div>
        <div class="report-tbl-row">
          <div class="user-tbl-title-left">Squats</div>        
          <div class="report-tbl-user-dash-item">0</div>
        </div>
        <div class="report-tbl-row">
          <div class="user-tbl-title-left">Pull Ups</div>      
          <div class="report-tbl-user-dash-item">50</div>
        </div>
      </div>
    </div>  
  </div>
</div>



<!-- User reports -->
<div class="report-user-details-wrapper">
  <div class="report-user-details-block">
    <a href="?module=reports&amp;id=5&amp;userid=1">
      <span class="report-user-details-block-heading">
        <h2>Baseline</h2>
      </span>
      <div class="report-tbl-row-header">
        <div class="report-tbl-item-date">Date</div>
        <div class="report-tbl-item-header">Time</div>
        <div class="report-tbl-item-wodtype">WOD Type</div>
        <div class="report-tbl-item-activity report-tbl-item-activity-user">Activities Completed</div>
      </div>
      <div class="clear"></div>
      <div class="report-tbl-row">
        <div class="report-tbl-item-date orange-text">2015-03-30</div>
        <div class="report-tbl-item-header">00:00</div>
        <div class="report-tbl-item-wodtype orange-text">My Gym</div>
        <div class="report-tbl-item-activity report-tbl-item-activity-user">Box Jump</div>
      </div>
      <div class="clear"></div>
    </a>
  </div>
  <br>

  <div class="report-user-details-block">
    <a href="?module=reports&amp;id=6&amp;userid=1">
      <span class="report-user-details-block-heading">
        <h2>WODs</h2>
      </span>
      <div class="report-tbl-row-header">
        <div class="report-tbl-item-date">Date</div>
        <div class="report-tbl-item-header">Time</div>
        <div class="report-tbl-item-wodtype">WOD Type</div>
        <div class="report-tbl-item-activity report-tbl-item-activity-user">Activities Completed</div>
      </div><div class="clear"></div>
      <div class="report-tbl-row">
        <div class="report-tbl-item-date orange-text">2015-03-30</div>
        <div class="report-tbl-item-header">00:00</div>
        <div class="report-tbl-item-wodtype orange-text">Baselines</div>
        <div class="report-tbl-item-activity report-tbl-item-activity-user">Box Jump</div>
      </div><div class="clear"></div>
    </a>
    <div>
    </div>
  </div>
</div>