<?php

class HomeController extends Controller{

    public function index(){
		$data = array();
        $view = $this->withLayout(
			new View($data, VIEWS_PATH.DS.'home'.DS.'index.html')
		);
		$content = $view->render();
		echo $content;
	}
	
	public function about(){
		$data = array();
        $view = $this->withLayout(
			new View($data, VIEWS_PATH.DS.'home'.DS.'about.html')
		);
		$content = $view->render();
		echo $content;
	}

}