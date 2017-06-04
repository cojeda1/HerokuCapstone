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
  <link rel="stylesheet" href="..\css\adminEditInv.css">
</head>


<body>
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
      <h1 align='center'> Investigator Information</h1>
      <div class="container">
        <form name="validate" ng-submit="validate.$valid && test($event)">
        <div class = "row">
          <div class = "col-sm-6">
            <h6> First Name: <h6>
          </div>
            <div class = "col-sm-6">
              <md-input-container>
              <input class="inpt" required type="text" id="firstName"></input>
            </md-input-container>
            </div>
        </div>
        <div class="row">
          <div class = "col-sm-6">
            <h6> Last Name:  </h6>
          </div>
          <div class = "col-sm-6">
            <md-input-container>
            <input class="inpt" required type="text" id="lastName"></input>
          </md-input-container>
          </div>
        </div>
        <div class="row">
          <div class = "col-sm-6">
            <h6> Department:  </h6>
          </div>
          <div class = "col-sm-6">
            <md-input-container>
            <input class="inpt" required type="text" id="department"></input>
          </md-input-container>
          </div>
        </div>
        <div class = "row">
          <div class="col-sm-6">
            <h6> Office:      </h6>
          </div>
          <div class="col-sm-6">
            <md-input-container>
            <input class="inpt" required type="text" id="office"></input>
          </md-input-container>
          </div>
        </div>
        <div class = "row">
          <div class = "col-sm-6">
            <h6> Phone Number: </h6>
          </div>
          <div class = "col-sm-6">
            <md-input-container>
            <input class="inpt" required type="text" id="phoneNumber"
            ng-model="phone"
            minlength="10"
            ng-minlength ="10"
            >
            </input>
          </md-input-container>
          </div>
        </div>
        <div class = "row">
          <div class="col-sm-6">
            <h6> Job Title </h6>
          </div>
          <div class="col-sm-6">
            <md-input-container>
            <input class="inpt" required type="text" id="jobTitle"></input>
          </md-input-container>
          </div>
        </div>
        <div class = "row">
          <div class="col-sm-6">
            <h6> Email: </h6>
          </div>
          <div class="col-sm-6">
            <md-input-container>
            <input class="inpt" required type="email" id="email"></input>
            <span ng-show = "validate.email.$touched && validate.email.$invalid">
              Invalid email!
            </span>
          </md-input-container>
          </div>
        </div>
        <div class = "row">
          <div class="col-sm-6">
            <h6> Employee ID: </h6>
          </div>
          <div class="col-sm-6">
            <md-input-container>
            <input class="inpt" required type="text" id="employeeID"></input>
          </md-input-container>
          </div>
        </div>
        <div class = "row">
          <div class="col-sm-6">
            <h6> AMEX ID: </h6>
          </div>
          <div class="col-sm-6">
            <md-input-container>
            <input class="inpt" required type="text" id="amexID"></input>
          </md-input-container>
          </div>
        </div>

        <div class = "row">
          <div class="col-sm-6">
            <h6> Card Number: </h6>
          </div>
          <div class="col-sm-6">
            <md-input-container>
            <input class="inpt" required type="text" id="cardNumber"></input>
          </md-input-container>
          </div>
        </div>
        <div class = "row">
          <div class = "col-sm-6">
            <h6> Expiration Date </h6>
          </div>
          <div class = "col-sm-6">
            <md-input-container>
            <input class="inpt" required type="text" id="expiration"></input>
          </md-input-container>
          </div>
        </div>
        <div class = "row">
          <div class = "col-sm-6">
            <h6>Name on Card: </h6>
          </div>
          <div class = "col-sm-6">
            <md-input-container>
            <input class="inpt" required type="text" id="cardName"></input>
          </md-input-container>
          </div>
        </div>
        <div class = "row">
          <div class = "col-sm-6">
            <h6>Assigned Accountant: </h6>
          </div>
          <div class = "col-sm-3">
            <md-input-container>
            <input class="inpt" required type="text" id="accountant" readonly></input>
          </md-input-container>
          </div>
          <div class="col-sm-3">
            <md-button class="md-raised edit" data-toggle="modal" data-target="#myModal">Change Accountant</md-button>
          </div>
        </div>
        <div class="container">
          <md-button class="md-raised buttonfloat edit" data-toggle="modal" data-target="#modal">Assign New Credit Card</md-button>
        </div>
        <div>
          <md-button class="md-raised edit" type="submit">Confirm</md-button>
        </div>
      </form>
    </div>

      <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <div align="center">
                <h4>Accountant List</h4>
              </div>
            </div>
            <div class="modal-body container">
              <div ng-repeat="accountant in accountants">
                <div class="col-sm-6">
                  {{accountant.accountant_info.first_name}} {{accountant.accountant_info.last_name}}
                </div>
                <div class="col-sm-6">
                  <md-button class="md-raised edit" ng-click="add(accountant)" data-dismiss="modal">Select</md-button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <form name="credit" ng-submit="credit.$valid && create($event)">

            <div class="modal-header">
              <div align="center">
                <h4>Assign New Credit Card</h4>
              </div>
            </div>
            <div class="modal-body container">
              <div class="container">
                <div class="col-sm-6">
                  <label>Name on Card</label>
                </div>
                <div class="col-sm-6">
                  <md-input-container>
                  <input class="inpt" required type="text" id="cardName1"></input>
                </md-input-container>
                </div>
              </div>

              <div class="container">
                <div class="col-sm-6">
                  <label>Card Number</label>
                </div>
                <div class="col-sm-6">
                  <md-input-container>
                  <input class="inpt" required type="text" id="cardNumber1"></input>
                </md-input-container>
                </div>
              </div>

              <div class="container">
                <div class="col-sm-6">
                  <label>Expiration Date</label>
                </div>
                <div class="col-sm-6">
                  <md-input-container>
                  <input class="inpt" required type="text" id="expiration1"></input>
                </md-input-container>
                </div>
              </div>

              <div class="container">
                <div class="col-sm-6">
                  <label>Reason</label>
                </div>
                <div class="col-sm-6">
                  <md-input-container>
                  <input class="inpt" required type="text" id="reason"></input>
                </md-input-container>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <div align="center">
                <md-button type="submit" class="md-raised edit">Create</md-button>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>

    </md-content>
  </div>


</main>

</body>
