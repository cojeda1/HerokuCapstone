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
  <!-- <link rel="stylesheet" href="..\..\..\node_modules\bootstrap\dist\css\bootstrap.min.css"> -->
  <link rel="stylesheet" href="..\css\viewreport.css">
</head>

<body ng-app ="homeApp" ng-controller="reportCtrl">

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

  <div class ="space" >

    <md-content>

       <div>
        <div style="text-align:right;float:right;">
          <h6>From: {{t_info.researcher[0].first_name}} {{t_info.researcher[0].last_name}} </h6>
          <h6> Assigned to: {{t_info.accountant[0].first_name}} {{t_info.accountant[0].last_name}}</h6>
          <h6> Status: {{t_info.transaction_information[0].status}} </h6>
        </div>
        <h2 style="text-align:left;float:left">{{t_info.transaction_information[0].date_bought | date}}<h2>
      </div>
    <hr />
    <form name="validated" ng-submit="validated.$valid && change()">
    <div style ="text-align:center">
      <md-input-container>
        <label>Transaction Number: </label><input class="inpt" type="text" required value="{{t_info.transaction_information[0].transaction_number}}" id="tNumber"</input>
      </md-input-container>

      <h4>Reconciliation Status: {{t_info.transaction_information[0].is_reconciliated}} </h4>

      <md-input-container>
        <label>Receipt Number: </label><input class="inpt" type="text" required value="{{t_info.transaction_information[0].receipt_number}}" id="rNumber"></input>
      </md-input-container>

      <md-input-container>
        <label>Location: </label><input class="inpt" type="text" required value="{{t_info.transaction_information[0].company_name}}" id="company"></input>
      </md-input-container>

      <md-input-container>
        <label>Total: </label><input class="inpt" type="text" required value="{{t_info.transaction_information[0].total}}" id="total"></input>
      </md-input-container>
    </div>

    <div class="table-responsive">
    <table class = "table col-md-6">
      <thead class="container">
        <tr>
           <th>Item</th>
           <th>Location</th>
           <th>Price</th>
           <th>Quantity</th>
           <th>Date</th>
           <th>Account</th>
           <th></th>
           <th></th>
        </tr>
      </thead>
      <tbody class="container">
        <tr ng-repeat="item in t_info.items">
          <td>{{item.item_name}}</td>
          <td>{{t_info.transaction_information[0].company_name}}</td>
          <td>{{item.item_price | currency}}</td>
          <td>{{item.quantity}}</td>
          <td>{{t_info.transaction_information[0].date_bought | date}}</td>
          <td>{{item.ufis_account_number}}</td>
          <td><md-button class="md-raised edit" ng-click="itemDialog(item)">Edit</md-button></td>
          <td><md-button class="md-raised edit" ng-click="deleteItem(item.item_id)">Delete</md-button></td>
        </tr>
      </tbody>
    </table>
  </div>

  <h4> Justification: </h4>
  <div class = "justBox">
    <md-input-container class="md-block">
      <input type="text" required value="{{t_info.transaction_information[0].description_justification}}" id="justification"></input>
  </md-input-container>
  </div>

    <h4> Receipts: </h4>
    <div class="container">
      <div class="button" ngf-select ng-model="picture.new" ngf-keep="'distinct'" ngf-multiple="true" ngf-accept="'image/*,application/pdf'">
        <md-button class="md-raised right edit">Select From File System</md-button>
      </div>
      <div class="row">
        <div class = "thumbReceipts col-sm-4" ng-repeat="image in t_info.images">
          <div ng-hide="path(image.image_path)">
            <img ng-click="pdf(image.image_path)" ngf-src="image.image_path" width="200px" height="200px">
          </div>
          <div ng-show="path(image.image_path)">
            <img ng-click="pdf(image.image_path)" src="../../../storage/uploads/pdfIcon.PNG">
          </div>
          <md-button class="md-raised" ng-click="deleteFile(image.image_id)">Remove</md-button>
        </div>
      </div>
      <div class="container">
        <div class="row col-sm-3" ng-repeat="file in picture.new">
          <img ng-hide="path(file.name)" ng-click="pdf1(file)" ngf-src="file" width="200px" height="200px">
          <img ng-show="path(file.name)" ng-click="pdf1(file)" src="../../../storage/uploads/pdfIcon.PNG">
        </div>
        <div>
          <md-button class="md-raised edit" ng-click="newPicture()">Submit New Pictures</md-button>
        </div>
      </div>
    </div>

      <!-- Full bleed  -->
    <h4> Comments: </h4>
    <div class="jusBox row">
      <div class ="col-sm-12">
          Comment section
      </div>
    </div>

    <div class = "container">
        <div class = "row form-group">
          <div class = "justBox container" ng-repeat="comment in t_info.comments">
            <p class="comment">{{comment.body_of_comment}}<br></p>
            <div align="right">
              <p class="codehex container">{{comment.first_name}} {{comment.last_name}}<br>
              {{comment.created_at | date}}<br></p>
            </div>
          </div>
        </div>
    </div>

    <div class="container" align="center">
      <md-button type="submit" class="md-raised edit">Submit Changes</md-button>
    </div>
  </form>

  <div style="visibility: hidden">
    <div class="md-dialog-container" id="myContainer">
      <md-dialog flex>
        <md-content class="md-padding">
          <form name="itemval" ng-submit="itemval.$valid && item()">
            <h1>Edit Item Information</h1>
            <div class="container" align="center">

              <md-input-container class="md-block">
                <label>Item Name</label>
                <input class="reset inpt" type="text" required id="itemName" value="{{items.item_name}}"></input>
              </md-input-container>

              <md-input-container class="md-block">
                <label>Item Price</label>
                <input class="reset inpt" type="text" required id="itemPrice" value="{{items.item_price}}"></input>
              </md-input-container>

              <md-input-container class="md-block">
                <label>Item Quantity</label>
                <input class="reset inpt" type="text" required id="itemQuantity" value="{{items.quantity}}"></input>
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
                      <md-button class="md-raised right dselect" ng-hide="show(account.ra_id)">Deselect</md-button>
                    </div>
                  </div>

                  <h4>Co-Investigator Accounts</h4>
                  <div class="field container" ng-repeat="account in accountsCOPI">
                    <div class="col-sm-8">
                      <h5>{{account.research_nickname}}</h5>
                    </div>
                    <div class="col-sm-4">
                      <md-button class="md-raised right select" ng-click="addID(account.ra_id)" ng-show="show(account.ra_id)">Select</md-button>
                      <md-button class="md-raised right dselect" ng-click="deleteID(account.ra_id)" ng-hide="show(account.ra_id)">Selected</md-button>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <div class="container" align="center">
              <md-button class="md-raised confirm" ng-disabled = "accountID.length == 0"type="submit">Edit</md-button>
              <md-button class="md-raised cancel" ng-click="hide()">Cancel</md-button>
            </div>
          </form>
        </md-content>
      </md-dialog>
    </div>
  </div>

</md-content>
  </div>
</body>
