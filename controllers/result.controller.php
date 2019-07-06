<?php

class ResultController extends Controller
{

	protected $auth;
	protected $repo;

	public function __construct()
	{
		$this->auth = new Auth();
		$this->repo = new Repository();
	}

	public function getById($id)
	{
		$data = array();
		$data['testResult'] = $this->repo->getTestResultById($id);
		$data['answers'] = $this->repo->getAnswerResultsByTestResultId($id);

		$view = $this->withLayout(
			new View($data, VIEWS_PATH . DS . 'result' . DS . 'detailed.html')
		);

		echo $view->render();
	}

	public function submit()
	{
		$restJson = file_get_contents("php://input");
		$_POST = json_decode($restJson, true);

		if (isset($_POST)) {

			$answers = $_POST['answers'];
			$userId = $_POST['userId'];
			$testId = $_POST['testId'];

			$test = $this->repo->getTestById($testId);
			$questions = $this->repo->getQuestionsByTestId($testId);
			
			$correctAnswers = 0;
			$answerDtos = array();
			foreach ($answers as $answer) {
				foreach ($questions as $q) {
					if ($answer['questionId'] == $q->id) {
						$answerResult = new AnswerResult();
						$answerResult->questionId = $q->id;
						$answerResult->questionText = $q->text;
						$answerResult->correctAnswer = $q->correctAnswer;
						$answerResult->givenAnswer = $answer['givenAnswer'];
						if ($answerResult->correctAnswer == $answerResult->givenAnswer) {
							$correctAnswers += 1;
						}
						array_push($answerDtos, $answerResult);
						break;
					}
				}
			}

			$testResult = new TestResult();
			$testResult->testId = $test->id;
			$testResult->userId = $userId;
			$testResult->correctAnswers = $correctAnswers;
			$testResult->questionsCount = count($questions);
			$testResultId = $this->repo->insertTestResult($testResult);
			foreach ($answerDtos as $a) {
				$a->testResultId = $testResultId;
			}
			$this->repo->insertAnswerResultArray($answerDtos);
			echo $testResultId;
		}
	}
}
