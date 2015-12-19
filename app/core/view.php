<?php
class View extends Route
{
    static function launch_view($layout = null)
    {
        global $customLayout;
        if(DEFINED('MODULES_APP'))
        {
            foreach(glob(MODULES_PATH . SL . MODULES_APP . SL . 'viewHelpers' . SL . '*.php') as $file)
            {
                /** @noinspection PhpIncludeInspection */
                include_once $file;
            }

            if(isset($customLayout)) {
                $path = MODULES_PATH . SL . MODULES_APP . SL . 'view/layouts' . SL . $customLayout . '.php';

                if (file_exists($path) && is_readable($path)) {
                    /** @noinspection PhpIncludeInspection */
                    include_once($path);
                } else {
                    echo 'No Such Layout: ' . $customLayout . '!';
                }
            }
            else
            {
                if (file_exists(MODULES_PATH . SL . MODULES_APP . SL . 'views/layouts/' . LAYOUT ) && is_readable(MODULES_PATH . SL . MODULES_APP . SL . 'views/layouts/' . LAYOUT )) {
                    /** @noinspection PhpIncludeInspection */
                    include_once(MODULES_PATH . SL . MODULES_APP . SL . 'views/layouts/' . LAYOUT);
                } else {
                    echo 'No Such Layout: ' . MODULES_PATH . SL . MODULES_APP . SL . 'view/layouts/' . LAYOUT . '!';
                }
            }
        }
        else
        {
            foreach(glob(APP_PATH . SL . 'viewHelpers' . SL . '*.php') as $file)
            {
                /** @noinspection PhpIncludeInspection */
                include_once $file;
            }

            if(isset($customLayout)) {
                $path = LAYOUT_PATH . SL . $customLayout . '.php';

                if (file_exists($path) && is_readable($path)) {
                    /** @noinspection PhpIncludeInspection */
                    include_once($path);
                } else {
                    echo 'No Such Layout: ' . $customLayout . '!';
                }
            }
            else
            {
                if (file_exists(DEF_LAYOUT) && is_readable(DEF_LAYOUT)) {
                    /** @noinspection PhpIncludeInspection */
                    include_once(DEF_LAYOUT);
                } else {
                    echo 'No Such Layout: ' . DEF_LAYOUT . '!';
                }
            }
        }
    }

    static function get_content($file)
    {
        global $Data;
        /** @noinspection PhpIncludeInspection */
        include_once($file);
    }

}