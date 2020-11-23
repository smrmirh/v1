<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{

    /* Reports :
        1 : Cdr
                - In/Out
                - Agent
                - Queue
                - QueueHold
                - Station
                - Number
        2 : Plugwatch
        3 : Logwatch
        4 : Score
        5 : Station

    */
    private $report;


    public function report(Request $request) {
        $this->report = strtolower(trim($request->report));
        switch($this->report) {
            case "cdr" :
                $cdr = new CdrController();
                $result = $cdr->get($request);
                return $result;
                break;

            default :
        }
    }
}
