<?php

class Bootstrap
{
    private $controller;
    private $action;
    private $request;

    public function __construct($request) {
        $this->request = $request;
        if($this->request['controller'] == ""){
            $this->controller = "home";
        } else {
            $this->controller = $this->request['controller'];
        }
        if($this->request['action'] == "") {
            $this->action  = "index";
        } else {
            $this->action = $this->request['action'];
        }
    }

    public function createController(){
        //Check Class
        if(class_exists($this->controller)){
            $parents = class_parents($this->controller);
            //Check id Extended
            if(in_array("Controller",$parents)){
                if(method_exists($this->controller, $this->action)) {
                    return new $this->controller($this->action, $this->request);
                } else {
                    //Method Does not Exist
                    echo "<p>Method Does not Exist</p>";
                    return;
                }
            } else {
                //Base Controller does not exist
                echo "<p>Base Controller not found</p>";
                return;
            }
        } else {
            //Base Controller does not exist
            echo "<p>Controller Class does not exist</p>";
            return;
        }
    }

}