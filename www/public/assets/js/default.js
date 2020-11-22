/* Default Js for alopad */
var app = angular.module('app', ['ui.bootstrap','ngRoute','ngAnimate','ngSanitize','ngFileUpload','ADM-dateTimePicker','angularMoment','growlNotifications']);

app.config(function($routeProvider,$locationProvider){
    $locationProvider.hashPrefix('');
    $routeProvider
        .when('/',{
            templateUrl : '/jstemplates/dashboard',
            controller : 'DashboardController',
        })
        .when('/reports',{
            templateUrl : '/jstemplates/reports',
            controller : 'SettingsController'
        })
        .when('/settings',{
            templateUrl : '/jstemplates/settings',
            controller : 'AnnouncesController'
        })
        .when('/users',{
            templateUrl : '/jstemplates/users',
            controller : 'UsersController'
        })
        .when('/announces',{
            templateUrl : '/jstemplates/announces',
            controller : 'AnnouncesController'
        })
        .when('/studio',{
            templateUrl : '/jstemplates/studio',
            controller : 'StudioController'
        })

        .otherwise({ redirectTo : '/'});
});

app.config(['ADMdtpProvider', function(ADMdtp) {
    ADMdtp.setOptions({
        calType: 'jalali',
        format: 'YYYY-MM-DD hh:mm',
        default: 'today',
        minuteStep : 10

    });
}]);

app.controller('ModalController',function($uibModalInstance,contents,dataEngine){
    var $pop = this;
    $pop.contents = contents;
    $pop.ok = function() { $uibModalInstance.close($pop.name);}
    $pop.cancel = function() { $uibModalInstance.dismiss($pop.name); }
    $pop.action = function(a,p) { dataEngine.action(a,p) }
});

app.controller('notifyController',function($rootScope){
    var index = 0;
    $rootScope.invalidNotification = false;
    $rootScope.notifications = {};
    $rootScope.addNotification = function(notification) {
        var i;
        if ( ! notification ) {
            $rootScope.invalidNotification = true;
            return;
        }
        i = index++;
        $rootScope.invalidNotification = false;
        $rootScope.notifications[i] = notification;
    }
});

app.factory('popIn',function($uibModal,$rootScope){
    return {
        notify : function(size,contents) {
            var notify =  $uibModal.open({
                templateUrl : '/assets/htmls/modal_simplenotify.php',
                controller : 'ModalController',
                controllerAs : '$pop',
                size : size,
                resolve : { contents : function() { return contents;}}
            });
            notify.result.then(function(res){
                console.log("Modal closed : " + res);
            },function(res){
                console.log("Modal dismissed :" + res);
            });
        },
        plug : function(size,contents) {
            var notify =  $uibModal.open({
                templateUrl : '/jstemplates/modal_plug',
                controller : 'ModalController',
                controllerAs : '$pop',
                size : size,
                resolve : { contents : function() { return contents;} }
            });
            notify.result.then(function(res){
                console.log("Modal closed : " + res);
            },function(res){
                console.log("Modal dismissed :" + res);
            });
        }
        ,
        form : function(size,type,contents) {
            var notify =  $uibModal.open({
                templateUrl : '/jstemplates/modal_' + type,
                controller : 'ModalController',
                controllerAs : '$pop',
                size : size,
                resolve : { contents : function() { return contents;} }
            });
            notify.result.then(function(res){
                console.log("Modal closed : " + res);
            },function(res){
                console.log("Modal dismissed :" + res);
            });
        }
    }
});



app.controller('sidebarController',function($scope,$location){
    $scope.go = function(l) { $location.path(l);}
});


app.controller('navbarController',function($scope,$rootScope,popIn){
    $scope.plug = function() {
        popIn.plug("lg",$rootScope.stats);
    };
    $scope.notif = function() {
        popIn.notifice({ result : false , message : "This is a result message"});
    }
});


app.controller('DashboardController',function($scope,$rootScope,popIn,Charts,dataStream,dataEngine){

    $rootScope.liveChartCollapse = true;
    if ( ! $rootScope.dataStreamRunning ) {
        dataStream.running();

        if ( angular.element('#liveChart').length ) {
            Charts.liveChart();
        }
    }

    $scope.action = function(a,p) {
        dataEngine.action(a,p);
    }
});

app.controller('UsersController',function($scope,$rootScope,popIn,Charts,dataStream,dataEngine){

    $rootScope.liveChartCollapse = true;
    if ( ! $rootScope.dataStreamRunning ) {
        dataStream.running();

        if ( angular.element('#liveChart').length ) {
            Charts.liveChart();
        }
    }

    $scope.addUser = function() {
        popIn.form("lg",'newuser',$rootScope.stats);
    }

    $scope.action = function(a,p) {
        dataEngine.action(a,p);
    }
});

app.controller('AnnouncesController',function($scope,$rootScope,popIn,Charts,dataStream,dataEngine){

    $rootScope.liveChartCollapse = true;
    if ( ! $rootScope.dataStreamRunning ) {
        dataStream.running();

        if ( angular.element('#liveChart').length ) {
            Charts.liveChart();
        }
    }

});




app.factory('dataStream',function($interval,$rootScope,$http,dSyncer,$window){
    return {
        running : function() {
            $rootScope.dataStreamRunning = true;
            $rootScope.disconnected = false;
            $http.get("/stats",{timeout : 6000}).then(function(r){
                $rootScope.stats = r.data;
            },function(r){
                //console.log("First time failed");
                $rootScope.disconnected = true;
                $rootScope.stats.pbx.activeCalls = 0;
            });
            $interval(function(){
                //**console.log("dataStream Interval " + new Date().getTime());
                //console.log("Interval going on..." + new Date());
                $http.get("/stats",{timeout : 5900}).then(function(r){
                    if (  $rootScope.disconnected  )
                        $rootScope.disconnected = false;
                    $rootScope.ntats = r.data;
                    if ( r.data.token === null  ) {
                        $window.location.href = "/logout";
                    }
                    dSyncer.stats();
                },function(r){
                    $rootScope.stats.pbx.activeCalls = 0;
                    $rootScope.disconnected = true;
                });
            },6000);
        }
    }
});




app.factory('dSyncer',function($rootScope){
    return {
        stats : function() {
            a = $rootScope.stats;
            b = $rootScope.ntats;
            $rootScope.stats.ts = b.ts;
            $rootScope.stats.pbx.activeCalls = b.pbx.activeCalls;
            $rootScope.stats.pbx.activeChannels = b.pbx.activeChannels;
            $rootScope.stats.pbx.calls = b.pbx.calls;
            $rootScope.stats.pbx.op = b.pbx.op;

            $rootScope.stats.pbx.stations = b.pbx.stations;
            //$rootScope.stats.pbx.agents = b.pbx.agents;
            $rootScope.stats.pbx.queues = b.pbx.queues;

            // Start : Syncing agents
            agents = $rootScope.stats.pbx.agents;
            n_agents = $rootScope.ntats.pbx.agents;
            angular.forEach(n_agents,function(val,key){
                //console.log("typeof " + key + " : " + typeof agents[key]);
                if ( typeof agents[key] === "undefined" || agents[key] === null ) {
                    agents[key] = val;
                }
                else {
                    agent = agents[key];
                    n_agent = n_agents[key];
                    angular.forEach(agent,function(v,k){
                        if (  typeof n_agent[k] !== "undefined" || n_agent[k] != null )
                            if ( agent[k] !== n_agent[k] )
                                agent[k] = n_agent[k];
                    });
                }
            });
            angular.forEach(agents,function(val,key){
                if( typeof n_agents[key] === "undefined" || n_agents[key] === null )
                    delete agents[key];
            });
            // End : Syncing agents
            // Start : Syncing Stations
            stations = $rootScope.stats.pbx.stations;
            n_stations = $rootScope.ntats.pbx.stations;

            angular.forEach(n_agents,function(val,key){
                if ( typeof stations[key] === "undefined" || stations[key] === null ) {
                    stations[key] = val;
                }
                else {
                    station = stations[key];
                    n_station = n_stations[key];
                    angular.forEach(station,function(v,k){
                        if (  typeof n_station[k] !== "undefined" || n_station[k] != null )
                            if ( station[k] !== n_station[k] )
                                station[k] = n_station[k];
                    });
                }
            });
            angular.forEach(stations,function(val,key){
                if( typeof n_stations[key] === "undefined" || n_stations[key] === null )
                    delete stations[key];
            });






            // Syncing stations ends!

        }
    }
});



app.filter('kCounter',function(){
    return function(obj) {
        if (obj == null) return 0;
        var k = Object.keys(obj);
        return k.length;
    }
});

app.filter('dtForm',function($rootScope){
    return function(dt) {

        var now = $rootScope.stats.ts *1000; //new Date().getTime();
        //var now = new Date().getTime();
        var msec = now - dt*1000;
        var mins = Math.floor(msec / 60000);

        if ( mins > (60 * 24 * 30) ) return Math.floor(mins/(60*24*30)) + " ماه";
        if ( mins > (60 * 24)) return Math.floor(mins/(60*24)) + " روز";
        if ( mins > 60 ) return Math.floor(mins/60) + " ساعت";
        if ( mins > 1 ) return mins + " دقیقه";
        if ( mins <= 0 ) return "چند لحظه ";

    }
});

app.filter('nullRemover',function(){
    return value != null;
});

app.directive('ngBlinker', function($animate) {
    return {
        link : function(scope,element,attrs) {
            scope.$watch(attrs.ngBlinker,function(val,oldVal){
                if ( val === oldVal )
                    return;
                else {
                    //console.log("Changed : " + val + " > " + oldVal);
                    $animate.addClass(element,"animated slow flash").then(function(){
                        $animate.removeClass(element,"animated slow flash")
                    });
                }
            });
        }
    }
});



app.factory('dataEngine', function($http,$rootScope,$interval,$timeout,dSyncer,popIn){
    return {
        httpget: function(path) { return $http.get(path,{timeout : 5500});},
        httpost: function(path,data) { return $http({ method: 'POST', dataType: 'json', url: path,
            headers: { 'Content-Type': 'application/json' }, data: data, timeout: 30000, cache: false }); },
        stats : function() {
            $rootScope.liveData = true;
            this.httpget('/stats').then(function(r){
                $rootScope.stats = r.data;
            });
            $interval(function(){
                $http.get('/stats').then(function(r){
                    //console.log("STATS UPDATED : " + new Date().getHours() + ":" + new Date().getMinutes() + ":" + new Date().getSeconds());
                    if (  $rootScope.disconnected )
                        $rootScope.disconnected = false;
                    $rootScope.ntats = r.data;
                    dSyncer.stats();
                },function(r){
                    $rootScope.stats.pbx.activeCalls = 0;
                    $rootScope.disconnected = true;
                });
            },5000);
        },
        action : function(act,p) {
            $rootScope.stats.lastResponse = null;
            $rootScope.stats.hasRunningAction = true;
            path = "/wa/" + act;
            console.log("Action  : " + act + " | params : " + JSON.stringify(p) );
            this.httpost(path, {r : act , p : p }).then(function(r){
                console.log(act + " result : " + JSON.stringify(r.data));
                if ( r.data ) {
                    $rootScope.stats.hasRunningAction = false;
                    $rootScope.stats.lastResponse = r.data;
                    //console.log("Plug :" + JSON.stringify($rootScope.stats.lastResponse));
                    switch(act) {
                        case 'plug' :
                            /*
                            if ( r.data.result ) {
                                $rootScope.addNotification(r.data);
                                $rootScope.stats.pbx.agents[p["agent_id"]].plugged = true;
                                $rootScope.stats.pbx.agents[p["agent_id"]].station_id = p.station_id;
                                $rootScope.stats.pbx.stations[p["station_id"]].taken = true;
                            }
                            $timeout(function(){$rootScope.stats.lastResponse = null;},6000)
                            break;

                             */
                        case 'unplug' :
                            /*
                            if ( r.data.result ) {

                                $rootScope.stats.pbx.agents[p["agent_id"]].plugged = false;
                                $rootScope.stats.pbx.agents[p["agent_id"]].station_id = null;
                            }
                            $timeout(function(){ $rootScope.stats.lastResponse = null;},6000);
                            break;
                             */
                        case 'login' :
                            /*$timeout(function(){ $rootScope.stats.lastResponse = null;},6000);
                            break;*/

                        case 'logout' :
                            $rootScope.addNotification(r.data);
                            $rootScope.stats.pbx.agents[p["agent_id"]].lastResponse = r.data;
                            $timeout(function(){ $rootScope.stats.pbx.agents[p["agent_id"]].lastResponse = null;},6000);
                            break;
                            /*if ( r.data.result ) {}*/
                            /*$timeout(function(){ $rootScope.stats.lastResponse = null;},6000);*/
                        case 'gplug' :
                        case 'gunplug' :
                            //$rootScope.stats.pbx.agents[p["agent_id"]].lastResponse = r.data;
                            //$timeout(function(){ $rootScope.stats.pbx.agents[p["agent_id"]].lastResponse = null;},6000);
                            //break;


                        case 'glogin' :
                            //$rootScope.stats.pbx.agents[p["agent_id"]].lastResponse = r.data;
                            //$timeout(function(){ $rootScope.stats.pbx.agents[p["agent_id"]].lastResponse = null;},6000);
                            //break;

                        case 'glogout' :
                            $rootScope.addNotification(r.data);
                            $rootScope.stats.pbx.agents[p["agent_id"]].lastResponse = r.data;
                            $timeout(function(){ $rootScope.stats.pbx.agents[p["agent_id"]].lastResponse = null;},6000);
                            break;

                        case 'report' :
                            $rootScope.addNotification(r.data);
                            $rootScope.reports = r.data.data;
                            break;

                        case 'agentAccessUpdate' :
                            popIn.notify("sm",r.data);
                            break;
                        case 'webAccessUpdate' :
                            popIn.notify("sm",r.data);
                            break;
                        case  'activate' :
                            popIn.notify("sm",r.data);
                            $rootScope.stats.pbx.agents[p.id]["is_paused"] = '0';
                            console.log("Successfull activate of " + p.id + " : " + $rootScope.stats.pbx.agents[p.id]["is_paused"] );
                            break;

                        case 'addUser' :
                            popIn.notify("sm",r.data);
                            p["fullname"] = "";
                            p["fullname_fa"] = "";
                            p["ext"] = "";
                            p["pin"] = "";
                            p["username"] = "";
                            p["mobile"] = "";
                            p["enabled"] = '1';
                            break;

                        case 'removeUser' :
                            popIn.notify("sm",r.data);
                            delete p;
                            //m = $rootScope.stats.pbx.agents.indexOf(p.ext);
                            console.log("Object : " + $rootScope.stats.pbx.agents[p.id]);
                            delete $rootScope.stats.pbx.agents[p.id];
                            console.log('User was removed : ' + p.id );
                            break;

                        case 'recordings' :
                            //console.log("Recordings Result : " + r.data.message);
                            $rootScope.recordings = r.data.recordings;
                            //console.log("RootScope : " + JSON.stringify($rootScope.recordings));
                            break;

                        case 'getAnnounces' :
                            $rootScope.announces = r.data.announces;
                            break;

                        case 'addAnnounce' :
                            popIn.notify("sm",r.data);
                            p["title"] = "";
                            p["prefix"] = "";
                            p["audioConfirmed"] = 0;
                            p["start"] = "";
                            p["end"] = "";
                            break;

                        case "disableAnnounce" :
                            popIn.notify("sm",r.data);
                            break;
                        case "enableAnnounce" :
                            popIn.notify("sm",r.data);
                            break;

                        default :
                            return;
                    }
                } else {
                    console.log(JSON.stringify(r.data));
                    //popIn.notify("sm",r.data);
                    //$scope.errorsCollapse = false;
                    //$scope.errors = r.data.message;
                }
            });

        }
    };
});





app.factory('Charts',function($rootScope,$interval){
    return {
        liveChart : function() {
            $rootScope.liveChartStarted = true;

            $rootScope.liveChartDataCount = 50;
            $rootScope.liveChartColor = "grey";
            // Initializing some zero data
            //console.log("I AM CALLED");

            if ( typeof $rootScope.liveChartInterval === "undefined" ) {
                $rootScope.liveChartDatas = [];
                for ( i = $rootScope.liveChartDataCount ; i > 0 ; i-- ) {
                    var d = new Date().getTime() - i*6000;
                    $rootScope.liveChartDatas.push({
                        y : 0,
                        x : d
                    });
                }
            }

            chart = new CanvasJS.Chart('liveChart',{
                animationEnabled: true,
                exportEnabled : false,
                backgroundColor : "white",
                title :  {
                    fontWeight : "lighter",
                    fontSize : 14,
                    fontFamily : "Kufi",
                    fontColor : "#397d93",
                    margin : 10,
                    text : 'آمار لحظه ای تماس های ورودی سامانه'
                },

                axisY : {
                    lineColor : "transparent",
                    interval : 5,
                    labelFontFamily : "Arial,Tahoma",
                    labelFontSize : 8,
                    labelFontColor : "#397d93",
                    includeZero: false,
                    gridColor : "transparent",
                    tickLength: 0,
                    crosshair: {
                        enabled: true,
                        snapToDataPoint: true,
                        labelFormatter: function(e) {
                            return CanvasJS.formatNumber(e.value, "#");
                        }
                    }

                },
                axisX : {
                    tickLength: 0,
                    //gridColor : "red",
                    intervalType: "second",
                    interval: 6,
                    valueFormatString : "mm:ss",
                    labelFontFamily : "Arial,Tahoma",
                    labelFontSize : 8,
                    labelFontColor : "transparent", //"#397d93",
                    lineColor : "transparent",
                    crosshair : {
                        enabled : true,
                        snapToDataPoint: true
                    }
                },
                axisX2 : {
                    interlacedColor: "red",
                    gridColor: "red",
                    title: ""
                },
                legend : {
                    cursor	: "pointer",
                    fontFamily : "Arial,Tahoma",
                    fontColor : "#397d93",
                    verticalAlign : "top",
                    horizontalAlign : "center",
                    dockInsidePlotArea : false
                },
                toolTip : {
                    fontFamily : "Kufi,Arial",
                    fontColor : "grey",
                    fontSize : "10",
                    textAlign : "right",
                    borderColor : "transparent",
                    cornerRadius : 5
                },
                data : [
                    {
                        toolTipContent : "مجموع تماس :‌ " + "{y}" + "<br>" + "زمان دقیق :" + " {x}",
                        xValueType : "dateTime",
                        xValueFormatString : "HH:mm:ss",
                        type : 'splineArea',
                        //color: "rgb(121,134,203)",
                        color: "rgb(122, 230, 240)",
                        dataPoints : $rootScope.liveChartDatas
                    }]
            });
            chart.render();
            //if ( $rootScope.liveChartInterval )
            //console.log("Interval status : " + $rootScope.liveChartInterval);
            if ( typeof $rootScope.liveChartInterval === "undefined" ) {
                $rootScope.liveChartInterval = $interval(function(){
                    //console.log("ActiveCall : " + $rootScope.stats.pbx.activeCalls + " - DC : " + $rootScope.liveChartDataCount + " - DL : " + $rootScope.liveChartDatas.length + " : " + new Date().getTime());
                    if ( $rootScope.liveChartDatas.length > $rootScope.liveChartDataCount -1 )
                        $rootScope.liveChartDatas.shift();

                    $rootScope.liveChartDatas.push({
                        y : $rootScope.stats.pbx.activeCalls,
                        x : new Date().getTime()
                    });
                    chart.render();
                },6000);
            }


        } // End of liveChart
    } // End of Return
});




function playback(f,u) {
    var p = f.split('_');
    console.log("Playing audio_" + p[0]);
    ele = "audio_" + p[0];
    if (  u == 1) {
        document.getElementById(ele).play();
    } else {
        document.getElementById(ele).pause();
    }
}








