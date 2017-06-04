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
  <link rel="stylesheet" href="..\css\adminAccountantInformation.css">
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
        <h1 align='center'> Accountant Information</h1>
        <div class = "row">
          <div class = "col-sm-6">
            <h6> First Name: <h6>
          </div>
            <div class = "col-sm-6 info">
              {{acc[0].first_name}}
            </div>
        </div>
        <div class="row">
          <div class = "col-sm-6">
            <h6> Last Name:  </h6>
          </div>
          <div class = "col-sm-6 info">
            {{acc[0].last_name}}
          </div>
        </div>
        <div class="row">
          <div class = "col-sm-6">
            <h6> Department:  </h6>
          </div>
          <div class = "col-sm-6 info">
            {{acc[0].department}}
          </div>
        </div>
        <div class = "row">
          <div class="col-sm-6">
            <h6> Office:      </h6>
          </div>
          <div class="col-sm-6 info">
            {{acc[0].office}}
          </div>
        </div>
        <div class = "row">
          <div class = "col-sm-6">
            <h6> Phone Number: </h6>
          </div>
          <div class = "col-sm-6 info">
            {{acc[0].phone_number}}
          </div>
        </div>
        <div class = "row">
          <div class="col-sm-6">
            <h6> Job Title </h6>
          </div>
          <div class="col-sm-6 info">
            {{acc[0].job_title}}
          </div>
        </div>
        <div class = "row">
          <div class="col-sm-6">
            <h6> Email: </h6>
          </div>
          <div class="col-sm-6 info">
            {{acc[0].email}}
          </div>
        </div>
        <div align="center" class="buttonpad">
          <md-button class= "md-raised edit" ng-click = "editAccountant()"> Edit</md-button>
        </div>

        <div class = "row justbox">
          <div class = "col-sm-6">
            <h6>Assigned Investigators: </h6>
          </div>
          <div class = "col-sm-6 info" ng-repeat= "ai in assigned_investigators">
            <p>{{ai.first_name}} {{ai.last_name}}</p>
          </div>
        </div>

      <h2 align="center"> Recent Audits: </h2>
      <table>
        <tr class="tablehead">
          <th>Investigator Name</th>
          <th>Credit Card Number</th>
          <th>Audit Date</th>
          <th> </th>
        </tr>
        <div class = "row"
            <form>
              <div class = "form-group">
                <div class = "col-sm-12">
                  <input type = "text" ng-model="search" class = "form-control search-bar search" placeholder="Search">
                </div>
              </div>
            </form>
          </div>
        <tr dir-paginate ="rt in recent_Transactions | filter:search |itemsPerPage:5" >
           <td>{{rt.researcherFirstName}}</td>
           <td>{{rt.credit_card_number}}</td>
           <td>{{rt.updated_at}} </td>
          <td><md-button class = "md-raised view" ng-click = "answer(researcher)"> view </md-button></td>
        </tr>
      </table>

      <div align="center">
        <div class="pagination">
           <dir-pagination-controls
             max-size="100"
             direction-links = "true"
             boundary-links = "true">
           </dir-pagination-controls>
        </div>
      </div>

    </md-content>
  </div>
</body>
