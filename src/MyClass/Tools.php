<?php

namespace src\MyClass;
use Symfony\Component\Filesystem\Filesystem;

class Tools
{
    /**
     * permet de supprimer des fichiers d'un dossier
     * Plugin Symfony
     * @param $path
     * @return mixed
     */
    public static function removeSy($path) {
        return (new Filesystem)->remove($path);
    }

    /**
     * permet de supprimer des fichiers par lot
     * @param $path
     * @return bool
     */
    public static function deleteDir($path) {
        $class_func = array(__CLASS__, __FUNCTION__);
        if (empty($path)) {
            return false;
        }
        return is_file($path) ?
            @unlink($path) :
            array_map($class_func, glob($path.'/*')) == @rmdir($path);
    }
}