<?php

class HomeController extends Controller
{
	
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

	public function upload()
	{
		if (isset($_POST['save'])) {
			$file = $_FILES['file']['tmp_name'];
			$handle = fopen($file, "r");
			$c = 0;
			while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
				var_dump($filesop);
				$question = $filesop[0];
				$answer_1 = $filesop[1];
				$answer_2 = $filesop[2];
				$answer_3 = $filesop[3];
				$answer_4 = $filesop[4];
				$correct_answer = $filesop[5];
				$data = array(
					'id' => null,
					'question' => $question,
					'answer_1' => $answer_1,
					'answer_2' => $answer_2,
					'answer_3' => $answer_3,
					'answer_4' => $answer_4,
					'correct_answer' => $correct_answer
				);
				if ($c <> 0) {
					echo $data;
				}
				$c = $c + 1;
			}
			echo "Data imported successfully !";
			echo $data;
		}
	}
}
