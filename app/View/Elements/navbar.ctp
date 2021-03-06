
<div id="nav" style="height:auto;">

		<div class="grid" style="float:left;margin:0;">
			<a href="#my-menu" class=""/>
			<img id="menuselect" alt="Menu" src="/img/640/menu.png"/></a>
		</div>

		<?php
			if(($this->params->controller == 'members' && $this->view == 'index'))
			{
				// do nothing
			}
			else
			{
				?>
					<div class="grid" style="float:left;margin:0;">
						<a class="menuitem" href="/members" data-transition="slidefade" data-prefetch><img alt="Home" src="/img/640/home.png"/></a>
					</div>
				<?php
			}
		?>

	<div id="menuvideo" class="grid" style="float:left;margin:0;"></div>	

	<?php
		if(($this->params->controller == 'members' && $this->view == 'index'))
		{
			// do nothing	
		}
		else
		{
			?>
				<div id="back" class="grid" style="float:right;margin:0%;" onclick="history.back();">
					<img alt="Back" src="/img/640/back.png"/>
				</div>
			<?php
		}
	?>
	
	<div style="clear:both"></div>

</div> 
<div class="clear"></div>



<div data-role="popup" id="popupFeedback" data-theme="a" class="ui-corner-all" style="display:none;">
	<form id="feedbackform">
		<div style="padding:2%">
			<h3>Successfully Saved</h3>
			<textarea id="feedback" name="Comments" cols="10" rows="50" placeholder="Comments?"></textarea>
			<div class="ui-grid-a">
				<div class="ui-block-a"><a href="#" data-mini="true" data-role="button" data-inline="true" onClick="SubmitFeedback();" data-theme="c">Send</a></div>
				<div class="ui-block-b"><a href="#" data-mini="true" data-role="button" data-inline="true" data-rel="back" data-theme="c">Close</a></div>
			</div>
		</div>
	</form>
</div>
<div data-role="popup" id="motivationMessage" data-theme="a" class="ui-corner-all" style="display:none;">
	<form id="motivationmessageform">
		<div style="padding:2%">
			<h3 id="motivationMessageText"></h3>
			<div class="ui-block-b"><label for="showmessage">Show at start up</label><input type="checkbox" id="showmessage" name="showmessage" value="1" checked="true" id="showmessage" /></div>
			<div class="ui-grid-a">
				<div class="ui-block-b"><a href="#" onclick="SubmitShowMessageResult();" data-mini="true" data-role="button" data-inline="true" data-rel="back" data-theme="c">Ok</a></div>
			</div>
		</div>
	</form>
</div>