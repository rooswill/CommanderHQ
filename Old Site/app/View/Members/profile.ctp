<?php
  if(isset($profile['data']['MemberSubscription'][0]['subscription_date']))
      $subscription = date('F d, Y', strtotime($profile['data']['MemberSubscription'][0]['subscription_date']));
  else
      $subscription = 'N/A';

  if(isset($profile['data']['MemberSubscription'][0]['subscription_expires']))
      $subscription_expires = date('F d, Y', strtotime($profile['data']['MemberSubscription'][0]['subscription_expires']));
  else
      $subscription_expires = 'N/A';

  if(isset($profile['data']['MemberSubscription'][0]['active']) && $profile['data']['MemberSubscription'][0]['active'] == 1)
      $active = 'Active';
  else
      $active = 'Inactive';

  if(isset($profile['data']['Member']['dob']))
      $dob = $profile['data']['Member']['dob'];
  else
      $dob = 'Pending';


    if(isset($profile['data']['MemberSubscription'][0]['subscription_date']) && isset($profile['data']['MemberSubscription'][0]['subscription_expires']))
    {
      // check days remaining;
      $sub = strtotime($profile['data']['MemberSubscription'][0]['subscription_date']);
      $exp = strtotime($profile['data']['MemberSubscription'][0]['subscription_expires']);
      $datediff = $exp - $sub;
      $remaining = floor($datediff / (60 * 60 * 24));
    }
?>

<div class="user-profile">
  <div class="user-profile-image">

    <?php

      $filename_profile = WWW_ROOT . $profile['data']['Member']['profile_picture'];

      if(file_exists($filename_profile))
          $profile_picture = $profile['data']['Member']['profile_picture'];
      else
          $profile_picture = "/img/640/profile-image.png";

    ?>


    <img src="<?php echo $profile_picture; ?>">
  </div>
  <div class="user-profile-details">

    <div class="user-profile-name">
      <?php echo ucfirst($profile['data']['Member']['name'])." ".ucfirst($profile['data']['Member']['surname']); ?>
    </div>

    <div class="user-profile-content">
      <div class="user-profile-content-block">
        <div class="left-content">Email</div>
        <div class="divider-content">:</div>
        <div class="right-content"><?php echo $profile['data']['Member']['email']; ?></div>
        <div class="clear"></div>
      </div>
      <div class="user-profile-content-block">
        <div class="left-content">Cellphone</div>
        <div class="divider-content">:</div>
        <div class="right-content"><?php echo $profile['data']['Member']['cellphone']; ?></div>
        <div class="clear"></div>
      </div>
      <div class="user-profile-content-block">
        <div class="left-content">DOB</div>
        <div class="divider-content">:</div>
        <div class="right-content"><?php echo $dob; ?></div>
        <div class="clear"></div>
      </div>
      <div class="user-profile-content-block">
        <div class="left-content">Gender</div>
        <div class="divider-content">:</div>
        <div class="right-content"><?php echo $profile['data']['Member']['gender']; ?></div>
        <div class="clear"></div>
      </div>
      <div class="user-profile-content-block">
        <div class="left-content">Height</div>
        <div class="divider-content">:</div>
        <div class="right-content"><?php echo $profile['data']['MemberDetail'][0]['height']; ?> cm</div>
        <div class="clear"></div>
      </div>
      <div class="user-profile-content-block no-border">
        <div class="left-content">Weight</div>
        <div class="divider-content">:</div>
        <div class="right-content"><?php echo $profile['data']['MemberDetail'][0]['weight']; ?> kg</div>
        <div class="clear"></div>
      </div>
    </div>

    <div class="custommargintopten">
      <div><div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="b" data-disabled="false" class="ui-btn ui-btn-up-b ui-shadow ui-btn-corner-all" aria-disabled="false">
        <span class="ui-btn-inner">
          <span class="ui-btn-text">Edit Profile</span>
        </span>
        <a href="/members/edit/<?php echo $profile['data']['Member']['id']; ?>" type="button" data-theme="b" class="ui-btn-hidden" data-disabled="false">Edit Profile</a>
      </div>
    </div>

    <?php
      if(isset($member_gym))
      {
        ?>
          <div class="user-profile-name">
            My Gym
          </div>
          <div class="user-profile-content">
            <div class="user-profile-content-block no-border">
              <div class="left-content">Gym Name</div>
              <div class="divider-content">:</div>
              <div class="right-content"><?php echo $member_gym; ?></div>
              <div class="clear"></div>
            </div>
          </div>
        <?php
      }

    ?>


    <div class="user-profile-name">
      Subscription Details
    </div>

    <div class="user-profile-content">
      <div class="user-profile-content-block">
        <div class="left-content">Member Status</div>
        <div class="divider-content">:</div>
        <div class="right-content"><?php echo $active; ?></div>
        <div class="clear"></div>
      </div>
      <div class="user-profile-content-block">
        <div class="left-content">Member since</div>
        <div class="divider-content">:</div>
        <div class="right-content"><?php echo $subscription; ?></div>
        <div class="clear"></div>
      </div>
      <div class="user-profile-content-block no-border">
        <div class="left-content">Membership Expire</div>
        <div class="divider-content">:</div>
        <div class="right-content"><?php echo $subscription_expires; ?></div>
        <div class="clear"></div>
      </div>
      <?php
        if(isset($remaining))
        {
          ?>
            <div class="user-profile-content-block no-border">
              <div class="left-content">Remaining Days</div>
              <div class="divider-content">:</div>
              <div class="right-content"><?php echo $remaining; ?></div>
              <div class="clear"></div>
            </div>
          <?php
        }
      ?>
    </div>

    <div class="custommargintopten">
      <div><div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="b" data-disabled="false" class="ui-btn ui-btn-up-b ui-shadow ui-btn-corner-all" aria-disabled="false">
        <span class="ui-btn-inner">
          <span class="ui-btn-text">Update Subscription</span>
        </span>
        <a href="/subscription/confirm" type="button" data-theme="b" class="ui-btn-hidden" data-disabled="false">Update Subscription</a>
      </div>
    </div>


    <div class="user-profile-name">
      Workout Details
    </div>

    <div class="user-profile-content">
      <div class="report-tbl-row">
        <div class="left-content">Logged Workouts</div>
        <div class="divider-content">:</div>
        <div class="right-content"><?php echo $user_workouts; ?></div>
        <div class="clear"></div>
      </div>
    </div>
  </div>

</div>