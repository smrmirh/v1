<div class="text-Shabnam" ng-init="$pop.aid = {{Auth::user()->id}}">
    <div class="container-fluid p-0">
        <div class="modal-header text-rtl bg-light text-Shabnam">
            <h4 class="">انتخاب ایستگاه</h4>
            <!--<p>Plugged :@{{ $pop.contents.pbx.agents[$pop.aid].plugged }}</p>-->

        </div>
        <div class="modal-body p-0">

            <!--<div class="container-fluid border-bottom border-light p-2 text-center">
                <div ng-if="$pop.contents.hasRunningAction">
                    <img style="width:50px; height: 50px;" src="/assets/images/preloader01.gif">
                </div>

                <div ng-if="$pop.contents.lastResponse" class="alert text-right" ng-class="{ 'alert-success' : $pop.contents.lastResponse.result , 'alert-warning' : !$pop.contents.lastResponse.result }">
                    @{{ $pop.contents.lastResponse.message }}
                </div>
            </div>-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6 col-md-6 t07em">
                        <div class="container-fluid pb-2">
                            <div class="row mt-1 mb-2">
                                <div class="col-3"></div>
                                <div class="col-9">
                                    <input type="text" class="form-control form-control-sm text-rtl" placeholder="جستجوی صف" ng-model="queueSearch">
                                </div>
                            </div>
                            <div class="row border border-light text-right mb-1 p-1" ng-repeat="(k,v) in $pop.contents.pbx.agents[$pop.aid].binds" ng-if="v.enabled">
                                <div class="col-2 text-left">
                                    <span ng-if="!v.binded">
                                        <button class="btn btn-sm btn-outline-primary" ng-disabled="v.binded" ng-click="$pop.action('login',{ agent_id : $pop.aid , queue_id : v.queue_id })">ورود</button>
                                    </span>
                                </div>
                                <div class="col-2 text-left">
                                    <span ng-if="v.binded">
                                        <button class="btn btn-sm btn-outline-warning" ng-disabled="!v.binded" ng-click="$pop.action('logout',{ agent_id : $pop.aid , queue_id : v.queue_id })">خروج</button>
                                    </span>
                                </div>
                                <div class="col-6 d-flex align-items-center justify-content-end text-right text-muted">@{{ v.queue_name_fa }}</div>
                                <div class="col-2 border-left border-light d-flex align-items-center justify-content-center bg-light">
                                    <span class="fas fa-users t16em" ng-class="{ 'icon-agent-in blink' : v.binded , 'icon-agent-out' :  !v.binded }"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Stations Column -->
                    <div class="col-6 col-md-6 t07em border-left border-light">
                        <div class="container-fluid pb-2">
                            <div class="row mt-1 mb-2">
                                <div class="col-3"></div>
                                <div class="col-9">
                                    <input type="text" class="form-control form-control-sm text-rtl" placeholder="جستجوی ایستگاه" ng-model="stnSearch">
                                </div>
                            </div>
                            <div class="row border border-light text-right mb-1 p-1" ng-repeat="(k,v) in $pop.contents.pbx.stations" ng-if="v.available">
                                <div class="col-5 text-left">
                                    <button class="btn btn-sm btn-outline-primary" ng-disabled="v.id == $pop.contents.pbx.agents[$pop.aid].station_id" ng-click="$pop.action('plug',{ agent_id : $pop.aid , station_id : v.id })">اتصال</button>
                                </div>
                                <div class="col-5 text-muted d-flex align-items-center justify-content-end border-lef border-light"><span>@{{ v.name_fa }}</span></div>
                                <div class="col-2 border-left border-light d-flex align-items-center justify-content-center bg-light">
                                    <span ng-if="v.id == 0" class="fas fa-mobile-alt t16em" ng-class="{ 'station-taken blink' : v.taken , 'station-free' :  !v.taken }"></span>
                                    <span ng-if="v.id != 0" class="fas fa-phone-office t16em" ng-class="{ 'station-taken blink' : v.taken , 'station-free' :  !v.taken }"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of stations column -->
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline-danger" ng-click="$pop.action('unplug',{ agent_id : $pop.aid  })" ng-disabled=" !$pop.contents.pbx.agents[$pop.aid].plugged">قطع اتصال</button>
            <button class="btn btn-outline-warning" ng-click="$pop.cancel()">Close</button>
        </div>
    </div>


</div>

