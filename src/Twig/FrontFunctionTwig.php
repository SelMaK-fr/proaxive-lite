<?php


namespace src\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FrontFunctionTwig extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('statuscircle', [$this, 'getStatusCircle']),
            new TwigFunction('statusactive', [$this, 'getActiveOrInactive']),
            new TwigFunction('viewAlert', [$this, 'getViewFlash']),
            new TwigFunction('getDataWithHtml', [$this, 'getDataWithHtml']),
            new TwigFunction('getdata', [$this, 'getData']),
            new TwigFunction('breadcrumb', [$this, 'breadcrumb'])
        ];
    }

    /**
     * Permet d'afficher le status en ligne ou non sous forme de
     *
     * @param $var
     * @return string
     */
    public function getStatusCircle(int $var){

        if ($var == 1){
            $class = 'success';
        } elseif ($var == 0 or null){
            $class = 'danger';
        }
        return $html = '<span class="label label-circle-small-'.$class.'"></span>';
    }

    /**
     * @param int $var
     * @return string
     */
    public function getActiveOrInactive(int $var){
        if ($var == 1){
            $html = '<span class="label label-success">Activé</span>';
        } elseif ($var == 0 or null){
            $html = '<span class="label label-danger">Désactivé</span>';
        }
        return $html;
    }

    /**
     * @param $type
     * @param $message
     * @return string
     */
    public function getViewFlashFlex($type, $message){
        $html = '';
        if ($type == "success"){
            $html = '<div class="alert alert-success" role="alert"><div class="a-icon"><i class="icofont-check"></i></div><span>'.$message.'</span></div>';
        } elseif($type == "danger") {
            $html = '<div class="alert alert-danger" role="alert"><div class="a-icon"><i class="icofont-danger-zone"></i></div><span>'.$message.'</span></div>';
        } elseif($type == "warning") {
            $html = '<div class="alert alert-warning" role="alert"><div class="a-icon"><i class="icofont-exclamation-tringle"></i></div><span>'.$message.'</span></div>';
        } elseif($type == "info") {
            $html = '<div class="alert alert-info" role="alert"><div class="a-icon"><i class="icofont-info-square"></i></div><span>'.$message.'</span></div>';
        }
        return $html;
    }

    /**
     * @param $type
     * @param $message
     * @return string
     */
    public function getViewFlash($type, $message){
        $html = '';
        if ($type == "success"){
            $html = '<div class="alert alert-success" role="alert"><span><i class="icofont-check"></i></span>'.$message.'</div>';
        } elseif($type == "danger") {
            $html = '<div class="alert alert-danger" role="alert"><span><i class="icofont-danger-zone"></i></span>'.$message.'</div>';
        } elseif($type == "warning") {
            $html = '<div class="alert alert-warning" role="alert"><span><i class="icofont-exclamation-tringle"></i></span>'.$message.'</div>';
        } elseif($type == "info") {
            $html = '<div class="alert alert-info" role="alert"><span><i class="icofont-info-square"></i></span>'.$message.'</div>';
        }
        return $html;
    }

    /**
     * Retourne un champ d'une ligne si non renvoi false
     *
     * @param $data
     * @param $text
     * @return mixed
     */
    public function getData($data, $text){
        if(!empty($data) or $data == NULL){
            return $data;
        }else{
            return $text;
        }
    }

    /**
     * Retourne un champ d'une ligne si non renvoi false
     * Avec option balise HTML + Titre
     * @param $data
     * @param $text
     * @return mixed
     */
    public function getDataWithHtml($data, $label, $surround){
        if(!empty($data)){
            if($label){
                $labelCar = $label .' :';
            } else {
                $labelCar = '';
            }
            $data = $labelCar . ' <'.$surround.'>'.$data.'</' . $surround .'><br>';
            return $data;
        }else{
            return false;
        }
    }

    /**
     * @param string $separator
     * @param string $home
     * @param string $lastItem
     * @return string
     */
    public function breadcrumb($separator = '', $home = '', $lastItem = ''){

        // This sets the subdirectory as web_root (If you want to use a subdirectory)
        // If you do not use a web_root subdirectory, set $directory2=""; (NO trailing /)
        $directory2 = "admin" ;

        // This gets the REQUEST_URI (/path/to/file.php), splits the string (using '/') into an array, and then filters out any empty values
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ;
        $path_array = array_filter(explode('/',$path)) ;

        // This line of code accommodates using a subfolder (/var/www/html/<this folder>) as root
        // This removes the first item in the array path so it doesn't repeat
        if ($directory2 != "")
        {
            array_shift($path_array) ;
        }

        // This will build our "base URL" ... Also accounts for HTTPS :)
        //if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") {$path .= "s";}
        $base = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on'?'s':'') . '://' . $_SERVER['REQUEST_URI'] . '/'. $directory2 ;

        // Initialize a temporary array with our breadcrumbs. (starting with our home page, which I'm assuming will be the base URL)
        $breadcrumbs = Array("<li><a href=\"$base\">$home</a></li>") ;

        // Get the index for the last value in our path array
        $last = end($path_array) ;

        // Initialize the counter
        $crumb_counter = 2 ;

        // Build the rest of the breadcrumbs
        foreach ($path_array as $crumb)
        {
            // Our "title" is the text that will be displayed representing the filename without the .suffix
            // If there is no "." in the crumb, it is a directory
            if (strpos($crumb,".") == false)
            {
                $title = $crumb ;
            }
            else
            {
                $title = substr($crumb,0,strpos($crumb,".")) ;
            }

            // If we are not on the last index, then create a hyperlink
            if ($crumb != $last)
            {
                $calling_page_array = array_slice(array_values(array_filter(explode('/',$path))),0,$crumb_counter,false) ;
                $calling_page_path = "/".implode('/',$calling_page_array) ;
                $breadcrumbs[] = '<li><a href="/admin">Admin</a></li><li><a href="'.$calling_page_path.'">'.$title.'</a></li>' ;
            }

            // Otherwise, just display the title
            else
            {
                if($lastItem == ''){
                    $breadcrumbs[] = '<li>'.$title.'</li>' ;
                } else {
                    $breadcrumbs[] = '<li>'.$lastItem.'</li>' ;
                }
            }

            $crumb_counter = $crumb_counter + 1 ;

        }
        // Build our temporary array (pieces of bread) into one big string :)
        return implode($separator, $breadcrumbs) ;
    }

    public function breadcrumbDefault($key, $link){

        $breadcrumb = [];
        foreach ($key as $bread){
            $breadcrumb = '<li><a href="'.$link.'">'.$key.'</a></li>';
        }
        return $breadcrumb;
    }

}