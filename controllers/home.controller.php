<?php
use function GuzzleHttp\json_encode;

class HomeController extends Controller
{
	
    public function indexView(){
		$data = array();
        $view = $this->withLayout(
			new View($data, VIEWS_PATH.DS.'home'.DS.'index.html')
		);
		$content = $view->render();
		echo $content;
	}
	
	public function aboutView(){
		$data = array();
        $view = $this->withLayout(
			new View($data, VIEWS_PATH.DS.'home'.DS.'about.html')
		);
		$content = $view->render();
		echo $content;
	}
}
