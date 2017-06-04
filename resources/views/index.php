<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" ng-app="myApp" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" ng-app="myApp" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" ng-app="myApp" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" ng-app="myApp" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>My AngularJS App</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href=<?= url('..\node_modules\angular-material\angular-material.min.css')?>>
  <link rel="stylesheet" href=<?= url('..\node_modules\bootstrap\dist\css\bootstrap.min.css')?>>

  <!--<style type="text/css">
        .container {
            width: 500px;
            clear: both;
        }
        .container input {
            width: 100%;
            clear: both;
        }
    </style>-->

</head>
<body ng-app = "myApp">
   <div class = "container">

       <!-- public/views/authView.html -->
       <div class="col-sm-4 col-sm-offset-4">
           <div class="well">
               <h3>Login</h3>
               <form>
                   <div class="form-group">
                       <input type="email" id = "email" class="form-control" placeholder="Email" ng-model="auth.email">
                   </div>
                   <div class="form-group">
                       <input type="password" id = "password" class="form-control" placeholder="Password" ng-model="auth.password">
                   </div>
                   <button class="btn btn-primary" ng-click="login()">Submit</button>
               </form>
           </div>
       </div>
     
    </div>
  <!-- In production use:
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/x.x.x/angular.min.js"></script>
  -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.2/angular.min.js"></script> -->
  <!-- Application Dependencies-->
  <script src=<?= url('..\node_modules\angular\angular.js')?>></script>
  <script src=<?= url("https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.15/angular-ui-router.min.js")?>></script>
  <script src=<?= url('..\node_modules\satellizer\dist\satellizer.js')?>></script>
  <script src=<?= url('\app\auth\LOGIN.js')?>></script>
</body>
</html>
