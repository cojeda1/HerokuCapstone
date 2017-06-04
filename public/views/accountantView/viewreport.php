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
<main ui-view>
<body ng-app = "HomeApp" ng-controller="viewReportCntrl">

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

  <div class = "space">
    <md-content class="md-padding">

       <div class ="joa">
        <div style="text-align:right;float:right;">
          <h6>From:{{researcher[0].first_name}} {{researcher[0].last_name}} </h6>
          <h6> Assigned to: {{accountant[0].first_name}} {{accountant[0].last_name}}</h6>
          <h6> Status: {{trans_info[0].status}} </h6>
          <md-button class="md-raised" ng-show="(trans_info[0].status == 'in progress' ||trans_info[0].status == 'unassigned') && userid != trans_info[0].accountant_id" ng-click="assignAccountant()">
            Assign to me</md-button>
          <md-button class="md-raised md-primary" ng-disabled="true" ng-show='trans_info[0].accountant_id===userid'> Assigned to you </md-button>
        </div>
        <h1 style="text-align:left;float:left">Created At: {{trans_info[0].created_at}}</h1>

      </div>
    <hr />
    <div style ="text-align:center" class="justBox">
      <h4>Transaction Number:{{trans_info[0].transaction_number}}</h4>
      <h4 ng-if="trans_info[0].is_reconciliated === 0">Reconciliation Status: Not Reconcialated</h4>
      <h4 ng-if="trans_info[0].is_reconciliated === 1">Reconciliation Status: Reconcialated</h4>
      <h4>Charged Credit Card: {{credit_card[0].credit_card_number}}</h4>
      <h4>Location: {{trans_info[0].company_name}} </h4>
      <h4>Receipt Date: {{trans_info[0].date_bought}}</h4>
      <h4>Receipt Number: {{trans_info[0].receipt_number}}
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
          <td>
            <div ng-show= "noneditmode">{{tItem.ufis_account_number}}
              <md-button class="md-raised" ng-click= 'editMode(tItem.ufis_account_number)'>Edit</md-button>
            </div>
            <div ng-show = "editmode">
              <div class="row">
                <div class="col-sm-12">
                  {{tItem.ufis_account_number}}
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <input type="number"ng-show = "choosen == tItem.ufis_account_number" id = "editAccountNumber{{tItem.item_id}}" value="{{nums4}}"></input>
                </div>
              </div>
              <div class = "row">
                <div class="col-sm-12">
                  <md-button class="md-raised" ng-show = "choosen === tItem.ufis_account_number" ng-click = "editAcc(nums4, tItem.item_id)">Done</md-button>
                  <md-button class="md-raised" ng-show = "choosen === tItem.ufis_account_number"  ng-click = "backToNoneEditMode()">Cancel</md-button>
                </div>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <h4> Justification: </h4>
  <div class = "justBox pddng">
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
    <div class = "justBox pddng">
    <md-list flex>
      <md-list-item class="md-3-line md-long-text" ng-repeat="comment in comments">
        <div class = "md-list-item-text" >
          <h3>{{comment.first_name}} {{comment.last_name}}</h3>
          <p>{{comment.body_of_comment}}</p>
          <h5 style ="text-align:right">{{comment.created_at | date}}</h5>
          <a ng-show = "comment.accountant_id == userid" ng-click = "editComment($event,comment)">Edit</a>
          <a ng-show= "comment.accountant_id == userid" ng-click = "deleteComment(comment.comment_id, $event)">Delete</a>
        </div>
      </md-list-item>
  </md-list flex>
    </div>
    <div class="jusBox row">
      <div class ="col-sm-12">
          <h4>Leave a comment:</h4>
      </div>
    </div>
    <div class = "container">
        <div class = "row form-group">
          <div class = "col-sm-10" >
            <textarea class = "form-control textarea" rows ="2" id="comment" ng-model ="leftComment"></textarea>
          </div>
          <div class = "col-sm-2">
            <md-button class = "md-raised lebutton col-sm-12" align="right" ng-click ="leaveComment($event)">Commment</md-button>
          </div>
        </div>
    </div>
    <!---Notes--->
    <h4> Notes: </h4>
    <div class = "justBox pddng">
    <md-list flex>
      <md-list-item class="md-3-line md-long-text" ng-repeat="note in notes">
        <div class = "md-list-item-text" >
          <h3>{{note.first_name}} {{note.last_name}}</h3>
          <p>{{note.body_of_note}}</p>
          <h3 style ="text-align:right">{{note.created_at | date}}</h5>
          <a ng-click = "editNote($event,note.note_id)">Edit</a>
          <a ng-click = "deleteNote(note.note_id, $event)">Delete</a>
        </div>
      </md-list-item>
  </md-list flex>
    </div>
    <div class="jusBox row">
      <div class ="col-sm-12">
          <h4>Leave a Note:</h4>
      </div>
    </div>
    <div class = "container">
        <div class = "row form-group">
          <div class = "col-sm-10" >
            <textarea class = "form-control textarea" rows ="2" id="note" ng-model ="leftNote"></textarea>
          </div>
          <div class = "col-sm-2">
            <md-button class = "md-raised lebutton col-sm-12" align="right" ng-click ="leaveNote($event)">Make Note</md-button>
          </div>
        </div>
    </div>
      <!-- Dialogs -->
    <div class="buttons" align="center">
      <md-button ng-disabled = "trans_info[0].status == 'approved' || trans_info[0] =='denied'" class = "md-raised escsup" ng-click = "customPrompt($event, 'escalated')">Escalate to supervisor </md-button><br>
      <md-button ng-disabled = "trans_info[0].status == 'approved' || trans_info[0] =='denied'"class = "md-raised cnfrm" ng-click ="customPrompt($event, 'approved')"> Approve</md-button>
      <md-button ng-disabled = "trans_info[0].status == 'approved' || trans_info[0] =='denied'"class="md-raised dny" ng-click="customPrompt($event, 'denied')" >Deny</md-button>
    </div>
  </md-content>

</div>
</body>
</main>
