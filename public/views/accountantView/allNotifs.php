<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Home</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="..\..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\..\..\node_modules\bootstrap\dist\css\bootstrap.min.css">
  <!-- <link rel="stylesheet" href="..\..\css\app.css"> -->
  <link rel="stylesheet" href="..\..\css\notifPage.css">
</head>

<body ng-app='HomeApp' ng-controller='notificationCtrl'>

  <div class="navStyle">
    <nav class = "navbar navbar-default">
      <div class = "container-fluid navMargin">
        <ul class="nav navbar-nav">
          <li><a ng-click = "homeOpen()">HOME</a></li>
          <li><a ng-click = "reportsOpen()">REPORTS</a></li>
          <li><a ng-click = "auditedReport()">MY HISTORY</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a ng-click="notifications($event)" ><span class="glyphicon glyphicon-envelope"></span></a></li>
        </ul>
     </div>
    </nav>
  </div>

  <div class="space">

    <div>
      <h1 align="center">Notifications</h1>
    </div>

    <div class="user">
      <div align="center">
        <h3>Assigned By Yourself:</h3>
      </div>
      <div class="border-table" ng-repeat="notification in notifs.accountant_assign">
        <div class="container">
          <div align="center">
            <label>{{notification.notification_body}}</label>
          </div>
        </div>
      </div>
    </div>

    <div class="user">
      <div align="center">
        <h3>Assigned By Administrator:</h3>
      </div>
      <div class="border-table" ng-repeat="notification in notifs.admin_assign">
        <div class="container">
          <div align="center">
            <label>{{notification.notification_body}}</label>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
