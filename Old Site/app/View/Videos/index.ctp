<script type="text/javascript">
	var thislimit ='<?php echo CakeSession::read('limitstart'); ?>';
	var thiskeyword = $('#keyword').val();

	var screenWidth = window.innerWidth || document.body.clientWidth;
    var screenHeight = window.innerHeight || document.body.clientHeight;

	if(thiskeyword == '')
	{
		<?php if(CakeSession::read('keyword')) { ?>
		    thiskeyword = '<?php echo CakeSession::read('keyword');?>';
		<?php } ?>
	}

	<?php 
		if(isset($_REQUEST['orientation']) && CakeSession::read('video')) 
		{ 
			?>
	    		GetVideo('<?php echo CakeSession::read('video');?>');
			<?php 
		} 
	?>

	if(thiskeyword != '')
	    getResults();
	    
	function page(limit)
	{ 
	    $('#videodisplay').html('');
	    $.ajax({url:'/videos/getVideos/?action=formsubmit',data:{keyword:thiskeyword,limitstart:limit, swidth: screenWidth, sheight:screenHeight},dataType:"html",success:display});
	}

	function GetVideo(filename)
	{
	    $.ajax({url:'/videos/showVideo/',data:{video:filename, swidth: screenWidth, sheight:screenHeight},dataType:"html",success:VideoDisplay});
	}

	function getResults()
	{ 
	    $('#videodisplay').html('');
	    $.ajax({url:'/videos/getVideos/?action=formsubmit',data:{keyword:thiskeyword,limitstart:thislimit, swidth: screenWidth, sheight:screenHeight},dataType:"html",success:display});
	}
	    
	function getVideoResults()
	{
	    $('#videodisplay').html('');
	    var keyword = $('#keyword').val(); 
	    $.ajax({url:'/videos/getVideos',data:{keyword:keyword, swidth: screenWidth, sheight:screenHeight},dataType:"html",success:display});
	}

	function VideoDisplay(data)
	{
	    $('#videodisplay').html(data);
	}

	function display(data)
	{
	    $('#AjaxOutput').html(data);
		//$.mobile.silentScroll(0);
	}

</script>

<div id="topselection" class="ui-listview">
	<h1 class="ui-li-heading">Video Search</h1>
</div>
<?php 
	if(isset($this->params->query['keyword']))
		$keyword = $this->params->query['keyword'];
	else
		$keyword = NULL;
?>
<div class="videosearch">
	<div class="affiliatestop">
		<input type="search" results="5" placeholder="Video Search" id="keyword" name="keyword" value="<?php echo $keyword;?>" />
		<input type="button" name="Submitbtn" class="affiliatesbutton" value="Go" data-inline="true" data-mini="true" data-theme="b" onclick="getVideoResults();" />
	</div>
</div>
<div class="clear"></div>
<div id="videodisplay" style="margin:10px 0;"></div>
<div id="AjaxOutput"></div>