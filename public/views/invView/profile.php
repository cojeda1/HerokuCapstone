<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>View Report</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\..\node_modules\bootstrap\dist\css\bootstrap.min.css">
  <link rel="stylesheet" href="..\css\invProfile.css">
</head>

<body ng-app = 'homeApp' ng-controller="profileCtrl">

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

  <div class = "space" >

    <md-content>

      <div align="center">
        <h1>User Profile Information</h1>
      </div>

      <div class="container">
        <div class="field container">
          <div class="col-sm-6">
            <label>Investigator Name: </label>
          </div>
          <div class="col-sm-6">
            <label>{{profile_info[0].first_name}} {{profile_info[0].last_name}}</label>
          </div>
        </div>

        <div class="field container">
          <div class="col-sm-6">
            <label>Email: </label>
          </div>
          <div class="col-sm-6">
            <label>{{profile_info[0].email}}</label>
          </div>
        </div>

        <div class="field container">
          <div class="col-sm-6">
            <label>Job Title: </label>
          </div>
          <div class="col-sm-6">
            <label>{{profile_info[0].job_title}}</label>
          </div>
        </div>

        <div class="field container">
          <div class="col-sm-6">
            <label>Department: </label>
          </div>
          <div class="col-sm-6">
            <label>{{profile_info[0].department}}</label>
          </div>
        </div>

        <div class="field container">
          <div class="col-sm-6">
            <label>Office: </label>
          </div>
          <div class="col-sm-6">
            <label>{{profile_info[0].office}}</label>
          </div>
        </div>

        <div class="field container">
          <div class="col-sm-6">
            <label>Phone Number: </label>
          </div>
          <div class="col-sm-6">
            <label>{{profile_info[0].phone_number}}</label>
          </div>
        </div>

        <div class="field container">
          <div class="col-sm-6">
            <label>Employee ID: </label>
          </div>
          <div class="col-sm-6">
            <label>{{profile_info[0].employee_id}}</label>
          </div>
        </div>

      </div>

      <div class="edit-button" align="center">
        <md-button class="md-raised edit" ng-click="dialogBut($event)">Edit Information</md-button>
      </div>

      </div>

    </md-content>
  </div>

  <!-- MODAL SECTION -->
  <div style="visibility: hidden">
    <div class="md-dialog-container" id="myContainer">
      <md-dialog flex>
        <md-content class="md-padding">
          <form name="validated" ng-submit="validated.$valid && change()">
            <h1 align="center">Information to be Edited</h1>
            <div class="container">

              <md-input-container class="md-block">
                <label>Employee ID</label>
                <input class="inpt" type="text" value="{{profile_info[0].employee_id}}" required id="id"></input>
              </md-input-container>

              <md-input-container class="md-block">
                <label>Job Title</label>
                <input class="inpt" type="text" value="{{profile_info[0].job_title}}" required id="title"></input>
              </md-input-container>

              <md-input-container class="md-block">
                <label>Department</label>
                <input class="inpt" type="text" value="{{profile_info[0].department}}" required id="department"></input>
              </md-input-container>

              <md-input-container class="md-block">
                <label>Office</label>
                <input class="inpt" type="text" value="{{profile_info[0].office}}" required id="office"></input>
              </md-input-container>

              <md-input-container class="md-block">
                <label>Phone Number</label>
                <input class="inpt" min="0" type="text" value="{{profile_info[0].phone_number}}" required id="number"></input>
              </md-input-container>
              <label ng-show="warning" class="warning">*Phone number should be exactly 9 digits!</label>
              <label ng-show="warning1" class="warning">*It seems some of the fields are empty!</label>


            </div>

            <div class="container" align="center">
              <md-button class="md-raised confirm" type="submit">Submit</md-button>
              <md-button class="md-raised cancel" ng-click="hide()">Cancel</md-button>
            </div>
          </form>
        </md-content>
      </md-dialog>
    </div>
  </div>
</body>
