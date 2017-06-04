<DOCTYPE! html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="..\..\..\node_modules\angular-material\angular-material.min.css">
  <!-- <link rel="stylesheet" href="..\..\..\node_modules\bootstrap\dist\css\bootstrap.min.css"> -->
  <link rel="stylesheet" href="..\..\css\adminAddAccountant.css">
  <title>CID.amex_report</title>
</head>
<body>
  <div ng-app='myApp' ng-controller='viewAnAccCntrl' class="main">
  <main ui-view>
    <!-- Navigation bar -->
  <nav class = "navbar navbar-default">
    <div class = "container-fluid">
      <ul class="nav navbar-nav">
        <li><a ng-click = "homeOpen()">HOME</a></li>
        <li><div class = "dropdown">
          <button class ="dropbtn">CREATE USER</button>
          <div class = "dropdown-content">
            <a ng-click = "createInvOpen()">Create Investigator</a>
            <a href="#">Create Accountant</a>
          </div>
        </div></li>
        <li><div class = "dropdown">
          <button class ="dropbtn">RECONCILIATION</button>
          <div class = "dropdown-content">
            <a href="#">Upload Account Status</a>
            <a href="#">Reconciliation Result</a>
          </div>
        </div></li>
        <li><div class = "dropdown">
          <button class ="dropbtn">VIEW</button>
          <div class = "dropdown-content">
            <a href="#">Purchase Reports</a>
            <a ng-click= "ccOpen()" >Credit Cards</a>
            <a ng-click="usersOpen()">Users</a>
          </div>
        </div></li>
      </ul>
   </div>
  </nav>
    <div align="center">
      <h1>Create Accountant Account</h1><br>
    </div>
    <div class="container field">
      <div class="col-sm-6">
        <label>First Name</label>
      </div>
      <div class="col-sm-6">
        <input type="text" id= "firstName" placeholder="{{acc[0].first_name}}"></input>
      </div>
    </div>
    <div class="container field">
      <div class="col-sm-6">
        <label>Last Name</label>
      </div>
      <div class="col-sm-6">
        <input type="text" id = "lastName" placeholder="{{acc[0].last_name}}"></input>
      </div>
    </div>

    <div class="container field">
      <div class="col-sm-6">
        <label>Department</label>
      </div>
      <div class="col-sm-6">
        <input type="text" id = "department" placeholder="{{acc[0].department}}"></input>
      </div>
    </div>

    <div class="container field">
      <div class="col-sm-6">
        <label>Office</label>
      </div>
      <div class="col-sm-6">
        <input type="text" id = "office" placeholder="{{acc[0].office}}"></input>
      </div>
    </div>

    <div class="container field">
      <div class="col-sm-6">
        <label>Phone Number</label>
      </div>
      <div class="col-sm-6">
        <input type="number" id = "phoneNumber" placeholder="{{acc[0].phone_number}}"></input>
      </div>
    </div>

    <div class="container field">
      <div class="col-sm-6">
        <label>Job</label>
      </div>
      <div class="col-sm-6">
        <input type="text" id = "job" placeholder="{{acc[0].job_title}}"></input>
      </div>
    </div>

    <div class="container field">
      <div class="col-sm-6">
        <label>Email</label>
      </div>
      <div class="col-sm-6">
        <input type="text" id = "email" placeholder="{{acc[0].email}}"></input>
      </div>
    </div>

    <div class="container">
      <br>
      <div class="addInv" align="center" >
        <h3>Assigned Investigators</h3>
        <div class="container" ng-repeat = "ai in assigned_investigators">
          <p>{{ai.first_name}} {{ai.last_name}} <span class="glyphicon glyphicon-remove-sign" ng-click ="deleteInv(ai)"></span></p>
        </div>
      </div>
      <div class="col-sm-12" align="center">
        <br>
        <button type="button" class="btn btn-info btn-md col-sm-12" ng-click ="addInv($event)">Add Investigator</button>
      </div>
    </div>

    <div class="container" align"center">
      <div class="col-sm-6" align="center">
        <button type="button" class="btn btn-lg btn-success" ng-click = "done()">Done Editing</button>
      </div>
      <div class="col-sm-6" align="center">
        <button type="button" class="btn btn-lg btn-danger" ng-click = "cancel()">Cancel</button>
      </div>
    </div>
  </div>

  <script src="..\..\..\node_modules\angular\angular.js"></script>
  <script src="..\..\..\node_modules\angular-material\angular-material.js"></script>
  <script src="..\..\..\node_modules\angular-route\angular-route.js"></script>
  <script src="..\..\..\node_modules\angular-utils-pagination\dirPagination.js"></script>
  <script src="..\..\..\node_modules\angular-aria\angular-aria.js"></script>
  <script src="..\..\..\node_modules\angular-animate\angular-animate.js"></script>
  <script src="..\..\app\mainAdminController.js"></script>
</main>
</body>
