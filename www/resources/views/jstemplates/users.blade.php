<div id="app-contents" class="app-contents">
    <div class="container-fluid mt-2">
        <div class="row mb-2">
            <div class="col-12">
                <button class="btn btn-outline-primary btn-sm" ng-click="addUser()">افزودن کاربر</button>
            </div>
        </div>
        <uib-accordion close-others="false">
            <div uib-accordion-group class="mt-1" ng-repeat="(i,u) in stats.pbx.agents" ng-init="u.isOpen=false" ng-click="u.isOpen=!u.isOpen" heading="@{{ u.fullname_fa }}">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="container-fluid border-right border-light">
                                <div class="row">
                                    <div class="col-6 p-1 bg-light text-info">نام کاربر</div>
                                    <div class="col-6 p-1 border border-light">@{{ u.fullname_fa }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-6 p-1 bg-light text-info">شماره داخلی</div>
                                    <div class="col-6 p-1 border border-light">@{{ u.ext }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-6 p-1 bg-light text-info">نام کاربری</div>
                                    <div class="col-6 p-1 border border-light">
                                        <input class="form-control form-control-sm" ng-value="u.username">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 m-2 text-right">
                                        <button class="btn btn-sm btn-outline-info">بروزرسانی</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-6 p-1 bg-light text-info">رمز عبور</div>
                                    <div class="col-6 p-1 border border-light">
                                        <input class="form-control form-control-sm" ng-value="u.password">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 p-1 bg-light text-info">تکرار رمز عبور</div>
                                    <div class="col-6 p-1 border border-light">
                                        <input class="form-control form-control-sm" ng-value="u.password">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 m-2 text-right">
                                        <button class="btn btn-sm btn-outline-warning">بروزرسانی</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 col-md-4">

                        </div>
                    </div>
                </div>
            </div>
        </uib-accordion>
    </div>

</div>
