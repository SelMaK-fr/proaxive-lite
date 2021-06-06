<?php
namespace src\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('activeornot', [$this, 'valueIsActiveOrNot']),
            new TwigFilter('statuscircle', [$this, 'getStatusCircle']),
            new TwigFilter('supext', [$this, 'SupExt']),
        ];
    }

    /**
     * @param int $key
     * @return string
     */
    public function valueIsActiveOrNot(int $key)
    {
        if ($key == 1) {$data = '<label class="label label-info">Activé</label>';}
        if ($key == 0) {$data = '<label class="label label-danger">Désactivé</label>';}
        return $data;
    }


    /**
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
     * Supprime l'extension d'un fichier
     * @param string $key
     * @return string
     */
    public function SupExt(string $key)
    {
        $dot = ".";
        $position = strpos($key, $dot);
        return substr($key, 0, $position);
    }
}