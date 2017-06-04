<DOCTYPE! html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\..\node_modules\bootstrap\dist\css\bootstrap.min.css">
  <!-- <link rel="stylesheet" href="..\..\css\app.css"> -->
  <link rel="stylesheet" href="..\css\adminCreditCards.css">
  <title>CID.amex_report</title>
</head>

<body ng-app='myApp' ng-controller='crediCardsctrl'>

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

      <div align="center">
        <h1>Credit Cards</h1>
      </div>

      <div class = "container"
        <form>
          <div class = "form-group">
            <div class = "col-sm-12">
              <input type = "text" ng-model="search" class = "form-control search-bar search" placeholder="Search">
            </div>
          </div>
        </form>
      </div>

    <div class = "col-lg-12">
      <div>
        <table class = "table table-hover">
          <thead>
            <tr>
              <th ng-click="tableSort('userId')"><b>Credit Card Number</b>
                <span class="glyphicon sort-icon"
                      ng-show="sortKey=='userId'"
                      ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                </span>
              </th>
              <th ng-click="tableSort('id')"><b>Investigator</b>
                <span class="glyphicon sort-icon"
                      ng-show="sortKey=='id'"
                      ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                </span>
              </th>
              <th ng-click="tableSort('title')"><b>Accountant</b>
                <span class="glyphicon sort-icon"
                      ng-show="sortKey=='title'"
                      ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                </span>
              </th>
              <th ng-click="tableSort('title')"><b>Credit Card Status</b>
                <span class="glyphicon sort-icon"
                      ng-show="sortKey=='title'"
                      ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                </span>
              </th>
            </tr>
          </thead>
          <tbody class="table">
            <tr dir-paginate ="creditCard in creditCards | orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize">
              <td>{{creditCard.credit_card_number}}</td>
              <td>{{creditCard.researcher_first_name + " "+ creditCard.researcher_last_name}}</td>
              <td>{{creditCard.accountant_first_name+ " "+ creditCard.accountant_last_name}}</td>
              <td>
                <div ng-show= "creditCard.is_active== '0'">Expired</div>
                <div ng-show = "creditCard.is_active == '1'">Active </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </md-content>
  </div>
</body>
