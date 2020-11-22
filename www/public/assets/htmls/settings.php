<?php
session_start();
if ( ! isset($_SESSION["logged"]) )
{
    header("HTTP/1.0 404 Not Found");
    die();
}
if (  isset($_SESSION["logged"])  ) :
?>

<?php if ( $_SESSION["is_admin"] ) : ?>
    <!-- Admin Settings -->
    <div id="app-contents" class="app-contents">
        <uib-tabset active="0">
            <uib-tab index="2" heading="تنظیمات سیستم" disable="true"></uib-tab>
            <!--<uib-tab index="3" heading="پرداخت">Long Labeled Justified content</uib-tab>
            <uib-tab index="4" heading="منوی صوتی">Long Labeled Justified content</uib-tab>-->
            <uib-tab index="1" heading="مدیریت صف" disable="true"></uib-tab>
            <uib-tab index="0" heading="مدیریت اپراتورها">
                    <div class="container-fluid pb-5">
                        <div class="container text-kufi">
                            <div class="row mt-2 p-1" ng-init="addUserCollapse=true">
                                <div class="col-12 col-md-12 bg-white shadow-sm" uib-collapse="addUserCollapse">
                                    <div class="container-fluid"></div>
                                    <form name="nuForm" ng-submit="nuForm.$valid" novalidate>
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-12 col-md-2 p-0">
                                                <div class="row m-0">
                                                    <div class="col-md-12 text-center p-2 t08em fw-800 text-info bg-light d-none d-sm-block">&nbsp;</div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 p-0">
                                                <div class="row m-0 mb-2">
                                                    <div class="col-md-12 text-center p-2 t08em fw-800 text-info bg-light">دسترسی وب</div>
                                                </div>
                                                <div class="row d-flex m-0 mb-1 align-items-center">
                                                    <div class="col-8 col-md-8">
                                                        <input type="text" class="form-control form-control-sm" ng-model="nuForm.username" placeholder="Username">
                                                    </div>
                                                    <div class="col-4 col-md-4 t08em bg-light text-info text-left text-rtl">نام کاربری :</div>
                                                </div>
                                                <div class="row d-flex m-0 mb-1 align-items-center">
                                                    <div class="col-8 col-md-8">
                                                        <input type="password" class="form-control form-control-sm" ng-model="nuForm.password" placeholder="Password">
                                                    </div>
                                                    <div class="col-4 col-md-4 t08em bg-light text-info text-left text-rtl">رمز ورود :</div>
                                                </div>
                                                <div class="row d-flex m-0 mb-1 align-items-center">
                                                    <div class="col-8 col-md-8">
                                                        <input type="password" class="form-control form-control-sm" ng-model="nuForm.passwordc" placeholder="Password confirm">
                                                    </div>
                                                    <div class="col-4 col-md-4 t08em bg-light text-info text-left text-rtl">تکرار رمز :</div>
                                                </div>
                                                <div class="row  m-0 mb-1 align-items-center">
                                                    <div class="col-8 col-md-8 d-flex justify-content-end">
                                                        <select class="form-control form-control-sm text-rtl col-8 col-md-6 text-wYekan" ng-model="nuForm.access" ng-init="nuForm.access=1">
                                                            <option ng-value="1">اپراتور</option>
                                                            <option ng-value="2">مدیرگروه</option>
                                                            <option ng-value="3">مدیر</option>
                                                            <option ng-value="4">ادمین</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4 col-md-4 t08em bg-light text-info text-left text-rtl">دسترسی :</div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 p-0 border-left border-light">
                                                <div class="container-fluid p-0">
                                                    <div class="row m-0 mb-2">
                                                        <div class="col-md-12 text-center p-2 t08em fw-800 text-info bg-light">اطلاعات اپراتور</div>
                                                    </div>
                                                    <div class="row d-flex m-0 mb-1 align-items-center">
                                                        <div class="col-8 col-md-8">
                                                            <input type="text" class="form-control form-control-sm text-rtl text-wYekan" ng-model="nuForm.fullname_fa" placeholder="نام اپراتور" required>
                                                        </div>
                                                        <div class="col-4 col-md-4 t08em bg-light text-info text-left text-rtl">نام اپراتور :</div>
                                                    </div>
                                                    <div class="row  m-0 mb-1 align-items-center">
                                                        <div class="col-8 col-md-8">
                                                            <input type="text" class="form-control form-control-sm text-rtl" ng-model="nuForm.fullname" placeholder="Fullname" required>
                                                        </div>
                                                        <div class="col-4 col-md-4 t08em bg-light text-info text-left text-rtl">نام(لاتین) :</div>
                                                    </div>
                                                    <div class="row m-0 mb-1 align-items-center">
                                                        <div class="col-8 col-md-8 d-flex justify-content-end flex-row-reverse">
                                                            <div class="col-5 p-0">
                                                                <input type="text" class="form-control form-control-sm  text-rtl" ng-model="nuForm.ext" placeholder="شماره" ng-minlength="3" ng-maxlength="3">
                                                            </div>
                                                            <div class="col-7 p-0 pr-1">
                                                                <input type="text" class="form-control form-control-sm text-rtl" ng-model="nuForm.pin" placeholder="کد اتصال" ng-minlength="6" ng-maxlength="6">
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-md-4 t08em bg-light text-info text-left text-rtl">شماره :</div>
                                                    </div>
                                                    <div class="row  m-0 mb-1 align-items-center">
                                                        <div class="col-8 col-md-8">
                                                            <input type="text" class="form-control form-control-sm text-rtl" ng-model="nuForm.mobile" placeholder="شماره همراه" ng-minlength="11" ng-maxlength="11">
                                                        </div>
                                                        <div class="col-4 col-md-4 t08em bg-light text-info text-left text-rtl">موبایل :</div>
                                                    </div>
                                                    <div class="row  m-0 mb-1 align-items-center">
                                                        <div class="col-8 col-md-8 d-flex justify-content-end">
                                                            <select class="form-control form-control-sm text-rtl col-8 col-md-6 text-wYekan" ng-model="nuForm.secid">
                                                                <option ng-repeat="(k,v) in stats.pbx.queues" ng-value="v.id">{{v.name_fa}}</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-4 col-md-4 t08em bg-light text-info text-left text-rtl">گروه :</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-2 p-0">
                                                <div class="row m-0 mb-2 d-none d-sm-block">
                                                    <div class="col-md-12 text-center p-2 t08em fw-800 text-info bg-light">&nbsp;</div>
                                                </div>
                                                <div class="row m-0 mb-1 d-flex align-items-center">
                                                    <div class="col-8 col-md-4 d-flex justify-content-end" ng-init="nuForm.enabled='1'">
                                                        <input type="checkbox" class="form-control form-control-sm w-auto" ng-disabled="false" ng-model="nuForm.enabled" ng-true-value="'1'" ng-false-value="'0'">
                                                    </div>
                                                    <div class="col-4 col-md-8 t08em bg-light text-info text-left text-rtl">فعال :</div>
                                                </div>
                                                <div class="row m-0 mb-1 d-flex align-items-center">
                                                    <div class="col-8 col-md-4 d-flex justify-content-end" ng-init="nuForm.is_agent='1'">
                                                        <input type="checkbox" class="form-control form-control-sm w-auto " ng-model="nuForm.is_agent" ng-true-value="'1'" ng-false-value="'0'">
                                                    </div>
                                                    <div class="col-4 col-md-8 t08em bg-light text-info text-left text-rtl">اپراتور :</div>
                                                </div>
                                                <div class="row m-0 mb-1 d-flex align-items-center" ng-if="nuForm.is_agent">
                                                    <div class="col-8 col-md-4 d-flex justify-content-end" ng-init="nuForm.is_ivradmin='0'">
                                                        <input type="checkbox" class="form-control form-control-sm w-auto " ng-model="nuForm.is_ivradmin" ng-true-value="'1'" ng-false-value="'0'">
                                                    </div>
                                                    <div class="col-4 col-md-8 t08em bg-light text-info text-left text-rtl">ادمین تلفن :</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 pb-2">
                                                <button class="btn btn-sm btn-success" ng-disabled="!nuForm.$valid" ng-click="action('addUser',nuForm)">ثبت کاربر</button>
                                                <button class="btn btn-sm btn-outline-danger" ng-click="addUserCollapse=true">انصراف</button>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="col-12 col-md-12 m-2 d-flex justify-content-end">
                                   <button class="btn btn-outline-info d-flex flex-row-reverse align-items-center" ng-click="addUserCollapse=!addUserCollapse">
                                       <div class="material-icons ml-2">person_add</div>
                                       <div class="t07em">افزودن کاربر</div>
                                   </button>
                                </div>
                            </div>
                            <div class="row bg-white mt-1 box" ng-repeat="(k,v) in stats.pbx.agents" ng-init="v.collapse=true">
                                <div class="col-md-12 border border-light ">
                                    <div class="row border-bottom border-light text-wYekan clickable bg-light" ng-click="v.collapse=!v.collapse">
                                        <div class="flex-fill">
                                                <div class="row m-0 h-100 d-flex align-items-center text-black-50">
                                                    <div class="col-2 col-md-1 d-flex align-items-center">
                                                        <div class="d-flex align-items-center" ng-if="v.is_agent == '1'">
                                                            <i class="material-icons t14em text-deactive dox" ng-if="v.is_paused == '1'" uib-dropdown-toggle>panorama_fish_eye</i>
                                                            <i class="material-icons t14em text-active animated infinite slower flash dox" ng-if="v.is_paused == '0'" uib-dropdown-toggle>lens</i>
                                                        </div>
                                                    </div>
                                                    <div class="col-2 col-md-1 d-flex align-items-center text-left">
                                                        <i class="material-icons t14em text-danger animated infinite flash dox" ng-if="v.hint == 'Ringing'">ring_volume</i>
                                                        <i class="material-icons t14em text-success animated slow infinite flash dox" ng-if="v.hint == 'InUse'">phone_in_talk</i>
                                                        <i class="material-icons t14em text-warning dox" ng-if="v.hint == 'Unreachable'">power_off</i>
                                                        <i class="material-icons t14em text-black-50 dox" ng-if="v.hint == 'Idle'">phone_enabled</i>
                                                    </div>
                                                    <div class="col-2 col-md-8"></div>
                                                    <div class="col-6 col-md-2 text-right fw-800">{{v.fullname_fa}}</div>
                                                </div>
                                        </div>
                                        <div class="">
                                            <img class="border border-white shadow-sm m-1" style="width:30px;height: 30px; border-radius:50%;" src="/assets/images/profile-blank.png">
                                        </div>
                                    </div>
                                    <div class="row" uib-collapse="v.collapse">
                                        <div class="col-md-12 mt-2">
                                            <div class="row">
                                                <div class="col-12 col-md-4"></div>
                                                <div class="col-12 col-md-4">
                                                    <!-- User web access -->
                                                    <form name="up.webAccessUpdate" ng-submit="up.webAccessUpdate.$valid" novalidate>
                                                        <input type="hidden" ng-model="up.id" ng-init="up.id=v.id">
                                                    <div class="row d-flex m-0 mb-1 align-items-center">
                                                        <div class="col-8 col-md-8">
                                                            <input type="text" class="form-control form-control-sm" ng-model="up.username" ng-init="up.username=v.username" placeholder="Username">
                                                        </div>
                                                        <div class="col-4 col-md-4 t06em text-info text-left text-rtl">نام کاربری</div>
                                                    </div>
                                                    <div class="row d-flex m-0 mb-1 align-items-center">
                                                        <div class="col-8 col-md-8">
                                                            <input type="email" class="form-control form-control-sm" ng-model="up.email" ng-init="up.email=v.email" placeholder="ایمیل">
                                                        </div>
                                                        <div class="col-4 col-md-4 t06em text-info text-left text-rtl">ایمیل</div>
                                                    </div>
                                                    <div class="row d-flex m-0 mb-1 align-items-center">
                                                        <div class="col-8 col-md-8">
                                                            <input type="password" class="form-control form-control-sm" ng-model="up.password" placeholder="Password">
                                                        </div>
                                                        <div class="col-4 col-md-4 t06em text-info text-left text-rtl">رمز ورود</div>
                                                    </div>
                                                    <div class="row d-flex m-0 mb-1 align-items-center">
                                                        <div class="col-8 col-md-8">
                                                            <input type="password" class="form-control form-control-sm" ng-model="up.passwordc" placeholder="Password confirm">
                                                        </div>
                                                        <div class="col-4 col-md-4 t06em text-info text-left text-rtl">تکرار رمز</div>
                                                    </div>
                                                    <div class="row m-0 mb-1 align-items-center">
                                                        <div class="col-8 col-md-8 d-flex justify-content-end">
                                                            <select class="form-control form-control-sm text-rtl col-8 col-md-6 text-wYekan" ng-model="up.access" ng-init="up.access=v.access">
                                                                <option ng-value="'1'">اپراتور</option>
                                                                <option ng-value="'2'">مدیرگروه</option>
                                                                <option ng-value="'3'">مدیر</option>
                                                                <option ng-value="'4'">ادمین</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-4 col-md-4 t06em text-info text-left text-rtl">دسترسی</div>
                                                    </div>
                                                    <div class="row m-0 mb-1 mt-3 align-items-center justify-content-end">
                                                        <div class="col-md-12">
                                                            <button class="btn btn-sm btn-outline-success" ng-disabled="!up.webAccessUpdate.$valid" ng-click="action('webAccessUpdate',up)">بروزرسانی</button>
                                                        </div>
                                                    </div>
                                                    </form>
                                                    <!-- User web access -->
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <!-- Update Operator Form -->
                                                    <div class="container-fluid p-0">
                                                        <form name="up.agentAccessUpdate" ng-submit="up.agentAccessUpdate.$valid">

                                                        <div class="row d-flex m-0 mb-1 text-wYekan align-items-center">
                                                            <div class="col-4">
                                                                <div class="bg-light p-1 d-flex align-items-center">
                                                                    <div class="">
                                                                        <input type="checkbox" ng-model="up.is_ivradmin" ng-init="up.is_ivradmin=v.is_ivradmin" ng-true-value="'1'" ng-false-value="'0'">
                                                                    </div>
                                                                    <div class="flex-fill text-center t07em text-info">ادمین تلفن</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="bg-light p-1 d-flex align-items-center">
                                                                    <div class="">
                                                                        <input type="checkbox" ng-model="up.is_agent" ng-init="up.is_agent=v.is_agent" ng-true-value="'1'" ng-false-value="'0'">
                                                                    </div>
                                                                    <div class="flex-fill text-center t07em text-info">اپراتور</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="bg-light p-1 d-flex align-items-center">
                                                                    <div class="">
                                                                        <input type="checkbox" ng-model="up.enabled" ng-init="up.enabled=v.enabled" ng-true-value="'1'" ng-false-value="'0'">
                                                                    </div>
                                                                    <div class="flex-fill text-center t07em text-info">فعال</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row d-flex m-0 mb-1 align-items-center">
                                                            <div class="col-8 col-md-8">
                                                                <input type="text" class="form-control form-control-sm text-rtl text-wYekan" ng-model="up.fullname_fa" ng-init="up.fullname_fa=v.fullname_fa" placeholder="نام اپراتور" required>
                                                            </div>
                                                            <div class="col-4 col-md-4 t08em text-info text-left text-rtl">نام اپراتور</div>
                                                        </div>
                                                        <div class="row  m-0 mb-1 align-items-center">
                                                            <div class="col-8 col-md-8">
                                                                <input type="text" class="form-control form-control-sm text-rtl" ng-model="up.fullname" ng-init="up.fullname=v.fullname" placeholder="Fullname" required>
                                                            </div>
                                                            <div class="col-4 col-md-4 t08em text-info text-left text-rtl">نام(لاتین)</div>
                                                        </div>
                                                        <div class="row m-0 mb-1 align-items-center">
                                                            <div class="col-8 col-md-8 d-flex justify-content-end flex-row-reverse">
                                                                <div class="col-5 p-0">
                                                                    <input type="text" class="form-control form-control-sm  text-rtl" ng-model="up.ext" ng-init="up.ext=v.ext" placeholder="شماره" ng-minlength="3" ng-maxlength="3">
                                                                </div>
                                                                <div class="col-7 p-0 pr-1">
                                                                    <input type="text" class="form-control form-control-sm text-rtl" ng-model="up.pin" ng-init="up.pin=v.pin" placeholder="کد اتصال" ng-minlength="6" ng-maxlength="6">
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-md-4 t08em text-info text-left text-rtl">شماره</div>
                                                        </div>
                                                        <div class="row  m-0 mb-1 align-items-center">
                                                            <div class="col-8 col-md-8">
                                                                <input type="text" class="form-control form-control-sm text-rtl" ng-model="up.mobile" ng-init="up.mobile=v.mobile" placeholder="شماره همراه" ng-minlength="11" ng-maxlength="11">
                                                            </div>
                                                            <div class="col-4 col-md-4 t08em text-info text-left text-rtl">موبایل</div>
                                                        </div>
                                                        <div class="row  m-0 mb-1 align-items-center">
                                                            <div class="col-8 col-md-8 d-flex justify-content-end">
                                                                <select class="form-control form-control-sm text-rtl col-8 col-md-6 text-wYekan" ng-model="up.secid" ng-init="up.secid=v.secid">
                                                                    <option ng-repeat="(ok,ov) in stats.pbx.queues" ng-value="ov.id">{{ov.name_fa}}</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-4 col-md-4 t08em text-info text-left text-rtl">گروه</div>
                                                        </div>
                                                        <div class="row m-0 mb-1 mt-3 align-items-center">
                                                            <div class="col-md-12">
                                                                <button class="btn btn-sm btn-outline-info" ng-disabled="!up.agentAccessUpdate.$valid" ng-click="action('agentAccessUpdate',up)">بروزرسانی</button>
                                                                <button class="btn btn-sm btn-outline-danger" ng-click="action('removeUser',v)">حذف کاربر</button>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                    <!-- Update Operator Form -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </uib-tab>
        </uib-tabset>
    </div>
    <!-- Admin Settings -->
<?php endif; /* Admin User contents */ ?>


















<?php endif; ?>
