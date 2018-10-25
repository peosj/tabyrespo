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
<?php include('blocks/main-header.php');?>
    <!-- / main header -->
    
        <div class="bg-light lter b-b wrapper-md">
      <h1 class="m-n font-thin h3">Form Elements</h1>
    </div>

<div class="wrapper-md" ng-controller="FormDemoCtrl">
  <div class="row">
    <div class="col-sm-8">
      <div class="panel panel-default">
        <div class="panel-heading font-bold">Basic form</div>
        <div class="panel-body">
          <form action="app/action/user-details.php" method="post" role="form">
          
          <?php //echo $_GET['id'];
              
             
                $query = mysql_query("select * from cheque where cheque_id='".$_GET['id']."'");
                $queryResult = mysql_fetch_array($query);
             
              
              
              //$customerList = $queryResult['id'];
              
              ?> 
              <input type="hidden" name="id" value="<?php echo $queryResult['cheque_id'];?>" />
            <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" id="name" value="<?php echo $queryResult['name_on_account'];?>" class="form-control" placeholder="Full name" />
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="text" name="email" id="email" value="<?php echo $queryResult['email'];?>" class="form-control" placeholder="Email" onblur="emailCheck();"/>
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input type="text" name="phone" id="phone" value="<?php echo $queryResult['phone'];?>" class="form-control" placeholder="Phone" />
            </div>
            <div class="form-group">
              <label>City</label>
              <input type="text" name="city" id="city" value="<?php echo $queryResult['city'];?>" class="form-control" placeholder="City"/>
            </div>
            
            
            <!--<div class="form-group col-sm-12">
                <button type="submit" name="submit" class="btn btn-sm btn-info" style="padding: 5px 50px;font-size: 22px;">Update</button>
           </div>-->
           
           
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
