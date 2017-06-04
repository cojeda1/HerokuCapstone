<DOCTYPE! html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <!-- <link rel="stylesheet" href="..\..\..\node_modules\bootstrap\dist\css\bootstrap.min.css"> -->
  <link rel="stylesheet" href="..\css\adminAddAccountant.css">
  <title>CID.amex_report</title>
</head>
<body  ng-app='myApp' ng-controller='createAccCntrl'>
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
    <!--- Title --->
      <div align="center">
        <h1>Create Accountant Account</h1><br>
      </div>
    <!-- form --->
    <form class = "form-horizontal" name = "register" ng-submit="register.$valid && createAccountant($event) "  >
      <div class = "form-group" >
              <div class="container field">
                <div class="col-sm-6">
                  <label>First Name</label>
                </div>
                <div class="col-sm-6">
                  <md-input-container class = "md-block">
                    <input class="inpt" required type="text" id= "firstName"></input>
                  </md-input-container>
                </div>
              </div>
              <div class="container field">
                <div class="col-sm-6">
                  <label>Last Name</label>
                </div>
                <div class="col-sm-6">
                  <md-input-container class = "md-block">
                  <input class="inpt" required type="text" id = "lastName"></input>
                  </md-input-container>
                </div>
              </div>

              <div class="container field">
                <div class="col-sm-6">
                  <label>Department</label>
                </div>
                <div class="col-sm-6">
                  <md-input-container class="md-block">
                    <input class="inpt" type="text" id = "department"></input>
                  </md-input-container>
                </div>
              </div>

              <div class="container field">
                <div class="col-sm-6">
                  <label>Office</label>
                </div>
                <div class="col-sm-6">
                  <md-input-container class="md-block">
                    <input class="inpt" type="text" id = "office"></input>
                  </md-input-container>
                </div>
              </div>

              <div class="container field">
                <div class="col-sm-6">
                  <label>Phone Number</label>
                </div>
                <div class="col-sm-6">
                  <md-input-container class="md-block">
                  <input
                  class="inpt"
                  required type="text"
                  id="phoneNumber"
                  ng-model ="phone"
                  placeholder="Phone Number"
                  minlength ="10"
                  md-maxlength="11"
                  ng-minlength ="10">
                </input>
                <div ng-message = "minlength">
                  Phone number must be atleast 10 numbers!
                </div>
                </md-input-container>
                </div>
              </div>

              <div class="container field">
                <div class="col-sm-6">
                  <label>Job</label>
                </div>
                <div class="col-sm-6">
                  <md-input-container class="md-block">
                    <input class="inpt" required type="text" id = "job"></input>
                  </md-input-container>
                </div>
              </div>

              <div class="container field">
                <div class="col-sm-6">
                  <label>Email</label>
                </div>
                <div class="col-sm-6">
                  <md-input-container class="md-block">
                    <input class="inpt" type="email" id = "email" name="email" ng-model="email"></input>
                    <span ng-show = "register.email.$touched && register.email.$invalid">
                      Invalid email!
                    </span>
                  </md-input-container>
                </div>
              </div>
              <div class="container field">
                <div class="col-sm-6">
                  <label>Password</label>
                </div>
                <div class="col-sm-6">
                  <md-input-container class="md-block">
                    <input class="inpt" required type="password" id = "password"></input>
                  </md-input-container>
                </div>
              </div>
              <div class="container buttonpad">
                <br>
                <div class="addInv" align="center" >
                  <h3>Assigned Investigators</h3>
                  <div class="container" ng-repeat = "inv in selected_researchers track by $index">
                    <p>{{inv.researcher_first_name}} {{inv.researcher_last_name}} <span class="glyphicon glyphicon-remove-sign" ng-click ="deleteInv(inv)"></span></p>
                  </div>
                </div>
                <div class="col-sm-12" align="center">
                  <br>
                  <md-button type="button" class="md-raised add" ng-click ="addInv($event)">Add Investigator</md-button>
                </div>
              </div>

              <div class="container" align"center">
                <div class="col-sm-6" align="center">
                  <md-button type="submit" class="md-raised button-change create"
                  ng-disabled = "(register.email.$touched && register.email.$invalid) || (register.phone.$touched && register.phone.$error.minlength)"
                  >Create</button>
                </div>
                <div class="col-sm-6" align="center">
                  <md-button type="button" class="md-raised button-change cancel" ng-click="homeOpen()">Cancel</md-button>
                </div>
              </div>
            </div>
          </form>
        </md-content>
      </div>
</body>
