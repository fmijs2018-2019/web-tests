<?php
use function GuzzleHttp\json_encode;

class TestController extends Controller
{

	private $db;

	function __construct()
	{
		$this->db = new DB();
	}

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
			var_dump($_FILES);
			$file = $_FILES['file']['tmp_name'];
			$handle = fopen($file, "r");
			$c = 0;
			$this->db->query('insert into tests ( created_by, topic ) values ( 1, ' . $this->db->quote($_FILES['file']['name']) . ' )');
			$testId = $this->db->lastInsertId();
			$insertQuestionsQuery = 'insert into questions ( test_id, text, answer_1, answer_2, answer_3, answer_4, correct_answer ) values ';

			while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
				$question = iconv(mb_detect_encoding($filesop[0], mb_detect_order(), true), "UTF-8", $filesop[0]);;
				$answer_1 = $filesop[1];
				$answer_2 = $filesop[2];
				$answer_3 = $filesop[3];
				$answer_4 = $filesop[4];
				$correct_answer = $filesop[5];
				if ($c <> 0) {
					$insertQuestionsQuery .= '(' . $this->db->quote($testId) . ', ' . $this->db->quote($question) . ', ' . $this->db->quote($answer_1) . ', ' . $this->db->quote($answer_2) . ', ' . $this->db->quote($answer_3) . ', ' . $this->db->quote($answer_4) . ', ' . $this->db->quote($correct_answer) . '),';
				}
				$c = $c + 1;
			}

			$insertQuestionsQuery = rtrim($insertQuestionsQuery, ', ');
			$this->db->query($insertQuestionsQuery);

			echo $testId;
		}
	}

	public function get($id)
	{
		$testTopic = $this->db->query("select topic from tests where id = " . $id);
		$questions = $this->db->query("select id, text, answer_1, answer_2, answer_3, answer_4, correct_answer from questions where test_id = " . $id);
		$data = array();
		$data['topic'] = $testTopic[0]['topic'];
		$data['questions'] = $questions;

		$view = $this->withLayout(
			new View($data, VIEWS_PATH . DS . 'test' . DS . 'edit.html')
		);
		$content = $view->render();
		echo $content;
	}

	public function update()
	{
		$test = json_decode(file_get_contents('php://input'));
		$topic = $test->topic;
		$this->db->query('update tests set topic =' . $this->db->quote($topic));

		foreach ($test->questions as $key => $value) { 
			$updateQuery = 'update questions set text = "'. $this->db->quote($value->text) .'" , 
			answer_1 = "'.$this->db->quote($value->answer_1).'", 
			answer_2 ="'.$this->db->quote($value->answer_2).'", 
			answer_3 ="'.$this->db->quote($value->answer_3).'", 
			answer_4 ="'.$this->db->quote($value->answer_4).'", 
			correct_answer =' . $value->correct_answer.'
			where id = '.$value->id;

			$this->db->query($updateQuery);
		}

		// $insertQuestionsQuery = 'insert into questions ( test_id, text, answer_1, answer_2, answer_3, answer_4, correct_answer ) values ';
		// foreach ($test->questions as $key => $value) {
		// 	$insertQuestionsQuery .= '("' . $testId . '", "' . $value->question . '", "' . $value->answer_1 . '", "' . $value->answer_2 . '", "' . $value->answer_3 . '", "' . $value->answer_4 . '", "' . $value->correct_answer . '"),';
		// }
		// $insertQuestionsQuery = rtrim($insertQuestionsQuery, ", ");
		// $this->db->query($insertQuestionsQuery);
	}
}
