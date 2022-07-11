<?php

require '../app/core/Constants.php';

final class Autoloader
{
    public static function loadCoreClasses (string $className)
    {
        $file = Constants::corePath() . "$className.php";
        return static::_load($file);
    }

    public static function loadModelsClasses (string $className)
    {
        $file = Constants::modelsPath() . "$className.php";

        return static::_load($file);
    }


    public static function loadViewsClasses (string $className)
    {
        $file = Constants::viewsPath() . "$className.php";

        return static::_load($file);
    }

    public static function loadControllersClasses (string $className)
    {
        $file = Constants::controllersPath() . "$className.php";

        return static::_load($file);
    }

    private static function _load (string $file)
    {
        if (is_readable($file))
        {
            require $file;
        }
    }
}

spl_autoload_register('Autoloader::loadCoreClasses');
spl_autoload_register('Autoloader::loadModelsClasses');
spl_autoload_register('Autoloader::loadViewsClasses');
spl_autoload_register('Autoloader::loadControllersClasses');
