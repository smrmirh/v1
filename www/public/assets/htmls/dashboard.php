
<!-- Stuffs for Admin user -->
<div id="app-contents" class="app-contents">
    <div class="container-fluid">

        <div class="row shadow" style="overflow: hidden;" uib-collapse="liveChartCollapse">
            <div id="liveChart" class="col-md-12 active-calls-chart pt-2 pr-4 bg-white"></div>
        </div>
        <div class="row m-2 text-kufi">
            <div class="col-md-2 icon-clickable" ng-click="liveChartCollapse = !liveChartCollapse">
                <div class="bg-white rad-10 mb-2 shadow-sm d-flex flex-row">
                    <div class="d-flex align-items-center p-3 border-right border-light"><i class="material-icons text-3em text-black-50"><!--trending_up--></i></div>
                    <div class="flex-fill d-flex flex-column">
                        <div class="text-info d-flex align-items-end justify-content-end h-75">
                            <span class="pr-4 pt-2 text-2em8w" ng-blinker="stats.pbx.activeCalls">
                                @{{stats.pbx.activeCalls}}
                            </span>
                        </div>
                        <div class="small text-black-50 p-2 d-flex justify-content-end border-top border-light mr-1" style="font-size:.6em;">
                           زنده
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white rad-10 mb-2 shadow-sm d-flex flex-row">
                    <div class="d-flex align-items-center p-3 border-right border-light"><i class="material-icons text-3em text-black-50"><!--timer--></i></div>
                    <div class="flex-fill d-flex flex-column">
                        <div class="text-info d-flex align-items-end justify-content-end h-75">
                            <span class="pr-4 pt-2 text-2em8w" ng-blinker="stats.pbx.waiting">@{{stats.pbx.op.total}}</span>
                        </div>
                        <div class="small text-black-50 p-2 d-flex justify-content-end border-top border-light mr-1" style="font-size:.6em;">
                           در انتظار پاسخ
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white rad-10 mb-2 shadow-sm d-flex flex-row">
                    <div class="d-flex align-items-center p-3 border-right border-light"><i class="material-icons text-3em text-black-50"><!--phone_in_talk--></i></div>
                    <div class="flex-fill d-flex flex-column">
                        <div class="text-info d-flex align-items-end justify-content-end h-75">
                            <span class="pr-4 pt-2 text-2em8w" ng-blinker="stats.pbx.talking">@{{stats.pbx.op.busy}}</span>
                        </div>
                        <div class="small text-black-50 p-2 d-flex justify-content-end border-top border-light mr-1" style="font-size:.6em;">
                          در حال مکالمه
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white rad-10 mb-2 shadow-sm d-flex flex-row">
                    <div class="d-flex align-items-center p-3 border-right border-light"><i class="material-icons text-3em text-black-50"><!--people_alt--></i></div>
                    <div class="flex-fill d-flex flex-column">
                        <div class="text-info d-flex align-items-end justify-content-end h-75">
                            <span class="pr-4 pt-2 text-2em8w" ng-blinker="stats.pbx.agents_available" style="color:#17a2cc;">@{{stats.pbx.op.plugged}}</span>
                        </div>
                        <div class="small text-black-50 p-2 d-flex justify-content-end border-top border-light mr-1" style="font-size:.6em;">
                        اپراتورهای متصل
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white rad-10 mb-2 shadow-sm d-flex flex-row">
                    <div class="d-flex align-items-center p-3 border-right border-light"><i class="material-icons text-3em text-black-50"><!--call_received--></i></div>
                    <div class="flex-fill d-flex flex-column">
                        <div class="text-info d-flex align-items-end justify-content-end h-75">
                            <span class="pr-4 pt-2 text-2em8w" ng-blinker="stats.pbx.answered" style="color:#00c6b8">@{{stats.pbx.calls.answered}}</span>
                        </div>
                        <div class="small text-black-50 p-2 d-flex justify-content-end border-top border-light mr-1" style="font-size:.6em;">
                           پاسخ داده شده
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white rad-10 mb-2 shadow-sm d-flex flex-row">
                    <div class="d-flex align-items-center p-3 border-right border-light"><i class="material-icons text-3em text-black-50"><!--call_missed--></i></div>
                    <div class="flex-fill d-flex flex-column">
                        <div class="text-info d-flex align-items-end justify-content-end h-75">
                            <span class="pr-4 pt-2 text-2em8w" style="color:#d5a2b8;" ng-blinker="stats.pbx.abandon">@{{stats.pbx.calls.abandoned}}</span>
                        </div>
                        <div class="small text-black-50 p-2 d-flex justify-content-end border-top border-light mr-1" style="font-size:.6em;">
                           از دست رفته
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end of container-fluid -->
    <div class="container-fluid">
        <div class="row m-2">
            <div class="col-md-2 p-0 text-kufi">
                <div class="container-fluid">
                    <div class="pl-3 pr-3 rad-10 mb-2 shadow-sm" style="overflow: hidden;">
                        <div class="row bg-white">
                            <div class="col-md-12 pb-2 d-flex flex-column align-items-center justify-content-center">
                                <i class="material-icons text-2em8w text-black-50" ng-if="(stats.pbx.calls|kCounter) == 0">tv_off</i>
                                <i class="material-icons text-2em8w text-black-50" ng-if="(stats.pbx.calls|kCounter) > 0">live_tv</i>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="...col-md-12 text-center text-muted p-1" ng-if="(stats.pbx.calls|kCounter) == 0">

                            </div>
                        </div>
                        <div class="row bg-white pb-1 pl-1 pr-1 box" ng-if="(stats.pbx.calls|kCounter) > 0" ng-repeat="(k,v) in stats.pbx.calls">
                            <div class="col-md-12 p-1 d-flex align-items-center justify-content-start bg-light">
                                <div class="p-1 d-flex align-items-center border-right border-white">
                                    <i class="material-icons text-info t08em" ng-if="v.direction=='in'">call_received</i>
                                    <i class="material-icons text-danger t08em" ng-if="v.direction=='out'">call_made</i>
                                </div>
                                <div class="text-black-50 t05em d-flex align-items-center">
                                    @{{v.caller}}
                                </div>
                                <div class="d-flex align-items-center text-black-50 ml-2">
                                    <i class="material-icons t08em text-warning" ng-if="v.state == 'Up'">outlined_flag</i>
                                    <i class="material-icons t08em text-success animated infinite slow flash" ng-if="v.state == 'Talking'">phone_in_talk</i>
                                    <i class="material-icons t08em" ng-if="v.state == 'Waiting'">access_alarm</i>
                                    <i class="material-icons t08em animated infinite flash" ng-if="v.state == 'Ringing'">vibration</i>
                                </div>
                                <div class="flex-fill d-flex align-items-center flex-row-reverse text-center text-muted">
                                    <div class="t05em w-50" ng-if="v.duration == 0">@{{v.wtime}}s</div>
                                    <div class="t05em w-50" ng-if="v.duration > 0">@{{v.duration}}s</div>
                                    <div class="t05em w-50">@{{v.agent.ext}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10 p-0">
                <div class="container-fluid text-kufi text-black-50">
                    <div class="pl-3 pr-3 shadow-sm mb-2">
                        <div class="row">
                            <div class="col-md-10 p-1 bg-white">
                                <div class="container-fluid">
                                    <div class="row pb-3 border border-light">
                                        <div class="col-md-12">
                                            <div class="row pr-3 pt-2 d-flex flex-row-reverse align-items-center justify-content-start">
                                                <i class="material-icons pl-1">playlist_add_check</i>
                                                <span class="t08em">لیست اعلان</span>
                                            </div>

                                            <div class="row p-2 ml-2 mr-2 d-flex align-items-center justify-content-center t05em bg-light text-info ">
                                                <div class="col-md-1 d-none d-sm-block">اتمام</div>
                                                <div class="col-md-1 d-none d-sm-block">شروع</div>
                                                <div class="col-md-1 d-none d-sm-block text-center">روز</div>
                                                <div class="col-md-1 col-2 p-0 text-center">موثر</div>
                                                <div class="col-md-1 col-1 p-0 text-center">تعداد</div>
                                                <div class="col-md-4 col-5 p-0 text-right">عنوان</div>
                                                <div class="col-md-2 col-2 p-0 text-right">
                                                    <span class="d-block d-sm-none">پ/ش</span>
                                                    <span class="d-none d-sm-block">پیش شماره</span>
                                                </div>
                                                <div class="col-md-1 col-2 p-0 d-flex align-items-center justify-content-center"></div>
                                            </div>
                                            <div class="row row ml-2 mr-2" ng-if="(stats.pbx.announces|kCounter) == 0">
                                                <div class="col-md-12 p-2 text-center border border-light t07em text-wYekan">اعلان فعالی وجود ندارد</div>
                                            </div>
                                            <div class="row ml-2 mr-2" ng-if="(stats.pbx.announces|kCounter) > 0">
                                                <div class="col-12 p-1 bg-light mt-1 box" ng-repeat="(k,v) in stats.pbx.announces" ng-init="v.collapse = true">
                                                    <div class="container-fluid">
                                                        <div class="row t08em d-flex align-items-center justify-content-start">
                                                            <div class="col-md-1 p-0 d-none d-sm-block text-center text-time">@{{v.schedule_end}}</div>
                                                            <div class="col-md-1 p-0 d-none d-sm-block text-center text-time">@{{v.schedule_start}}</div>
                                                            <div class="col-md-1 p-0 d-none d-sm-block text-center text-time text-kufi">
                                                                <span ng-if="v.diff == 0">امروز</span>
                                                                <span ng-if="v.diff == 1">فردا</span>
                                                                <span ng-if="v.diff == 2">پس فردا</span>
                                                                <span ng-if="v.diff > 3" style="direction: ltr;">@{{v.diff}} روز</span>
                                                            </div>
                                                            <div class="col-md-1 col-2 text-center" ng-blinker="v.hits-v.continued"></div>
                                                            <div class="col-md-1 col-1 p-0 text-center fw-bold" ng-blinker="v.hits"></div>
                                                            <div class="col-md-4 col-5 p-0 text-right">
                                                                <span class="d-block d-sm-none t05em w-100 text-center">@{{v.title}}</span>
                                                                <span class="d-none d-sm-block">@{{v.title}}</span>
                                                            </div>
                                                            <div class="col-md-2 col-2 p-0 text-right icon-clickable" ng-click="v.collapse=!v.collapse">@{{v.prefix}}</div>
                                                            <div class="col-md-1 col-2 p-0 d-flex align-items-center justify-content-center icon-clickable">
                                                                <i class="material-icons t22em" ng-if="v.enabled == '1'">play_circle_filled</i>
                                                                <i class="material-icons t22em" ng-if="v.enabled == '0'">pause_circle_filled</i>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--
                                    <div class="row">
                                        <div class="col-md-12 border-bottom border-light">
                                            <div class="row pr-3 pt-2 border-bottom border-light d-flex flex-row-reverse align-items-center justify-content-start">
                                                <i class="material-icons pl-1">playlist_add_check</i>
                                                <span class="t08em">لیست کمپین</span>
                                            </div>
                                        </div>
                                    </div>
                                    -->

                                </div>
                                <div class="container-fluid border border-dark">
                                    <div class="row border border-danger">
                                        <div class="col-12 border border-success">
                                            <div class="row pr-3 pt-2 border d-flex align-items-center justify-content-end">
                                                Filter
                                            </div>
                                            <div class="row pr-3 pt-2 border border-warning d-flex align-items-center justify-content-end">
                                                <div class="col-6">1</div>
                                                <div class="col-6">2</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-0 bg-white border-left border-light">
                                <div class="container-fluid">
                                    <div class="row pr-3 pt-2  border-bottom border-light d-flex flex-row-reverse align-items-center justify-content-start">
                                        <i class="material-icons">list_alt</i>
                                        <span class="t08em">لیست اپراتورها</span>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-12">
                                            <select class="form-control form-control-sm text-rtl" ng-model="opsearch.secid" ng-init="opsearch.secid='1'">
                                                <option ng-value="'1'">امداد</option>
                                                <option ng-value="'2'">بحران</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-1 text-right" ng-repeat="(k,v) in stats.pbx.agents" ng-init="v.collapse=true" ng-if="v.is_agent=='1' && v.secid == opsearch.secid">
                                        <div class="col-md-12 bg-light p-0 pt-1 pb-1 d-flex flex-row-reverse align-items-center justify-content-start">
                                            <div class="w-75 h-100 border-left pr-1 pl-1 border-white d-flex align-items-center justify-content-end text-wYekan fw-800" ng-click="v.collapse=!v.collapse">@{{v.fullname_fa}}</div>
                                            <div class="h-100 pr-1 pl-1 d-flex align-items-center justify-content-end t05em fw-600 text-black-50">@{{v.ext}}</div>
                                            <div class="h-100 pl-1 pr-1 d-flex align-items-center t07em">
                                                <i class="material-icons t14em text-danger animated infinite flash dox" ng-if="v.hint == 'Ringing'">ring_volume</i>
                                                <i class="material-icons t14em text-success animated slow infinite flash dox" ng-if="v.hint == 'InUse'">phone_in_talk</i>
                                                <i class="material-icons t14em text-warning dox" ng-if="v.hint == 'Unavailable'">power_off</i>
                                                <i class="material-icons t14em text-black-50 dox" ng-if="v.hint == 'Idle'">phone_enabled</i>
                                                <i class="material-icons t14em text-black-50 dox" ng-if="v.hint == 'InUse&Ringing'">ring_volume</i>
                                            </div>
                                            <div class="flex-fill h-100 d-flex align-items-center justify-content-start" style="cursor: pointer">
                                                <span uib-dropdown on-toggle="toggled(open)" class="h-100 d-flex align-items-center justify-content-start">
                                                    <i class="material-icons t14em text-deactive dox" ng-if="v.is_paused == '1'" uib-dropdown-toggle>panorama_fish_eye</i>
                                                    <i class="material-icons t14em text-active animated infinite slower flash dox" ng-if="v.is_paused == '0'" uib-dropdown-toggle>lens</i>
                                                    <div ng-if="v.is_paused == '1'" class="dropdown-menu text-black-50" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                                    <a href="" class="dropdown-item text-info t07em" ng-repeat="(sk,sv) in stats.pbx.stations" ng-click="action('activate',{ ext : v.ext, station : sv.name})">@{{sv.name}}<span class="text-black-50" ng-if="v.occupied_by.name"> (@{{sv.occupied_by.name}})</span></a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="" class="dropdown-item text-danger t07em" ng-click="action('activate',{ ext : v.ext, station : 'mobile' , id : v.id})">موبایل</a>
                                                  </div>
                                                  <div ng-if="v.is_paused == '0'" class="dropdown-menu" uib-dropdown-menu aria-labelledby="simple-dropdown">
                                                    <a href="" class="dropdown-item t07em text-black-50" ng-click="action('deactivate',{ ext : v.ext , id : v.id })">غیرفعال</a>
                                                  </div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 border border-light" uib-collapse="v.collapse">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
