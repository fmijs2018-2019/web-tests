<?php
use function GuzzleHttp\json_encode;

class TestController extends Controller
{

	public function index()
	{
		$data = array();
		$view = $this->withLayout(
			new View($data, VIEWS_PATH . DS . 'test' . DS . 'index.html')
		);
		$content = $view->render();
		echo $content;
	}

	public function upload()
	{
		if (isset($_FILES['file'])) {
			$result = array();
			$file = $_FILES['file']['tmp_name'];
			$handle = fopen($file, "r");
			$c = 0;
			while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
				$question = iconv(mb_detect_encoding($filesop[0], mb_detect_order(), true), "UTF-8", $filesop[0]);;
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
					array_push($result, $data);
				}
				$c = $c + 1;
			}
			echo json_encode($result);
		}
	}

	public function save()
	{
		$questions = json_decode(file_get_contents('php://input'));

		foreach ($questions as $key => $value) { 
			// TODO: save in db
		}
	}
}
