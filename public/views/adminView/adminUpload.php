<DOCTYPE! html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\..\node_modules\bootstrap\dist\css\bootstrap.min.css">
  <link rel="stylesheet" href="..\css\app.css">
  <link rel="stylesheet" href="..\css\adminUpload.css">

  <title>CID.amex_report</title>
</head>

<body>
  <div ng-app='myApp' ng-controller='uploadCtrl'>

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

    <div class="space">

      <div align="center" class="positioning">
        <div>
          <label>File: {{picture.file.name}} </label>
        </div>
        <md-button class="md-raised select"><div class="button" ngf-select ng-model="picture.file" name="file" ngf-pattern="'.xlsx,.xls'"
          ngf-accept="'.xlsx, .xls'" ngf-max-size="20MB" ngf-min-height="100"
          ngf-resize="{width: 100, height: 100}">
          Select From File System</md-button>
        </div></md-button>

        <div class="pad-top">
          <div>
            <md-button class="md-raised submit" ng-click="submit()">Submit</md-button>
            <md-button class="md-raised cancel" ng-click = "homeOpen()">Cancel</md-button>
          </div>
        </div>

      </div>

    </div>
  </div>

</body>
