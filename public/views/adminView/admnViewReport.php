<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>View Report</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\..\node_modules\bootstrap\dist\css\bootstrap.min.css">
  <link rel="stylesheet" href="..\css\viewreport.css">
</head>
<body>
  <div ng-app = 'myApp' ng-controller="viewReportCntrl">

      <!-- Navigation bar -->
    <div class="navStyle">
      <nav class = "navbar navbar-default">
        <div class = "container-fluid navMargin">
          <ul class="nav navbar-nav">
            <li><a ng-click = "homeOpen()">HOME</a></li>
            <li><div class = "dropdown">
              <button class ="dropbtn">CREATE USER</button>
              <div class = "dropdown-content">
                <a ng-click = "createInv()">Create Investigator</a>
                <a ng-click = "createAccOpen()">Create Accountant</a>
            </div>
            </div></li>
            <li><div class = "dropdown">
              <button class ="dropbtn">RECONCILIATION</button>
              <div class = "dropdown-content">
                <a href="#">Upload Account Status</a>
                <a href="#">Reconciliation Result</a>
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
        <div>
         <div style="text-align:right;float:right;">
           <h6> From: {{researcher[0].first_name}} {{researcher[0].last_name}} </h6>
           <h6> Assigned to: {{accountant[0].first_name}} {{accountant[0].last_name}}</h6>
           <h6> Status: {{trans_info[0].status}} </h6>
           <div class = "dropdown" style="text-align:left;float:right">
             <md-button class = "md-raised" ng-disabled="(trans_info[0].status == 'approved')||(trans_info[0].status == 'dennied')">Assign an accountant</md-button>
             <div class = "dropdown-content changeButton" >
               <input type = "text" ng-model="search" class = "form-control search" placeholder="Search">
               <div ng-repeat = "accountant in accountants|filter:search">
                 <a class="link" ng-click ="assignAccountant(accountant.accountant_info.accountant_id)">{{accountant.accountant_info.first_name}} </a>
               </div>
             </div>
           </div>
         </div>
         <h2 style="text-align:left;float:left">{{trans_info[0].billing_cycle}}<h2>
       </div>
     <hr />
     <div style ="text-align:center" class="justBox">
       <h4>Transaction Number:{{trans_info[0].transaction_number}}</h4>
       <h4 ng-if="trans_info[0].is_reconciliated === 0">Reconciliation Status: Waiting</h4>
       <h4 ng-if="trans_info[0].is_reconciliated === 1">Reconciliation Status: Reconcialated</h4>
       <h4>Charged Credit Card: {{trans_info[0].credit_card_number}}</h4>
       <h4>Location: {{trans_info[0].company_name}} </h4>
       <h4>Receipt Date: {{trans_info[0].date_bought}}</h4>
     </div>
     <br>
     <div class="table table-responsive">
     <table class = "table col-md-6">
       <thead>
         <tr>
            <th>Item</th>
            <th>Item quantity </th>
            <th>Item Value</th>
            <th>Charged to Account Number </th>
         </tr>
       </thead>
       <tbody>
         <tr ng-repeat = "tItem in trans_items">
           <td>{{tItem.item_name}}</td>
           <td>{{tItem.quantity}}</td>
           <td>{{tItem.item_price | currency}}</td>
           <td>{{tItem.ufis_account_number}}</td>
         </tr>
       </tbody>
     </table>
    </div>
    <h4> Justification: </h4>
    <div class = "justBox">
     <p>{{trans_info[0].description_justification}}</p>
    </div>
     <h4> Receipts: </h4>
     <div class="row">
       <div class = "col-sm-3">
           <div class = "thumbReceipts justbox">
             <div ng-repeat = "image in images">
               <a ng-src={{image.image_path}}>
             <img ng-src="{{image.image_path}}" class ="img-thumbnail" alt="receipt thumbnail" width ="50" height="50">
             </a>
             </div>
         </div>
       </div>
     </div>

       <!-- Full bleed  -->
     <h4> Comments: </h4>
     <div class = "justBox">
     <md-list flex>
       <md-list-item class="md-3-line md-long-text" ng-repeat="comment in comments">
         <div class = "md-list-item-text" >
           <h3>{{comment.body_of_comment}}</h3>
           <p>- {{comment.first_name}} {{comment.last_name}}</p>
           <h5 style ="text-align:right">{{comment.created_at | date}}</h5>
           <a ng-click = "editComment($event,comment.comment_id)">Edit</a>
           <a ng-click = "deleteComment(comment.comment_id, $event)">Delete</a>
         </div>
       </md-list-item>
    </md-list flex>
     </div>
       <!-- Dialogs -->
     <div class="buttons" align="center">
       <md-button class = "md-raised escsup" ng-click = "customPrompt($event, 'escalated')">Escalate to supervisor </md-button><br>
       <md-button class = "md-raised cnfrm" ng-click ="customPrompt($event, 'approved')"> Approve</md-button>
       <md-button class="md-raised dny" ng-click="customPrompt($event, 'denied')" >Deny</md-button>
     </div>
   </md-content>

</div>
</body>
