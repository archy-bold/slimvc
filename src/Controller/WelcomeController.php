<?php namespace App\Controller;

class WelcomeController extends AbstractController{
	
	public function index(){
		$this->render('pages/welcome.html', array(
			'page'       => 'welcome',
			'url'        => url('/'),
			'meta_image' => url('/assets/img/metaimage.png'),
		));
	}

}
