<?php

	require_once 'Google/autoload.php';
	require_once 'Google/Service/YouTube.php';

    App::uses('AppModel', 'Model');

    class Video extends AppModel 
    {
		public $URL = '';
		public $SearchResults = '';
		public $Response = '';
	  	
		public function SearchResults($keyword, $maxResults = 10)
		{
			$youtube_api_key = 'AIzaSyCzdupJ1aGsUE5dFURNiLSte6z9lik-m9Q';

			$query = "crossfit_".$keyword;

			$client = new Google_Client();
			$client->setDeveloperKey($youtube_api_key);
			$htmlBody = '';
			$counter = 0;

			$youtube = new Google_Service_YouTube($client);

			try 
			{
				$searchResponse = $youtube->search->listSearch('id,snippet', array(
			      'q' => $query,
			      'maxResults' => $maxResults,
			    ));

				$videos = array();
			    $channels = '';
			    $playlists = '';

			    if(isset($searchResponse))
			    {
					foreach ($searchResponse['items'] as $searchResult) 
					{
						if($searchResult['id']['kind'] == 'youtube#video')
						{
							$videos[$counter]['video_id'] = $searchResult['id']['videoId'];
							$videos[$counter]['video_title'] = $searchResult['snippet']['title'];
							$videos[$counter]['video_description'] = $searchResult['snippet']['description'];
							$videos[$counter]['video_image'] = $searchResult['snippet']['thumbnails']['high']['url'];
							$counter++;
						}
					}
				}
				else
					$videos = NULL;

			} 
			catch (Google_ServiceException $e) 
			{
				$htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));	
			}
			catch (Google_Exception $e) 
			{
			    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
			}

			// $VideoResults = array();
			// $this->URL = 'http://gdata.youtube.com/feeds/api/videos?q=crossfit_'.urlencode($keyword).'';
			// $ch=curl_init();
			// curl_setopt($ch, CURLOPT_URL, $this->URL);
			// curl_setopt($ch, CURLOPT_TIMEOUT, 180);
			// curl_setopt($ch, CURLOPT_HEADER, 0);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// curl_setopt($ch, CURLOPT_HTTPGET, 1);
			// $this->Response=curl_exec($ch);

			// curl_close($ch);

			// $this->SearchResults = new SimpleXMLElement($this->Response);

			// foreach($this->SearchResults as $Child)
			// {
			// 	if($Child->title != '') 
			// 		array_push($VideoResults, $Child);
			// }

			return $videos;

			// return $VideoResults;	
		}
	}