<div id="topselection">
	<h1>Profile</h1>
</div>
<br />
<form enctype="multipart/form-data" name="profileform" id="profileform" method="post" action="/members/edit/<?php echo $profile['Member']['id']; ?>">
	<div data-role="fieldcontain" class="ui-field-contain ui-body ui-br">
		<input type="hidden" value="<?php echo $profile['Member']['id']; ?>" name="id">

		<label for="firstname" class="ui-input-text">Profile Picture</label>
		<div class="">
			<input type="file" name="profile_picture" id="fileToUpload">
		</div>

		<label for="firstname" class="ui-input-text">First Name</label>
		<div class="">
			<input type="text" value="<?php echo $profile['Member']['name']; ?>" placeholder="First Name" name="name" id="firstname" class="textinput ui-input-text ui-body-c">
		</div>
		<label for="lastname" class="ui-input-text">Last Name</label>
		<div class="">
			<input type="text" value="<?php echo $profile['Member']['surname']; ?>" placeholder="Last Name" name="surname" id="lastname" class="textinput ui-input-text ui-body-c">
		</div>
		<label for="username" class="ui-input-text">User Name</label>
		<div class="">
			<input type="text" value="<?php echo $profile['Member']['username']; ?>" placeholder="User Name" name="username" id="username" class="textinput ui-input-text ui-body-c">
		</div>
		<label for="cell" class="ui-input-text">Cell (+2778000000)</label>
		<div class="">
			<input type="tel" placeholder="Cell (+2778000000)" value="<?php echo $profile['Member']['cellphone']; ?>" name="cellphone" id="cell" class="textinput ui-input-text ui-body-c">
		</div>
		<label for="email" class="ui-input-text">Email</label>
		<div class="">
			<input type="email" value="<?php echo $profile['Member']['email']; ?>" placeholder="Email" name="email" id="email" class="textinput ui-input-text ui-body-c">
		</div>
		<label for="DOB" class="ui-input-text">Date of Birth</label>
		<div class="">
			<input type="date" value="<?php echo $profile['Member']['dob']; ?>" placeholder="Date of Birth" id="DOB" name="dob" class="textinput ui-input-text ui-body-c">
		</div>
		<label for="DOB" class="ui-input-text">Registered Gym</label>
		<div class="mygym-main-block">
			<input type="text" value="" placeholder="Find your Gym" id="mygym" name="mygym" class="textinput ui-input-text ui-body-c">
			<input type="hidden" value="" id="affiliate_id" name="affiliate_id">
			<ul data-filter-theme="d" data-filter-placeholder="Add Activity..." data-filter="true" data-inset="true" data-role="listview" class="mygym-list ui-listview ui-listview-inset ui-corner-all ui-shadow"></ul>
		</div>
		<div class="systemofmeasure">
			<input type="hidden" value="" id="AffiliateId" name="AffiliateId">
			<div class="systemofmeasurelabel">System Of Measure</div>
			<fieldset data-type="horizontal" data-role="controlgroup" class="controlgroup ui-corner-all ui-controlgroup ui-controlgroup-horizontal" aria-disabled="false" data-disabled="false" data-shadow="false" data-corners="true" data-exclude-invisible="true" data-mini="false" data-init-selector=":jqmData(role='controlgroup')">
				
				<div class="ui-controlgroup-controls">

					<div class="ui-radio">
						<input type="radio" checked="checked" onclick="getSystem('Metric');" value="Metric" id="radio-choice-1" name="system_of_measure" class="radioinput">
						<label for="radio-choice-1" data-corners="true" data-shadow="false" data-iconshadow="true" data-wrapperels="span" data-icon="radio-on" data-theme="c" data-mini="false" class="ui-radio-on ui-btn-active ui-btn ui-btn-up-c ui-btn-corner-all ui-fullsize ui-btn-icon-left ui-first-child">
							Metric
						</label>
					</div>

					<div class="ui-radio">
						<input type="radio" onclick="getSystem('Imperial');" value="Imperial" id="radio-choice-2" name="system_of_measure" class="radioinput">
						<label for="radio-choice-2" data-corners="true" data-shadow="false" data-iconshadow="true" data-wrapperels="span" data-icon="radio-off" data-theme="c" data-mini="false" class="ui-radio-off ui-btn ui-btn-up-c ui-btn-corner-all ui-fullsize ui-btn-icon-left ui-last-child">
							Imperial
						</label>
					</div>

				</div>
			</fieldset>
		</div><!-- systemofmeasure -->
		<div class="height">
			<div id="heightlabel">Height(cm)</div>
			<div class="">
				<input type="number" value="<?php echo $profile['MemberDetail'][0]['height']; ?>" name="height" class="textinput ui-input-text ui-body-c" id="height">
			</div>
		</div><!-- height -->
		<div class="weight">
			<div id="weightlabel">Weight(kg)</div>
			<div class="">
				<input type="number" value="<?php echo $profile['MemberDetail'][0]['weight']; ?>" name="weight" class="textinput ui-input-text ui-body-c" id="weight">
			</div>
		</div><!-- weight -->
		<div class="gender">
			<div class="genderlabel">Gender</div>
			<fieldset data-type="horizontal" data-role="controlgroup" class="controlgroup ui-corner-all ui-controlgroup ui-controlgroup-horizontal" aria-disabled="false" data-disabled="false" data-shadow="false" data-corners="true" data-exclude-invisible="true" data-mini="false" data-init-selector=":jqmData(role='controlgroup')">
				<div class="ui-controlgroup-controls">
					<div class="ui-radio">
						<label for="male" data-corners="true" data-shadow="false" data-iconshadow="true" data-wrapperels="span" data-icon="radio-on" data-theme="c" data-mini="false" class="ui-radio-on ui-btn-active ui-btn ui-btn-up-c ui-btn-corner-all ui-fullsize ui-btn-icon-left ui-first-child">
							Male
						</label>
						<input type="radio" checked="checked" value="M" name="gender" id="male" class="radioinput">
					</div>

					<div class="ui-radio">
						<label for="female" data-corners="true" data-shadow="false" data-iconshadow="true" data-wrapperels="span" data-icon="radio-off" data-theme="c" data-mini="false" class="ui-radio-off ui-btn ui-btn-up-c ui-btn-corner-all ui-fullsize ui-btn-icon-left ui-last-child">
							Female
						</label>
						<input type="radio" value="F" name="gender" id="female" class="radioinput">
					</div>

				</div>
			</fieldset>
		</div><!-- gender -->
		<div class="anonymous">
			<div class="anonymouslabel">Anonymous</div>
			<a data-iconpos="notext" data-theme="e" data-icon="info" data-transition="pop" data-inline="true" class="ui-icon-alt ui-btn ui-btn-up-e ui-shadow ui-btn-corner-all ui-btn-inline ui-btn-icon-notext" data-role="button" data-position-to="window" data-rel="popup" href="#popupInfo" id="popuphq" data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" aria-haspopup="true" aria-owns="#popupInfo" title="">
				<span class="ui-btn-inner">
					<span class="ui-btn-text"></span>
					<span class="ui-icon ui-icon-info ui-icon-shadow">&nbsp;</span>
				</span>
			</a>
			<div style="display: none;"><!-- placeholder for popupInfo -->
			</div><!-- anonymous -->
			<div class="savebutton">
					<input type="submit" data-theme="b" value="Save" class="buttongroup" data-disabled="false">
			</div><!-- savebutton -->
		</div><!-- fieldcontain -->
		<div class="clear"></div>
	</div>
</form>