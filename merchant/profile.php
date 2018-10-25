<?php include("config/config.php"); ?>
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
    <div style="background:url(images/c4.jpg) center center; background-size:cover">
      <div class="wrapper-lg bg-white-opacity">
        <div class="row m-t">
          <div class="col-sm-4">
            <a href class="thumb-lg pull-left m-r">
              <img src='
                    <?php
                        if(file_exists("admin/app/ajax/profile/user/profile_pic_".$_SESSION['logid'].".png"))
                        {
                            echo"admin/app/ajax/profile/user/profile_pic_".$_SESSION['logid'].".png";
                        }                       
                        else
                        {
                            echo"app/ajax/profile/user/avatar5.png";
                        }
                    ?>
                    '  class="img-circle" alt="<?php echo $_SESSION['logname1'];?>" style="height: 106px;"/>
            </a>
            <?php //echo $_GET['id'];
            //echo "select * from users where user_id='".$_SESSION['logid']."'";
                $query = mysql_query("select * from users where user_id='".$_SESSION['logid']."'");
                $queryResult = mysql_fetch_array($query);
                ?>
            <div class="clear m-b">
              <div class="m-b m-t-sm">
                <span class="h3 text-black" style="font-size: 20px;"><?php echo $_SESSION['logname'];?></span>
              </div>
              <p class="m-b">
                <a href="" style="color: #000;font-size: 20px;" ><?php echo $queryResult['email'];?></a><br />
                <a href="" style="color: #000;font-size: 20px;" ><?php echo $queryResult['phone'];?></a><br />
                <a href="" style="color: #000;font-size: 20px;" ><?php //echo $queryResult['email'];?></a><br />
                <a href="" style="color: #000;font-size: 20px;" ><?php //echo $queryResult['contact_number'];?></a>
              </p>
              <!--<a href class="btn btn-sm btn-success btn-rounded">Follow</a>-->
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
            </div>
          </div>
          
          <div class="col-sm-4">
          <div class="col-sm-12" id="profilepic" style="display: none;background-color: #c3a96f !important;border: solid 1px gre !important;height: 106px!important;margin-top: 20px!important;border-radius: 5px!important;" >
            <div>
              <form action="app/action/change-image.php" method="post" enctype="multipart/form-data">
              <img src="images/close-button-icon-3749.png" style="width: 30px;float: right;margin-right: -15px;cursor: pointer;" onclick="hideChangeImage();" />
              <div class="form-group  col-sm-12" style="margin-top: -38px;">
                  <label></label>
                  <input type="file" name="file" id="file" class="form-control" style="padding: 4px;width: 90%;" />
              </div>
              <div class="form-group col-sm-12">
                <button type="submit" name="submit" class="btn btn-sm btn-info" style="padding: 0px 50px;font-size: 20px;" >Change</button>
              </div> 
              </form>
              </div>
              </div>
          
          </div>
           
          
          <!--<div class="col-sm-5">
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
          </div>-->
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
            <input type="hidden" name="user_id" value="<?php echo $queryResult['user_id'];?>" />
            <div class="form-group">
              <label class="col-lg-4 control-label">First Name</label>
              <div class="col-lg-8">
                <input type="text" name="fname" value="<?php echo $queryResult['firstname'];?>" class="form-control" placeholder="Name" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-4 control-label">Last Name</label>
              <div class="col-lg-8">
                <input type="text" name="lname" value="<?php echo $queryResult['lastname'];?>" class="form-control" placeholder="Name" />
              </div>
            </div>
            <!--<div class="form-group">
              <label class="col-lg-4 control-label">Company Name</label>
              <div class="col-lg-8">
                <input type="text" name="cname" value="<?php echo $queryResult['company_name'];?>" class="form-control" placeholder="Name" readonly="readonly" />
              </div>
            </div>-->
            
            <!--<div class="form-group">
              <label class="col-lg-4 control-label">Address</label>
              <div class="col-lg-8">
                <input type="text" name="address" value="<?php echo $queryResult['address'];?>" class="form-control" placeholder="City" readonly="readonly" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-4 control-label">Bank Address</label>
              <div class="col-lg-8">
                <input type="text" name="bank_address" value="<?php echo $queryResult['bank_address'];?>" class="form-control" placeholder="Bank Address" readonly="readonly" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-4 control-label">DBA</label>
              <div class="col-lg-8">
                <input type="text" name="dba" value="<?php echo $queryResult['dba'];?>" class="form-control" placeholder="dba" readonly="readonly" />
              </div>
            </div>-->
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="panel panel-default">
        <div class="panel-heading font-bold" style="text-align: center;center;background-color: #23b7e5;color: white;">Personal Information</div>
        <div class="panel-body bs-example form-horizontal">
        
        <div class="form-group">
              <label class="col-lg-4 control-label">Email</label>
              <div class="col-lg-8">
                <input type="email" name="email" value="<?php echo $queryResult['email'];?>" class="form-control" placeholder="Email" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-4 control-label">Phone</label>
              <div class="col-lg-8">
                <input type="text" name="phone" value="<?php echo $queryResult['phone'];?>" class="form-control" placeholder="Phone" />
              </div>
            </div>
            
            <!--<div class="form-group">
              <label class="col-lg-4 control-label">Business Type</label>
              <div class="col-lg-8">
                <input type="text" name="busines_type" value="<?php echo $queryResult['business_type'];?>" class="form-control" placeholder="Business Type" readonly="readonly" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-4 control-label">Billing Cycle</label>
              <div class="col-lg-8">
                <input type="text" name="billing_cycle" value="<?php echo $queryResult['billing_cycle'];?>" class="form-control" placeholder="Billing Cycle" readonly="readonly" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-4 control-label">Bank Name</label>
              <div class="col-lg-8">
                <input type="text" name="bank_name" value="<?php echo $queryResult['bank_name'];?>" class="form-control" placeholder="Bank Name" readonly="readonly" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-4 control-label">Account Number</label>
              <div class="col-lg-8">
                <input type="text" name="account_number" value="*****<?php echo substr($queryResult['account_number'],-4);?>" class="form-control" placeholder="Account Number" readonly="readonly" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-4 control-label">Name On Account</label>
              <div class="col-lg-8">
                <input type="text" name="name_on_account" value="<?php echo $queryResult['name_on_bank_account'];?>" class="form-control" placeholder="Name on Account" readonly="readonly" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-4 control-label">IFSC Code</label>
              <div class="col-lg-8">
                <input type="text" name="ifsc_code" value="<?php echo $queryResult['ifsc_code'];?>" class="form-control" placeholder="IFSC Code" readonly="readonly" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-4 control-label">SWIFT Code</label>
              <div class="col-lg-8">
                <input type="text" name="swift_code" value="<?php echo $queryResult['swift_code'];?>" class="form-control" placeholder="Swift Code" readonly="readonly" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-4 control-label">Website</label>
              <div class="col-lg-8">
                <input type="text" name="web_address" value="<?php echo $queryResult['website'];?>" class="form-control" placeholder="Website" readonly="readonly" />
              </div>
            </div>
          <br />-->
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