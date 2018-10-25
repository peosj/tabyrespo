<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8" />
  <title>Html version | Angulr</title>
  <meta name="description" content="app, web app, responsive, responsive layout, admin, admin panel, admin dashboard, flat, flat ui, ui kit, AngularJS, ui route, charts, widgets, components" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<?php include('blocks/head.php');?>

</head>
<body>
<div class="app app-header-fixed ">
  

    <!-- header -->
<?php include('blocks/header.php');?>
  <!-- / header -->


    <!-- aside -->
<?php include('blocks/left-sidebar.php');?>
  <!-- / aside -->


  <!-- content -->
  <div id="content" class="app-content" role="main">
  	<div class="app-content-body ">
	    

<div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="
    app.settings.asideFolded = false; 
    app.settings.asideDock = false;
  ">
  <!-- main -->
  <div class="col">
    <!-- main header -->
<?php include('blocks/main-header.php');?>
    <!-- / main header -->
    
    
    
    
    
    
  </div>
  <!-- / main -->
  <!-- right col -->
<?php include('blocks/right-sidebar.php');?>
  <!-- / right col -->
</div>



	</div>
  </div>
  <!-- /content -->
  
  <!-- footer -->
<?php include('blocks/footer.php');?>
  <!-- / footer -->



</div>

<?php include('blocks/footer-scripts.php');?>

</body>
</html>
