<?php
namespace src\Router\AltoRouter;

class Router
{

    /**
     * @var string
     */
    private $viewPath;
    /**
     * @var \AltoRouter
     */
    private $router;

    /**
     * Router constructor.
     * @param string $viewPath
     */
    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new \AltoRouter();
    }

    public function get(string $url, string $view, ?string $name = null) :self
    {
        $this->router->map('GET', $url, $view, $name);
        return $this;
    }

    public function run()
    {
        $match = $this->router->match();
        if( is_array($match) && is_callable( $match['target'] ) ) {
            call_user_func_array( $match['target'], $match['params'] );
        } else {
            // no route was matched
            header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        }
       return $match['target'];
    }
}