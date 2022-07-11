<?php

final class Constants
{
    const VIEWS_DIR       = '/views/';

    const MODELS_DIR      = '/models/';

    const CORE_DIR        = '/core/';

    const CONTROLLERS_DIR = '/controllers/';

    const SERVER_CONFIG = 'dBServer.ini';
    

    public static function rootPath() :string 
    {
        return realpath(__DIR__ . '/../');   //because this Constants file is in /core/ directory. 
    }

    public static function corePath() :string 
    {
        return self::rootPath() . self::CORE_DIR;
    }

    public static function viewsPath() :string
    {
        return self::rootPath() . self::VIEWS_DIR;
    }

    public static function modelsPath() :string
    {
        return self::rootPath() . self::MODELS_DIR;
    }

    public static function controllersPath() :string
    {
        return self::rootPath() . self::CONTROLLERS_DIR;
    }
}