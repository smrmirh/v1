<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/ADM-dateTimePicker.min.css">
    <link rel="stylesheet" href="/assets/css/sidebar.css">
    <link rel="stylesheet" href="/assets/css/animate.css">
    <link rel="stylesheet" href="/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="/assets/css/default.css?0.3">
</head>
<body ng-app="app">

@include('layout.nav')
@yield('home')
<growl-notifications></growl-notifications>
<div ng-controller="notifyController">
    <div ng-repeat="notif in notifications">
        <growl-notification class="shadow shadow-sm" ng-class="{ 'bg-success' : notif.result , 'bg-danger' : !notif.result }">
            @{{ notif.message }}
        </growl-notification>
    </div>
</div>
</body>
<script src="/assets/js/canvasjs.min.js"></script>
<script src="/assets/js/angular.min-1.6.1.js"></script>
<script src="/assets/js/ADM-dateTimePicker.min.js"></script>
<script src="/assets/js/angular-route.min-1.6.1.js"></script>
<script src="/assets/js/angular-animate.min-1.6.1.js"></script>
<!--<script src="/assets/js/angular-aria.min-1.6.1.js"></script>-->
<script src="/assets/js/angular-notifications.min.js"></script>
<script src="/assets/js/angular-sanitize.min-1.6.1.js"></script>
<script src="/assets/js/moment.min.js"></script>
<script src="/assets/js/angular-moment.min.js"></script>
<script src="/assets/js/angular-touch.min-1.6.1.js"></script>
<script src="/assets/js/ng-file-upload.js"></script>
<script src="/assets/js/ui-bootstrap-tpls-3.0.6.min.js"></script>
<script src="/assets/js/default.js?0.3"></script>
</html>