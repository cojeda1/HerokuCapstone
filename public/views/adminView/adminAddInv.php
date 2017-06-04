<DOCTYPE! html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\..\node_modules\bootstrap\dist\css\bootstrap.min.css">
  <link rel="stylesheet" href="..\css\adminAddInv.css">

  <title>CID.amex_report</title>
</head>

<body  ng-app='myApp' ng-controller='createInv'>
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
        <h1>Create Investigator Account</h1><br>
      </div>
      <!-- Form --->
    <form name="validate" ng-submit="validate.$valid && submit($event)">
      <div class = "form-group">
        <div class="container field">
          <div class="col-sm-6">
            <label>First Name</label>
          </div>
          <div class="col-sm-6">
            <md-input-container class="md-block">
            <input class="inpt" required type="text" id="firstName"></input>
          </md-input-container>
          </div>
        </div>

        <div class="container field">
          <div class="col-sm-6">
            <label>Last Name</label>
          </div>
          <div class="col-sm-6">
            <md-input-container class="md-block">
            <input class="inpt" required type="text" id="lastName"></input>
          </md-input-container>
          </div>
        </div>

        <div class="container field">
          <div class="col-sm-6">
            <label>Department</label>
          </div>
          <div class="col-sm-6">
            <md-input-container class="md-block">
            <input class="inpt" required type="text" id="department"></input>
          </md-input-container>
          </div>
        </div>

        <div class="container field">
          <div class="col-sm-6">
            <label>Office</label>
          </div>
          <div class="col-sm-6">
            <md-input-container class="md-block">
            <input class="inpt" required type="text" id="office"></input>
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
            <input class="inpt" required type="text" id="job_title"></input>
          </md-input-container>
          </div>
        </div>

        <div class="container field">
          <div class="col-sm-6">
            <label>Email</label>
          </div>
          <div class="col-sm-6">
            <md-input-container class="md-block">
              <input class="inpt" required type="email" name = "email"ng-model = "email" id="email"></input>
              <span ng-show = "validate.email.$touched && validate.email.$invalid">
                Invalid email!
              </span>
            </md-input-container>
          </div>
        </div>

        <div class="container field">
          <div class="col-sm-6">
            <label>Password: </label>
          </div>
          <div class="col-sm-6">
            <md-input-container class="md-block">
            <input class="inpt" required type="password" id="password"></input>
          </md-input-container>
          </div>
        </div>

        <div class="container field">
          <div class="col-sm-6">
            <label>Amex Account ID: </label>
          </div>
          <div class="col-sm-6">
            <md-input-container class="md-block">
            <input class="inpt" required type="text" id="amexID"></input>
          </md-input-container>
          </div>
        </div>

        <div class="container field">
          <div class="col-sm-6">
            <label>Employee ID: </label>
          </div>
          <div class="col-sm-6">
            <md-input-container class="md-block">
            <input class="inpt" required type="text" id="empID"></input>
          </md-input-container>
          </div>
        </div>

          <div align="center">
            <h3>Credit Card Information</h3>
          </div>

          <div class="container field">
            <div class="col-sm-6">
              <label>Card Number</label>
            </div>
            <div class="col-sm-6">
              <md-input-container class="md-block">
              <input class="inpt" required type="text" id="cardNumber"></input>
            </md-input-container>
            </div>
          </div>

          <div class="container field">
            <div class="col-sm-6">
              <label>Expiration Date</label>
            </div>
            <div class="col-sm-6">
              <select id="month">
                <option ng-repeat="month in months" value="{{month}}">{{month}}</option>
              </select>
              <select id="year">
                <option ng-repeat="year in years" value="{{year.value}}">{{year.label}}</option>
              </select>
            </div>
          </div>

          <div class="container field">
            <div class="col-sm-6">
              <label>Name of Card</label>
            </div>
            <div class="col-sm-6">
              <md-input-container class="md-block">
              <input class="inpt" required type="text" id="cardName"></input>
            </md-input-container>
            </div>
          </div>

          <div class="container accountant">
            <label>Assigned Accountant: <md-button type="button" class="md-raised create" data-toggle="modal" data-target="#myModal">Select</md-button></label>
            <span ng-show = "selectedAcc != ' '">Selected Accountant is: {{selectedAcc}}</span>
          </div>

          <div class="container" align"center">
            <div class="col-sm-6" align="center">
              <md-button type="submit"
              class="md-raised create button-change"
              ng-disabled = "(validate.email.$touched && validate.email.$invalid) || (validate.phone.$touched && validate.phone.$error.minlength)">
              Create</md-button>
            </div>
            <div class="col-sm-6" align="center">
              <md-button type="button" class="md-raised cancel button-change" ng-click="homeOpen()">Cancel</md-button>

            </div>
          </div>
      </div>
    </form>

      <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Select Accountant</h4>
            </div>
            <div class="modal-body container">
              <div class="container" ng-repeat="accountant in accountants">
                <div class="col-sm-6">
                  <h4>{{accountant.accountant_info.first_name}} {{accountant.accountant_info.last_name}}</h4>
                </div>
                <div class="col-sm-6">
                  <md-button class="md-raised create" data-dismiss="modal" ng-click="getID(accountant)">Add</md-button>
                </div>
              </div>
            </div>
            <div class="modal-footer">
            </div>
          </div>

        </div>
      </div>
    </md-content>
  </div>
</body>
