<?php

App::uses('AppController', 'Controller');


class PagesController extends AppController {

	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}

	public function about()
	{
		$title_for_layout = 'Commander HQ | About Us';	
	}

	public function disclaimer()
	{
		$title_for_layout = 'Commander HQ | Disclaimer';	
	}

	public function feedback()
	{
		$title_for_layout = 'Commander HQ | Feedback';	
	}

	public function help()
	{
		$title_for_layout = 'Commander HQ | Help';	
	}

	public function privacy()
	{
		$title_for_layout = 'Commander HQ | Privacy Policy';	
	}

	public function terms()
	{
		$title_for_layout = 'Commander HQ | Terms & Conditions';	
	}
}
