<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Home</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\..\node_modules\bootstrap\dist\css\bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- <link rel="stylesheet" href="..\..\css\app.css">
  <link rel="stylesheet" href="..\..\css\invHome.css"> -->
  <link rel="stylesheet" href="..\css\admnHomestyle.css">
</head>
<body>
  <div ng-app='myApp' ng-controller='homeCtrl'>
    <main ui-view>
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
          <h2 "text-align:center">Recent Purchase Reports</h2>
          <!-- Search ---->
          <div class = "row"
            <form>
              <div class = "form-group">
                <div class = "col-sm-12">
                  <input type = "text" ng-model="search" class = "form-control search-bar search" placeholder="Search">
                </div>
              </div>
            </form>
          </div>
            <!-- Table  -->
            <div class = "col-lg-12">
              <div >
                <table class = "table table-hover">
                  <thead>
                    <tr>
                      <th ng-click="tableSort('userId')"><b>Researcher</b>
                        <span class="glyphicon sort-icon"
                              ng-show="sortKey=='userId'"
                              ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                        </span>
                      </th>
                      <th ng-click="tableSort('id')"><b>Assigned Accountant</b>
                        <span class="glyphicon sort-icon"
                              ng-show="sortKey=='id'"
                              ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                        </span>
                      </th>
                      <th ng-click="tableSort('title')"><b>Submission Date</b>
                        <span class="glyphicon sort-icon"
                              ng-show="sortKey=='title'"
                              ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                        </span>
                      </th>
                      <th ng-click="tableSort('title')"><b>Status</b>
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
                      <td>{{report.accountant_first_name}}</td>
                      <td>{{report.created_at}}</td>
                      <td>{{report.status}}</td>
                      <td><a ng-click="purchase(report.transaction_id)"><span class="glyphicon glyphicon-open-file"></span></a></td>
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
      </md-content>
    </div>
  </main>
</div>
</body>
