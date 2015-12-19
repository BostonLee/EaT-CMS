<?php

class Model extends Route
{
    static function launch_model()
    {
        if (DEFINED(MODULES_APP)) {
            $inc = MODULES_PATH . SL . MODULES_APP . SL . 'models' . SL . ucfirst(CONTROLLER_APP) . 'Model.php';
            if (file_exists($inc) && is_readable($inc)) {
                /** @noinspection PhpIncludeInspection */
                include($inc);
            }
        } else {
            $inc = MODEL_PATH . SL . ucfirst(CONTROLLER_APP) . 'Model.php';
            if (file_exists($inc) && is_readable($inc)) {
                /** @noinspection PhpIncludeInspection */
                include($inc);
            }
        }
    }

    static function db()
    {
        global $config;
        $data = $config['database'];
        global $pdo;
        try {
            $dsn = "mysql:host=" . $data['db_host'] . ";dbname=" . $data['db_name'] . ";charset=" . $data['db_charset'];
            $opt = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            );
            $pdo = new PDO($dsn, $data['db_username'], $data['db_password'], $opt);
        } catch (PDOException $e) {
            if (!DEBUG) {
                die('Connection fail.');
            } else {
                die('Connection fail: ' . $e->getMessage());
            }
        }
    }

    static function check_login()
    {
        global $config;
        global $isAdmin;

        $login = $_POST['Login'];
        $password = $_POST['Password'];
        session_start();
        $data_login = $config['admin'];


        if ($login == $data_login['login'] && $password == $data_login['password']) {
            $_SESSION['admin_login'] = $login;
            $_SESSION['admin_password'] = $password;
        }


        if (isset($_SESSION['admin_login']) && isset($_SESSION['admin_password'])) {
            if ($_SESSION['admin_login'] == $data_login['login'] && $_SESSION['admin_password'] == $data_login['password']) {
                $isAdmin = true;
            } else {
                $isAdmin = false;
                session_unset();
                session_destroy();
            }
        }
    }



    static function sql_wrap($sql, $array = null)
    {
        global $pdo;
        $statement = $pdo->prepare($sql);
        $statement->execute($array);
        if(strpos($sql,'SELECT') !== false) {
            $data = $statement->fetchAll();

            return $data;
        }
    }
}