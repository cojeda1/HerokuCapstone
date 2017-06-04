<DOCTYPE! html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\css\invHome.css">
  <title>CID.amex_report</title>
</head>

<body>
  <div ng-app='homeApp' ng-controller='homeCtrl'>
    <main ui-view>

      <!-- Navigation bar -->
    <div class="navStyle">
      <nav class = "navbar navbar-default">
        <div class = "container-fluid navMargin">
          <ul class="nav navbar-nav">
            <li><a class="white" ng-click = "viewHome()">HOME</a></li>
            <li><a class="white" ng-click = "createRep()">CREATE REPORT</a></li>
            <li><a class="white" ng-click = "viewTransactions()">TRANSACTIONS</a></li>
            <li><a class="white" ng-click = "viewCo()">CO-TRANSACTIONS</a></li>
            <li><a class="white" ng-click = "viewProfile()">PROFILE</a></li>
            <li><a class="white" ng-click = "reconcile()">RECONCILIATION</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a ng-click="notifications()" ><span class="glyphicon glyphicon-envelope"></span></a></li>
          </ul>
       </div>
      </nav>
    </div>

      <div class="space">
        <md-content>

        <div class="container">
          <div align="center">
            <h1>{{user_info[0].first_name}} {{user_info[0].last_name}}</h1>
          </div>
        </div>

        <div class="container heed">
          <div class="col-sm-8" align="center">
            <h3>Account Information</h3>
          </div>

          <div class="col-sm-4">
            <div class="dropdown">
              <md-button class="md-raised option">{{typeUser}}</md-button>
              <div class="dropdown-content">
                <a href="" ng-click="changeValue(1)">Principal Investigator</a>
                <a href="" ng-click="changeValue(2)">Co-Investigator</a>
              </div>
            </div>
            <!-- <md-button class="md-raised investigator" ng-click="changeValue()" ng-hide="table">as Co-Investigator</md-button>
            <md-button class="md-raised investigator" ng-click="changeValue()" ng-show="table">as Principal Investigator</md-button> -->
          </div>
        </div>
        <br>
        <div class = "container"
          <form>
            <div class = "form-group">
              <div class = "col-sm-12">
                <input type = "text" ng-model="search" class = "form-control search-bar search" placeholder="Search">
              </div>
            </div>
          </form>
        </div>

        <div class="container top" ng-show="table">
          <div class="container">
            <div>
              <table class = "table table-hover">
                <thead align="center">
                  <tr>
                    <th ng-click="tableSort('userId')">Account Nickname
                      <!-- <span class="glyphicon sort-icon"
                            ng-show="sortKey=='userId'"
                            ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                      </span> -->
                    </th>
                    <th ng-click="tableSort('id')"><b>UFIS Account Number</b>
                      <span class="glyphicon sort-icon"
                            ng-show="sortKey=='id'"
                            ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                      </span>
                    </th>
                    <th ng-click="tableSort('title')"><b>Budget Remaining</b>
                      <span class="glyphicon sort-icon"
                            ng-show="sortKey=='title'"
                            ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                      </span>
                    </th>
                    <th ng-click="tableSort('title')"><b>Unofficial Budget</b>
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
                  <tr dir-paginate ="account in r_account_info |itemsPerPage:pageSize">
                    <td align="center">{{account.research_nickname}}</td>
                    <td align="center">{{account.ufis_account_number}}</td>
                    <td align="right">{{account.budget_remaining | currency}}</td>
                    <td align="right">{{account.unofficial_budget | currency}}</td>
                      <td><a ng-click="viewAccount(account.ra_id)"><span class="glyphicon glyphicon-open-file"></span></a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div align="center" class="container">
            <md-button class="md-raised add" ng-click="addAccount()">Add Research Account</md-button>
          </div>
        </div>

      <div class="container" ng-hide="table">
        <div class="container">
          <div>
            <table class = "table table-hover">
              <thead>
                <tr>
                  <th ng-click="tableSort('userId')" align="center"><b>Account Nickname</b>
                    <span class="glyphicon sort-icon"
                          ng-show="sortKey=='userId'"
                          ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                    </span>
                  </th>
                  <th ng-click="tableSort('id')" align="center"><b>UFIS Account Number</b>
                    <span class="glyphicon sort-icon"
                          ng-show="sortKey=='id'"
                          ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                    </span>
                  </th>
                  <th ng-click="tableSort('title')" align="center"><b>Budget Remaining</b>
                    <span class="glyphicon sort-icon"
                          ng-show="sortKey=='title'"
                          ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                    </span>
                  </th>
                  <th ng-click="tableSort('title')" align="center"><b>Unofficial Budget</b>
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
                <tr dir-paginate ="account in copi_account_info | orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize">
                  <td>{{account.research_nickname}}</td>
                  <td>{{account.ufis_account_number}}</td>
                  <td align="right">{{account.budget_remaining}}</td>
                  <td align="right">{{account.unofficial_budget}}</td>
                  <td><a ng-click="viewAccount(account.ra_id)"><span class="glyphicon glyphicon-open-file"></span></a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      </md-content>
    </div>
  </main>
</div>
</body>
