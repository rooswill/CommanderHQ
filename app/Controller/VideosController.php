<?php


App::uses('AppController', 'Controller');

class VideosController extends AppController 
{

	public $scaffold = 'admin';

	public function index() 
	{
		$title_for_layout = 'Commander HQ | Member Home';
	}

	public function showVideo() {
		if (isset($this->request->query['video'])) {
			$Source = $this->request->query['video'];
		} else if (CakeSession::read('video')) {
			$Source = CakeSession::read('video');
		}

		$Height = floor($this->request->query['swidth'] * 0.717);
		$iFrame = '<iframe marginwidth="0px" marginheight="0px" width="'.$this->request->query['swidth'].'" height="'.$Height.'" src="' . $Source . '" frameborder="0"></iframe>';
		
		echo $iFrame;
		die();
	}

	public function getVideos() 
	{
		$Html = '';
		$i = 0;

		if (isset($this->request->query['keyword'])) 
			$keyword = $this->request->query['keyword'];
		elseif (CakeSession::read('keyword')) 
			$keyword = CakeSession::read('keyword');
		else
			$keyword = NULL;

		$VideoSearchResults = $this->Video->SearchResults($keyword);
		$Total = count($VideoSearchResults);

		if ($Total == 0)
			$Html.= '<font style="color:red; font-weight: bold;">No Results</font>';
		else 
		{
			if (isset($this->request->query['limitstart']) && $this->request->query['limitstart'] > 0) 
				$LimitStart = (int) $this->request->query['limitstart'];
			else 
				$LimitStart = 0;

			$Limit = 10;
			$LimitEnd = $LimitStart + $Limit;

			$Html.= '<p>Click on a title below to play video</p>';

			if (((int)$LimitStart == 0) && (!isset($this->request->query['keyword']))) 
			{
				$Html.= '<a href="#" onclick="GetVideo(\'http://www.youtube.com/embed/tzD9BkXGJ1M\')">What is CrossFit?</a>';
				$Html.= '<p>What is CrossFit? CrossFit is an effective way to get fit. Anyone can do it. It is a fitness program that combines a wide variety of functional movements into a timed or scored workout. We do pull-ups, squats, push-ups, weightlifting, gymnastics, running, rowing, and a host of other movements. Always varied, always changing, always producing results. Kids, cops, firefighters, soccer moms, Navy SEALS, and grandmas all do CrossFit. In fact, hundreds of thousands worldwide have followed our workouts and distinguished themselves in combat, the streets, the ring, stadiums, gyms and homes. Welcome.</p>';
			}

			foreach ($VideoSearchResults as $Video) 
			{
				$Html.= '<div class="video-items">';
					$Html.= '<div class="video-top-content">';
						$Html.= '<div class="video-images"><img src="'.$Video['video_image'].'" /></div>';
						$Html.= '<div class="video-title"><a onclick="GetVideo(\'' . $Video['video_id'] . '\')" href="#"><b>' . $Video['video_title'] . '</b></a></div>';
						$Html.= '<div class="clear"></div>';
					$Html.= '</div>';
					$Html.= '<div class="video-description"><p>' . $Video['video_description'] . '</p></div>';
				$Html.= '</div>';

				$i++;
			}

			$href = '1';

			// $pageNav = new Paging($Total, $LimitStart, $Limit, $href);
			// $Html.='		
			// <br/>
			// <center>
			// <div id="pagelinks">
			// ' . $pageNav->getPagesLinks() . '
			// </div>
			// </center>';
		}

		echo $Html;
		die();
	}

}
