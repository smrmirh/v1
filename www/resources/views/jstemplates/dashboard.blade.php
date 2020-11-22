
@if( Auth::user()->access == 3 )
<div id="app-contents" class="app-contents" ng-init="aid = {{Auth::user()->id}}">
    <div class="container-fluid">
        <div class="row shadow" style="overflow: hidden;" uib-collapse="liveChartCollapse">
            <div id="liveChart" class="col-12 active-calls-chart pt-2 pr-4 bg-white"></div>
        </div>

        <div class="row m-2 text-kufi">
            <div class="col-md-2 icon-clickable" ng-click="liveChartCollapse = !liveChartCollapse">
                <div class="bg-white rad-10 mb-2 shadow-sm d-flex flex-row">
                    <div class="d-flex align-items-center p-3 border-right border-light"><i class="text-25em fas fa-phone"><!--trending_up--></i></div>
                    <div class="flex-fill d-flex flex-column">
                        <div class="text-info d-flex align-items-end justify-content-end h-75">
                            <span class="pr-4 pt-2 text-20em8w" ng-blinker="stats.pbx.activeCalls">
                                @{{stats.pbx.activeCalls}}
                            </span>
                        </div>
                        <div class="small  p-2 d-flex justify-content-end border-top border-light mr-1" style="font-size:.6em;">
                            زنده
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white rad-10 mb-2 shadow-sm d-flex flex-row">
                    <div class="d-flex align-items-center p-3 border-right border-light"><i class="fas fa-clock text-30em"></i></div>
                    <div class="flex-fill d-flex flex-column">
                        <div class="text-info d-flex align-items-end justify-content-end h-75">
                            <span class="pr-4 pt-2 text-20em8w" ng-blinker="stats.pbx.calls.waiting">@{{stats.pbx.calls.waiting}}</span>
                        </div>
                        <div class="small  p-2 d-flex justify-content-end border-top border-light mr-1" style="font-size:.6em;">
                            درحال انتظار
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white rad-10 mb-2 shadow-sm d-flex flex-row">
                    <div class="d-flex align-items-center p-3 border-right border-light"><i class="fas fa-phone-volume text-30em"></i></div>
                    <div class="flex-fill d-flex flex-column">
                        <div class="text-info d-flex align-items-end justify-content-end h-75">
                            <span class="pr-4 pt-2 text-20em8w" ng-blinker="stats.pbx.talking">@{{stats.pbx.op.busy}}</span>
                        </div>
                        <div class="small p-2 d-flex justify-content-end border-top border-light mr-1" style="font-size:.6em;">
                            در حال مکالمه
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white rad-10 mb-2 shadow-sm d-flex flex-row">
                    <div class="d-flex align-items-center p-3 border-right border-light"><i class="fas fa-plug text-30em"></i></div>
                    <div class="flex-fill d-flex flex-column">
                        <div class="text-info d-flex align-items-end justify-content-end h-75">
                            <span class="pr-4 pt-2 text-20em8w" ng-blinker="stats.pbx.op.plugged" style="color:#17a2cc;">@{{stats.pbx.op.plugged}}</span>
                        </div>
                        <div class="small p-2 d-flex justify-content-end border-top border-light mr-1" style="font-size:.6em;">
                            اپراتورهای متصل
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white rad-10 mb-2 shadow-sm d-flex flex-row">
                    <div class="d-flex align-items-center p-3 border-right border-light"><i class="fas fa-check-double text-30em"></i></div>
                    <div class="flex-fill d-flex flex-column">
                        <div class="text-info d-flex align-items-end justify-content-end h-75">
                            <span class="pr-4 pt-2 text-20em8w" ng-blinker="stats.pbx.calls.answered" style="color:#00c6b8">@{{stats.pbx.calls.answered}}</span>
                        </div>
                        <div class="small p-2 d-flex justify-content-end border-top border-light mr-1" style="font-size:.6em;">
                            پاسخ داده شده
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white rad-10 mb-2 shadow-sm d-flex flex-row">
                    <div class="d-flex align-items-center p-3 border-right border-light"><i class="fas fa-phone-office text-30em"><!--call_missed--></i></div>
                    <div class="flex-fill d-flex flex-column">
                        <div class="text-info d-flex align-items-end justify-content-end h-75">
                            <span class="pr-4 pt-2 text-20em8w" style="color:#d5a2b8;" ng-blinker="stats.pbx.calls.abandoned">@{{stats.pbx.calls.abandoned}}</span>
                        </div>
                        <div class="small p-2 d-flex justify-content-end border-top border-light mr-1" style="font-size:.6em;">
                            از دست رفته
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end of container-fluid -->


    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="container-fluid">
                    <!-- Self profile -->
                @include('jstemplates.inc-selfprofile')
                <!-- Self profile end -->
                </div>
            </div>
            <div class="col-12 col-md-9">
                <div class="container-fluid shadow shadow-sm pb-2">
                    <!-- Agents control section -->
                    <div class="row m-1 pt-1 pr-1 border-top border-light">
                        <div class="col-8"></div>
                        <div class="col-2">
                            <input class="form-control form-control-sm text-rtl text-kufi" type="text" ng-model="agentFullname" placeholder="جستجوی نام اپراتور...">
                        </div>
                        <div class="col-2 pr-2 text-right bg-light d-flex align-items-center">
                            <span class="text-kufi text-info">اپراتور های مرکز تماس</span>
                        </div>
                    </div>
                    <div class="row m-1 p-1 text-center bg-light text-info">
                        <div class="col-2"></div>
                        <div class="col-2">آخرین مکالمه</div>
                        <div class="col-1">تماس ها</div>
                        <div class="col-2 border-right border-white">ایستگاه</div>
                        <div class="col-1 border-right border-white">وضعیت</div>
                        <div class="col-1 border-right border-white">اتصال</div>
                        <div class="col-1 border-right border-white">داخلی</div>
                        <div class="col-2"></div>
                    </div>
                    <div class="row m-1 p-1 border border-light text-center" ng-repeat="(k,v) in stats.pbx.agents" ng-if="v.id!=aid" ng-init="v.collapse=true">
                        <div class="col-12 col-md-2 p-1">--</div>
                        <div class="col-12 col-md-2 p-1 text-rtl t08em">
                            <span ng-if="v.lastcall" am-time-ago="v.lastcall | amFromUnix"></span>
                        </div>
                        <div class="col-12 col-md-1 p-1 text-success" ng-blinker="v.callstaken">@{{ v.callstaken }}</div>
                        <div class="col-12 col-md-2 p-1">@{{ stats.pbx.stations[v.station_id].name_fa }}</div>
                        <div class="col-12 col-md-1 p-1">
                            <span ng-if="v.plugged" class="fas" ng-class="{ 'fa-phone-rotary text-secondary' : v.hint == 'Idle' , 'fa-phone-rotary text-warning blink-fast' : v.hint == 'Ringing'   ,'fa-phone-volume text-danger blink' : v.hint == 'InUse' }"></span>
                        </div>
                        <div class="col-12 col-md-1 t12em">
                            <span class="fas fa-plug" ng-class="{'text-success' : v.plugged, 'text-secondary' : !v.plugged }"></span>
                        </div>
                        <div class="col-12 col-md-1 p-1">@{{ v.ext }}</div>
                        <div class="col-12 col-md-2 p-1 text-left icon-clickable" ng-click="v.collapse=!v.collapse" ng-class="{ 'bg-success text-white' : v.plugged , 'bg-light' : !v.plugged}">@{{ v.fullname_fa }}</div>
                        <div class="col-12 p-0" uib-collapse="v.collapse">
                            <div class="container-fluid mt-1 mb-2">
                                <div class="row">
                                    <div class="col-12 col-md-2 border border-light p-1">
                                        <div class="container-fluid" ng-if="stats.pbx.agents[k].plugged">
                                            <div class="row">
                                                <div class="col-12 t07em text-rtl">
                                                    <span class="" am-time-ago="v.lsl | amFromUnix"></span>
                                                </div>
                                                <div class="col-12 mt-1">
                                                    <button class="btn btn-sm btn-outline-danger btn-block" ng-click="action('unplug',{ agent_id : v.id })">قطع اتصال</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-fluid" ng-if="!stats.pbx.agents[k].plugged">
                                            <div class="row">
                                                <div class="col-12">
                                                    <select class="form-control form-control-sm" ng-model="v.selectedStationId">
                                                        <option ng-repeat="(s,n) in stats.pbx.stations" value="@{{ s }}" ng-if="n.available">@{{ n.name_fa }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 mt-1">
                                                    <button class="btn btn-outline-info btn-sm btn-block" ng-click="action('plug',{ agent_id : v.id , station_id : v.selectedStationId })">اتصال</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="container-fluid">
                                            <div class="row border border-light p-1" ng-repeat="(a,b) in stats.pbx.agents[k].binds">
                                                <div class="col-12 col-md-3"></div>
                                                <div class="col-12 col-md-3 d-flex align-items-center border-left border-light text-right text-rtl t07em">
                                                    <span ng-if="b.binded" am-time-ago="b.binded_at | amFromUnix"></span>
                                                </div>
                                                <div class="col-12 col-md-3 text-right border border-light">
                                                    <button ng-if="v.plugged" ng-disabled="!b.binded" class="btn btn-sm btn-outline-info" ng-click="action('logout',{ agent_id : v.id , queue_id : b.queue_id })">خروج</button>
                                                    <button ng-if="v.plugged" ng-disabled="b.binded" class="btn btn-sm btn-outline-warning" ng-click="action('login',{ agent_id : v.id , queue_id : b.queue_id })">ورود</button>
                                                </div>
                                                <div class="col-12 col-md-3 d-flex align-items-center bg-light">
                                                    <span>@{{ b.queue_name_fa }}</span>
                                                    <span class="fas fa-users ml-auto" ng-class="{ 'text-success blink' : b.binded }"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <div class="container-fluid h-100 d-flex align-items-center justify-content-center" ng-if="v.lastResponse">
                                            <span class="t22em" ng-class="{ 'text-success fas fa-check-circle' : v.lastResponse.result , 'text-danger fas fa-window-close' : !v.lastResponse.result  }"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Agents control section -->

                </div>
                <div class="container-fluid shadow shadow-sm pt-2">
                    <div class="row m-1 pt-1 pr-1 border-top border-light">
                        <div class="col-2">
                            <button class="btn btn-outline-warning btn-sm" ng-click="action('report',{ type : 'cdr' , period : 'today' })">بروزرسانی</button>
                        </div>
                        <div class="col-8"></div>
                        <div class="col-2 pr-2 text-right bg-light d-flex align-items-center">
                            <span class="text-kufi text-info">گزارشات تماس</span>
                        </div>
                    </div>
                    <div class="row m-1 p-1 bg-light text-info">
                        <div class="col-3"></div>
                        <div class="col-1"></div>
                        <div class="col-2">ایستگاه</div>
                        <div class="col-2">وضعیت تماس</div>
                        <div class="col-2">کاربر</div>
                        <div class="col-2">شماره</div>
                    </div>
                    <div class="row m-1 p-1 border border-light" ng-repeat="r in reports">
                        <div class="col-3"></div>
                        <div class="col-1">
                            <span ng-if="r.playback" ng-init="r.playtoggle=true">
                                <audio id="audio_@{{ r.linkedid }}">
                                    <source src="/monitor/@{{ r.playback }}" type="audio/mpeg">
                                </audio>
                                <span class="fas fa-play-circle icon-clickable"  id="@{{ r.linkedid }}_play" onclick="playback(this.id,1)" ng-if="r.playtoggle" ng-click="r.playtoggle = !r.playtoggle"></span>
                                <span class="fas fa-pause-circle icon-clickable" id="@{{ r.linkedid }}_stop" onclick="playback(this.id,0)" ng-if="!r.playtoggle" ng-click="r.playtoggle = !r.playtoggle"></span>
                            </span>
                        </div>
                        <div class="col-2">@{{ r.station }}</div>
                        <div class="col-2">@{{ r.status }}</div>
                        <div class="col-2">@{{ r.agent }}</div>
                        <div class="col-2">@{{ r.number }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>




</div>
@endif

@if( Auth::user()->access == 1 )
    <div id="app-contents" class="app-contents" ng-init="aid = {{Auth::user()->id}}">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-3 border-right border-light" style="">
                    <!-- Self profile -->
                    @include('jstemplates.inc-selfprofile')
                    <!-- Self profile end -->
                </div>
                <div class="col-12 col-md-9">
                    <div class="row mt-2">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

