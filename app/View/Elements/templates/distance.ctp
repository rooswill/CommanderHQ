<script src="/js/Libs/jquery.runner-min.js" type="text/javascript"></script>
<div class="template-content">
	<h1>Distance Template</h1>

	<div class="distance-content-block">
		<div class="distance-text">Distance</div>
		<div class="distance-values">0.0</div>
	</div>
	<div class="distance-content-block">
		<div class="distance-text">Pace</div>
		<div class="distance-values">0.0</div>
	</div>
	<div class="clear"></div>

	<div class="distance-content-block">
		<div class="distance-text">Duration</div>
		<div class="distance-values" id="timer"></div>
	</div>
	<div class="distance-content-block">
		<div class="distance-text">Calories</div>
		<div class="distance-values">0.0</div>
	</div>
	<div class="clear"></div>

	<div id="distance-map"></div>

	<div class="start-btn" id="workout-btn">
		Start Workout
	</div>
	<div class="pause-btn" id="workout-pause-btn" style="display:none;">
		Pause Workout
	</div>

    <script type="text/javascript">
    	$(document).ready(function() {
			$('#timer').runner();
		});

		$('#workout-btn').click(function() {
		    $('#timer').runner('start');
		    $('#workout-pause-btn').show();
		});

		$('#workout-pause-btn').click(function() {
		    $('#timer').runner('stop');
		    $('#workout-pause-btn').hide();
		});

		var map;
		function initMap() {
			map = new google.maps.Map(document.getElementById('distance-map'), {
				center: {lat: -34.397, lng: 150.644},
				zoom: 17
			});

			var infoWindow = new google.maps.InfoWindow({map: map});

			// Try HTML5 geolocation.
			if (navigator.geolocation) 
			{
				navigator.geolocation.getCurrentPosition(function(position) {
					var pos = {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					};

					// infoWindow.setPosition(pos);
					// infoWindow.setContent('Location found.');
					map.setCenter(pos);

					var marker = new google.maps.Marker({
					    position: pos,
					    map: map,
					    title: 'Hello World!'
				  	});


				}, function() {
					handleLocationError(true, infoWindow, map.getCenter());
				});
			} 
			else 
			{
				// Browser doesn't support Geolocation
				handleLocationError(false, infoWindow, map.getCenter());
			}
		}

		function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		  infoWindow.setPosition(pos);
		  //infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
		}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?callback=initMap"async defer></script>
</div>