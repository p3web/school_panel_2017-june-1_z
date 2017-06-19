<?php

/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/16/17 AD
 * Time: 15:52
 */
class controller_main_function
{

    public static function check_validation($field)
    {
        $result['is_valid'] = true;
        for ($i = 0; count($field) > $i; $i++) {
            if (isset($_REQUEST[$field[$i]])) {
                $result[$field[$i]] = $_REQUEST[$field[$i]];
            } else {
                $result[$field[$i]] = false;
                $result['is_valid'] = false;
            }
        }
        return $result;
    }

    public static function send_msg($msg, $title, $type = "error", $btn = "")
    {
        self::send_result(array('msg' => $msg, 'title' => $title, 'type' => $type, 'btn' => $btn, 'act' => 'message'));
        exit;
    }

    public static function send_result($res)
    {
        echo json_encode($res);
    }
    /// summery
    /// check the user is login after that check in do act
   /* public static function checkLogin()
    {
        if (!isset($_SESSION['user']) && !isset($_SESSION['user'][0]['email'])) {
            send_result(array('Result' => 'login.html', 'act' => 'location'));
            exit;
        } else {
            return true;
        }
    }
   */
}