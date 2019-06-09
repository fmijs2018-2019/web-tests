<?php

class HomeController extends Controller
{

	public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new Home();
    }

	public function index()
	{
		$this->data['test_content'] = 'Here will be a pages list';
	}

	public function view()
	{
		$params = App::getRouter()->getParams();

		if (isset($params[0])) {
			$alias = strtolower($params[0]);
			$this->data['content'] = "Here will be a page with '{$alias}' alias";
		}

		$this->data['content'] = "there is no parameters";
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
				if ($c <> 0) {					/*SKIP THE FIRST ROW*/
					$this->model->submit_index($data);
				}
				$c = $c + 1;
			}
			echo "Data imported successfully !";
			echo $data;
		}
	}
}
