

<div id="gridcontainer">

  <div class="grid size-3" style="float:left;">
    <a href="/members/workouts">
      <img class="Aicon" alt="WOD" src="/img/640/wod.png"/><br />
      <div class="tagIcon" style="">Workouts</div>
    </a>
  </div>

  <div class="grid size-3" style="float:left;">
    <a href="/members/progress">
      <img class="Aicon" alt="Reports" src="/img/640/reports.png"/><br />
      <div class="tagIcon" style="">Progress</div>
    </a>
  </div>

  <div class="grid size-3" style="float:left;">
    <a href="/skills">
      <img class="Aicon" alt="Skills" src="/img/640/skills.png"/><br />
      <div class="tagIcon" style="">Skills Level</div>
    </a>
  </div>

  <div class="clear"></div>

  <div class="grid size-3" style="float:left;">
    <a href="/locator">
      <img class="Aicon" alt="Affiliates" src="/img/640/affiliates.png"/><br />
      <div class="tagIcon" style="">Affiliates</div>
    </a>
  </div>

  <div class="grid size-3" style="float:left;">
    <a href="/about">
      <img class="Aicon" alt="About" src="/img/640/crossfit.png"/><br />
      <div class="tagIcon" style="">About Us</div>
    </a>
  </div>

  <div class="grid size-3" style="position: relative;float:left;">
    <span id="CountContainer"></span>
    <!--a href="#" onclick="OpenThisPage('?module=challenge');"-->
    <img class="Aicon" alt="Challenge" src="/img/640/challenges.png"/><br />
    <div class="tagIcon tagIconComing" style="">Challenges</div>
    <!--/a-->
  </div>

  <div class="clear"></div>

  <div class="grid size-3" style="float:left;">
    <a href="/members/profile">
      <img class="Aicon" alt="Profile" src="/img/640/profile.png"/><br />
      <div class="tagIcon" style="">Profile</div>
    </a>
  </div>

  <div class="grid size-3" style="float:left;">
    <a href="/converter">
      <img class="Aicon" alt="Converter" src="/img/640/converter.png"/><br />
      <div class="tagIcon" style="">Converter</div>
    </a>
  </div>

  <div class="grid size-3" style="float:left;">
    <a href="/videos">
      <img class="Aicon" alt="Video search" src="/img/640/video.png"/><br />
      <div class="tagIcon" style="">Video search</div>
    </a>
  </div>

</div>
<div class="clear"></div>

<?php
  if(isset($subscribed))
  {
    if(!$subscribed)
    {
      ?>
        <div class="unlock-block">
          <a href="/members/subscribe"><img alt="Subscribe" src="/img/640/home_banner.png"/></a>
        </div>
      <?php
    }
  }
?>

<div class="clear"></div>