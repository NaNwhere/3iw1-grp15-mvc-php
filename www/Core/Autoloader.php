<?php
namespace App\Core;

/**
 * Class Autoloader
 * Charge dynamiquement les classes de l'application.
 */
class Autoloader
{
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function autoload($class)
    {
        $class = str_replace('App\\', '', $class);
        $class = str_replace('\\', '/', $class);
        
        $file = ROOT . '/' . $class . '.php';
        
        if (file_exists($file)) {
            require_once $file;
        }
    }
}
