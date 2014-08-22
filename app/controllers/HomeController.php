<?php

class HomeController extends BaseController {

	public function indexAction()
	{
		return View::make('home.home');
	}

}
