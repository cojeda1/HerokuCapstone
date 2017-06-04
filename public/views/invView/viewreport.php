
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

<body  ng-app ="homeApp" ng-controller="reportCtrl">

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
        <h2 style="text-align:left;float:left">{{t_info.transaction_information[0].date_bought}}<h2>
      </div>
    <hr />

    <div style ="text-align:center">
      <h4>Transaction Number: {{t_info.transaction_information[0].transaction_number}}</h4>
      <h4 ng-show="t_info.transaction_information[0].is_reconciliated==1">Reconciliation Status: Reconciliated</h4>
      <h4 ng-show= "t_info.transaction_information[0].is_reconciliated==0 ">Reconciliation Status: Waiting </h4>
      <h4>Receipt Number: {{t_info.transaction_information[0].receipt_number}}
      <h4>Location: {{t_info.transaction_information[0].company_name}}</h4>
      <h4>Total: {{t_info.transaction_information[0].total | currency}}</h4>
    </div>

    <div class="table-responsive">
    <table class = "table col-md-6">
      <thead>
        <tr>
           <th>Item</th>
           <th>Location</th>
           <th>Price</th>
           <th>Quantity</th>
           <th>Date</th>
           <th>Account</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="item in t_info.items">
          <td>{{item.item_name}}</td>
          <td>{{t_info.transaction_information[0].company_name}}</td>
          <td>{{item.item_price | currency}}</td>
          <td>{{item.quantity}}</td>
          <td>{{t_info.transaction_information[0].date_bought | date}}</td>
          <td>{{item.ufis_account_number}}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <h4> Justification: </h4>
  <div class = "justBox">
    <p>{{t_info.transaction_information[0].description_justification}}</p>
  </div>

    <h4> Receipts: </h4>
    <div class="container row">
      <div class = "thumbReceipts col-sm-4" ng-repeat="image in t_info.images">
        <div ng-hide="path(image.image_path)">
          <img ng-click="pdf(image.image_path)" ngf-src="image.image_path"/>
        </div>
        <div ng-show="path(image.image_path)">
          <img ng-click="pdf(image.image_path)" src="../../storage/uploads/pdfIcon.PNG">
        </div>
      </div>
    </div>

      <!-- Full bleed  -->
    <h4> Comments: </h4>

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
      <md-button class="md-raised edit" ng-disabled="t_info.transaction_information[0].status==='approved'" ng-click="edit()">Edit Information</md-button>
      <md-button class="md-raised delete" ng-disabled="t_info.transaction_information[0].status==='approved'" ng-click="deleteTrans()">Delete Transaction</md-button>
    </div>
  </md-content>

  </div>

  </div>
</body>
