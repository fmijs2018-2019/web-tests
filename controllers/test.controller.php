<?php

use function GuzzleHttp\json_encode;

class TestController extends Controller
{

	private $db;
	private $auth;

	function __construct()
	{
		$this->db = new DB();
		$this->auth = new Auth();
	}

	public function index()
	{
		$data = $this->db->query("select * from tests");

		for ($i = 0; $i < count($data); $i++) {
			$data[$i]["isMine"] = $data[$i]['created_by'] == $this->auth->getUser()["sub"];
		}

		$view = $this->withLayout(
			new View($data, VIEWS_PATH . DS . 'test' . DS . 'index.html')
		);

		echo $view->render();
	}

	public function uploadView()
	{
		$data = array();
		$view = $this->withLayout(
			new View($data, VIEWS_PATH.DS.'test'.DS.'upload.html')
		);

		echo $view->render();
	}

	public function upload()
	{
		if (isset($_FILES['file'])) {
			$file = $_FILES['file']['tmp_name'];
			$handle = fopen($file, "r");
			$c = 0;
			$this->db->query('insert into tests ( created_by, topic ) values ('.$this->db->quote($this->auth->getUser()["sub"]).', ' . $this->db->quote($_FILES['file']['name']) . ' )');
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
		$test = $this->db->query("select topic, id from tests where id = " . $id);
		$questions = $this->db->query("select id, text, answer_1, answer_2, answer_3, answer_4, correct_answer from questions where test_id = " . $id);
		$data = array();
		$data['topic'] = $test[0]['topic'];
		$data['id'] = $test[0]['id'];
		$data['questions'] = $questions;

		return $data;
	}
 
	public function solve($id)
	{ 
		$data = $this->get($id);
		$data['user'] = $this->auth->getUser();

		$view = $this->withLayout(
			new View($data, VIEWS_PATH . DS . 'test' . DS . 'solve.html')
		);

		echo $view->render();
	}

	public function edit($id)
	{ 
		$data = $this->get($id);

		$view = $this->withLayout(
			new View($data, VIEWS_PATH . DS . 'test' . DS . 'edit.html')
		);

		echo $view->render();
	}

	public function update($id)
	{
		$test = json_decode(file_get_contents('php://input'));
		$topic = $test->topic;
		$this->db->query('update tests set topic = trim(both ' . $this->db->quote('\'') . ' from ' . $this->db->quote($topic) . ')where id = ' . $id);

		foreach ($test->questions as $key => $value) {
			$updateQuery = 'update questions set
			text = trim(both ' . $this->db->quote('\'') . ' from ' . $this->db->quote($value->text) . ') , 
			answer_1 = trim(both ' . $this->db->quote('\'') . ' from ' . $this->db->quote($value->answer_1) . '), 
			answer_2 = trim(both ' . $this->db->quote('\'') . ' from ' . $this->db->quote($value->answer_2) . '), 
			answer_3 = trim(both ' . $this->db->quote('\'') . ' from ' . $this->db->quote($value->answer_3) . '), 
			answer_4 = trim(both ' . $this->db->quote('\'') . ' from ' . $this->db->quote($value->answer_4) . '), 
			correct_answer = trim(both ' . $this->db->quote('\'') . ' from ' . $value->correct_answer . ')
			where id = ' . $value->id;

			$this->db->query($updateQuery);
		}
	}
}
