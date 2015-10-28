<script type="text/javascript"
src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script language="javascript">
	var lat;
	var lng;
	var options = {timeout:60000};
	navigator.geolocation.getCurrentPosition(findLocation, noLocation, options);

	function findLocation(position)
	{
	    lat = position.coords.latitude;
	    lng = position.coords.longitude;
			//console.log("lat="+lat+",lng="+lng);
	    $.ajax({url:'/locator/output',data:{latitude:lng,longitude:lat},dataType:"html",success:display}); 
	}

	function noLocation()
	{
    	$.ajax({url:'/locator',data:{latitude:null,longitude:null},dataType:"html",success:display}); 
	}

	function GymSearch()
	{
		if(($("#search_word").val()).length < 2) 
		{
			alert('You need to enter at least two characters to search.');
			return false;
		} 
		else 
		{
			$("#map_canvas").removeClass("active");
			$.ajax({url:'/locator/output',data:$("#searchform").serialize(),dataType:"html",success:display});
			$('#topselection').html('<h1>Search Results</h1>');
		}
	}

	function goBackTo()
	{
	    $.ajax({url:'ajax.php?module=locator',data:{latitude:lat,longitude:lng},dataType:"html",success:display});
	    $("#map_canvas").html("");
	    $("#map_canvas").removeClass("active");
	    topselectiondisplay('<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d"><li>Affiliate gyms near you</li></ul>');
	}

	function getDetails(id)
	{
	    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=locator\');" src="/img/640/back.png"/>');
	    $.ajax({url:'/locator/getDetails',data:{Id:id,lat:lat,lng:lng},dataType:"html",success:display});
	    $.ajax({url:'/locator/topSelection',data:{topselection:id,lat:lat,lng:lng},dataType:"html",success:topselectiondisplay});
	}

	function DisplayMap() {
	    $('#driveInstructions').removeClass("active");
	    if($("#map_canvas").hasClass("active")){
				$("#map_canvas").removeClass("active");
	    } else{
				$("#map_canvas").addClass("active");
	    }
	}

	function DisplayDriveInstructions() {
	    $("#map_canvas").removeClass("active");
	    if($("#driveInstructions").hasClass("active")){
				$("#driveInstructions").removeClass("active");
	    } else{
				$("#driveInstructions").addClass("active");
	    }
	}

	function topselectiondisplay(data)
	{
    	$('#topselection').html(data);
 
	}

	function display(data)
	{
	    $('#AjaxOutput').html(data);
	    //$('#listview').listview();
	    //$('#listview').listview('refresh');
	 //    $('.buttongroup').button();
	 //    $('.buttongroup').button('refresh');
		// $('#navbar').navbar();
	 //    $('#AjaxLoading').html('');	
	}

	function CloseBoth() {
	
		$('#driveInstructions').removeClass("active");
	}

</script>
<br/>
<div id="topselection" class="ui-listview">
	<h1 class="ui-li-heading">Affiliate gyms near you</h1>
</div>

<div id="mainPage" class="affiliates-section" style="padding:10px;">
	<div data-role="content">
		<form action="#" method="post" name="searchform" id="searchform">
			<div class="affiliatestop">
				<input type="search" results="5" placeholder="Search" name="keyword" id="search_word" />
				<input type="button" name="btnSubmit" class="affiliatesbutton" value="Go" data-inline="true" data-mini="true" data-theme="b" onclick="GymSearch();" />
			</div>
		</form>
	</div>
</div>

<div id="AjaxOutput" class="" style="padding:10px;">

</div>

<div id="map_canvas"></div>