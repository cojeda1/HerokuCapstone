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
  <link rel="stylesheet" href="..\css\accReportHistory.css">

</head>

<body ng-app='HomeApp' ng-controller='rhcntrl'>

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
      <div align="center">
        <h1>{{formattedDate}} {{status}} Purchase Reports</h1>
      </div>
      <hr>

      <div class = "container">
        <form>
          <div class = "form-group">
            <div class = "row">
              <div class = "col-sm-2"> </div>
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
  <!--search-->
  <div class="row">
    <div class = "container">
      <input type = "text" ng-model="search" class = "form-control search-bar search" placeholder="Search">
    </div>
  </div>

      <!-- Table  -->
      <div class = "table-responsive container">
        <div>
          <table class = "table table-hover">
            <thead>
              <tr>
                <th><b>Researcher</b></th>
                <th><b>Cycle</b></th>
                <th><b>Status</b></th>
                <th><b>Total</b></th>
                <th><b>Receipt Date</b></th>
                <th>
                </th>
              </tr>
            </thead>
            <tbody class="table">
              <tr dir-paginate ="report in reports | orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize">
                <td>{{report.first_name}}</td>
                <td>{{report.billing_cycle}}</td>
                <td>{{report.status}}</td>
                <td>{{report.total | currency}}</td>
                <td>{{report.created_at}}</td>
                <td ><a  ng-click= "transactID(report.transaction_id)"><span class="glyphicon glyphicon-open-file"></span></a></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div align="center">
       <div class="pagination">
          <dir-pagination-controls
            max-size="100"
            direction-links = "true"
            boundary-links = "true"
            class="text-center">
          </dir-pagination-controls>
        </div>
      </div>
  </md-content>
</main>
</body>
