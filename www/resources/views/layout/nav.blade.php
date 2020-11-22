<nav class="navbar navbar-expand-smr bg-bluemat fixed-top p-0" ng-controller="navbarController" ng-init="aid = {{Auth::user()->id}}">
    <div class="d-flex w-100 h-100 pr-2">
        <div class="d-flex">
            <div class="border-right border-white d-flex align-items-center justify-content-center" style="width:70px">
                <img class="profile-thumb" src="/assets/images/profile-blank.png">
            </div>
            <div class="text-kufi text-white t08em border-right border-white" style="width: 200px;">
                <div class="d-flex">
                    <div class="d-flex align-items-center justify-content-center flex-fill border-bottom border-white">
                        <span class="fw-800 pb-2 pt-1">{{Auth::user()->fullname_fa}}</span>
                    </div>
                </div>
                <div class="d-flex h-50">
                    <div class="d-flex h-100 w-25 align-items-center justify-content-center border-right border-white">
                        <span class="fas fa-phone-alt t14em" ng-class="{ 'blink-fast icon-agent-busy' : stats.pbx.agents[aid].hint == 'Ring' || stats.pbx.agents[aid].hint == 'Ringing' || stats.pbx.agents[aid].hint == 'InUse'  }"></span>
                    </div>

                    <div class="d-flex h-100 w-25 align-items-center justify-content-center border-right border-white">
                        {{Auth::user()->ext}}

                    </div>

                    <div class="d-flex flex-fill h-100 w-25 align-items-center justify-content-center">

                    </div>
                </div>
            </div>

        </div>

        <div class="d-flex align-items-center justify-content-center nav-icons border-right border-white">
            <span class="fas fa-headphones-alt t18em nav-ico icon-agent-unplugged clickable" ng-class="{'icon-agent-plugged' : stats.pbx.agents[aid].plugged , 'icon-agent-unplugged blink' : !stats.pbx.agents[aid].plugged }"   ng-click="plug()"></span>
        </div>




        <div class="flex-fill mr-2 d-flex align-items-center justify-content-end">
            <i class="fas fa-bars text-25em icon-clickable" data-toggle="modal" data-target="#sidebar"></i>
        </div>
    </div>
</nav>
<div ng-controller="sidebarController" class="modal fade" id="sidebar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout modal-sm" role="document">
        <div class="modal-content">
            <nav class="navbar navbar-expand-sm bg-orangemat">

            </nav>
            <div class="container-fluid">
                <div class="menu-item p-1 row d-flex border-bottom border-light" data-dismiss="modal" ng-click="go('/')">
                    <div class="pr-1 flex-fill text-kufi d-flex align-items-center justify-content-end text-title">
                        <div class="d-flex flex-row flex-row-reverse flex-fill">
                            <div class="flex-fill text-right">داشبورد</div>
                            <div class="flex-fill"></div>
                        </div>
                    </div>
                    <div class="p-1">
                        <!--<i class="material-icons p-2">dashboard</i>-->
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                </div>

                <div class="menu-item p-1 row d-flex border-bottom border-light" data-dismiss="modal">
                    <div class="pr-1 flex-fill text-kufi d-flex align-items-center justify-content-end text-title" ng-click="go('/reports')">
                        <div class="d-flex flex-row flex-row-reverse flex-fill">
                            <div class="flex-fill text-right">آمار و گزارشات</div>
                            <div class="flex-fill"></div>
                        </div>
                    </div>
                    <div class="p-1">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                </div>


                <div class="menu-item p-1 row d-flex border-bottom border-light" data-dismiss="modal" ng-click="go('/studio')">
                    <div class="pr-1 flex-fill text-kufi d-flex align-items-center justify-content-end text-title">
                        <div class="d-flex flex-row flex-row-reverse flex-fill">
                            <div class="flex-fill text-right">استودیو</div>
                            <div class="flex-fill"></div>
                        </div>
                    </div>
                    <div class="p-1">
                        <i class="fas fa-play-circle"></i>
                    </div>
                </div>


                <div class="menu-item p-1 row d-flex border-bottom border-light" data-dismiss="modal" ng-click="go('/users')">
                    <div class="pr-1 flex-fill text-kufi d-flex align-items-center justify-content-end text-title">
                        <div class="d-flex flex-row flex-row-reverse flex-fill">
                            <div class="flex-fill text-right">کاربران</div>
                            <div class="flex-fill"></div>
                        </div>
                    </div>
                    <div class="p-1">
                        <i class="fas fa-users"></i>
                    </div>
                </div>

                <div class="menu-item p-1 row d-flex border-bottom border-light" data-dismiss="modal" ng-click="go('/announces')">
                    <div class="pr-1 flex-fill text-kufi d-flex align-items-center justify-content-end text-title">
                        <div class="d-flex flex-row flex-row-reverse flex-fill">
                            <div class="flex-fill text-right">اعلان</div>
                            <div class="flex-fill"></div>
                        </div>
                    </div>
                    <div class="p-1">
                        <i class="fas fa-speaker"></i>
                    </div>
                </div>

                <div class="menu-item p-1 row d-flex border-bottom border-light" data-dismiss="modal" ng-click="go('/settings')">
                    <div class="pr-1 flex-fill text-kufi d-flex align-items-center justify-content-end text-title">
                        <div class="d-flex flex-row flex-row-reverse flex-fill">
                            <div class="flex-fill text-right">تنظیمات</div>
                            <div class="flex-fill"></div>
                        </div>
                    </div>
                    <div class="p-1">
                        <i class="fas fa-cogs"></i>
                    </div>
                </div>




            </div><!-- end of Conntainer-fluid -->
            <div class="d-flex flex-column position-absolute fixed-bottom border-top border-light">
                <div class="d-flex align-items-center justify-content-center h2">
                    <a href="/logout"><i class="fas fa-power-off icon-clickable" ng-click="go('logout')"></i></a>
                </div>
            </div>
        </div>

    </div>
</div>

