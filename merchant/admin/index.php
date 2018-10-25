<?php include('./../config/config.php');?>

<!DOCTYPE html>

<html lang="en" class="">

<head>

  <meta charset="utf-8" />

  <title>Qyk Pay | Admin Login</title>

  <meta name="description" content="app, web app, responsive, responsive layout, admin, admin panel, admin dashboard, flat, flat ui, ui kit, AngularJS, ui route, charts, widgets, components" />

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<?php include('blocks/head.php');?>



</head>

<body>

<div class="app app-header-fixed ">

  



<div class="container w-xxl w-auto-xs" ng-controller="SigninFormController" ng-init="app.settings.container = false;">

  <a href class="navbar-brand block m-t"><img src="images/qyk_logo.png" /></a>

  <div class="m-b-lg">

    <div class="wrapper text-center">

      <strong>Sign in to get in touch</strong>

    </div>

    <form name="form" action="app/action/admin-login.php" method="post" class="form-validation">

      <div class="text-danger wrapper text-center" ng-show="authError">

          

      </div>

      <div class="list-group list-group-sm">

        <div class="list-group-item">

          <input type="text" placeholder="Email" name="userid" class="form-control no-border" ng-model="user.email" required>

        </div>

        <div class="list-group-item">

           <input type="password" placeholder="Password" name="password" class="form-control no-border" ng-model="user.password" required>

        </div>

      </div>

      <button type="submit" name="submit" class="btn btn-lg btn-primary btn-block" ng-click="login()" ng-disabled='form.$invalid'>Log in</button>

      <div class="text-center m-t m-b"><a ui-sref="access.forgotpwd">Forgot password?</a></div>

      <div class="line line-dashed"></div>

    </form>

  </div>

  <div class="text-center" ng-include="'tpl/blocks/page_footer.html'">

    <p>

  <small class="text-muted">OneAsie.me  &copy; 2016</small>

</p>

  </div>

</div>





</div>



<?php include('blocks/footer-scripts.php');?>



</body>

</html>

