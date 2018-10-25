<?php include("../config/config.php"); ?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8" />
  <title>Qyk Pay</title>
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
      <h1 class="m-n font-thin h3" style="text-align: center;">Profile Details</h1>
    </div>
    <div style="background:url(../images/c4.jpg) center center; background-size:cover">
      <div class="wrapper-lg bg-white-opacity">
        <div class="row m-t">
          <div class="col-sm-3">
            <a href class="thumb-lg pull-left m-r">
              <img src='
                    <?php
                        if(file_exists("app/ajax/profile/admin/profile_pic_".$_SESSION['logid'].".png"))
                        {
                            echo"app/ajax/profile/admin/profile_pic_".$_SESSION['logid'].".png";
                        }                       
                        else
                        {
                            echo"app/ajax/profile/admin/avatar5.png";
                        }
                    ?>
                    '  class="img-circle" alt="<?php echo $_SESSION['logname'];?>" style="height: 88px;width: 88px;"/>
            </a>
            <?php //echo $_GET['id'];
                $query = mysql_query("select * from admin where emp_id='".$_SESSION['logid']."'");
                $queryResult = mysql_fetch_array($query);
                ?>
            <div class="clear m-b">
              <div class="m-b m-t-sm">
                <span class="h3 text-black" style="font-size: 20px;"><?php echo $_SESSION['logname'];?></span>
                <small class="m-l"><?php //echo $_SESSION['logrights'];?></small>
              </div>
              <p class="m-b">
                <a href="" style="color: #000;font-size: 20px;" ><?php //echo $queryResult['name'];?></a>
                <a href="" style="color: #000;font-size: 20px;" ><?php echo $queryResult['email'];?></a><br />
                <a href="" style="color: #000;font-size: 20px;" ><?php echo $queryResult['phone'];?></a>
              </p>
              <div class="btn btn-sm btn-success btn-rounded" id="profile_pic" onclick="showChangeImage();">Change Profile Pic</div>
              <script>
              
              function showChangeImage()
              {
                document.getElementById('profilepic').style.display = "block";
              }
              function hideChangeImage()
              {
                document.getElementById('profilepic').style.display = "none";
              }
              
              </script>
              <br />
              
            </div>
          </div>
          
          <div class="col-sm-4">
          <div class="col-sm-12" id="profilepic" style="display: none;background-color: #c3a96f !important;border: solid 1px gre !important;height: 106px!important;margin-top: 20px!important;border-radius: 5px!important;" >
            <div>
              <form action="app/action/change-image.php" method="post" enctype="multipart/form-data">
              <img src="../images/close-button-icon-3749.png" style="width: 30px;float: right;margin-right: -15px;cursor: pointer;" onclick="hideChangeImage();" />
              <div class="form-group  col-sm-12" style="margin-top: -38px;">
                  <label></label>
                  <input type="file" name="file" id="file" class="form-control" style="padding: 0px;width: 90%;" />
              </div>
              <div class="form-group col-sm-12">
                <button type="submit" name="submit" class="btn btn-sm btn-info" style="padding: 0px 50px;font-size: 20px;" >Change</button>
              </div> 
              </form>
              </div>
              </div>
          
          </div>
          <?php 
          
           $cheque_query = "
           SELECT user_id,
           SUM(CASE WHEN cheque_status = 'Processed' THEN 1 ELSE 0 END) AS 'processed_cheque',
           SUM(CASE WHEN cheque_status = 'Pending' THEN 1 ELSE 0 END) AS 'pending_cheque',
           SUM(CASE WHEN cheque_status = 'Declined' THEN 1 ELSE 0 END) AS 'declined_cheque'
           FROM cheque
           ORDER BY cheque_id DESC
            ";
            $cheque_sql = mysql_query($cheque_query);
            $cheque_data = mysql_fetch_array($cheque_sql);
          ?>
          <div class="col-sm-5">
            <div class="pull-right pull-none-xs text-center">
              <a href class="m-b-md inline m">
                <span class="h3 block font-bold" style="color: #23b7e5;text-shadow: 2px 1px 0px rgba(0,0,0,.5);font-size: 45px;"><?php echo $cheque_data['pending_cheque']; ?></span>
                <small style="color: #000;font-size: 15px;">Pending Cheques</small>
              </a>
              <a href class="m-b-md inline m">
                <span class="h3 block font-bold" style="color: #23b7e5;text-shadow: 2px 1px 0px rgba(0,0,0,.5);font-size: 45px;"><?php echo $cheque_data['declined_cheque']; ?></span>
                <small style="color: #000;font-size: 15px;">Return Cheques</small>
              </a>
              <a href class="m-b-md inline m">
                <span class="h3 block font-bold" style="color: #23b7e5;text-shadow: 2px 1px 0px rgba(0,0,0,.5);font-size: 45px;"><?php echo $cheque_data['processed_cheque']; ?></span>
                <small style="color: #000;font-size: 15px;">Processed Cheques</small>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="wrapper bg-white b-b">
      <ul class="nav nav-pills nav-sm">
        <br />
      </ul>
    </div>
    <div class="wrapper-md" ng-controller="FormDemoCtrl">
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
            <b>Alert!</b> &nbsp; <span id="error">Profile updated successfully !</span>
        </div>
    <?php } ?>
    <div class="col-sm-6">
      <div class="panel panel-default">
        <div class="panel-heading font-bold" style="text-align: center;center;background-color: #23b7e5;color: white;">Personal Information</div>
        <div class="panel-body">
          <form action="app/action/update-profile.php" method="post" class="bs-example form-horizontal">
            <input type="hidden" name="admin_id" value="<?php echo $queryResult['admin_id'];?>" />
            <div class="form-group">
              <label class="col-lg-2 control-label">Name</label>
              <div class="col-lg-10">
                <input type="text" name="name" value="<?php echo $queryResult['name'];?>" class="form-control" placeholder="Name" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Email</label>
              <div class="col-lg-10">
                <input type="email" name="email" value="<?php echo $queryResult['email'];?>" class="form-control" placeholder="Email" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Phone</label>
              <div class="col-lg-10">
                <input type="text" name="phone" value="<?php echo $queryResult['phone'];?>" class="form-control" placeholder="Phone" />
              </div>
            </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="panel panel-default">
        <div class="panel-heading font-bold" style="text-align: center;center;background-color: #23b7e5;color: white;">Location Information</div>
        <div class="panel-body bs-example form-horizontal">
            <input type="hidden" name="id" value="<?php echo $queryResult['id'];?>" />
            <div class="form-group">
              <label class="col-lg-2 control-label">City</label>
              <div class="col-lg-10">
                <input type="text" name="city" value="<?php echo $queryResult['city'];?>" class="form-control" placeholder="City" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">State</label>
              <div class="col-lg-10">
                <input type="text" name="state" value="<?php echo $queryResult['state'];?>" class="form-control" placeholder="State" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">Address</label>
              <div class="col-lg-10">
                <input type="text" name="address" value="<?php echo $queryResult['address'];?>" class="form-control" placeholder="Address" />
              </div>
            </div>
        </div>
      </div>
    </div>
     <div class="form-group col-sm-12">
              <div class="col-lg-12" style="margin-left: 485px;">
                <button type="submit" name="submit" class="btn btn-sm btn-info" style="font-size: 15px;font-weight: bold;">Update Information</button>
              </div>
      </div>
    </form>
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