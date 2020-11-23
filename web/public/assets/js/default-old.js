/* https://code.angularjs.org/1.6.1 */
/* https://mdbootstrap.com */


var app = angular.module('app', ['ui.bootstrap','ngRoute','ngAnimate','ngSanitize','ngFileUpload','ADM-dateTimePicker']);


    app.config(function($routeProvider,$locationProvider){
        /*
        ADMdtp.setOptions({
            calType: 'gregorian',
            format: 'YYYY-MM-DD hh:mm',
            default: 'today',
            ...
        });

         */
        $locationProvider.hashPrefix('');
        $routeProvider
            .when('/',{
                templateUrl : '/assets/htmls/dashboard.php',
                controller : 'DashboardController',
            })
            .when('/settings',{
                templateUrl : '/assets/htmls/settings.php',
                controller : 'SettingsController'
            })
            .when('/announces',{
                templateUrl : '/assets/htmls/announces.php',
                controller : 'AnnouncesController'
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






app.controller('sidebarController',function($scope,$location){
    $scope.go = function(l) { $location.path(l);}
});

app.controller('DashboardController',function($scope,$rootScope,popIn,Charts,dataStream,dataEngine){
    $rootScope.liveChartCollapse = true;
    if ( ! $rootScope.dataStreamRunning )
        dataStream.running();
    Charts.liveChart();

    $scope.action = function(a,p) {
        //console.log("Action : " + a + " params attached : " + JSON.stringify(p));
        dataEngine.action(a,p);
    }


});

app.controller('SettingsController',function($rootScope,$scope,dataStream,dataEngine){
    //$rootScope.nuForm = {};
    if ( ! $rootScope.dataStreamRunning )
        dataStream.running();

    $scope.action = function(a,p) {
        dataEngine.action(a,p);
    };


});

app.controller('AnnouncesController',function($rootScope,$scope,dataEngine,dataStream){
    $scope.itemsPerPage = 2;
    //$scope.currentPage = 1;
    $scope.page = 1;
    $scope.dateOptions = {};
    //$rootScope.recordings = [];
    $scope.studio = function(e,f) {
        //path = "/assets/sounds/" + f + "?" + new Date().getTime();
        //ele  = e + "_playback";
        console.log("Params : " + e + " : " + f);
        //console.log("Element : " + ele);
        //console.log("Path : " + path);
        $scope.audio = document.getElementById(e + "_playback");
        $scope.audio.volume = 0.8;
        $scope.audio.src = "/assets/sounds/" + f + "?" + new Date().getTime(); //"/assets/sounds/"+f+ "?" + new Date().getTime() ;
        $scope.audio.load();
        $scope.audio.play();

    };

    $scope.action = function(a,p) {
        dataEngine.action(a,p);
    };

    $scope.getRecordings = function() {dataEngine.action('recordings',{});};
    $scope.getRecordings();

    $scope.getAnnounces = function() {
        $scope.action('getAnnounces',{});
    };
    $scope.getAnnounces();


});


app.factory('dataStream',function($interval,$rootScope,$http,dSyncer){
    return {
        running : function() {
            $rootScope.dataStreamRunning = true;
            $rootScope.disconnected = false;
            $http.get("/stats",{timeout : 5900}).then(function(r){
                //console.log("First time initiated successfully");
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
                    dSyncer.stats();
                },function(r){
                    $rootScope.stats.pbx.activeCalls = 0;
                    $rootScope.disconnected = true;
                });
            },6000);
        }
    }
});


/*
app.service('liveData',function(Charts,dataEngine,$rootScope){
    //alert($rootScope.live)
    $rootScope.live = true;
    this.running = function() {
        dataEngine.stats();
        Charts.liveChart();
    }

});
 */


app.controller('ModalController',function($uibModalInstance,contents){
        var $pop = this;
        $pop.contents = contents;
        $pop.ok = function() { $uibModalInstance.close($pop.name);}
        $pop.cancel = function() { $uibModalInstance.dismiss($pop.name); }
    });

app.factory('popIn',function($uibModal){
        return {
            notify : function(size,contents) {
                var notify =  $uibModal.open({
                    templateUrl : '/jstemplates/htmls/modal_simplenotify.php',
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
                    resolve : { contents : function() { return contents;}}
                });
                notify.result.then(function(res){
                    console.log("Modal closed : " + res);
                },function(res){
                    console.log("Modal dismissed :" + res);
                });
            }

        }
    });



app.factory('dataEngine', function($http,$rootScope,$interval,dSyncer,popIn){
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
            path = "/data";
            console.log("Action : " + act);
            this.httpost(path, {r : act , p : p }).then(function(r){
                //console.log(act + " result : " + JSON.stringify(r.data));
                if ( r.data.result ) {
                    //agents = $rootScope.stats.pbx.agents;
                    switch(act) {
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
                        case 'deactivate' :
                            popIn.notify("sm",r.data);
                            $rootScope.stats.pbx.agents[p.id]["is_paused"] = '1';
                            console.log("Successfull deactivate of " + p.id + " : " + $rootScope.stats.pbx.agents[p.id]["is_paused"] );
                            break;
                        case 'addUser' :
                            popIn.notify("sm",r.data);
                            //angular.forEach(p,function(v,k){
                                //if ( k !== "enabled")
                                   // p[k] = null;
                            //});
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
                    popIn.notify("sm",r.data);
                    //$scope.errorsCollapse = false;
                    //$scope.errors = r.data.message;
                }
            });

        }
    };
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
            $rootScope.stats.pbx.waiting = b.pbx.waiting;
            $rootScope.stats.pbx.talking = b.pbx.talking;
            $rootScope.stats.pbx.answered = b.pbx.answered;
            $rootScope.stats.pbx.abandon = b.pbx.abandon;
            $rootScope.stats.pbx.agents_available = b.pbx.agents_available;
            //$rootScope.stats.pbx.agents = b.pbx.agents;
            $rootScope.stats.pbx.stations = b.pbx.stations;
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
            // Start : Syncing announces
            announces = $rootScope.stats.pbx.announces;
            n_announces = $rootScope.ntats.pbx.announces;
            angular.forEach($rootScope.ntats.pbx.announces,function(val,key){
                if ( typeof announces[key] === "undefined" || announces[key] === null ) {
                    //console.log("Type of key :" + key + " | typed : " + typeof key);
                    announces[key] = val;
                    //console.log("Val : " + JSON.stringify(announces));
                }
                else {
                    announce = announces[key];
                    n_announce = n_announces[key];
                    angular.forEach(announce,function(v,k){
                        if (  typeof n_announce[k] !== "undefined" || n_announce[k] != null )
                            if ( announce[k] !== n_announce[k] )
                                announce[k] = n_announce[k];
                    });
                }
            });
            angular.forEach(announces,function(val,key){
                if( typeof n_announces[key] === "undefined" || n_announces[key] === null )
                    delete announces[key];
            });
            // Syncing announces ends!

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
                exportEnabled : true,
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



