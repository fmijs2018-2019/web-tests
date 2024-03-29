<?php

class View{

    protected $data;

    protected $path;

    protected static function getDefaultViewPath(){
        $router = App::getRouter();
        if ( !$router ){
            return false;
        }
        $controller_dir = $router->getController();
        $template_name = $router->getMethodPrefix().$router->getAction().'layout.html';

        return VIEWS_PATH.DS.$controller_dir.DS.$template_name;
    }

    public function __construct($data, $path){
        $this->path = $path;
		$this->data = $data;
    }

    public function render(){
        $data = $this->data;

        ob_start();
        include($this->path);
        $content = ob_get_clean();

        return $content;
    }

}