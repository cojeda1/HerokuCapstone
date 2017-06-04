<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Home</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\..\node_modules\bootstrap\dist\css\bootstrap.min.css">
  <link rel="stylesheet" href="..\css\app.css"> <!--Table-->
  <link rel="stylesheet" href="..\css\invHome.css"><!--Space(Margins)-->
  <link rel="stylesheet" href="..\css\admnHomestyle.css"><!--navbar-->
  <link rel="stylesheet" href="..\css\adminRecResult.css"><!--button lenght-->
</head>
<body>
<!---Navigation Bar--->
<div ng-app = "myApp" ng-controller="resultcntrl" class="space">
<md-content>
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
<!---Title and info--->
<h2> Account Reconciliation Result </h2>
<h4> Reconciliation Date: 20 February, 11:00 PM (2017)</h4>
<h4>Amount Errror: $25,468.47 </h4>
<!-- Table Report Errors -->
<h2 style="text-align:center">Report Errors:</h2>
<div class = "table-responsive">
  <div>
    <table class = "table table-hover">
      <thead>
        <tr>
          <th ng-click="tableSort('name')"><b>Investigator</b>
            <span class="glyphicon sort-icon"
                  ng-show="sortKey=='name'"
                  ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
            </span>
          </th>
          <th ng-click="tableSort('username')"><b>Accountant</b>
            <span class="glyphicon sort-icon"
                  ng-show="sortKey=='username'"
                  ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
            </span>
          </th>
          <th ng-click="tableSort('street')"><b>Total</b>
            <span class="glyphicon sort-icon"
                  ng-show="sortKey=='street'"
                  ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
            </span>
          </th>
          <th ng-click="tableSort('id')"><b>Total</b>
            <span class="glyphicon sort-icon"
                  ng-show="sortKey=='id'"
                  ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
            </span>
          </th>
          <th>
          </th>
        </tr>
      </thead>
      <tbody class="table">
        <tr dir-paginate ="user in users | orderBy:sortKey:reverse|itemsPerPage:pageSize">
          <td>{{user.name}}</td>
          <td>{{user.username}}</td>
          <td>{{user.address.street}}</td>
          <td>{{user.id |currency}}</td>
          <td><a href="viewreport.php"><img src = "expandIcon.png" alt = "view" height="20" width="20"></a></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="pagination">
<dir-pagination-controls
  max-size="100"
  direction-links = "true"
  boundary-links = "true"
>
</dir-pagination-controls>
</div>
<section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
  <md-button class = "md-raised md-primary colorchange">Download</md-button>
  <md-button class = "md-raised colorchange">Reconcile Again</md-button>
</section>
</md-content>
</body>
