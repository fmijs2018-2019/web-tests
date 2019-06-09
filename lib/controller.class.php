<?php

class Controller{

	protected function withLayout($partialView, $layoutPath = VIEWS_PATH.DS.'layout.html') {
		$partial = $partialView->render();
        $layoutView = new View(compact('partial'), $layoutPath);
        return $layoutView;
	}

}