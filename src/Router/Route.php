<?php

namespace src\Router;

class Route
{

    private $callable;
    private $path;
    private $matches = [];
    private $params = [];


    /**
     *
     * @param type $path
     * @param type $callable
     */

    public function __construct($path, $callable){
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }


    /**
     *
     * @param type $param
     * @param type $regex
     */

    public function with($param, $regex){
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }


    /**
     *
     * @param type $url
     */
    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }


    /**
     *
     * @param type $match
     */
    private function paramMatch($match){
        if(isset($this->params[$match[1]])){
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }


    /**
     *
     */
    public function call(){

        if(is_string($this->callable)){
            $params = explode('#', $this->callable);
            if($params[0] === 'Dashboard'){
                $controller = "App\\Controller\\Dashboard\\" . ucfirst($params[1]) . "Controller";
                $action = $params[2];
            }
            else{
                $controller = "App\\Controller\\" . ucfirst($params[0]) . "Controller";
                $action = $params[1];
            }
            $controller = new $controller;
            return call_user_func_array([$controller, $action], $this->matches);
        }else{
            return call_user_func_array($this->callable, $this->matches);
        }
    }


    /**
     *
     * @param type $params
     */
    public function getUrl($params){
        $path = $this->path;
        foreach($params as $k => $v){
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }

}