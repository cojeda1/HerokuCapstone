<DOCTYPE! html>

<head>

  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <!-- <link rel="stylesheet" href="..\..\..\node_modules\bootstrap\dist\css\bootstrap.min.css"> -->
  <link rel="stylesheet" type="text/css" href="..\css\notifPage.css">
  <title>CID.amex_report</title>
</head>


<body  ng-app='homeApp' ng-controller='notificationCtrl'>

  <div class="navStyle">
    <nav class = "navbar navbar-default">
      <div class = "container-fluid navMargin">
        <ul class="nav navbar-nav">
          <li><a ng-click = "viewHome()">HOME</a></li>
          <li><a ng-click = "createRep()">CREATE REPORT</a></li>
          <li><a ng-click = "viewTransactions()">TRANSACTIONS</a></li>
          <li><a class="white" ng-click = "viewCo()">CO-TRANSACTIONS</a></li>
          <li><a ng-click = "viewProfile()">PROFILE</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a ng-click="notifications()" ><span class="glyphicon glyphicon-envelope"></span></a></li>
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
        <h3>From Administrator:</h3>
      </div>
      <div class="border-table" ng-repeat="notification in notifs.notifications_from_admin">
        <div class="container">
          <div align="center">
            <label>{{notification.notification_body}}</label>
          </div>
        </div>
      </div>
    </div>

    <div class="user">
      <div align="center">
        <h3>From Accountant:</h3>
      </div>
      <div class="border-table" ng-repeat="notification in notifs.notifications_from_accountant">
        <div class="container">
          <div align="center">
            <label>{{notification.notification_body}}</label>
          </div>
        </div>
      </div>
    </div>

  </div>

</body>
