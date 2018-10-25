<?php 
    session_start();
    include("../config/config.php");
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8" />
  <title>Qyk Pay</title>
  <meta name="description" content="app, web app, responsive, responsive layout, admin, admin panel, admin dashboard, flat, flat ui, ui kit, AngularJS, ui route, charts, widgets, components" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<script src="app/js/comment_form.js" type="text/javascript"></script> 
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
      <h1 class="m-n font-thin h3" style="text-align: center;">View Ticket Details</h1>
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
        <b>Alert!</b> &nbsp; <span id="error">Updated successfully !</span>
    </div>
  <?php } ?>
      <div class="panel panel-default">
        <div class="panel-heading font-bold">View Ticket Details</div>
        <div class="panel-body">
        <div class="row" id="error" style="display: none;width: 99%; margin: 0 auto;">
                                        <div class="col-sm-12" style="background: #ffe7fe; padding:10px; text-align: center;">
                                            Please fill all mendatory fields !
                                        </div>
        </div>
          <form id="frm" name="frm" action="app/action/update-ticket.php" method="post" enctype="multipart/form-data" role="form" onsubmit="return tab1ContactTypeSubmit()">
          <?php 
              $support_id = $_GET['id'];
              $ticket_query = "SELECT * from support where support_id = $support_id";
              $ticket_query_result = mysql_query($ticket_query);
              $ticket_query_row = mysql_fetch_array($ticket_query_result);
          ?>
            <input type="hidden" name="support_id" value="<?php echo $ticket_query_row['support_id'];?>" />
            <div class="form-group col-sm-3">
              <label>Registered Email ID</label>
              <input type="text" name="registered_email" id="registered_email" value="<?php echo $ticket_query_row['registered_email'];?>" class="form-control" placeholder="Enter Registered Email ID" />
            </div>
            <div class="form-group col-sm-3">
              <label>Transaction ID</label>
              <input type="text" name="t_id" id="t_id" value="<?php echo $ticket_query_row['transaction_id'];?>" class="form-control" placeholder="Enter Transaction ID" />
            </div>
            <div class="form-group col-sm-3">
              <label>Support Type </label>
              <select name="support_type" id="support_type" class="form-control m-b">
                <option value="">Select Support Type</option>
                <option value="Technical Issue" <?php if($ticket_query_row['support_type']=='Technical Issue'){echo "Selected";} ?>>Technical issue</option>
                <option value="Billing Department" <?php if($ticket_query_row['support_type']=='Billing Department'){echo "Selected";} ?>>Billing Department</option>
                <option value="Customer Service" <?php if($ticket_query_row['support_type']=='Customer Service'){echo "Selected";} ?>>Customer Service</option>
              </select>
            </div>
            <div class="form-group col-sm-3">
              <label>Ticket Type </label>
              <select name="ticket_type" id="ticket_type" class="form-control m-b">
                <option value="Open" <?php if($ticket_query_row['ticket_type']=='Open'){echo "Selected";} ?>>Open Ticket</option>
                <option value="Closed" <?php if($ticket_query_row['ticket_type']=='Closed'){echo "Selected";} ?>>Closed Ticket</option>
              </select>
            </div>
            <div class="form-group col-sm-12">
              <label>Comments </label>
              <textarea name="comment" id="comment" class="form-control"></textarea>
            </div>
            <br />
           <div class="form-group col-sm-12">
                <button type="submit" name="submit" class="btn btn-sm btn-info" style="padding: 5px 50px;font-size: 22px;">Update</button>
           </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col-sm-12">
    <div class="wrapper">
      <ul class="timeline">
      <li class="tl-header">
          <div class="btn btn-info">Now</div>
        </li>
   <?php 
    $comments = "select * from support_comment where support_id = '$support_id' order by support_comment_id DESC";
    $comments_query = mysql_query($comments);
    while($comments_row = mysql_fetch_array($comments_query))    
    {
                
                    if($comments_row['user_type']=='user')
                    {                        
                        $user_query = "select * from users where user_id = '".$comments_row['user_id']."'";
                        $user_sql = mysql_query($user_query);
                        $user_data = mysql_fetch_array($user_sql);
                        //echo $user_data['f_name'];
                        $user_name = $user_data['f_name']." ". $user_data['l_name'];
                        
                        if(file_exists("../app/ajax/profile/profile_pic_".$user_data['user_id'].".png"))
                        {
                            $src = "../app/ajax/profile/profile_pic_".$user_data['user_id'].".png";
                        }                       
                        else
                        {
                            $src = "../app/ajax/profile/avatar5.png";
                        }
                    }
                    
                    if($comments_row['user_type']=='admin')
                    {
                        $admin_query = "select * from admin where emp_id = '".$comments_row['user_id']."'";
                        $admin_sql = mysql_query($admin_query);
                        $admin_data = mysql_fetch_array($admin_sql);
                        
                        $user_name = $admin_data['name'];
                        
                        if(file_exists("app/ajax/profile/admin/profile_pic_".$admin_data['emp_id'].".png"))
                        {
                            $src = "app/ajax/profile/admin/profile_pic_".$admin_data['emp_id'].".png";
                        }                       
                        else
                        {
                            $src = "app/ajax/profile/admin/avatar5.png";
                        }
                    }
                    
    ?> 
        <li class="tl-item tl-left">
          <div class="tl-wrap b-primary">
            <span class="tl-date"><?php echo $comments_row['timestamp'];?></span>
            <div class="tl-content panel padder b-a block">
              <span class="arrow left pull-up hidden-left"></span>
              <span class="arrow right pull-up visible-left"></span>
              <div class="text-lt m-b-sm">
              <a href class="avatar thumb-xs m-r-xs" style="width: 45px;">
                    <img src='<?php echo $src; ?>'  class="img-circle" alt="User Image" style="height: 45px;"/>
                    <i class="on b-white left"></i>
                  </a>
              <?php echo $user_name; ?></div>
              <div class="panel-body pull-in b-t b-light">
                <p style="color: #23b7e5;"><?php echo $comments_row['comment'];?></p>
              </div>             
            </div>
          </div>
        </li> 
  <?php } ?>
          </ul>
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