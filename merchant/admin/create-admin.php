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
<script src="app/js/admin_form.js" type="text/javascript"></script>
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
      <h1 class="m-n font-thin h3" style="text-align: center;">Create Admin</h1>
    </div>
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
            <b>Alert!</b> &nbsp; <span id="error">Admin created successfully !</span>
        </div>
    <?php } ?>
      <div class="panel panel-default">
        <div class="panel-heading font-bold">Create Admin</div>
        <div class="panel-body">
          <form id="frm" name="frm" action="app/action/create-admin.php" method="post" enctype="multipart/form-data" role="form" onsubmit="return tab1ContactTypeSubmit()">
          
            <div class="form-group col-sm-3">
              <label>Select Rights</label>
              <select name="profile" id="profile" class="form-control m-b">
              <option value="">Select Rights</option>
              <option value="Reviewer">Reviewer</option>
              <option value="Editor">Editor</option>
              <option value="Admin">Admin</option>
              
            </select>
            </div>
            
            
            
            <div class="form-group col-sm-3">
              <label>Employee ID</label>
              <input type="text" name="emp_id" id="emp_id" class="form-control" placeholder="Enter Employee ID" />
            </div>
            
            <div class="form-group col-sm-3">
              <label>Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" />
            </div>
            
            <div class="form-group col-sm-3">
              <label>Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" onblur="emailCheck();"/>
            </div>
            
            <div class="form-group col-sm-3">
              <label>Phone</label>
              <input type="text" name="phone" id="phone" class="form-control" onkeypress="return isNumberKey(event)" maxlength="10" placeholder="Enter Phone Number" />
            </div>
            
            <div class="form-group col-sm-3">
              <label>City</label>
              <input type="text" name="city" id="city" class="form-control" placeholder="Enter City" />
            </div>
            
            <div class="form-group col-sm-3">
              <label>State</label>
              <input type="text" name="state" id="city" class="form-control" placeholder="Enter State" />
            </div>
            
            <div class="form-group col-sm-3">
              <label>Address</label>
              <input type="text" name="address" id="address" class="form-control" placeholder="Enter Address" />
            </div>
            <div class="form-group col-sm-3">
              <label>Profile Pic</label>
              <input type="file" name="file" id="file" class="form-control" placeholder="Select Profile Pic" style="padding: 0px;" />
            </div>
            
            <div class="form-group col-sm-3">
              <label>Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" />
            </div>
            
            <div class="form-group col-sm-3">
              <label>Confirm Password</label>
              <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Enter Confirm Password" onblur="chkRepeatPassword();" />
            </div>
            <br />
           <div class="form-group col-sm-12">
                <button type="submit" name="submit" class="btn btn-sm btn-info" style="padding: 5px 50px;font-size: 22px;">Submit</button>
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
