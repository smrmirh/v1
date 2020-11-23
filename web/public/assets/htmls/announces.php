<?php
session_start();
if ( ! isset($_SESSION["logged"]) )
{
    header("HTTP/1.0 404 Not Found");
    die();
}
if (  isset($_SESSION["logged"])  ) :
?>


<!-- Admin  -->
<?php if ( $_SESSION["access"] > 4 ) : ?>
    <div id="app-contents" class="app-contents border border-dark">
       <div class="container pt-2 text-kufi" ng-init="newAnnounce.collapse = true">
           <div class="container-fluid p-0 bg-white" uib-collapse="newAnnounce.collapse">
               <div class="container-fluid t07em">
                   <form name="newAnnounceForm" ng-submit="newAnnounceForm.$valid">
                       <div class="container-fluid">
                           <div class="row">
                               <div class="col-12 col-md-8 p-1 border border-light">
                                   <div class="container-fluid p-0">
                                       <div class="p-2 text-center bg-light fw-800 t14em text-info">تنظیمات</div>
                                   </div>
                                   <div class="container-fluid p-0">
                                       <div class="row m-0">
                                           <div class="col-md-4"></div>
                                           <div class="col-8 col-md-6 d-flex justify-content-end">
                                               <input type="checkbox" ng-model="newAnnounce.enabled" ng-init="newAnnounce.enabled=1" ng-true-value="1" ng-false-value="0" class="form-control form-control-sm w-auto">
                                           </div>
                                           <div class="col-4 col-md-2 text-info bg-light d-flex align-items-center">: فعال</div>
                                       </div>
                                       <div class="row m-0">
                                           <div class="col-md-4"></div>
                                           <div class="col-8 col-md-6">
                                               <input class="form-control form-control-sm m-1 text-rtl text-wYekan" type="text" ng-model="newAnnounce.title" placeholder="عنوان..." required>
                                           </div>
                                           <div class="col-4 col-md-2 text-info bg-light d-flex align-items-center">: عنوان</div>
                                       </div>
                                       <div class="row m-0">
                                           <div class="col-md-7"></div>
                                           <div class="col-8 col-md-3">
                                               <input class="form-control form-control-sm m-1 text-rtl text-wYekan" type="text" ng-model="newAnnounce.prefix" placeholder="پیش شماره..." ng-minlength="2" ng-maxlength="10" required>
                                           </div>
                                           <div class="col-4 col-md-2 text-info bg-light d-flex align-items-center">: پیش شماره</div>
                                       </div>
                                       <div class="row m-0 border border-light">
                                           <div class="col-md-4"></div>
                                           <div class="col-8 col-md-6">
                                               <adm-dtp class="m-1" ng-model='newAnnounce.start' required></adm-dtp>
                                           </div>
                                           <div class="col-4 col-md-2 text-info bg-light d-flex align-items-center">:‌ شروع</div>
                                           <div class="col-md-4"></div>
                                           <div class="col-8 col-md-6">
                                               <adm-dtp class="m-1" ng-model='newAnnounce.end' options='{calType: "jalali", format: "YYYY-MM-DD hh:mm", default: 0}'></adm-dtp>
                                           </div>
                                           <div class="col-4 col-md-2 text-info bg-light d-flex align-items-center">: اتمام</div>
                                       </div>
                                       <div class="row m-0">
                                           <div class="col-12 col-md-10">
                                               <textarea class="form-control form-control-sm m-1 text-rtl" placeholder="توضیحات ..."></textarea>
                                           </div>
                                           <div class="col-md-2 text-info bg-light d-none d-sm-block align-items-center"></div>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-12 col-md-4 p-1">
                                 <div class="container-fluid p-0">
                                     <div class="p-2 text-center bg-light fw-800 t14em text-info">انتخاب فایل صوتی</div>
                                     <div class="row border border-light m-0 p-2 d-flex align-items-center justify-content-center" ng-init="newAnnounce.audio=false;">
                                         <select ng-model="newAnnounce.recordingType" class="form-control form-control-sm col-8 text-rtl text-wYekan" ng-init="newAnnounce.recordingType=1;newAnnounce.audioConfirmed=0" ng-change="newAnnounce.audio=false;newAnnounce.audioConfirmed=0">
                                             <option ng-value="1">انتخاب از لیست</option>
                                             <option ng-value="2">ضبط استودیو</option>
                                             <!--<option ng-value="3">آپلود فایل صوتی</option>-->
                                         </select>
                                     </div>
                                     <div class="row border border-light m-0 mt-1" ng-if="newAnnounce.recordingType==1">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12 text-center text-wYekan text-info t12em text-rtl bg-light p-1">
                                                    فایل صوتی را از لیست زیر انتخاب نمایید
                                                </div>
                                                <div class="col-12 d-flex align-items-center justify-content-center mt-2 p-2">
                                                    <select ng-model="recording" ng-options="r.title for r in recordings" ng-change="studio('recording',recording.filename);newAnnounce.audio=recording.id;newAnnounce.audioConfirmed=0" class="form-control form-control-sm col-8 text-rtl text-wYekan">
                                                        <!--<option ng-repeat="r in recordings" ng-value="r.id" ng-click="studio('recording',r.filename)">{{r.title}}</option>-->
                                                    </select>
                                                </div>
                                                <div  class="col-12 border border-light p-0  d-flex align-items-center justify-content-center">
                                                    <audio id="recording_playback" style="height:35px;" class="p-2" controls>
                                                        <source type="audio/mpeg">
                                                    </audio>
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                                     <div class="row border border-light m-0 mt-1" ng-if="newAnnounce.recordingType==2">
                                       <div class="container-fluid">
                                           <div class="row">
                                               <div class="col-12 text-center text-wYekan text-info t12em text-rtl bg-light">جهت ضبط صدای جدید با شماره گیری <kbd class="bg-warning">5*</kbd> از طریق دستگاه تلفن اقدام نموده و پس از اطمینان از صدای ضبط شده آن را به اعلان اضافه نمایید.</div>
                                               <div class="col-12 p-0 mt-3" ng-init="star5temp='/assets/sounds/star5temp.wav'">
                                                   <div class="container-fluid d-flex align-items-center justify-content-center icon-clickable" ng-click="studio('star5temp','star5temp.wav');newAnnounce.audio=-1">
                                                       <span>بازخوانی استودیو</span>
                                                       <span class="material-icons bg-light">refresh</span>
                                                   </div>
                                               </div>
                                               <div class="col-12 border border-light p-0  d-flex align-items-center justify-content-center">
                                                   <audio id="star5temp_playback" style="height:35px;" class="p-2" controls>
                                                       <source type="audio/mpeg">
                                                   </audio>
                                               </div>
                                           </div>
                                       </div>
                                     </div>
                                     <div class="row border border-light m-0 mt-1" ng-if="newAnnounce.audio != false">
                                         <div class="col-12 mt-1 border border-light d-flex align-items-center justify-content-end">
                                             <div class="flex-fill text-right pr-2 text-wYekan text-success">فایل صوتی را تایید میکنم</div>
                                             <input class="form-control form-control-sm w-auto" type="checkbox" ng-model="newAnnounce.audioConfirmed">
                                         </div>
                                     </div>
                                     <div class="row border border-light m-0 mt-1" ng-if="newAnnounce.recordingType==3">
                                        آپلود فایل
                                     </div>
                                 </div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-12 m-2 border border-light p-2">
                                   <button class="btn btn-sm btn-success" ng-click="action('addAnnounce',newAnnounce);getAnnounces()" ng-disabled="!newAnnounceForm.$valid || !newAnnounce.audio || !newAnnounce.audioConfirmed">ثبت اعلان</button>
                                   <button class="btn btn-sm btn-outline-danger" ng-click="newAnnounce.collapse=true">انصراف</button>
                               </div>
                           </div>
                       </div>
                   </form>
               </div>
           </div>
           <div class="container-fluid">
               <div class="row text-kufi mt-2">
                   <div class="col-md-12 d-flex justify-content-end">
                       <button class="btn btn-outline-info d-flex flex-row-reverse align-items-center" ng-click="newAnnounce.collapse=!newAnnounce.collapse">
                           <div class="material-icons ml-2">person_add</div>
                           <div class="t07em">اعلان جدید</div>
                       </button>
                   </div>
               </div>
           </div>
           <div class="container-fluid mt-2">
               <div class="row bg-white text-wYekan text-black-50 mt-1 shadow-sm" ng-repeat="a in announces" ng-init="a.collapse=true">
                   <div class="col-12">
                       <div class="row">
                           <div class="col-12 p-0 d-flex align-items-center">
                               <div class="flex-fill d-flex align-items-center justify-content-center text-right">
                                   <div class="col-md-5 d-none d-sm-block">
                                       <div class="row">
                                           <div class="col-md-6"></div>
                                           <div class="col-md-6">
                                               <div class="row">
                                                   <div class="col-md-6">
                                                       <div class="d-flex align-items-center justify-content-end">
                                                           <div class="border border-light pl-1 pr-1 text-success">{{a.hits - a.continued}}</div>
                                                           <div class="bg-light pl-2 pr-2 text-muted t08em">موثر</div>
                                                       </div>
                                                   </div>
                                                   <div class="col-md-6">
                                                       <div class="d-flex align-items-center justify-content-end">
                                                           <div class="border border-light pl-1 pr-1 text-info">{{a.hits}}</div>
                                                           <div class="bg-light pl-2 pr-2 text-muted t08em">مجموع</div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="col-md-2 d-none d-sm-block text-black-50">{{a.end}}</div>
                                   <div class="col-4 col-md-1 text-danger border border-light">{{a.prefix}}</div>
                                   <div class="col-8 col-md-4 border border-light icon-clickable text-black-50 fw-800"">{{a.title}}</div>
                               </div>
                                <!--
                               <div class="d-flex align-items-center p-2 icon-clickable" ng-init="a.pllayback=false" ng-click="a.playback=!a.playback">
                                   <i class="material-icons" ng-if="!a.playback">play_circle_outline</i>
                                   <i class="material-icons" ng-if="a.playback">pause_circle_outline</i>
                               </div>
                               -->
                           <div class="d-flex align-items-center p-2 icon-clickable" ng-init="a.pllayback=false" ng-click="action('removeAnnounce',{ id : a.id });getAnnounces();">
                               <i class="material-icons text-danger">delete</i>
                           </div>
                               <div class="d-flex align-items-center p-2 icon-clickable">
                                   <i class="material-icons" ng-if="a.enabled=='1'" ng-click="action('disableAnnounce',{id : a.id });getAnnounce();">volume_up</i>
                                   <i class="material-icons" ng-if="a.enabled=='0'" ng-click="action('enableAnnounce',{id : a.id });getAnnounces();">volume_off</i>
                               </div>
                           </div>
                       </div>
                       <div class="row mt-1 t08em" uib-collapse="a.collapse">
                           <div class="col-12">
                               <div class="container-fluid m-1">
                                   <div class="row">
                                       <div class="col-12 col-md-4 p-0">
                                           <!-- Recording field : Start -->
                                           <div class="container-fluid p-0">
                                               <div class="p-2 text-center bg-light fw-800 t14em text-info">انتخاب فایل صوتی</div>
                                               <div class="row border border-light m-0 p-2 d-flex align-items-center justify-content-center" ng-init="a.audio=false;">
                                                   <select ng-model="a.recordingType" class="form-control form-control-sm col-8 text-rtl text-wYekan" ng-init="a.recordingType=1;a.audioConfirmed=0" ng-change="a.audio=false;a.audioConfirmed=0">
                                                       <option ng-value="1">انتخاب از لیست</option>
                                                       <option ng-value="2">ضبط استودیو</option>
                                                       <!--<option ng-value="3">آپلود فایل صوتی</option>-->
                                                   </select>
                                               </div>
                                               <div class="row border border-light m-0 mt-1" ng-if="a.recordingType==1">
                                                   <div class="container-fluid">
                                                       <div class="row">
                                                           <div class="col-12 text-center text-wYekan text-info t08em text-rtl bg-light p-1">
                                                               فایل صوتی را از لیست زیر انتخاب نمایید
                                                           </div>
                                                           <div class="col-12 d-flex align-items-center justify-content-center mt-2 p-2">
                                                               <select ng-model="recording" ng-options="r.title for r in recordings" ng-change="studio('audiolist_'+a.id+'_recording',recording.filename);a.audio=recording.id;a.audioConfirmed=0" class="form-control form-control-sm col-8 text-rtl text-wYekan">
                                                                   <!--<option ng-repeat="r in recordings" ng-value="r.id" ng-click="studio('recording',r.filename)">{{r.title}}</option>-->
                                                               </select>
                                                           </div>
                                                           <div  class="col-12 border border-light p-0  d-flex align-items-center justify-content-center">
                                                               <audio id="audiolist_{{a.id}}_playback" style="height:35px;" class="p-2" controls>
                                                                   <source type="audio/mpeg">
                                                               </audio>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                               <div class="row border border-light m-0 mt-1" ng-if="a.recordingType==2">
                                                   <div class="container-fluid">
                                                       <div class="row">
                                                           <div class="col-12 text-center text-wYekan text-info t08em text-rtl bg-light">جهت ضبط صدای جدید با شماره گیری <kbd class="bg-warning">5*</kbd> از طریق دستگاه تلفن اقدام نموده و پس از اطمینان از صدای ضبط شده آن را به اعلان اضافه نمایید.</div>
                                                           <div class="col-12 p-0 mt-3" ng-init="star5temp='/assets/sounds/star5temp.wav'">
                                                               <div class="container-fluid d-flex align-items-center justify-content-center icon-clickable" ng-click="studio('audio_' + a.id + '_star5temp','star5temp.wav');newAnnounce.audio=-1">
                                                                   <span>بازخوانی استودیو</span>
                                                                   <span class="material-icons bg-light">refresh</span>
                                                               </div>
                                                           </div>
                                                           <div class="col-12 border border-light p-0  d-flex align-items-center justify-content-center">
                                                               <audio id="audio_{{a.id}}_star5temp_playback" style="height:35px;" class="p-2" controls>
                                                                   <source type="audio/mpeg">
                                                               </audio>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                               <div class="row border border-light m-0 mt-1" ng-if="a.audio != false">
                                                   <div class="col-12 mt-1 border border-light d-flex align-items-center justify-content-end">
                                                       <div class="flex-fill text-right pr-2 text-wYekan text-success">فایل صوتی را تایید میکنم</div>
                                                       <input class="form-control form-control-sm w-auto" type="checkbox" ng-model="newAnnounce.audioConfirmed">
                                                   </div>
                                               </div>
                                               <div class="row border border-light m-0 mt-1" ng-if="a.recordingType==3">
                                                   آپلود فایل
                                               </div>
                                           </div>
                                           <!-- Recording field : End -->
                                       </div>
                                       <div class="col-12 col-md-4 p-0">
                                           <div class="container-fluid text-info">
                                               <div class="row">
                                                   <div class="col-12 p-1 text-center t12em fw-800 bg-light">اطلاعات اعلان</div>
                                                   <div class="col-8 text-black-50 border-bottom border-light text-right">
                                                       <input type="text" class="form-control form-control-sm text-rtl m-1" ng-model="a.title">
                                                   </div>
                                                   <div class="col-4 bg-light d-flex align-items-center">عنوان</div>
                                                   <div class="col-8 text-black-50 border-bottom border-light text-right">
                                                       <adm-dtp class="m-1" ng-model='a.start' options='{calType: "jalali", format: "YYYY-MM-DD hh:mm" , default : a.start}'></adm-dtp>
                                                   </div>
                                                   <div class="col-4 bg-light d-flex align-items-center">شروع</div>
                                                   <div class="col-8 text-black-50 border-bottom border-light text-right">
                                                       <adm-dtp class="m-1" ng-model='a.end' options='{calType: "jalali", format: "YYYY-MM-DD hh:mm" , default : a.end}'></adm-dtp>
                                                   </div>
                                                   <div class="col-4 bg-light d-flex align-items-center">اتمام</div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-12 col-md-4 p-0 border-left border-light">
                                           <div class="container-fluid text-info">
                                               <div class="row ">
                                                   <div class="col-12 p-1 text-center t12em fw-800 bg-light">آمار و ارقام</div>
                                                   <div class="col-8 text-black-50 border-bottom border-light text-right">
                                                       <i class="material-icons p-0 icon-clickable">save_alt</i>
                                                   </div>
                                                   <div class="col-4 bg-light d-flex align-items-center">دانلود گزارش</div>
                                                   <div class="col-8 text-black-50 border-bottom border-light text-right">{{a.prefix}}</div>
                                                   <div class="col-4 bg-light">پیش شماره</div>
                                                   <div class="col-8 text-black-50 border-bottom border-light text-right">{{a.hits}}</div>
                                                   <div class="col-4 bg-light">تعداد تماس</div>
                                                   <div class="col-8 text-success border-bottom border-light text-right">{{a.hits - a.continued}}</div>
                                                   <div class="col-4 bg-light">موثر</div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="row mb-2 mt-2">
                                       <div class="col-12 text-kufi">
                                           <button class="btn btn-success btn-sm">بروزرسانی</button>
                                           <button class="btn btn-outline-danger btn-sm">حذف</button>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <div class="container-fluid mt-1">
               <div class="row">
                   <div class="col-12 p-0 text-center">
                       <!--Pagination-->
                   </div>
               </div>
           </div>
       </div>
    </div>
<? endif; ?>
<!-- End of Admin -->



<? endif; ?>
