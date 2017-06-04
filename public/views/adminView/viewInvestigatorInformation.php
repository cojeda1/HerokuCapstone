<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Home</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\..\node_modules\bootstrap\dist\css\bootstrap.min.css">
  <!-- <link rel="stylesheet" href="..\..\css\app.css">
  <link rel="stylesheet" href="..\..\css\invHome.css"> -->
  <link rel="stylesheet" href="..\css\adminInvInformation.css">
</head>
<body>
  <!-- Navigation bar -->
<div class="navStyle">
<nav class = "navbar navbar-default">
<div class = "container-fluid navMargin">
  <ul class="nav navbar-nav">
    <li><a ng-click = "homeOpen()">HOME</a></li>
    <li><div class = "dropdown">
      <button class ="dropbtn">CREATE USER</button>
      <div class = "dropdown-content">
        <a class="choice" ng-click = "createInv()">Create Investigator</a>
        <a class="choice" ng-click = "createAccOpen()">Create Accountant</a>
        <a class="choice" ng-click = "createAdmin()">Create Admin</a>
      </div>
    </div></li>
    <li><div class = "dropdown">
      <button class ="dropbtn">RECONCILIATION</button>
      <div class = "dropdown-content">
        <a ng-click="excelUpload()">Upload Account Status</a>
        <a ng-click="excelResults()">Reconciliation Result</a>
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

      <h1 align='center'> Investigator Information</h1>
      <div class = "row">
        <div class = "col-sm-6">
          <h6> First Name: <h6>
        </div>
          <div class = "col-sm-6 info">
            {{researcher_info.first_name}}
          </div>
      </div>
      <div class="row">
        <div class = "col-sm-6">
          <h6> Last Name:  </h6>
        </div>
        <div class = "col-sm-6 info">
          {{researcher_info.last_name}}
        </div>
      </div>
      <div class="row">
        <div class = "col-sm-6">
          <h6> Department:  </h6>
        </div>
        <div class = "col-sm-6 info">
          {{researcher_info.department}}
        </div>
      </div>
      <div class = "row">
        <div class="col-sm-6">
          <h6> Office:      </h6>
        </div>
        <div class="col-sm-6 info">
          {{researcher_info.office}}
        </div>
      </div>
      <div class = "row">
        <div class = "col-sm-6">
          <h6> Phone Number: </h6>
        </div>
        <div class = "col-sm-6 info">
          {{researcher_info.phone_number}}
        </div>
      </div>
      <div class = "row">
        <div class="col-sm-6">
          <h6> Job Title </h6>
        </div>
        <div class="col-sm-6 info">
          {{researcher_info.job_title}}
        </div>
      </div>
      <div class = "row">
        <div class="col-sm-6">
          <h6> Email: </h6>
        </div>
        <div class="col-sm-6 info">
          {{researcher_info.email}}
        </div>
      </div>
      <div class = "row">
        <div class="col-sm-6">
          <h6> Card Number: </h6>
        </div>
        <div class="col-sm-6 info">
          {{activeCard.credit_card_number}}
        </div>
      </div>
      <div class = "row">
        <div class = "col-sm-6">
          <h6> Expiration Date </h6>
        </div>
        <div class = "col-sm-6 info">
          {{activeCard.expiration_date}}
        </div>
      </div>
      <div class = "row">
        <div class = "col-sm-6">
          <h6>Name on Card: </h6>
        </div>
        <div class = "col-sm-6 info">
          {{activeCard.name_on_card}}
        </div>
      </div>
      <div class = "row">
        <div class = "col-sm-6">
          <h6>Assigned Accountant: </h6>
        </div>
        <div class = "col-sm-6 info">
          {{accountantInfo.first_name}} {{accountantInfo.last_name}}
        </div>
      </div>
      <div class = "row">
        <div align="center">
          <md-button class= "md-raised edit" ng-click="edit()">Edit</md-button>
        </div>
      </div>
    <h2 align="center"> Recent Purchase Reports</h2>
    <table>
      <tr>
        <th>Submission Date</th>
        <th>Status</th>
        <th></th>
      </tr>
      <tr dir-paginate ="pr in purchase_reports | filter:search |itemsPerPage:3" >
         <td>{{pr.created_at}}</td>
         <td>{{pr.status}}</td>
        <td><md-button class = "md-raised view" ng-click = "answer(researcher)"> view </md-button></td>
      </tr>
    </table>
    <div align="center">
      <div class="pagination">
         <dir-pagination-controls
           max-size="100"
           direction-links = "true"
           boundary-links = "true"
         >
         </dir-pagination-controls>
      </div>
    </div>
    <h2 align="center"> Credit Card History </h2>
    <table>
      <tr>
        <th>Credit Card Number</th>
        <th>Status</th>
        <th>Expiration Date</th>
      </tr>
      <tr dir-paginate ="cc in creditCards| filter:search |itemsPerPage:3" >
         <td>{{cc.credit_card_number}}</td>
         <td>{{cc.isActive}}</td>
         <td>{{cc.expiration_date}}</td>
      </tr>
    </table>
      <div align="center">
        <div class="pagination">
           <dir-pagination-controls
             max-size="100"
             direction-links = "true"
             boundary-links = "true"
           >
           </dir-pagination-controls>
        </div>
      </div>
    </md-content>
  </div>

</body>
