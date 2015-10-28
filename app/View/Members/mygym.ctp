<div class="ui-listview" id="topselection">
	<h1 class="ui-li-heading">My Gym WOD</h1>
</div>

<div class="AjaxOutputForWODs" id="AjaxOutput">
	<div data-role="navbar" class="ui-navbar ui-mini" role="navigation">
		<ul class="ui-grid-a">
			<li style="width:48%" class="ui-block-a">
				<a class="ui-btn-active marginleftten ui-btn ui-btn-up-c ui-btn-inline" onclick="Tabs('1');" href="#" data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="span" data-theme="c" data-inline="true">
					<span class="ui-btn-inner">
						<span class="ui-btn-text">Well Rounded</span>
					</span>
				</a>
			</li>
			<li style="width:48%" class="ui-block-b">
				<a onclick="Tabs('2');" href="#" data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="span" data-theme="c" data-inline="true" class="ui-btn ui-btn-up-c ui-btn-inline">
					<span class="ui-btn-inner">
						<span class="ui-btn-text">Advanced</span>
					</span>
				</a>
			</li>
		</ul>
	</div>
	<div id="tab1" class="active"> 
		<div id="details1"><br>
			<div class="previouswods">
				Be CrossFit hasn't loaded a Well Rounded WOD for today.<br>
				Why not create your own?
			</div>
			<div class="previouswods">
				<ul data-dividertheme="d" data-theme="c" data-inset="true" data-role="listview" class="listview ui-listview ui-listview-inset ui-corner-all ui-shadow">
					<li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="c" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-first-child ui-last-child ui-btn-up-c">
						<div class="ui-btn-inner ui-li">
							<div class="ui-btn-text">
								<a onclick="getPreviousWorkoutList(2);" href="#" class="ui-link-inherit">Previous 30 workouts</a>
							</div>
							<span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span>
						</div>
					</li>
				</ul><!--listview-->
			</div><!--previouswods-->
		</div>
	</div>   
	<div id="tab2">  <div id="details2"></div>
</div>
</div>