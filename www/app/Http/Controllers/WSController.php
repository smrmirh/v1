<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WSController extends Controller
{

    var $currentAction;
    var $currentAccess = false;
    var $currentUserId = false;
    var $currentDepId  = false;
    var $allowed = false;

    function __construct() {}

    public function index(Request $request) {
        //return $request->action;

        if ( ! Auth::check() ) {
            $this->accessValidate();
        }

        $this->currentAccess = Auth::user()->access;
        $this->currentUserId = Auth::user()->id;
        $this->currentDepId = Auth::user()->depid;


        if ( ! $request->action ) {
            $this->display(false,"none","نوع درخواست مشخص نشده است");
        }

        $this->currentAction = $request->action;

        if ( ! $request->p ) {
            $this->display(false,$request->action,"درخواست شما بدون جزییات کافی ارسال گردیده است");
        }
        $params = $request->p;


        switch($request->action) {

            case "plug" :
                $this->plug($params);
                break;

            case "gplug" :
                $this->gplug($params);
                break;

            case "unplug" :
                $this->unplug($params);
                break;

            case "gunplug" :
                $this->gunplug($params);
                break;

            case "login" :
                $this->login($params);
                break;

            case "logout" :
                $this->logout($params);
                break;


            case "glogin" :
                $this->glogin($params);
                break;

            case "glogout" :
                $this->glogout($params);
                break;


            default :
                $this->display(false,"none","درخواست نامعتبر");
        }

    }


    /* Function for self plugging */
    public function plug($params) {
        if ( ! $params["agent_id"] ) {
            $this->display(false,"plug","شناسه اپراتور ارسال نشده است");
        }
        if ( ! $params["station_id"] ) {
            $this->display(false,"plug","شناسه ایستگاه ارسال نشده است");
        }

        $plug = AgentController::plug($params["agent_id"],$params["station_id"],false,"Self","");

        if ( $plug["result"] ) {
            $this->display(true,"plug","اتصال با موفقیت انجام شد");
        } else {
            $this->display(false,"plug","امکان اتصال بر روی این ایستگاه وجود ندارد.");
        }
    }


    /* Granted plug, Use for SP and Admins */
    public function gplug($params) {
        if ( ! $params["agent_id"] ) {
            $this->display(false,$this->currentAction,"شناسه اپراتور ارسال نشده است");
        }
        if ( ! $params["station_id"] ) {
            $this->display(false,$this->currentAction,"شناسه ایستگاه ارسال نشده است");
        }

        if ( $this->currentAccess < 4 ) {
            if ( $this->currentDepId != AgentController::getDepartmentId($params["agent_id"]) ) {
                $this->display(false,$this->currentAction,"شما مجاز به انجام این عملیات نیستید");
            }
        }

        $gplug = AgentController::plug($params["agent_id"],$params["station_id"],true,"Supervised($this->currentUserId)","");

        if ( $gplug["result"] ) {
            $this->display(true,"plug","اتصال با موفقیت انجام شد");
        } else {
            $this->display(false,"plug","امکان اتصال بر روی این ایستگاه وجود ندارد.");
        }


    }


    public function unplug($params) {
        if ( ! $params["agent_id"] ) {
            $this->display(false,$this->currentAction,"شناسه اپراتور ارسال نشده است");
        }

        $unplug = AgentController::unplug($params["agent_id"]);
        if ( $unplug["result"] ) {
            $this->display(true,$this->currentAction,"قطع اتصال با موفقیت انجام شد");
        } else {
            $this->display(false,$this->currentAction,"خطا در قطع اتصال" . "(" . $unplug["error"]  . ")");
        }
    }





    public function gunplug($params) {
        if ( $this->currentAccess < 4 ) {
            if ( $this->currentDepId != AgentController::getDepartmentId($params["agent_id"]) ) {
                $this->display(false,$this->currentAction,"شما مجاز به انجام این عملیات نیستید");
            }
        }

        $gunplug = AgentController::unplug($params["agent_id"]);
        if ( $gunplug["result"] ) {
            $this->display(true,$this->currentAction,"قطع اتصال با موفقیت انجام شد");
        } else {
            $this->display(false,$this->currentAction,"خطا در قطع اتصال" . "(" . $gunplug["error"]  . ")");
        }

    }






    public function login($params) {
        if ( ! isset( $params["agent_id"] )  ) {
            $this->display(false,$this->currentAction,"شناسه کاربری ارسال نشده است");
        }
        if ( ! isset($params["queue_id"])) {
            $this->display(false,$this->currentAction,"شناسه صف ارسال نشده است");
        }

        if ( $this->currentUserId == $params["agent_id"] ) {
            $by = "WebSelf($params[agent_id])";
        } else {
            if ( $this->currentUserId < 3 ) {
                $this->display(false,$this->currentAction,ErrorRefrenceController::errors(1));
            } else {
                $by = "Supervised by " . $this->currentUserId;
            }

        }

        $login = AgentController::login($params["agent_id"],$params["queue_id"],$by,"-");

        if ( $login["result"] ) {
            $this->display(true,$this->currentAction,"ورود به صف با موفقیت انجام شد");
        } else {
            $this->display(false,$this->currentAction,"خطا در ورود به صف");
        }

    }


    /* glogin : Login made by SP or admins */
    public function glogin($params) {
        if ( $this->currentAccess < 4 ) {
            if ( $this->currentDepId != AgentController::getDepartmentId($params["agent_id"]) ) {
                $this->display(false,$this->currentAction,"شما مجاز به انجام این عملیات نیستید");
            }
        }


        if ( ! isset( $params["agent_id"] )  ) {
            $this->display(false,$this->currentAction,"شناسه کاربری ارسال نشده است");
        }
        if ( ! isset($params["queue_id"])) {
            $this->display(false,$this->currentAction,"شناسه صف ارسال نشده است");
        }

        $by = "Supervised($this->currentUserId)";
        $glogin = AgentController::login($params["agent_id"],$params["queue_id"],$by,"-");


        if ( $glogin["result"] ) {
            $this->display(true,$this->currentAction,"ورود به صف با موفقیت انجام شد");
        } else {
            $this->display(false,$this->currentAction,"خطا در ورود به صف");
        }

    }


    /* Self-logout */
    public function logout($params) {

        if ( ! isset( $params["agent_id"] )  ) {
            $this->display(false,$this->currentAction,"شناسه کاربری ارسال نشده است");
        }
        if ( ! isset($params["queue_id"])) {
            $this->display(false,$this->currentAction,"شناسه صف ارسال نشده است");
        }

        if ( $this->currentUserId == $params["agent_id"] ) {
            $by = "WebSelf($params[agent_id])";
        } else {
            if ( $this->currentUserId < 3 ) {
                $this->display(false,$this->currentAction,ErrorRefrenceController::errors(1));
            } else {
                $by = "Supervised by " . $this->currentUserId;
            }

        }

        $logout = AgentController::logout($params["agent_id"],$params["queue_id"],$by,"-");

        if ( $logout["result"] ) {
            $this->display(true,$this->currentAction,"خروج از صف با موفقیت انجام شد");
        } else {
            $this->display(false,$this->currentAction,"خطا در خروج از صف");
        }

    }

    /* glogout : logout made by SP or Admins */
    public function glogout($params) {
        if ( $this->currentAccess < 4 ) {
            if ( $this->currentDepId != AgentController::getDepartmentId($params["agent_id"]) ) {
                $this->display(false,$this->currentAction,"شما مجاز به انجام این عملیات نیستید");
            }
        }

        if ( ! isset( $params["agent_id"] )  ) {
            $this->display(false,$this->currentAction,"شناسه کاربری ارسال نشده است");
        }
        if ( ! isset($params["queue_id"])) {
            $this->display(false,$this->currentAction,"شناسه صف ارسال نشده است");
        }

        $by = "Supervised($this->currentUserId)";
        $glogout = AgentController::logout($params["agent_id"],$params["queue_id"],$by,"Supervised($this->currentUserId)");
        if ( $glogout["result"] ) {
            $this->display(true,$this->currentAction,"خروج از صف با موفقیت انجام شد");
        } else {
            $this->display(false,$this->currentAction,"خطا در خروج از صف");
        }

    }


    public function display($result,$action,$message) {
        $res =  array(
            "result"    => $result,
            "action"    => $action,
            "message"   => $message
        );
        echo json_encode($res);
        exit;
    }

    public function accessValidate(){
        //$this->display(false,"none","Access retricted");
        //$this->allowed = true;
        abort("401");
    }


}
