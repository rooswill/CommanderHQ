<ul id="admin-menu">
<a href="/admin/reports"><li>Dashboard</li></a>
<a href="/admin/workouts/add"><li>Create WOD</li></a>
<!--<a href="#"><li>Historic</li></a>-->
<!--<a href="#"><li>Booking</li></a>-->
<!--<a href="#"><li>Messages</li></a>-->
<a href="/admin/workouts"><li>WODs</li></a>
<!--a href="?module=challenges"><li>Challenges</li></a-->
<a href="/admin/logout"><li>logout</li></a>

<div style="float: right;">
  <li style="font-size:14px;">
    <div style="margin: -10px 10px 0 0;display:inline-block">
      <img src="/img/admin/profile.png" height="40px" width="40px">
    </div>
    <div style="display:inline-block;margin-top: 2px !important;vertical-align: top;">
      <?php
        echo $user['username'];
      ?>
    </div>
  </li>
</div>
</ul>