<DOCTYPE! html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\..\node_modules\bootstrap\dist\css\bootstrap.min.css">
  <link rel="stylesheet" href="..\css\adminViewPR.css">

  <title>CID.amex_report</title>
</head>

<body>
  <div ng-app='myApp' ng-controller='myCtrl' class="main">
    <div class="navStyle">
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

    <div align="center">
      <h1>Transaction Report</h1><br>
    </div>

    <div class="field">
      <label>Transaction Number:</label><br>
      <input type="text" value="Number" readonly></input>
    </div>

    <div class="field">
      <label>Date:</label><br>
      <input type="text" value="Date" readonly></input>
    </div>

    <div class="field">
      <label>Location Name:</label><br>
      <input type="text" value="Location" readonly></input>
    </div>

    <div class="field">
      <label>Address:</label><br>
      <input type="text" value="Address" readonly></input>
    </div>

    <div class="field">
      <label>Telephone:</label><br>
      <input type="text" value="xxx-xxx-xxxx" readonly></input>
    </div>

    <div class="field">
      <label>Assigned Accountant:</label><br>
      <div class="container">
        <div class="col-sm-2">
          <h4>Accountant Name</h4>
        </div>

        <div class="col-sm-10">
          <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Edit</button>
        </div>
      </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Select Accountant</h4>
          </div>
          <div class="modal-body container">
            <div class="col-sm-6">
              <p>Repeat per Accountant<button type="button" class="btn btn-primary btn-sm">Select</button></p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Confirm</button>
          </div>
        </div>

      </div>
    </div>

  </div>

</body>
