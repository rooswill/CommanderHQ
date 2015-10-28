<div id="loginback">
	<div id="container" class="logincontainer" ng-controller="loginController">
		<div class="error_message">
			<?php
				if(isset($error_message))
					echo $error_message['data'];
			?>
		</div>
		<form novalidate class="simple-form" action="/members/login" method="post">
			<div class="alreadymember">Already a member? Login here</div>
			<div class="ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c ui-mini">
				<input type="text" value="" name="username" data-mini="true" placeholder="Username" class="ui-input-text ui-body-c">
			</div>
			<div class="ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c ui-mini">
				<input type="password" value=""  data-mini="true" placeholder="Password" name="password" id="password" class="ui-input-text ui-body-c">
			</div>
			<div class="forgot">
				<a href="#forgot" class="ui-link">Forgot username / password?</a>
			</div>
			<div class="remember">Remember me</div>
			<input type="checkbox" value="yes" ng-model="user.remember" data-role="none" name="remember" id="remember">
			<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="b" data-disabled="false" class="ui-btn ui-shadow ui-btn-corner-all ui-btn-up-b" aria-disabled="false">
				<span class="ui-btn-inner">
					<span class="ui-btn-text">Login</span>
				</span>
				<input type="submit" data-theme="b" ng-click="login(user)" class="ui-btn-hidden" data-disabled="false" value="Save" />
			</div>
		</form>

		<div class="ismember">Not a member yet?</div>
		<div class="signup">
			<a href="/members/signup" class="ui-link">
				<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="e" data-disabled="false" class="ui-btn ui-shadow ui-btn-corner-all ui-btn-up-e" aria-disabled="false">
					<span class="ui-btn-inner">
						<span class="ui-btn-text">Sign Up</span>
					</span>
					<button data-theme="e" class="ui-btn-hidden" data-disabled="false">Sign Up</button>
				</div>
			</a>
		</div>

		<div class="loginwith">Login with</div>

		<div class="sociallinks">
			<!--
			<a href="https://dev.twitter.com/docs/auth/implementing-sign-twitter">
			-->
			<a href="login-twitter.php" rel="external">
				<img alt="Twitter" src="/img/640/twitter.png"/>
			</a>
			<!--
			<a href="https://developers.google.com/accounts/docs/OpenID#settingup">
			-->
			<a href="gplus_login.php" rel="external">
				<img alt="Google" src="/img/640/google.png"/>
			</a>
			<!--
			<a href="http://developers.facebook.com/docs/authentication/server-side/">
			-->

			<a href="/members/facebook/login" rel="external">
				<img alt="Facebook" src="/img/640/facebook.png"/>
			</a>

		</div>
	</div>
</div>