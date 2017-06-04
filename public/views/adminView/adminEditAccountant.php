<DOCTYPE! html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\..\node_modules\bootstrap\dist\css\bootstrap.min.css">
  <link rel="stylesheet" href="..\css\adminEditAccountant.css">

  <title>CID.amex_report</title>
</head>

<body  ng-app='myApp' ng-controller='editAccCntrl'>

    <!-- Navigation bar -->
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

  <div class="main">
    <md-content>

<!--title-->
    <div align="center">
      <h1>Edit Accountant Account</h1><br>
    </div>
<!--form-->
<form name="validate" ng-submit="validate.$valid">
  <div class="container field">
    <div class="col-sm-6">
      <label>First Name</label>
    </div>
    <div class="col-sm-6">
      <md-input-container>
        <input class="inpt" required type="text" id= "firstName" value="{{acc[0].first_name}}"></input>
      </md-input-container>
    </div>
  </div>
  <div class="container field">
    <div class="col-sm-6">
      <label>Last Name</label>
    </div>
    <div class="col-sm-6">
      <md-input-container>
        <input class="inpt" required type="text" id = "lastName" value="{{acc[0].last_name}}"></input>
      </md-input-container>
    </div>
  </div>

  <div class="container field">
    <div class="col-sm-6">
      <label>Department</label>
    </div>
    <div class="col-sm-6">
      <md-input-container>
        <input class="inpt" required type="text" id = "department" value="{{acc[0].department}}"></input>
      </md-input-container>
    </div>
  </div>

  <div class="container field">
    <div class="col-sm-6">
      <label>Office</label>
    </div>
    <div class="col-sm-6">
      <md-input-container>
        <input class="inpt" required type="text" id = "office" value="{{acc[0].office}}"></input>
      </md-input-container>
    </div>
  </div>

  <div class="container field">
    <div class="col-sm-6">
      <label>Phone Number</label>
    </div>
    <div class="col-sm-6">
      <md-input-container>
        <input
        class="inpt"
        required
        type="text"
        id = "phoneNumber"
        value ="{{acc[0].phone_number}}"
        ng-model ="phone"
        minlength ="10"
        md-maxlength="10">
      </input>
      </md-input-container>
    </div>
  </div>

  <div class="container field">
    <div class="col-sm-6">
      <label>Job</label>
    </div>
    <div class="col-sm-6">
      <md-input-container>
        <input class="inpt" required type="text" id = "job" value="{{acc[0].job_title}}"></input>
      </md-input-container>
    </div>
  </div>

  <div class="container field">
    <div class="col-sm-6">
      <label>Email</label>
    </div>
    <div class="col-sm-6">
      <md-input-container>
        <input class="inpt" required type="text" id = "email" value="{{acc[0].email}}"></input>
        <span ng-show = "validate.email.$touched && validate.email.$invalid">
          Invalid email!
        </span>
      </md-input-container>
    </div>
  </div>
    <div class="container">
      <br>
      <div class="addInv" align="center">
        <h3>Assigned Investigators</h3>
        <div class="container" ng-repeat= "as in assigned_investigators">
          <p>{{as.first_name}} {{as.last_name}}<span class="glyphicon glyphicon-remove-sign" ng-click= 'deleteInv(as)'></span></p>
        </div>
      </div>
      <div class="col-sm-12" align="center">
        <br>
        <md-button type="button" class="md-raised add" ng-click='addInv($event)'>Add Investigator</md-button>
      </div>
    </div>

    <div class="container" align"center">
      <div class="col-sm-6" align="center">
      <md-button class="md-raised confirm" type="submit" ng-click="test($event)">Confirm</md-button>
      </div>
      <div class="col-sm-6" align="center">
        <md-button type="button" class="md-raised cancel" ng-click="close()">Cancel</md-button>
      </div>
    </div>
    </form>
  </md-content>
  </div>

</body>
