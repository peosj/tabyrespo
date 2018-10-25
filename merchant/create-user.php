<?php 
    session_start();
    include("config/config.php");
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8" />
  <title>Html version | Angulr</title>
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
	    

<div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="
    app.settings.asideFolded = false; 
    app.settings.asideDock = false;
  ">
  <!-- main -->
  <div class="col">
    <!-- main header -->
<?php include('blocks/main-header.php');?>
    <!-- / main header -->
    
    
    <div class="bg-light lter b-b wrapper-md">
      <h1 class="m-n font-thin h3">Form Elements</h1>
    </div>
<div class="wrapper-md" ng-controller="FormDemoCtrl">
  <div class="row">

    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading font-bold">Basic form</div>
        <div class="panel-body">
          <form id="frm" name="frm" action="app/action/create-user.php" method="post" enctype="multipart/form-data" role="form">
          
          
          <script>                                        
                    function updateManager()
                    {
                            var profile = document.getElementById('profile').value;                                                                               
                            $.ajax
                                ({
                                    type: "POST",
                                    url: "app/ajax/register_update_manager.php",                                                                         
                                    data: "profile="+profile,                                                                
                                    success: function(msg)
                                        {                                                                                                                                                                            
                                             document.getElementById('manager').innerHTML = msg;                                                                                                                                                                                                                      
                                        }
                                });
                    }                                                            
                    </script>
          
          
            <div class="form-group col-sm-3">
              <label>Select Profile</label>
              <select name="profile" id="profile" class="form-control m-b" onchange="updateManager();">
              <?php 
                        $user_hierarchy = array();
                        $prfl = mysql_query("select * from user_hierarchy where priority < (select priority from user_hierarchy where value = '".$_SESSION['logprofile']."') ORDER BY priority ASC");
                        while($prfl_row = mysql_fetch_array($prfl))
                        {
                            $user_hierarchy[$prfl_row['value']] = $prfl_row['priority'];
                            echo"<option value='".$prfl_row['value']."'>".$prfl_row['usual_name']."</option>"; 
                        }
              ?> 
            </select>
            </div>
            <div class="form-group col-sm-3">
              <label>Select Manager</label>
              <select name="manager" id="manager" class="form-control m-b">
              <option value="">Select Manager</option>
                    <?php
                        $sql = "select * from user where profile IN (select value from user_hierarchy where priority > (select priority from user_hierarchy where value = 'rm') AND status = '1') ORDER BY name";
                        $prfl = mysql_query($sql);                                                        
                        while($prfl_row = mysql_fetch_array($prfl))
                            {
                                echo"<option value='".$prfl_row['emp_id']."'>".$prfl_row['name']."</option>";
                            }
                    ?>
            </select>
            </div>
            
            
            <div class="form-group col-sm-3">
              <label>Employee ID</label>
              <input type="text" name="emp_id" id="emp_id" class="form-control" placeholder="Enter email" />
            </div>
            
            <div class="form-group col-sm-3">
              <label>Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Enter email" />
            </div>
            
            <div class="form-group col-sm-3">
              <label>Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" onblur="emailCheck();" />
            </div>
            
            <div class="form-group col-sm-3">
              <label>Phone</label>
              <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter email" />
            </div>
            
            <div class="form-group col-sm-3">
              <label>City</label>
              <input type="text" name="city" id="city" class="form-control" placeholder="Enter email" />
            </div>
            
            <div class="form-group col-sm-3">
              <label>Address</label>
              <input type="text" name="address" id="address" class="form-control" placeholder="Enter email" />
            </div>
            <div class="form-group col-sm-3">
              <label>Profile Pic</label>
              <input type="file" name="file" id="file" class="form-control" placeholder="Enter email" style="padding: 0px;" />
            </div>
            
            <div class="form-group col-sm-3">
              <label>Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter email" />
            </div>
            
            <div class="form-group col-sm-3">
              <label>Confirm Password</label>
              <input type="password" name="password1" id="password1" class="form-control" placeholder="Enter email" onblur="chkRepeatPassword();" />
            </div>
            <br />
           <div class="form-group col-sm-12">
                <button type="submit" class="btn btn-sm btn-info" style="padding: 5px 50px;font-size: 22px;">Submit</button>
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
