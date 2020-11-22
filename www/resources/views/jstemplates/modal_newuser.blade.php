<div class="text-Shabnam">
    <div class="container-fluid">
        <div class="mt-2 p-2 bg-light text-info text-right">
            افزودن کاربر
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row mt-1">
                    <div class="col-9">
                        <input type="text" class="form-control form-control-sm" placeholder="نام کاربر ...">
                    </div>
                    <div class="col-3 bg-light text-info p-1">نام کاربر</div>
                </div>
                <div class="row mt-1">
                    <div class="col-9">
                        <input type="text" class="form-control form-control-sm" placeholder="نام کاربر ...">
                    </div>
                    <div class="col-3 bg-light text-info p-1">نام لاتین</div>
                </div>
                <div class="row mt-1">
                    <div class="col-9">
                        <input type="text" class="form-control form-control-sm" placeholder="">
                    </div>
                    <div class="col-3 bg-light text-info p-1">نام کاربری</div>
                </div>
                <div class="row mt-1">
                    <div class="col-9">
                        <input type="text" class="form-control form-control-sm" placeholder="">
                    </div>
                    <div class="col-3 bg-light text-info p-1">رمز عبور</div>
                </div>
                <div class="row mt-1">
                    <div class="col-9">
                        <input type="text" class="form-control form-control-sm" placeholder="">
                    </div>
                    <div class="col-3 bg-light text-info p-1">تکرار رمز عبور</div>
                </div>

                <hr>

                <div class="row mt-1">
                    <div class="col-9">
                        <input type="text" class="form-control form-control-sm" placeholder="">
                    </div>
                    <div class="col-3 bg-light text-info p-1">شماره داخلی</div>
                </div>

                <div class="row mt-1">
                    <div class="col-9">
                        <input type="text" class="form-control form-control-sm" placeholder="">
                    </div>
                    <div class="col-3 bg-light text-info p-1">شماره موبایل</div>
                </div>

                <div class="row mt-1">
                    <div class="col-9">
                        <div class="container-fluid">
                            <div class="row" ng-repeat="(k,v) in $pop.contents.pbx.queues">
                                <div class="col-11 text-right form-control form-control-sm border-0">
                                    @{{ v.name_fa }}
                                </div>
                                <div class="col-1">
                                    <input type="checkbox" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 bg-light text-info p-1">انتخاب صف</div>
                </div>

                <div class="row mt-1">
                    @{{ $pop.contents.pbx.queues[1].queue_name }}
                </div>


            </div>
        </div>
        <div class="modal-footer">
            <div class="container-fluid">
                <button class="btn btn-outline-info btn-sm" ng-disabled="true">ایجاد کاربر</button>
                <button class="btn btn-outline-danger btn-sm" ng-click="close()">بستن</button>
            </div>
        </div>
    </div>
</div>