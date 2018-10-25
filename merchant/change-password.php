<?php include("config/config.php"); ?>
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
<div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="app.settings.asideFolded = false;app.settings.asideDock = false;">
  <!-- main -->
  <div class="col">
    <!-- main header -->
<?php //include('blocks/main-header.php');?>
    <!-- / main header -->
    
    <div class="bg-light lter b-b wrapper-md" style="">
      <h1 class="m-n font-thin h3" style="text-align: center;">Change Password</h1>
    </div>
    <br />
    <div class="col-sm-12">
    <div class="col-sm-3">
    </div>
    <?php
    $query = "select * from users where user_id = '".$_SESSION['logid']."'";
    $query_result = mysql_query($query);
    $query_result_row = mysql_fetch_array($query_result);
    ?>
    <div class="col-sm-6">
    
    
     <?php if(@$_GET['msg']=='error'){?>
        <div class="alert alert-danger alert-dismissable" id="errormsg" style="display: block; width: 100%;">
            <i class="fa fa-ban"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <b>Alert!</b> &nbsp; <span id="error">Somthing went wrong !</span>
        </div>
        <?php } ?>
        
        <?php if(@$_GET['msg']=='success'){?>
        <div class="alert alert-success alert-dismissable" id="errormsg" style="display: block; width: 100%;">
            <i class="fa fa-ban"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <b>Alert!</b> &nbsp; <span id="error">Password changed successfully !</span>
        </div>
    <?php } ?>
    
      <div class="panel panel-default">
        <div class="panel-heading font-bold" style="text-align: center;">Change Passwod</div>
        <div class="panel-body">
          <form action="app/action/change-password.php" method="post" class="bs-example form-horizontal">
            <div class="form-group">
              <label class="col-lg-3 control-label">Old Password</label>
              <div class="col-lg-8">
                <input type="password" name="old_password" value="<?php echo $query_result_row['password'];?>" class="form-control" placeholder="Old Password"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">New Password</label>
              <div class="col-lg-8">
                <input type="password" name="new_password" class="form-control" placeholder="New Password" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Confirm Password</label>
              <div class="col-lg-8">
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" />
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-offset-2 col-lg-10">
                <div class="checkbox">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-offset-2 col-lg-10">
                <button type="submit" name="submit" class="btn btn-sm btn-info">Change Password</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    </div>
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