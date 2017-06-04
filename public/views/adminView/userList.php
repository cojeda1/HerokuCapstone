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
  <link rel="stylesheet" href="..\css\adminUserList.css">
</head>

<body ng-app='myApp' ng-controller='listCtrl'>
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

      <div align="center">
        <!-- Heading -->
        <h1 style="text-align:center">Users: {{typeUser}}</h1>
      </div>

      <div class="container">
        <div class = "row">
          <!--- Search bar --->
          <div class = "col-md-8">
            <form>
              <div class = "form-group">
                <input type = "text" ng-model="search" class = "form-control search" placeholder="Search">
              </div>
            </form>
          </div>
          <div class = "col-md-4">
              <!--dropdown for changing between accountant or investigator-->
              <div class = "dropdown" style="text-align:left;float:right">
                <md-button class = "md-raised" >{{typeUser}} </md-button>
                <div class = "dropdown-content changeButton" >
                  <a class="link"  href="" ng-click = "changeTypeUser('Investigator')" > Investigator </a>
                  <a class="link" href = "" ng-click ="changeTypeUser('Accountant')"> Accountant </a>
                  <a class="link" href = "" ng-click ="changeTypeUser('Admin')"> Admin </a>
                </div>
              </div>
          </div>
        </div>
      </div>
      <!--- Investigators Table --->
      <div ng-show = "typeUser == 'Investigator' ">
          <table class = "table table-hover">
            <thead>
              <tr>
                <th><b>Investigator's Name</b>
                  <span class="glyphicon sort-icon"
                        ng-show="sortKey=='researcher_first_name'"
                        ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                  </span>
                </th>
                <th><b>Credit Card Number</b>
                  <span class="glyphicon sort-icon"
                        ng-show="sortKey=='credit_card_number'"
                        ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                  </span>
                </th>
                <th><b>Accountant Name</b>
                  <span class="glyphicon sort-icon"
                        ng-show="sortKey=='accountant_first_name'"
                        ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                  </span>
                </th>
                <th>
                </th>
              </tr>
            </thead>
            <tbody class="table">
              <tr dir-paginate ="inv in investigators | orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize">
                <td>{{inv.researcher_first_name}}</td>
                <td>{{inv.credit_card_number}}</td>
                <td>{{inv.accountant_first_name}}</td>
                <td><a ng-click = "viewInv(inv.researcher_id)"><span class="glyphicon glyphicon-open-file"></span></a></td>
              </tr>
            </tbody>
          </table>
      </div>
      <!--- Accountants Table--->
      <div ng-show = "typeUser =='Accountant'">
          <table class = "table table-hover">
            <thead>
              <tr>
                <th><b>Accountant's Name</b>
                  <span class="glyphicon sort-icon"
                        ng-show="sortKey=='first_name'"
                        ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                  </span>
                </th>
                <th><b>Recent audit</b>
                  <span class="glyphicon sort-icon"
                        ng-show="sortKey=='updated_at'"
                        ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}">
                  </span>
                </th>
                <th>
                </th>
              </tr>
            </thead>
            <tbody class="table">
              <tr dir-paginate ="accountant in accountants | orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize">
                <td>{{accountant.accountant_info.first_name}}</td>
                <td>{{accountant.transaction_info.updated_at}}</td>
                <td><a ng-click = "viewAccountant(accountant.accountant_info.accountant_id)"><span class="glyphicon glyphicon-open-file"></span></a></td>
              </tr>
            </tbody>
          </table>
      </div>
      <!---Pagination--->
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
       <!--- Admins Table--->
       <div ng-show = "typeUser =='Admin'">
           <table class = "table table-hover">
             <thead>
               <tr>
                 <th><b>Admin's Name</b>
                   <span></span>
                 </th>
                 <th>
                 </th>
               </tr>
             </thead>
             <tbody class="table">
               <tr dir-paginate ="admin in admins | orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize">
                 <td>{{admin.first_name}}</td>
                 <td><a ng-click = "viewAdmin(admin.admin_id)"><span class="glyphicon glyphicon-open-file"></span></a></td>
               </tr>
             </tbody>
           </table>
       </div>
       <!---Pagination--->
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
