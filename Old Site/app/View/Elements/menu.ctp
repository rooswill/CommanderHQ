<?php

  if(CakeSession::read('global_user_info'))
  {
    $user_info = CakeSession::read('global_user_info');
    $link = '<a href="/members/profile" class="contentLink menu-profile" style="">'.$user_info[0]['Member']['username'].'</a>';
    $login = '<a href="/members/logout" class="contentLink menu-logout" style="">Logout</a>';
    $member = '';
  }
  else
  {
    $link = '<a href="/members/login" class="contentLink menu-profile" style="">Profile</a>';
    $login = '<a href="/members/login" class="contentLink menu-logout" style="">Sign In</a>';
    $member = '<li style=""><a href="/subscription/confirm" class="contentLink menu-unlock" style="">Unlock Commander HQ+</a></li>';
  }
  
   
?>
<nav id="my-menu">
  <ul>
    <li style="">
      <?php echo $link; ?>
    </li>
    <?php
      echo $member;
    ?>
    <li class="Divider">WOD</li>
    <li style="">
      <a href="/members/mygym" class="contentLink menu-my-gym" style="">My Gym WOD</a>
    </li>
    <li style="">
      <a href="/members/workouts/custom" class="contentLink menu-personal-create" style="">Create Personal WOD</a>
    </li>
    <li style="">
      <a href="/members/workouts/personal" class="contentLink menu-personal-wod" style="">My Personal WODs</a>
    </li>
    <li style="">
      <a href="/members/benchmark" class="contentLink menu-benchmark" style="">Benchmarks</a>
    </li>
    <li style="">
      <a href="/members/workouts/completed" class="contentLink menu-completed" style="">Completed WODs</a>
    </li>
    <li class="Divider">FEATURES</li>
    <li style="">
      <a href="/members/progress" class="contentLink menu-progress" style="">Progress</a>
    </li>
    <li style="">
      <a href="/members/baseline" class="contentLink menu-baseline" style="">My Baselines</a>
    </li>
    <li style="">
      <a href="/skills" class="contentLink menu-skill-level" style="">Skills Level</a>
    </li>
    <li class="Divider">MY GYM</li>
    <li style="">
      <a href="/members/registergym" class="contentLink menu-register-gym" style="">Register my gym</a>
    </li>
    <li style="">
      <a href="/locator" class="contentLink menu-affiliates" style="">Affiliates</a>
    </li>
    <li style="">
      <a href="/about" class="contentLink menu-about-use" style="">About Us</a>
    </li>
    <li class="Divider">TOOLS</li>
    <li style="">
      <a href="/videos" class="contentLink menu-video" style="">Video Search</a>
    </li>
    <li style="">
      <a href="/converter" class="contentLink menu-convertor" style="">Converter</a>
    </li>
    <li class="Divider"></li>
    <li style="">
      <a href="/help" class="contentLink menu-help" style="">Help</a>
    </li>
    <li style="">
      <a href="/terms" class="contentLink menu-terms" style="">Terms &amp; Conditions</a>
    </li>
    <li style="">
      <?php echo $login; ?>
    </li>
  </ul>
</nav>