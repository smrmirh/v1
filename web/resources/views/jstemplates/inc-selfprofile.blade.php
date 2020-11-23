<!-- Self profile -->
<div class="container-fluid shadow shadow-sm">
    <div class="row text-center border-bottom border-light">
        <div class="col-12 col-md-6 bg-light text-success" ng-blinker="stats.pbx.agents[aid].callstaken" style="font-size: 4em;">@{{ stats.pbx.agents[aid].callstaken }}</div>
        <div class="col-12 col-md-6 d-flex align-items-center justify-content-center border-right border-light">تعداد تماس</div>
    </div>
    <div class="row border-bottom border-light text-center mt-1" ng-if="stats.pbx.agents[aid].lastcall > 0">
        <div class="col-12 col-md-6 text-rtl d-flex align-items-center justify-content-start">@{{ stats.pbx.agents[aid].lastcall|dtForm }} پیش</div>
        <div class="col-12 col-md-6 bg-light p-1 text-info">زمان آخرین مکالمه</div>
    </div>
    <div class="row border-bottom border-light text-center mt-1" ng-if="stats.pbx.agents[aid].lastcall > 0">
        <div class="col-12 col-md-6 text-rtl d-flex align-items-center justify-content-start">
            <span class="fas" ng-class="{'fa-check-circle text-success' : stats.pbx.agents[aid].plugged, 'fa-window-close text-danger' : !stats.pbx.agents[aid].plugged }"></span>
        </div>
        <div class="col-12 col-md-6 bg-light p-1 text-info">وضعیت اتصال</div>
    </div>

    <div class="row border-bottom border-light text-center mt-1">
        <div class="col-12 col-md-6 text-rtl d-flex align-items-center justify-content-start">
            <!--<span>@{{ stats.pbx.agents[aid].lsl|dtForm }} پیش</span>-->
            <span am-time-ago="stats.pbx.agents[aid].lsl | amFromUnix" ></span>
        </div>
        <div class="col-12 col-md-6 bg-light p-1 text-info">آخرین اتصال</div>
    </div>

    <div class="container-fluid mt-2 p-0 text-center" ng-if="stats.pbx.agents[aid].binds|kCounter">
        <div class="row  border border-light p-1 text-info">
            <div class="col-6 bg-light">آخرین ورود</div>
            <div class="col-2 bg-light">وضعیت</div>
            <div class="col-4 bg-light">صف</div>
        </div>
        <div class="row border border-light text-center mt-1" ng-repeat="(k,v) in stats.pbx.agents[aid].binds">
            <div class="col-12 col-md-6 text-rtl d-flex align-items-center">
                <span ng-if="v.binded_at" am-time-ago="v.binded_at | amFromUnix"></span>
            </div>
            <div class="col-12 col-md-2 d-flex align-items-center">
                <span ng-blinker="v.binded" class="fas" ng-class="{'fa-check-circle text-success' : v.binded, 'fa-window-close text-danger' : !v.binded }"></span>
            </div>
            <div class="col-4 col-md-4 p-1">@{{ v.queue_name_fa }}</div>
        </div>

    </div>
</div>
<!-- Self profile end -->