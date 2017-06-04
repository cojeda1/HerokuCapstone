<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>View Report</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\css\invViewAccount.css">
</head>

<body ng-app = 'homeApp' ng-controller="accountCtrl">

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

  <div class = "space" >
    <md-content>

      <div align="center">
        <h1>Account Information</h1>
      </div>

      <div class="container">
        <div class="field">
          <label>Nickname: </label>
          <label>{{account_info.research_account_info[0].research_nickname}}</label>
        </div>
        <div class="field">
          <label>UFIS: </label>
          <label>{{account_info.research_account_info[0].ufis_account_number}}</label>
        </div>
        <div class="field">
          <label>FRS: </label>
          <label>{{account_info.research_account_info[0].frs_account_number}}</label>
        </div>
        <div class="field">
          <label>Unofficial Budget: </label>
          <label>{{account_info.research_account_info[0].unofficial_budget}}</label>
        </div>
        <div class="field">
          <label>Remaining Amount: </label>
          <label>{{account_info.research_account_info[0].budget_remaining}}</label>
        </div>
      </div>

      <div class="list-table">
        <div align="center">
          <h3>List of Co-Investigators In Account</h3>
        </div>

        <div class="border-table container">
          <div class="container" ng-repeat="researcher in copi">
            <div>
              <h3>{{researcher.first_name}} {{researcher.last_name}}</h3>
            </div>
            <div>
              <md-button class="md-raised cancel right" ng-hide="disable()" ng-click="deleteresearcher(researcher)">Remove</md-button>
            </div>
          </div>
        </div>

        <div align="center">
          <md-button class="md-raised confirm" ng-click="addInv($event)" ng-hide="disable()">Select Other Investigators</md-button>
        </div>
      </div>

      <div class="field">
        <label>Decision to view reports of Co-Investigators: </label>
        <label>{{answer(account_info.research_account_info[0].be_notified)}}</label>
      </div>

      <div align="center">
        <md-button class="md-raised confirm" ng-click="editInfo($event)" ng-hide="disable()">Edit Information</md-button>
      </div>

    </md-content>
  </div>

  <div style="visibility: hidden">
    <div class="md-dialog-container" id="myContainer">
      <md-dialog flex>
        <md-content class="md-padding">
          <form name="validate" ng-submit="validate.$valid && edit()">
            <h1 align="center">Information to be Edited</h1>
            <div class="container">

              <md-input-container class="md-block">
                <label>Nickname</label>
                <input class="inpt" type="text" value="{{account_info.research_account_info[0].research_nickname}}" required id="nickname"></input>
              </md-input-container>

              <md-input-container class="md-block">
                <label>UFIS</label>
                <input class="inpt" required type="text" value="{{account_info.research_account_info[0].ufis_account_number}}" id="ufis"></input>
              </md-input-container>

              <md-input-container class="md-block">
                <label>FRS</label>
                <input class="inpt" required type="text" value="{{account_info.research_account_info[0].frs_account_number}}" id="frs"></input>
              </md-input-container>

              <md-input-container class="md-block">
                <label>Unofficial Budget</label>
                <input class="inpt" required type="text" value="{{account_info.research_account_info[0].unofficial_budget}}" id="budget"></input>
              </md-input-container>

              <md-input-container class="md-block">
                <label>Remaining Amount</label>
                <input class="inpt" required type="text" value="{{account_info.research_account_info[0].budget_remaining}}" id="remaining"></input>
              </md-input-container>

            </div>

            <div class="container" align="center">
              <md-button class="md-raised confirm" type="submit">Submit</md-button>
              <md-button class="md-raised cancel" ng-click="hide()">Cancel</md-button>
            </div>
          </form>
        </md-content>
      </md-dialog>
    </div>
  </div>

  <div style="visibility: hidden">
    <div class="md-dialog-container" id="myContainer1">
      <md-dialog flex>
        <md-content class="md-padding">
            <h1 align="center">Investigators</h1>
            <h6>**Investigators will not be added until information is submitted after pressing Edit Information button</h6>

            <div class="field container" ng-repeat="researcher in researchers">
              <div class="col-sm-10">
                <h3>{{researcher.first_name}} {{researcher.last_name}}</h3>
              </div>
              <div class="col-sm-2">
                <md-button class="md-raised confirm right" ng-click="addresearcher(researcher)" ng-show="show(researcher)">Select</md-button>
                <md-button class="md-raised confirm right" ng-click="deleteresearcher(researcher)" ng-hide="show(researcher)">Deselect</md-button>
              </div>
            </div>

            <div class="container" align="center">
              <md-button class="md-raised confirm" ng-click="hide()" type="submit">Finish</md-button>
            </div>
        </md-content>
      </md-dialog>
    </div>
  </div>

</body>
