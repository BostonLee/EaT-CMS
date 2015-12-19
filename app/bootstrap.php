<?php

foreach(glob(APP_PATH. SL .'interfaces/*.php') as $file)
{
    /** @noinspection PhpIncludeInspection */
    include_once $file;
}

/** @noinspection PhpIncludeInspection */
include_once(CORE_PATH . SL . 'router.php');
/** @noinspection PhpIncludeInspection */
include_once(CORE_PATH . SL . 'controller.php');
/** @noinspection PhpIncludeInspection */
include_once(CORE_PATH . SL . 'model.php');
/** @noinspection PhpIncludeInspection */
include_once(CORE_PATH . SL . 'view.php');


class Bootstrap
{
    static function init()
    {
        Model::db();
        Model::check_login();
        foreach(glob(APP_PATH. SL .'actionHelpers/*.php') as $file)
        {
            /** @noinspection PhpIncludeInspection */
            include_once $file;
        }
        global $titlePage;
        global $config;
        $titlePage = $config['settings']['title'];
        Route::launch();
    }
}