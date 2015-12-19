<?php
class Controller extends Route
{
    static function launch_controller()
    {
        if(defined('ACTION_APP') && !defined('MODULES_APP'))
        {
            self::check_include(VIEW_PATH . SL . CONTROLLER_APP . SL . ACTION_APP . 'View.php');
        }
        else if(defined('MODULES_APP'))
        {
            self::check_include(MODULES_PATH. SL . MODULES_APP  . SL . 'views' . SL . CONTROLLER_APP . SL . ACTION_APP . 'View.php');
        }
        else
        {
            if(CONTROLLER_APP != 'error')
            {
                self::check_include(DEF_VIEW_PATH.'');
            }
            else
            {
                self::check_include(VIEW_PATH. SL . 'error' . SL . DEF_VIEW);
            }
        }
    }
    static private function check_include($inc)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && strpos(KEY_APP,'ajax?get') !== false || $_SERVER['REQUEST_METHOD'] === 'POST' && KEY_APP == 'ajax?post') {

            $ACTION_APP = '';
            $classMain = CONTROLLER_APP . '_Controller';
            foreach(explode("-", ACTION_APP) as $index=>$spl)
            {
                if($index != 0){$ACTION_APP .= ucfirst($spl);}
                else { $ACTION_APP .= $spl;}
            }
            $classMain = CONTROLLER_APP . '_Controller';
            $functionAction = $ACTION_APP . 'Action';
            $classMain = new $classMain;
            $classMain->$functionAction();
        }
        else {
            if (file_exists($inc) && is_readable($inc)) {
                $classMain = CONTROLLER_APP . '_Controller';
                $functionAction = ACTION_APP . 'Action';
                $classMain = new $classMain;
                $classMain->$functionAction();

                $view = new View();
                $view->launch_view($inc);
            } else {
                self::not_found(ACTION_APP);
            }
        }
    }
    static function not_found($error)
    {
        if(DEBUG) { echo('Action: "$error" not found!');  die(); }
else { Route::error404('action:' . ACTION_APP); }
}
}