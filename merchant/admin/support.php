<?php 

    session_start();

    include("config/config.php");

?>

<!DOCTYPE html>

<html lang="en" class="">

<head>

  <meta charset="utf-8" />

  <title>Qyk Pay | Support</title>

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

      <h1 class="m-n font-thin h3" style="text-align: center;">Support Form</h1>

    </div>

<div class="wrapper-md" ng-controller="FormDemoCtrl">

  <div class="row">



    <div class="col-sm-12">

      <div class="panel panel-default">

        <div class="panel-heading font-bold">Support Form</div>

        <div class="panel-body">

          <form id="frm" name="frm" action="app/action/support.php" method="post" enctype="multipart/form-data" role="form">



            <div class="form-group col-sm-3">

              <label>Registered Email ID</label>

              <input type="text" name="registered_email" id="registered_email" class="form-control" placeholder="Enter Registered Email ID" />

            </div>

            

            <div class="form-group col-sm-3">

              <label>Transaction ID </label>

              <input type="text" name="transaction_id" id="transaction_id" class="form-control" placeholder="Enter Transaction ID" />

            </div>

            

            <div class="form-group col-sm-3">

              <label>Support Type </label>

              <select name="support_type" id="support_type" class="form-control m-b">

                <option value="">Select Support Type</option>

                <option value="Technical Issue">Technical issue</option>

                <option value="Billing Department">Billing Department</option>

                <option value="Customer Service">Customer Service</option>

                    

              </select>

            </div>

            

            <div class="form-group col-sm-9">

              <label>Comments </label>

              <textarea name="comment" class="form-control"></textarea>

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

