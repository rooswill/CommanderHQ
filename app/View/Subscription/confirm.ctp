<br />
<div id="bodytext">
	<div class="user-profile-name">
	  Subscription Confirmation
	</div>
	<p>
		Please make sure the following details are correct.
	</p>
</div>

<div class="user-profile-content" style="margin:0px 2%;">
	<div class="user-profile-content-block">
		<div class="left-content">Name</div>
		<div class="divider-content">:</div>
		<div class="right-content"><?php echo $user_details['Member']['name']; ?></div>
		<div class="clear"></div>
	</div>
	<div class="user-profile-content-block">
		<div class="left-content">Surname</div>
		<div class="divider-content">:</div>
		<div class="right-content"><?php echo $user_details['Member']['surname']; ?></div>
		<div class="clear"></div>
	</div>
	<div class="user-profile-content-block no-border">
		<div class="left-content">Email</div>
		<div class="divider-content">:</div>
		<div class="right-content"><?php echo $user_details['Member']['email']; ?></div>
		<div class="clear"></div>
	</div>
</div>

<div id="bodytext">
	<p>
		Please select the subscription package you would like to purchase.
	</p>
	<select name="membership_package" onchange="updateSubscription(this.value);" autocomplete="off" id="subscription_package">
		<option value='--'>-- Please select package --</option>
		<option value='<?php echo SUBSCRIPTION_PRICE; ?>'>1 Month</option>
		<?php
			for($i = 0; $i <= 12; $i += 6)
			{
				if($i != 0)
					echo "<option value='".SUBSCRIPTION_PRICE * $i."'> ".$i." Month</option>";
			}
		?>
	</select>
</div>

<form action="https://<?php echo $payfast_host; ?>/eng/process" method="post" name="paymentForm" id="paymentForm">
	<input type="hidden" name="merchant_id" value="<?php echo MERCHANT_ID_TEST; ?>" />
	<input type="hidden" name="merchant_key" value="<?php echo MERCHANT_KEY_TEST; ?>" />
	<input type="hidden" name="return_url" value="<?php echo RETURN_URL; ?>" />
	<input type="hidden" name="cancel_url" value="<?php echo CANCEL_URL; ?>" />
	<input type="hidden" name="notify_url" value="<?php echo PROCESS_URL; ?>" />
	<input type="hidden" name="name_first" value="<?php echo $user_details['Member']['name']; ?>" />
	<input type="hidden" name="name_last" value="<?php echo $user_details['Member']['surname']; ?>" />
	<input type="hidden" name="email_address" value="<?php echo $user_details['Member']['email']; ?>" />
	<input type="hidden" name="m_payment_id" value="<?php echo $user_details['Member']['id']; ?>" />
	<input type="hidden" name="amount" id="subscription_amount" value="" />
	<input type="hidden" name="item_name" id="subscription_name" value="" />
	<input type="hidden" name="item_description" value="" />
	<input type="hidden" name="custom_int1" id="subscription_period" value="" />
</form>

<div class="user-profile-content" style="margin:0px 2%;">
	<div class="user-profile-content-block no-border">
		<div class="left-content">Total</div>
		<div class="divider-content">:</div>
		<div class="right-content" id="subscription_total_value">R 0.00</div>
		<div class="clear"></div>
	</div>
</div>
<br /> <br />
<div class="custommargintopten" style="margin:0px 2%;">
	<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="b" data-disabled="false" class="ui-btn ui-btn-up-b ui-shadow ui-btn-corner-all" aria-disabled="false">
		<span class="ui-btn-inner">
			<span class="ui-btn-text">Update Subscription</span>
		</span>
		<a href="#" onclick="processSubscription();" type="button" data-theme="b" class="ui-btn-hidden" data-disabled="false">Update Subscription</a>
	</div>
</div>