<div id="AjaxOutput">
	* All fields are required    
	<form method="post" id="verifyform" name="refer" action="/members/signup">
		<input type="hidden" value="submitted" name="form">
		<div class="ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c">
			<input type="text" ng-model="user.name" value="" placeholder="First Name" autocapitalize="on" name="FirstName" id="firstname" class="textinput ui-input-text ui-body-c">
		</div>
		<br>    
		<div class="ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c">
			<input type="text" ng-model="user.surname" value="" placeholder="Last Name" name="LastName" id="lastname" class="textinput ui-input-text ui-body-c">
		</div><br>   
		<div class="ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c">
			<input type="text" ng-model="user.username" value="" placeholder="User Name" name="UserName" id="username" class="textinput ui-input-text ui-body-c">
		</div>
		<br>    
		<div class="ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c">
			<input type="password" ng-model="user.password" value="" placeholder="Password" name="PassWord" id="password" class="textinput ui-input-text ui-body-c">
		</div>
		<br>    
		<div class="ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c">
			<input type="password" value="" placeholder="Confirm Password" name="ConfirmPassWord" id="password" class="textinput ui-input-text ui-body-c">
		</div><br>
		<div class="ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c">
			<input type="email" ng-model="user.email" placeholder="Email Address" value="" name="Email" id="email" class="textinput ui-input-text ui-body-c">
		</div>
		<br>
		<div class="ui-input-text ui-shadow-inset ui-corner-all ui-btn-shadow ui-body-c">
			<input type="tel" ng-model="user.cellphone" placeholder="Cell (+00000000000)" value="" name="Cell" id="cell" class="textinput ui-input-text ui-body-c">
		</div> 
		<br><fieldset data-type="horizontal" data-role="controlgroup" class="controlgroup ui-corner-all ui-controlgroup ui-controlgroup-horizontal" aria-disabled="false" data-disabled="false" data-shadow="false" data-corners="true" data-exclude-invisible="true" data-mini="false" data-init-selector=":jqmData(role='controlgroup')">
		<div class="ui-controlgroup-controls">
			<div class="ui-radio">
				<label for="male" data-corners="true" data-shadow="false" data-iconshadow="true" data-wrapperels="span" data-icon="radio-off" data-theme="c" data-mini="false" class="ui-radio-off ui-btn ui-btn-up-c ui-btn-corner-all ui-fullsize ui-btn-icon-left ui-first-child">
					<span class="ui-btn-inner">
						<span class="ui-btn-text">Male</span>
						<span class="ui-icon ui-icon-radio-off ui-icon-shadow">&nbsp;</span>
					</span>
				</label>
				<input type="radio" ng-model="user.gender" value="M" name="Gender" id="male" class="radioinput">
			</div>

			<div class="ui-radio">
				<label for="female" data-corners="true" data-shadow="false" data-iconshadow="true" data-wrapperels="span" data-icon="radio-off" data-theme="c" data-mini="false" class="ui-radio-off ui-btn ui-btn-up-c ui-btn-corner-all ui-fullsize ui-btn-icon-left ui-last-child">
					<span class="ui-btn-inner">
						<span class="ui-btn-text">Female</span>
						<span class="ui-icon ui-icon-radio-off ui-icon-shadow">&nbsp;</span>
					</span>
				</label>
				<input type="radio" ng-model="user.gender" value="F" name="Gender" id="female" class="radioinput">
			</div>

		</div></fieldset>
		<br>System Of Measure
		<fieldset data-type="horizontal" data-role="controlgroup" class="controlgroup ui-corner-all ui-controlgroup ui-controlgroup-horizontal" aria-disabled="false" data-disabled="false" data-shadow="false" data-corners="true" data-exclude-invisible="true" data-mini="false" data-init-selector=":jqmData(role='controlgroup')">
			<div class="ui-controlgroup-controls">
				<div class="ui-radio">
					<input type="radio" ng-model="user.measure" value="Metric" id="radio-choice-1" name="SystemOfMeasure" class="radioinput">
					<label for="radio-choice-1" data-corners="true" data-shadow="false" data-iconshadow="true" data-wrapperels="span" data-icon="radio-off" data-theme="c" data-mini="false" class="ui-radio-off ui-btn ui-btn-up-c ui-btn-corner-all ui-fullsize ui-btn-icon-left ui-first-child">
						<span class="ui-btn-inner">
							<span class="ui-btn-text">Metric</span>
							<span class="ui-icon ui-icon-radio-off ui-icon-shadow">&nbsp;</span>
						</span>
					</label>
				</div>

				<div class="ui-radio">
					<input type="radio" ng-model="user.measure" value="Imperial" id="radio-choice-2" name="SystemOfMeasure" class="radioinput">
					<label for="radio-choice-2" data-corners="true" data-shadow="false" data-iconshadow="true" data-wrapperels="span" data-icon="radio-off" data-theme="c" data-mini="false" class="ui-radio-off ui-btn ui-btn-up-c ui-btn-corner-all ui-fullsize ui-btn-icon-left ui-last-child">
						<span class="ui-btn-inner">
							<span class="ui-btn-text">Imperial</span>
							<span class="ui-icon ui-icon-radio-off ui-icon-shadow">&nbsp;</span>
						</span>
					</label>
				</div>
			</div>
		</fieldset>
		<br>            
		<div data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-theme="b" data-disabled="false" class="ui-btn ui-shadow ui-btn-corner-all ui-btn-up-b" aria-disabled="false">
			<span class="ui-btn-inner">
				<span class="ui-btn-text">Submit</span>
			</span>
			<input type="submit" value="Submit" class="buttongroup ui-btn-hidden" data-theme="b" data-disabled="false">
		</div>
		<br>
	</form>
	<div class="clear"></div>
</div>