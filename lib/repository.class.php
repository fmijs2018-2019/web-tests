<?php

class Repository
{
	private $db;

	function __construct()
	{
		$this->db = new DB();
	}

	function getTestById($id)
	{
		$data = $this->db->query("select id, topic, created_at, created_by from tests where id = " . $id);
		if (count($data) > 0) {
			$test = new Test();
			$test->id = (int) $data[0]['id'];
			$test->topic = (int) $data[0]['topic'];
			$test->createdAt = $data[0]['created_at'];
			$test->createdBy = $data[0]['created_by'];
			return $test;
		} else {
			return null;
		}
	}

	function getQuestionsByTestId($id)
	{
		$data = $this->db->query("select id, test_id, text, answer_1, answer_2, answer_3, answer_4, correct_answer from questions where test_id = " . $id);
		$result = array();
		foreach ($data as $d) {
			$question = new Question();
			$question->id = (int) $d['id'];
			$question->testId = (int) $d['test_id'];
			$question->text = $d['text'];
			$question->answer1 = $d['answer_1'];
			$question->answer2 = $d['answer_2'];
			$question->answer3 = $d['answer_3'];
			$question->answer4 = $d['answer_4'];
			$question->correctAnswer = (int) $d['correct_answer'];
			array_push($result, $question);
		}
		return $result;
	}

	function getTestResultById($id)
	{
		$data = $this->db->query('select id, test_id, user_id, correct_answers, questions_count, created_at from test_results where id = ' . $id);
		if (count($data) > 0) {
			$tResult = new TestResult();
			$tResult->id = (int) $data[0]['id'];
			$tResult->testId = (int) $data[0]['test_id'];
			$tResult->userId = $data[0]['user_id'];
			$tResult->correctAnswers = (int) $data[0]['correct_answers'];
			$tResult->questionsCount = (int) $data[0]['questions_count'];
			$tResult->createdAt = $data[0]['created_at'];
			return $tResult;
		} else {
			return null;
		}
	}

	function getTestResultsByUserId($id)
	{
		$userId = $this->db->quote($id);
		$data = $this->db->query('select id, test_id, user_id, correct_answers, questions_count, created_at from test_results where user_id = ' . $userId);
		$result = array();
		foreach($data as $d) {
			$tResult = new TestResult();
			$tResult->id = (int) $d['id'];
			$tResult->testId = (int) $d['test_id'];
			$tResult->userId = $d['user_id'];
			$tResult->correctAnswers = (int) $d['correct_answers'];
			$tResult->questionsCount = (int) $d['questions_count'];
			$tResult->createdAt = $d['created_at'];
			array_push($result, $tResult);
		}
		return $result;
	}

	function getAnswerResultsByTestResultId($id)
	{
		$data = $this->db->query('select id, test_result_id, correct_answer, given_answer, question_id, question_text from answer_results where test_result_id = ' . $id);
		$result = array();
		foreach ($data as $d) {
			$answer = new AnswerResult();
			$answer->id = (int) $d['id'];
			$answer->testResultId = (int) $d['test_result_id'];
			$answer->correctAnswer = (int) $d['correct_answer'];
			$answer->givenAnswer = (int) $d['given_answer'];
			$answer->questionId = (int) $d['question_id'];
			$answer->questionText = $d['question_text'];
			array_push($result, $answer);
		}
		return $result;
	}

	function insertTestResult($result)
	{
		$userId = $this->db->quote($result->userId);
		$testId = $result->testId;
		$correctAnswers = $result->correctAnswers;
		$questionsCount = $result->questionsCount;

		$query = 'insert into test_results (user_id, test_id, correct_answers, questions_count) '
			. 'values (' . $userId . ',' . $testId . ',' . $correctAnswers . ',' . $questionsCount . ')';

		$this->db->query($query);
		return $this->db->lastInsertId();
	}

	function insertAnswerResultArray($array)
	{
		$db = $this->db;
		$query = 'insert into answer_results (correct_answer, given_answer, question_id, question_text, test_result_id) values '
			. join(',', array_map(function ($q) use ($db) {
				return '(' . $q->correctAnswer . ',' . $q->givenAnswer . ',' . $q->questionId . ',' . $this->db->quote($q->questionText) . ',' . (int) $q->testResultId . ')';
			}, $array));
		$this->db->query($query);
	}
}
