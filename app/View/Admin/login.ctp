<script type='text/javascript'>
	$(function() {
		function log( message ) {
			$( "#gymname" ).val( message );
		}
		$( "#gymname" ).autocomplete({
			source: "ajax.php?module=login&action=getAffiliates",
			minLength: 2,
			select: function( event, ui ) {
				log( ui.item.value );
			}
		});
	});
	
	<?php /*$Device = new DeviceManager(); if(!$Device->isFullHTML5Compatible()) : ?>
	alert('This is embarrassing! You may have some compatibility issues with this service as our support for legacy browsers is limited. We apologise for the inconvenience and recommend you upgrade to the latest HTML 5 browser to get the best experience from our service.');
	<?php endif;*/ ?>

	function validateForm()
	{
    var x=document.forms["regForm"]["gymname"].value;
		if (x==null || x=="")
		{
			alert("Gym Name required");
			return false;
		}

		var x=document.forms["regForm"]["email"].value;
		var atpos=x.indexOf("@");
		var dotpos=x.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		{
			alert("Not a valid e-mail address");
			return false;
		}else{
      document.regForm.submit();
		}
	}
</script>
<?php /*if (!$Device->isFullHTML5Compatible()) : ?>
	<a href="javascript:;"><div class="compatibility-white-bg">This is embarrassing! You may have some compatibility issues with this service as our support for legacy browsers is limited. We apologise for the inconvenience and recommend you upgrade to the latest HTML 5 browser to get the best experience from our service.</div></a>
<?php endif;*/ ?>
<?php //echo $Display->Message; ?>
<br/><br/>

<div id="content_main">
	<div class="form form_left">
		<form name="form" id="form" method="post" action="/admin/login"> 
			<h2>Login</h2>     
			<div style="padding: 0px 0px 12px 0px;">
				<div class="form_div">
					<input id="username" style="width: 389px;text-transform: none;" type="text" name="username" placeholder="Username" value=""/>
				</div>
			</div>
			<div style="padding: 0px 0px 12px 0px;">
				<div class="form_div">
					<input id="password" style="width: 389px;" type="password" name="password" placeholder="Password" value=""/>
				</div>
			</div>
			<input type="submit" id="submit" value="Login"> 	  
			<div class="clear">&nbsp;</div>    
		</form>
		<p><a href="?module=forgot">Forgotten username/password?</a></p>
	</div>
	<?php //if($Display->Message <> '<div class="register_message">Successfully Registered!<br/>You have been sent an email with your username and password.</div>') : ?>
	<div class="form form_right">
		<form name="regForm" id="regForm" method="post" action="index.php">
			<input type="hidden" name="module" value="login"/>
			<input type="hidden" name="action" value="Register"/>                        
			<h2>Register</h2>     
			<div style="padding: 0px 0px 12px 0px;">
				<div class="form_div"><input id="Gym Name" style="width: 389px;" type="text" id="gymname" name="gymname" placeholder="Affiliate Gym Name" value=""/></div>
			</div>
			<div style="padding: 0px 0px 12px 0px;">
				<div class="form_div"><input id="Location" style="width: 389px;" type="text" name="address" placeholder="Location / Address" value=""/></div>
			</div>
			<h2>Contact person for registration:</h2>
			<div style="padding: 0px 0px 12px 0px;">
				<div class="form_div"><input id="Name" style="width: 389px;" type="text" name="name" placeholder="Name" value=""/></div>
			</div>
			<div style="padding: 0px 0px 12px 0px;">
				<div class="form_div"><input id="Email" style="width: 389px;" type="text" name="email" placeholder="Email" value=""/></div>
			</div>
			<div style="padding: 0px 0px 12px 0px;">
				<div class="form_div"><input id="Phone" style="width: 389px;" type="text" name="phone" placeholder="Cell (+00000000000)" value=""/></div>
			</div>
			<div style="float: right;" id="submit" onClick="validateForm();">Register</div> 	  
			<div class="clear">&nbsp;</div>    
		</form>
	</div>
	<?php //endif; ?>
	<div class="clear">&nbsp;</div>
</div>
