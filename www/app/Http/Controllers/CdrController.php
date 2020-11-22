<?php

namespace App\Http\Controllers;

use App\Models\Cdr;
use Illuminate\Http\Request;

class CdrController extends Controller
{


    private $model;

    private $direction      = null;
    private $agent_id       = null;
    private $queue_id       = null;
    private $station_id     = null;
    private $period         = null;
    private $number         = null;
    private $dtFrom         = null;
    private $dtTo           = null;


    public function get($r) {
        $this->agent_id         = isset($r->agent_id)   && (strlen($r->agent_id)) > 0       ? (int) $r->agent_id        : null;
        $this->queue_id         = isset($r->agent_id)   && (strlen($r->queue_id)) > 0       ? (int) $r->queue_id        : null;
        $this->direction        = isset($r->agent_id)   && (strlen($r->queue_id)) > 0       ? trim($r->direction)       : null;
        $this->number           = isset($r->number)     && (strlen($r->number)) > 0         ? trim($r->number)          : null;
        $this->period           = isset($r->period)     && (strlen($r->period)) > 0         ? strtolower($r->period)    : null;
        $this->dtFrom           = isset($r->dtFrom)     && (strlen($r->dtFrom)) > 0         ? (int) $r->dtFrom          : null;
        $this->dtTo             = isset($r->period)     && (strlen($r->dtTo)) > 0           ? (int) $r->period          : null;

        $this->model = new Cdr();

        if ( ! is_null($this->direction) ) {

        }

        if ( ! is_null($this->agent_id) ) {
            $this->model->where("aid",$this->agent_id);

            if ( ! is_null($this->queue_id) ) {
                $this->model->where("qid",$this->queue_id);
            }
        } else {
            if ( ! is_null($this->queue_id) ) {
                $this->model->where("dst",QueuesController::getQueueNameById($this->queue_id));
            }
        }


        // Setting up date period on calldate field
        $this->periodCheck();


        if ( !is_null( $this->number ) ) {
            $this->model->where("src");
        }

    }


    private function periodCheck() {

        switch($this->period) {
            case "today" :
                $this->model->where("calldate",Carbon::today());
                break;

            case "yesterday" :
                $this->model->where("calldate",Carbon::yesterday());
                break;

            case "thisweek" :
                $this->model->where("calldate",Carbon::today());
                break;

            case "lastweek" :
                $this->model->where("calldate",Carbon::today());
                break;

            case "thismonth" :
                $this->model->where("calldate",Carbon::today());
                break;

            case "lastmonth" :
                $this->model->where("calldate",Carbon::today());
                break;

            default :
                $this->model->where("calldate",Carbon::today());
                break;
        }




    }




    private function model() {
        return array(
            "calldate"      => 0,
            "linkedid"      => "",
            "uniqueid"      => "",
            "location"      => "in",
            "queue"         => null,
            "queue_id"      => null,
            "agent_id"      => null,
            "agent"         => null,
            "number"        => null,
            "status"        => "INBOUND",
            "duration"      => 0,
            "billsec"       => 0,
            "station"       => null,
            "station_id"    => null,
            "score"         => null,
            "recordingfile" => null,
            "xfer"          => false,
            "xfer_by"       => null,

        );
    }
}
