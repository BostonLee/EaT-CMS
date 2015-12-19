<?php
class Route
{
    static function launch()
    {

        global $config;
        global $isAdmin;
        $actual_link = $_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
        $route = explode('/',$actual_link);

        $modules = explode(',',$config['modules']['active_modules']);
        $is_module = false;

        foreach($modules as $modul) { if(array_key_exists(1,$route) && $route[1] == $modul && $route[1] != '') { $is_module = true; } }

        $arr_length = count($route);
        $add_value = 0;
        if($is_module){ $add_value = 1; }
        for($i=1 - $add_value;$i<$arr_length;$i++)
        {
            switch($i)
            {

                case 0:
                    $number_value = $i + 1;
                    DEFINED('MODULES_APP') or DEFINE('MODULES_APP',$route[$number_value]);
                    foreach(explode(',',$config['modules']['admin_login_required']) as $check)
                    {

                        if($check == MODULES_APP && !$isAdmin && MODULES_APP != '')
                        {
                            header('Location: '. LOGIN_PAGE);
                            die();
                        }
                    }
                    if($route[$number_value + $add_value] != ''){ DEFINED('CONTROLLER_APP') or DEFINE('CONTROLLER_APP',$route[$number_value + $add_value]); }
                    else {
                        DEFINED('CONTROLLER_APP') or DEFINE('CONTROLLER_APP','index');
                        DEFINED('ACTION_APP') or DEFINE('ACTION_APP','index');
                    }
                    break;

                case 1:
                    $number_value = $i;
                    if($route[$number_value + $add_value + 1] == '') { DEFINED('ACTION_APP') or DEFINE('ACTION_APP','index'); }
                    if($route[$number_value + $add_value] != ''){ DEFINED('CONTROLLER_APP') or DEFINE('CONTROLLER_APP',$route[$number_value + $add_value]); }
                    else {
                        DEFINED('CONTROLLER_APP') or DEFINE('CONTROLLER_APP','index');
                        DEFINED('ACTION_APP') or DEFINE('ACTION_APP','index');
                    }
                    break;
                case 2:
                    $number_value = $i;
                    if($route[$number_value + $add_value] != ''){ DEFINED('ACTION_APP') or DEFINE('ACTION_APP',$route[$number_value + $add_value]); }
                    else {  DEFINED('ACTION_APP') or DEFINE('ACTION_APP','index'); }
                    break;
                case 3:
                    $number_value = $i;
                    if($route[$number_value + $add_value] != ''){ DEFINED('KEY_APP') or DEFINE('KEY_APP',$route[$number_value + $add_value]); }
                    break;
                case 4:
                    $number_value = $i;
                    if($route[$number_value + $add_value] != ''){ DEFINED('VALUE_APP') or DEFINE('VALUE_APP',$route[$number_value + $add_value]); }
                    break;
            }
        }

        switch($add_value)
        {
            case 0:
                if(defined('CONTROLLER_APP')) { self::check_include(CONTROLLER_PATH. SL .ucfirst(CONTROLLER_APP).'Controller.php'); }
                else { self::check_include(DEF_CONTROLLER.''); }
                break;
            case 1:
                if(defined('CONTROLLER_APP')) { self::check_include(MODULES_PATH. SL . MODULES_APP . SL . 'controllers' . SL .ucfirst(CONTROLLER_APP).'Controller.php'); }
                else { self::check_include(MODULES_PATH. SL . MODULES_APP . SL . 'controllers' . SL . 'IndexController.php'); }
                break;
        }

        Model::launch_model();
        Controller::launch_controller();

    }
    static private function check_include($inc)
    {
        if( file_exists($inc) && is_readable($inc)) {
            /** @noinspection PhpIncludeInspection */
            include($inc); }
        else { self::not_found(CONTROLLER_APP); }
    }
    static function not_found($error)
    {
        if(DEBUG) { echo("Page: $error not found!"); die(); }
else { self::error404('page:'.$error); }
}

static function error404($error)
{
    header("Location: /error#".$error);
    die();
}
}