<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Home</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\..\node_modules\bootstrap\dist\css\bootstrap.min.css">
  <!-- <link rel="stylesheet" href="..\..\css\app.css"> -->
  <link rel="stylesheet" href="..\css\accountantHomeView.css">
  <link rel="stylesheet" href="..\css\adminUserList.css">
</head>

<body>
  <div ng-app='HomeApp' ng-controller='myCtrl'>
    <main ui-view>

      <div class="navStyle">
        <nav class = "navbar navbar-default">
          <div class = "container-fluid navMargin">
            <ul class="nav navbar-nav">
              <li><a ng-click = "homeOpen()">HOME</a></li>
              <li><a ng-click = "reportsOpen()">REPORTS</a></li>
              <li><a ng-click = "auditedReport()">MY HISTORY</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a ng-click="notifications($event)" ><span class="glyphicon glyphicon-envelope"></span></a></li>
            </ul>
         </div>
        </nav>
      </div>

      <div class="space">
        <md-content class="md-padding">
          <!-- Navigation bar -->
          <!-- <md-nav-bar
          md-selected-nav-item="currentNavItem"
          nav-bar-aria-label="navigationLinks">
              <md-nav-item md-nav-click = "homeOpen()" name="Home">Home</md-nav-item>
              <md-nav-item md-nav-click ="reportsOpen()" name="Reports">Reports</md-nav-item>
              <md-nav-item md-nav-click= "auditedReport()" name="Audited"> My History </md-nav-item>
          </md-nav-bar> -->
          <div align="center">
            <h1>Assigned to me Purchase Reports</h1>
          </div>
        <!-- Search -->
        <div class = "row">
          <div class = "col-sm-12">
            <input type = "text" ng-model="search" class = "form-control search-bar search" placeholder="Search">
          </div>
        </div>
      <br>
          <!-- Table  -->
          <div class = "table-responsive">
            <div>
              <table class = "table table-hover">
                <thead>
                  <tr>
                    <th><b>Researcher</b></th>
                    <th><b>Cycle</b></th>
                    <th><b>Status</b></th>
                    <th><b>Updated at</b></th>
                    <th><b>Created at</b></th>
                    <th>
                    </th>
                  </tr>
                </thead>
                <tbody class="table">
                  <tr dir-paginate ="report in reports | orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize">
                    <td>{{report.first_name}}</td>
                    <td>{{report.billing_cycle }}</td>
                    <td>{{report.status}}</td>
                    <td>{{report.updated_at}}</td>
                    <td>{{report.created_at}}</td>
                    <td ><a  ng-click= "transactID(report.transaction_id)"><span class="glyphicon glyphicon-open-file"></span></a></td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
       <div class="pagination">
          <dir-pagination-controls
            max-size="100"
            direction-links = "true"
            boundary-links = "true">
          </dir-pagination-controls>
          </md-content>
        </div>
      </div>
    </main>
  </div>
</body>
