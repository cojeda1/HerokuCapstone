<DOCTYPE! html>

<head>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <!-- <link rel="stylesheet" href="..\..\..\node_modules\bootstrap\dist\css\bootstrap.min.css"> -->
  <link rel="stylesheet" type="text/css" href="../css/createRep.css">
  <title>CID.amex_report</title>
</head>

<body ng-app="homeApp" ng-controller="createCtrl">

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

      <form name="validated" ng-submit="validated.$valid && submitTrans($event)">
      <div class="container" align="left">
        <div>
          <h1>Transaction Report</h1>
        </div>
        <div class="col-sm-12">
          <label>Transaction Number:</label><br>
          <md-input-container class="md-block">
            <input min="0" class="inpt numbers" type="number" required id="number"></input>
          </md-input-container>
        </div>
        <div  class="col-sm-12">
          <label>Receipt Date:</label><br>
          <md-datepicker
          ng-model="myDate"
          md-placeholder="Enter date"
          md-open-on-focus required
          md-max-date ="maxDate"
          id = 'date' class="md-block"></md-datepicker>
        </div>
        <div  class="col-sm-12">
          <label>Location Name:</label><br>
          <md-input-container class="md-block">
            <input class="inpt" type="text" required id="location"></input>
          </md-input-container>
        </div>
        <div class="col-sm-12">
          <label>Receipt Number:</label><br>
          <md-input-container class="md-block">
            <input min="0" class="inpt numbers" type="number" required id="receipt"></input>
          </md-input-container>
        </div>
        <div class="col-sm-12">
          <label>Total:</label><br>
          <md-input-container class="md-block">
            <input min="0" step="0.01" class="inpt" type="number" required id="total" value="{{total}}"></input>
          </md-input-container>
        </div>
      </div>

      <div class="container">
        <br>
        <div class="needBorder container" align="center">
          <h1 class="smallHeader">Purchase List</h1>
          <div class="container">
            <table class = "table col-md-6">
              <thead>
                <tr>
                   <th>Item</th>
                   <th>Price</th>
                   <th>Quantity</th>
                   <th></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="item in account_info">
                  <td>{{item.item_name}}</td>
                  <td>{{item.item_price | currency}}</td>
                  <td>{{item.quantity}}</td>
                  <td><md-button class="md-raised cancel" class="stretch" ng-click="deleteItem(item)">Delete</md-button></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div align="center" class="separate container">
            <md-button class="md-raised right submitbutton" ng-click="itemDialog($event)">Add an Item</md-button>
          </div>
        </div>
      </div><br>


      <div class="container">
        <h2>Justification</h2>
        <md-input-container class="md-block">
          <input class="inpt" required type="text" id="just"></textarea>
        </md-input-container>
      </div>

      <div class="container">
        <h2>Receipt Images</h2>
          <!-- <div class="button" ngf-select ng-model="picture.file" name="file" ngf-pattern="'image/*'"
            ngf-accept="'image/*,application/pdf'" ngf-max-size="20MB" ngf-min-height="100"
            ngf-resize="{width: 100, height: 100}">Select</div> -->
          <md-button class="md-raised right"><div class="button" ngf-keep="'distinct'" ngf-select ng-model="picture.files" ngf-multiple="true" ngf-accept="'image/*,application/pdf'">
            Select From File System
          </div></md-button>
        <div class="container">
          <div class="row col-sm-3" ng-repeat="file in picture.files">
            <img ng-hide="path(file.name)" ng-click="pdf(file)" ngf-thumbnail="file || '/thumb.jpg'">
            <img ng-show="path(file.name)" ng-click="pdf(file)" src="../../storage/uploads/pdfIcon.PNG">
            <!-- <iframe ngf-src="file" width="200px" height="200px" frameborder="0" scrolling="no"></iframe> -->
            <md-button class="md-raised delete" ng-click="remove(file)">Remove</md-button>
          </div>
        </div>
      </div>

      <div class="container" align="center">
        <br>
        <md-button class="md-raised right submitbutton" type="submit">Submit</md-button>
      </div>
    </form>

    </div>
  </md-content>
  </div>

  <div style="visibility: hidden">
    <div class="md-dialog-container" id="myContainer">
      <md-dialog flex>
        <md-content class="md-padding">
          <form name="itemval" ng-submit="itemval.$valid && addItem($event)">
            <h1>Item Information</h1>
            <div class="container" align="center">

              <md-input-container class="md-block">
                <label>Item Name</label>
                <input class="reset inpt" type="text" required id="itemName"></input>
              </md-input-container>

              <md-input-container class="md-block">
                <label>Item Price</label>
                <input min="0" class="reset inpt" type="number" step="0.01" required id="itemPrice"></input>
              </md-input-container>

              <md-input-container class="md-block">
                <label>Item Quantity</label>
                <input class="reset inpt" type="number" min="0" required id="itemQuantity"></input>
              </md-input-container>

              <div class="list-table container">
                <div align="center">
                  <h3>Researches Item belongs to</h3>
                </div>
                <div class="border-table container">
                  <h4>Principal Investigator Accounts</h4>
                  <div class="field container" ng-repeat="account in accounts">
                    <div class="col-sm-8">
                      <h5>{{account.research_nickname}}</h5>
                    </div>
                    <div class="col-sm-4">
                      <md-button class="md-raised right select" ng-click="addID(account.ra_id)" ng-show="show(account.ra_id)">Select</md-button>
                      <md-button class="md-raised right dselect" ng-click="deleteID(account.ra_id)" ng-hide="show(account.ra_id)">Deselect</md-button>
                    </div>
                  </div>

                  <h4>Co-Investigator Accounts</h4>
                  <div class="field container" ng-repeat="account in accountsCOPI">
                    <div class="col-sm-8">
                      <h5>{{account.research_nickname}}</h5>
                    </div>
                    <div class="col-sm-4">
                      <md-button class="md-raised right select" ng-click="addID(account.ra_id)" ng-show="show(account.ra_id)">Select</md-button>
                      <md-button class="md-raised right dselect" ng-click="deleteID(account.ra_id)" ng-hide="show(account.ra_id)">Deselect</md-button>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <div class="container" align="center">
              <md-button class="md-raised confirm" ng-disabled = "accountID.length == 0"type="submit">Submit</md-button>
              <md-button class="md-raised cancel" ng-click="hide()">Cancel</md-button>
            </div>
          </form>
        </md-content>
      </md-dialog>
    </div>
  </div>
  </main>
</body>
