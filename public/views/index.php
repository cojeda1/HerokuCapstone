<DOCTYPE! html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="..\..\node_modules\angular-material\angular-material.min.css">
  <link rel="stylesheet" href="..\css\login.css">
  <title>CID.amex_report</title>
</head>
<main ui-view>
<body ng-app = "myApp" ng-controller ="AuthController">
    <div>
        <div class="well">
            <h3 align="center">Login</h3>
            <form>
                <div class="form-group">
                    <input type="email" id = "email" class="form-control" placeholder="Email" ng-model="auth.email">
                </div>
                <div class="form-group">
                    <input type="password" id = "password" class="form-control" placeholder="Password" ng-model="auth.password">
                </div>
                <div class="container row" id="loginRow">
                 <div class="col-md-6">
                   <md-button class="md-raised submitBtn" ng-click="login()">Submit</md-button>
                 </div>
                 <div class="col-md-6">
                    <div class = "dropdown" id="loginDropdown">
                      <md-button class ="md-raised loginBtn">Login as {{choosen}}</md-button>
                        <div class = "dropdown-content">
                          <a ng-click="changeChoosen('administrator')">administrator</a>
                          <a ng-click= "changeChoosen('accountant')" >accountant</a>
                          <a ng-click="changeChoosen('researcher')">researcher</a>
                        </div>
                    </div>
                </div>
              </div>
            </form>
        </div>
    </div>
</main>
<script src="..\..\node_modules\angular\angular.js"></script>
<script src="..\app\app.js"></script>
<script src="..\..\node_modules\angular-material\angular-material.js"></script>
<script src="..\..\node_modules\angular-route\angular-route.js"></script>
<script src="..\node_modules\angular-utils-pagination\dirPagination.js"></script>
<script src="..\..\node_modules\angular-aria\angular-aria.js"></script>
<script src="..\..\node_modules\angular-animate\angular-animate.js"></script>
<script src="..\..\node_modules\angular-ui-router\release\angular-ui-router.js"></script>
<script src="..\..\node_modules\angular-file-upload\dist\angular-file-upload.js"></script>
<script src="..\..\node_modules\ng-file-upload\dist\ng-file-upload.js"></script>
<script src="..\..\node_modules\ng-file-upload\dist\ng-file-upload-shim.min.js"></script>
<script src ="..\js\admin\mainAdminController.js"></script>
<script src = "..\js\investigator\mainInvCntrl.js"></script>
<script src ="..\js\mainAccCntrl.js"></script>
</body>
