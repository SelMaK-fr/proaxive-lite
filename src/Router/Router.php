<?php

namespace src\Router;

class Router
{
    private $url; // Contiendra l'URL sur laquelle on souhaite se rendre
    private $routes = []; // Contiendra la liste des routes
    private $namedRoutes = []; // Nom de la route

    /**
     *
     * @param type $url
     */
    public function __construct($url){
        $this->url = $url;
    }


    /**
     *
     * @param type $path
     * @param type $callable
     * @param type $name
     * @return type
     */
    public function get($path, $callable, $name = null){
        return $this->add($path, $callable, $name, 'GET');
    }



    /**
     *
     * @param type $path
     * @param type $callable
     * @param type $name
     * @return type
     */
    public function post($path, $callable, $name = null){
        return $this->add($path, $callable, $name, 'POST');
    }

    /**
     *
     * @param type $path
     * @param type $callable
     * @param type $name
     * @return type
     */
    public function put($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'POST');
    }

    /**
     *
     * @param type $path
     * @param type $callable
     * @param type $name
     * @return type
     */
    public function delete($path, $callable, $name = null){
        return $this->add($path, $callable, $name, 'POST');
    }


    /**
     *
     * @param type $path
     * @param type $callable
     * @param type $name
     * @param type $method
     */
    private function add($path, $callable, $name, $method){
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if(is_string($callable) && $name === null){
            $name = $callable;
        }
        if($name){
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    /**
     *
     * @return type
     * @throws RouterException
     */
    public function run(){
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new RouterException('REQUEST_METHOD does not exist !');
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)){
                return $route->call();
            }
        }
        // throw new RouterException('No matching routes !');
        return header("Location: /"); // Return vers l'index
    }


    /**
     *
     * @param $name
     * @param array $params
     * @return mixed
     */
    public function url($name, $params = []){
        if(!isset($this->namedRoutes[$name])){
            throw new RouterException('No route matches this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }
}