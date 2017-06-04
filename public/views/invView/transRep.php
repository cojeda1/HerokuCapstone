<DOCTYPE! html>

<head>
  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <!-- <link rel="stylesheet" href="..\..\..\node_modules\bootstrap\dist\css\bootstrap.min.css"> -->
  <link rel="stylesheet" type="text/css" href="..\css\transRep.css">
  <title>CID.amex_report</title>
</head>


<body  ng-app='homeApp' ng-controller='tableCtrl'>

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

    <div class="main">
      <md-content>

        <div class="container">
          <div>
            <h1>Transactions</h1>
            <h3>Billing Cycle {{formattedDate}}</h3>
          </div>
        </div>

        <div class = "container"
          <form>
            <div class = "form-group">
              <div class = "col-sm-7">
                <input type = "text" ng-model="search" class = "form-control search-bar search" placeholder="Search">
              </div>
              <div class = "col-sm-1">
              </div>
              <div class = "col-sm-2">
                <md-input-container>
                  <label>Month</label>
                  <md-select ng-model="month">
                    <md-optgroup>
                      <md-option ng-value="m" ng-repeat="m in months">{{m}}</md-option>
                    </md-optgroup>
                  </md-select>
                </md-input-container>
                <md-input-container>
                  <label>Year</label>
                  <md-select ng-model="year">
                    <md-optgroup>
                      <md-option ng-value="y" ng-repeat="y in years">{{y}}</md-option>
                    </md-optgroup>
                  </md-select>
                </md-input-container>
              </div>
              <div class = "col-sm-2">
                <md-button class = "md-raised" ng-click = "viewCycle()">
                  View Cycle
                </md-button>
              </div>
            </div>
          </form>
        </div>

        <div class = "col-lg-12 separate">
          <div>
            <table class = "table table-hover">
              <thead>
                <tr>
                  <th ng-click="tableSort('userId')"><b>Date Bought</b>
                    <span class="glyphicon sort-icon"
                          ng-show="sortKey=='userId'"
                          ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                    </span>
                  </th>
                  <th ng-click="tableSort('id')"><b>Location</b>
                    <span class="glyphicon sort-icon"
                          ng-show="sortKey=='id'"
                          ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                    </span>
                  </th>
                  <th ng-click="tableSort('title')"><b>Total</b>
                    <span class="glyphicon sort-icon"
                          ng-show="sortKey=='title'"
                          ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                    </span>
                  </th>
                  <th ng-click="tableSort('id')"><b>Status</b>
                    <span class="glyphicon sort-icon"
                          ng-show="sortKey=='userId'"
                          ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                    </span>
                  </th>
                  <th>
                  </th>
                </tr>
              </thead>
              <tbody class="table">
                <tr dir-paginate ="transaction in transactions | orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize">
                  <td>{{transaction.date_bought}}</td>
                  <td>{{transaction.company_name}}</td>
                  <td class="currency">{{transaction.total | currency}}</td>
                  <td>{{transaction.status}}</td>
                  <td><a ng-click="viewReport(transaction.transaction_id)"><span class="glyphicon glyphicon-open-file"></span></a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </md-content>
    </div>

  </main>
</body>
