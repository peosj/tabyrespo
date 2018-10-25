<?php 
    session_start();
    include("../config/config.php");
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8" />
  <title>Qyk Pay | Users</title>
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
<div class="bg-light lter b-b wrapper-md">
  <h1 class="m-n font-thin h3" style="text-align: center;">All Users</h1>
</div>
<div class="wrapper-md">
  <?php if(@$_GET['msg']=='enable_disable_error'){?>
    <div class="alert alert-danger alert-dismissable" id="errormsg" style="display: block; width: 97%;">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <b>Alert!</b> &nbsp; <span id="error">Somthing went wrong !</span>
    </div>
    <?php } ?>
    <?php if(@$_GET['msg']=='enable_disable_success'){?>
    <div class="alert alert-success alert-dismissable" id="errormsg" style="display: block; width: 100%;">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <b>Alert!</b> &nbsp; <span id="error">User status changed successfully !</span>
    </div>
  <?php } ?>
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
        <b>Alert!</b> &nbsp; <span id="error">User deleted successfully !</span>
    </div>
  <?php } ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      All Users
    </div>
    <div class="table-responsive">
      <table ui-jq="dataTable" ui-options="{
          sAjaxSource: 'api/datatable.json',
          aoColumns: [
            { mData: 'engine' },
            { mData: 'browser' },
            { mData: 'platform' },
            { mData: 'version' },
            { mData: 'grade' }
          ]
        }" class="table table-striped b-t b-b">
        <thead>
          <tr>
            <th>Sno</th>
            <th>Login Id</th>
            <th>First Name</th>   
            <th>Last Name</th>
            <th>Email</th> 
            <th>Contact No.</th>
            <th class="col-sm-2">Action</th>
          </tr>
        </thead>
        <tbody>
                                        <?php
                                            $list_sale_sno=0;                                            
                                            $sales_list_query = "select * from users ORDER BY user_id DESC";                                            
                                            $sales_list_mysql = mysql_query($sales_list_query);
                                            while($sales_list_row = mysql_fetch_array($sales_list_mysql))
                                            {
                                                $user_id = $sales_list_row['user_id'];
                                                //$login_id = $sales_list_row['login_id'];
                                                $f_name = $sales_list_row['firstname'];
                                                $l_name = $sales_list_row['lastname'];
                                                $email = $sales_list_row['email'];
                                                $contact_number = $sales_list_row['phone'];
                                                $status = $sales_list_row['status'];
                                                $list_sale_sno++;
                                                echo"
                                                <tr>
                                                    <td>$list_sale_sno</td>
                                                    <td>$user_id</td>
                                                    <td>$f_name</td>   
                                                    <td>$l_name</td>
                                                    <td>$email</td>
                                                    <td>$contact_number</td>
                                                    
                                                    <td>";
                                                    if($status == 1)
                                                    {
                                                        echo"<a href='app/action/user_enable_disable.php?id=$user_id&status=1' class='btn btn-success btn-sm'>Disable</a>";
                                                    }
                                                    if($status == 0)
                                                    {
                                                        echo"<a href='app/action/user_enable_disable.php?id=$user_id&status=0' class='btn btn-danger btn-sm'>Enable</a>";
                                                    }                                                    
                                                echo"
                                                <a href='app/action/delete-user.php?id=$user_id' class='btn btn-success btn-sm' onclick='return confirm(\"Are you sure to delete this user.\");'>Delete</a>
                                                </td></tr>
                                                ";
                                            }
                                        ?>
                                        </tbody>
      </table>
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
<form name="frm_pay" method="post" action="app/action/update-cheque-status.php">
<input type="hidden" name="cheque" id="cheque"  />
<input type="hidden" name="cheque_id" id="cheque_id" class="caseid"  />
<input type="hidden" value="dashboard" name="dashboard" id="dashboard" class="dashboard" />
</form>
<script>
function updateStatus(id,tid)
{
    alert(id);
    alert(tid);
    var cheque_status = document.getElementById(id).value;
    //var id = document.getElementById('id').value;
    alert(cheque_status);
    alert(id);
    document.getElementById('cheque').value = cheque_status;
    document.getElementById('cheque_id').value =tid;
    document.frm_pay.submit();
}
</script>
</div>
<?php include('blocks/footer-scripts.php');?>
</body>
</html>