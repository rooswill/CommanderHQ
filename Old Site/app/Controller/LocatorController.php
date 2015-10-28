<?php


App::uses('AppController', 'Controller');

class LocatorController extends AppController 
{

	public $scaffold = 'admin';
	public $uses = array('Affiliate');

	public $GPS_Points;
	public $GPS_Start;
	public $GPS_End;
	public $Origin;

	public function index() 
	{
		$title_for_layout = 'Commander HQ | Member Home';
	}

	public function getDetails() 
	{
		$Affiliate = $this->Affiliate->getAffiliate($this->request->query['Id']);
		//$this->Origin='capetown';
		$this->Origin = '' . $Affiliate[0]['Affiliate']['latitude'] . ',' . $Affiliate[0]['Affiliate']['longitude'] . '';
		$URL = 'http://maps.googleapis.com/maps/api/directions/xml?origin=' . $this->Origin . '&destination=' . $Affiliate[0]['Affiliate']['latitude'] . ',' . $Affiliate[0]['Affiliate']['longitude'] . '&sensor=true';
		//echo $URL;
		$params = '';
		$Html = '';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_TIMEOUT, 180);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		$data = curl_exec($ch);
		curl_close($ch);

		$xml = new SimpleXMLElement($data);
		$dir = '';
		$i = 0;
		$gps_pos = array();

		$Directions = '';
		$first_br = true;
		foreach ($xml as $step) {
			foreach ($step as $loc) {
				foreach ($loc as $gps) {
					#print_r($gps);
					if ($gps->start_location->lat != '') {

						if ($dir != '')
							$dir.='|';
						$Directions.=$gps->html_instructions;
						if(!$first_br) $Directions.= '<br/>';
						$first_br = false;
						array_push($gps_pos, '' . $gps->start_location->lat . ',' . $gps->start_location->lng . '');
						$i++;
						$dir.='' . $gps->start_location->lat . ',' . $gps->start_location->lng . '';
					}
				}
			}
		}
		$first = $gps_pos[0];
		$last = $gps_pos[$i - 1];
		
		if($first == null or $i > 50) { // Affiliate gym too far for directions
			$Directions = $Affiliate[0]['Affiliate']['name'] . ' is too far for us to give you an accurate list of directions.';
			$first = $Affiliate[0]['Affiliate']['longitude'] . ',' . $Affiliate[0]['Affiliate']['latitude'];
			$Html.='
			<script type="text/javascript">
			$("#map_canvas").html("");
			var latlng1 = new google.maps.LatLng(' . $first . ');
			var myOptions = {
				zoom: 3,
				center: latlng1,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var LatLong=new google.maps.LatLng();
			var map1 = new google.maps.Map(document.getElementById("map_canvas"),
				myOptions);
			var marker1 = new google.maps.Marker({
				position: latlng1,
				map: map1,
				title: "A"
			});
			$("#map_canvas").show();
			</script>';
			} else {
				$Html.='
				<script type="text/javascript">
				$("#map_canvas").html("");
				var latlng1 = new google.maps.LatLng(' . $first . ');
				var latlng2 = new google.maps.LatLng(' . $last . ');
				var myOptions = {
					zoom: 13,
					center: latlng2,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				var LatLong=new google.maps.LatLng();
				var map1 = new google.maps.Map(document.getElementById("map_canvas"),
					myOptions);
			var marker1 = new google.maps.Marker({
				position: latlng1,
				map: map1,
				title: "A"
			});
			var marker2 = new google.maps.Marker({
				position: latlng2,
				map: map1,
				title: "Z"
			});
			var points = new Array();';

			foreach ($gps_pos AS $key => $val) 
			{
				$Html.='points.push(new google.maps.LatLng(' . $val . '));';
			}

			$Html.='
			var polyline = new google.maps.Polyline({
				path: points,
				map: map1,
				strokeColor: "#034693",
				strokeOpacity: 0.8,
				strokeWeight: 2
			});

			$("#map_canvas").show();
			</script>';
			}

			$tab_html = '<div data-role="navbar" id="navbar">
			<ul>
			<li style="width:48%"><a href="#" onclick="DisplayMap();" class="ui-btn-active">Map</a></li>
			{driving_directions}
			</ul>
			</div><!-- navbar -->
			<div id="tab1"></div>
			<div id="tab2"></div>';
			$driving_directions = '';
			if ($this->Origin != '') {
				$driving_directions = '<li style="width:48%"><a href="#" onclick="DisplayDriveInstructions();">Directions</a></li>';
			}
			$Html .= str_replace("{driving_directions}", $driving_directions, $tab_html);
			$Html .= '<div id="driveInstructions">' . $this->formatDirections($Directions) . '</div><div class="clear"></div>';
			
			echo $Html;
			die();
	}

	function formatDirections($Directions) {
		$Directions = str_replace('<div style="font-size:0.9em">', '<br/>', $Directions);
		$Directions = str_replace('</div>', '<br/>', $Directions);
			#$Directions = str_replace('</b><br/>', '</b>', $Directions);
		$Directions = str_replace('</b>', '</b>&nbsp;', $Directions);
		return $Directions;
	}

	function output() {
		$html = '';
		$Overthrow = '';

		if (isset($this->request->query['keyword'])) {
			$Affiliates = $this->Affiliate->getAffiliatesFromSearch(addslashes($this->request->query['keyword']));
			if (count($Affiliates) > 0) 
			{
				$html.='<div ' . $Overthrow . '>';
				$html .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="arrow-r">';
				foreach ($Affiliates AS $Affiliate) 
				{
					$html .= '<li>';
					$html .= '<a href="#" onclick="getDetails(' . $Affiliate['Affiliate']['id'] . ');">' . $Affiliate['Affiliate']['name'] . ':<br/><span style="font-size:small">' . $Affiliate['Affiliate']['region'] . '</span></a>';
					$html .= '</li>';
				}
				$html .= '</ul><div class="clear"></div><br/></div>';
			} 
			else 
			{
				$html = 'No affiliate gyms match your search';
			}
		} 
		else if (isset($this->request->query['Id'])) 
		{

			$html.=$this->getDetails();
		} 
		else 
		{
			if (isset($this->request->query['latitude']) && isset($this->request->query['longitude'])) 
			{
				if ($this->request->query['latitude'] == null || $this->request->query['longitude'] == null) 
				{
					$html = 'Cannot determine your present location';
				} 
				else 
				{
					$Affiliates = $this->Affiliate->getAffiliates();
					if (count($Affiliates) > 0) 
					{
						$html.='<div ' . $Overthrow . '>';
						$html .= '<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d" data-icon="arrow-r">';
						foreach ($Affiliates AS $Affiliate) 
						{
							$html .= '<li>';
							$html .= '<a href="" onclick="getDetails(' . $Affiliate['Affiliate']['id'] . ');">' . $Affiliate['Affiliate']['name'] . ':<br/><span style="font-size:small">' . $Affiliate['Affiliate']['region'] . '</span></a>';
							$html .= '</li>';
						}
						$html .= '</ul><div class="clear"></div><br/></div>';
					} 
					else 
					{
						$html = '<p>No Affiliate Gyms near your present location</p>';
					}
				}
			}
		}
		echo $html;
		die();
	}

	function topSelection() {

		$Affiliate = $this->Affiliate->getAffiliate($this->request->query['topselection']);
		$Html = '<h1><a href="http://' . $Affiliate[0]['Affiliate']['url'] . '" target="_blank">' . $Affiliate[0]['Affiliate']['name'] . '</a></h1><div class="mapdesc">';
		$address = $Affiliate[0]['Affiliate']['address'] <> '' ? $Affiliate[0]['Affiliate']['address'] . '<br/>' : '';
		$city = $Affiliate[0]['Affiliate']['city'] <> '' ? $Affiliate[0]['Affiliate']['city'] . '<br/>' : '';
		$region = $Affiliate[0]['Affiliate']['region'] <> '' ? $Affiliate[0]['Affiliate']['region'] . '<br/>' : '';
		$Html .= '
		' . $address . '
		' . $city . '
		' . $region . '';
		if ($FormattedNumber = str_replace('-', '', $Affiliate[0]['Affiliate']['tel_number'])) {
			$Html .= 'Tel: <a href="tel:' . $FormattedNumber . '">
			' . $Affiliate[0]['Affiliate']['tel_number'] . '</a></div><!-- mapdesc -->';
		}

		echo $Html;
		die();
	}

}
