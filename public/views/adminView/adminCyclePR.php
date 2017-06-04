<DOCTYPE! html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\..\node_modules\bootstrap\dist\css\bootstrap.min.css">
  <!-- <link rel="stylesheet" href="..\..\css\app.css"> -->
  <link rel="stylesheet" href="..\css\adminCyclePR.css">
  <title>CID.amex_report</title>
</head>

<body ng-app='myApp' ng-controller='viewCycle'>
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
    <md-content>
      <div align="center">
        <h1>{{formattedDate}} {{status}} Purchase Reports</h1>
      </div>

      <div class = "container">
        <form>
          <div class = "form-group">
            <div class = "row">
            <div class = "col-sm-2">
              <md-input-container>
                <label>Status</label>
                <md-select ng-model="status" >
                  <md-optgroup>
                    <md-option ng-value="s" ng-repeat="s in statuses">{{s}}</md-option>
                  </md-optgroup>
                </md-select>
              </md-input-container>
            </div>
            <div class="col-sm-2">
              <md-input-container>
                <label>Month</label>
                <md-select ng-model="month" >
                  <md-optgroup>
                    <md-option ng-value="m" ng-repeat="m in months">{{m}}</md-option>
                  </md-optgroup>
                </md-select>
              </md-input-container>
              <md-input-container>
                <label>Year</label>
                <md-select ng-model="year" >
                  <md-optgroup>
                    <md-option ng-value="y" ng-repeat="y in years">{{y}}</md-option>
                  </md-optgroup>
                </md-select>
              </md-input-container>
            </div>
            <div class = "col-sm-2">
              <md-button class= "md-raised md-primary" ng-click = "viewCycle()">
                View Selected Cycle
              </md-button>
            </div>
            <div class = "col-sm-2">
              <md-button class = "md-raised" ng-click = "viewAll()"> View All transactions</md-button>
            </div>
          </div>
        </div>
        </form>

      </div>
      <div class = 'row'>
        <div class = "col-md-12">
          <input type = "text" ng-model="search" class = "form-control search-bar search" placeholder="Search">
        </div>
      </div>
      <div class = "col-lg-12 table-responsive">
        <div>
          <table class = "table table-hover">
            <thead>
              <tr>
                <th><b>Investigator</b>
                  <span class="glyphicon sort-icon"
                        ng-show="sortKey=='userId'"
                        ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                  </span>
                </th>
                <th><b>Submission Date</b>
                  <span class="glyphicon sort-icon"
                        ng-show="sortKey=='id'"
                        ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                  </span>
                </th>
                <th><b>Location of Purchase</b>
                  <span class="glyphicon sort-icon"
                        ng-show="sortKey=='title'"
                        ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                  </span>
                </th>
                <th><b>Status</b>
                  <span class="glyphicon sort-icon"
                        ng-show="sortKey=='title'"
                        ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                  </span>
                </th>
                <th>
                </th>
              </tr>
            </thead>
            <tbody class="table">
              <tr dir-paginate ="report in reports | orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize">
                <td>{{report.researcher_first_name}}</td>
                <td>
                <div>{{report.created_at}}</div>
                </td>
                <td>{{report.company_name}}</td>
                <td>{{report.status}}</td>
                <td><a ng-click="purchase(report.transaction_id)"><span class="glyphicon glyphicon-open-file"></span></a></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </md-content>
  </div>
</body>
