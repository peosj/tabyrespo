<?php 
    session_start();
    include("config/config.php");
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8" />
  <title>Qyk Pay</title>
  <meta name="description" content="app, web app, responsive, responsive layout, admin, admin panel, admin dashboard, flat, flat ui, ui kit, AngularJS, ui route, charts, widgets, components" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<script src="app/js/sales_form.js" type="text/javascript"></script> 
<script src="app/js/create_user.js" type="text/javascript"></script>
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
    <div class="bg-light lter b-b wrapper-md">
      <h1 class="m-n font-thin h3" style="text-align: center;">Create User</h1>
    </div>
                                    <?php if(@$_GET['msg']=='error'){?>
                                    <div class="alert alert-danger alert-dismissable" id="errormsg" style="display: block; width: 97%;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                        <b>Alert!</b> &nbsp; <span id="error">Somthing went wrong !</span>
                                    </div>
                                    <?php } ?>
                                    <?php if(@$_GET['msg']=='success'){?>
                                    <div class="alert alert-success alert-dismissable" id="errormsg" style="display: block; width: 100%;">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                        <b>Alert!</b> &nbsp; <span id="error">User created successfully !</span>
                                    </div>
                                    <?php } ?>
<div class="wrapper-md" ng-controller="FormDemoCtrl">
  <div class="row">
    <div class="col-sm-12">
    <div class="row">
    <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <div style="color:#ff0000; display: none;" id="errormsg">Please fill all mendatory fields.</div>
        </div>
        <div class="col-sm-4"></div>
    </div> 
      <div class="panel panel-default">
        <div class="panel-heading font-bold">Create User</div>
        <div class="panel-body">
        <div class="row" id="error" style="display: none;width: 99%; margin: 0 auto;">
                                        <div class="col-sm-12" style="background: #ffe7fe; padding:10px; text-align: center;">
                                            Please fill all mendatory fields !
                                        </div>
        </div>
          <form id="frm" name="frm" action="app/action/create-user.php" method="post" enctype="multipart/form-data" role="form" onsubmit="return tab1ContactTypeSubmit()">
            <!--<div class="form-group col-sm-3">
              <label>User ID</label>
              <input type="text" name="emp_id" id="emp_ide" class="form-control" placeholder="Enter User ID" />
            </div>-->
            <div class="form-group col-sm-3">
              <label>First Name</label>
              <input type="text" name="fname" id="fname" class="form-control" placeholder="Enter First Name" />
            </div>
            <div class="form-group col-sm-3">
              <label>Last Name</label>
              <input type="text" name="lname" id="lname" class="form-control" placeholder="Enter Last Name" />
            </div>
            <div class="form-group col-sm-3">
              <label>Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" />
            </div>
            <div class="form-group col-sm-3">
              <label>Phone</label>
              <input type="text" name="phone" id="phone" class="form-control" onkeypress="return isNumberKey(event)" maxlength="10" placeholder="Enter Phone" />
            </div>
            <div class="form-group col-sm-3">
              <label>Profile Pic</label>
              <input type="file" name="file" id="file" class="form-control" placeholder="Enter email" style="padding: 0px;" />
            </div>
            <div class="form-group col-sm-3">
              <label>Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" />
            </div>
            <div class="form-group col-sm-3">
              <label>Confirm Password</label>
              <input type="password" name="password1" id="password1" class="form-control" placeholder="Enter Confirm Password" onblur="chkRepeatPassword();" />
            </div>
            <br />
           <div class="form-group col-sm-12">
                <button type="submit" name="submit" class="btn btn-sm btn-info" style="padding: 5px 50px;font-size: 22px;" >Submit</button>
           </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
  </div>
  <!-- / main -->
  <!-- right col -->
<?php //include('blocks/right-sidebar.php');?>
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