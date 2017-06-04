<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Home</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\..\node_modules\bootstrap\dist\css\bootstrap.min.css">
  <!-- <link rel="stylesheet" href="..\..\css\app.css">
  <link rel="stylesheet" href="..\..\css\invHome.css"> -->
  <link rel="stylesheet" href="..\css\adminInvInformation.css">
</head>
<body ng-app = "myApp" ng-controller = "viewAnAdminCntrl">
  <!-- Navigation bar -->
<div class="navStyle">
<nav class = "navbar navbar-default">
<div class = "container-fluid navMargin">
  <ul class="nav navbar-nav">
    <li><a ng-click = "homeOpen()">HOME</a></li>
    <li><div class = "dropdown">
      <button class ="dropbtn">CREATE USER</button>
      <div class = "dropdown-content">
        <a class="choice" ng-click = "createInv()">Create Investigator</a>
        <a class="choice" ng-click = "createAccOpen()">Create Accountant</a>
        <a class="choice" ng-click = "createAdmin()">Create Admin</a>
      </div>
    </div></li>
    <li><div class = "dropdown">
      <button class ="dropbtn">RECONCILIATION</button>
      <div class = "dropdown-content">
        <a ng-click="excelUpload()">Upload Account Status</a>
        <a ng-click="excelResults()">Reconciliation Result</a>
      </div>
    </div></li>
    <li><div class = "dropdown">
      <button class ="dropbtn">VIEW</button>
      <div class = "dropdown-content">
        <a ng-click="viewCycle()">Purchase Reports</a>
        <a ng-click= "ccOpen()" >Credit Cards</a>
        <a ng-click="usersOpen()">Users</a>
      </div>
    </div></li>
  </ul>
</div>
</nav>
</div>

  <div class="space">
    <md-content>

      <h1 align='center'> Admin Information</h1>
      <div class = "row">
        <div class = "col-sm-6">
          <h6> First Name: <h6>
        </div>
          <div class = "col-sm-6 info">
            {{admin_info.first_name}}
          </div>
      </div>
      <div class="row">
        <div class = "col-sm-6">
          <h6> Last Name:  </h6>
        </div>
        <div class = "col-sm-6 info">
          {{admin_info.last_name}}
        </div>
      </div>
      <div class="row">
        <div class = "col-sm-6">
          <h6> Department:  </h6>
        </div>
        <div class = "col-sm-6 info">
          {{admin_info.department}}
        </div>
      </div>
      <div class = "row">
        <div class="col-sm-6">
          <h6> Office:      </h6>
        </div>
        <div class="col-sm-6 info">
          {{admin_info.office}}
        </div>
      </div>
      <div class = "row">
        <div class = "col-sm-6">
          <h6> Phone Number: </h6>
        </div>
        <div class = "col-sm-6 info">
          {{admin_info.phone_number}}
        </div>
      </div>
      <div class = "row">
        <div class="col-sm-6">
          <h6> Job Title </h6>
        </div>
        <div class="col-sm-6 info">
          {{admin_info.job_title}}
        </div>
      </div>
      <div class = "row">
        <div class="col-sm-6">
          <h6> Email: </h6>
        </div>
        <div class="col-sm-6 info">
          {{admin_info.email}}
        </div>
      </div>

      <md-button class = "md-raised md-primary" ng-click ="disableAdmin($event)">
        Disable Admin
      </md-button>
    </md-content>
  </div>

  <script src="..\..\..\node_modules\angular\angular.js"></script>
  <script src="..\..\..\node_modules\angular-material\angular-material.js"></script>
  <script src="..\..\..\node_modules\angular-route\angular-route.js"></script>
  <script src="..\..\..\node_modules\angular-utils-pagination\dirPagination.js"></script>
  <script src="..\..\..\node_modules\angular-aria\angular-aria.js"></script>
  <script src="..\..\..\node_modules\angular-animate\angular-animate.js"></script>
  <script src="..\..\..\node_modules\angular-ui-router\release\angular-ui-router.js"></script>
  <script src="..\..\js\admin\mainAdminController.js"></script>
</body>
