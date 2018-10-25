<?php include('config/config.php');?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8" />
  <title>E-Cheque</title>
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
  <h1 class="m-n font-thin h3" style="text-align: center;">Search Details</h1>
</div>
<div class="wrapper-md">
  <div class="panel panel-default">
    <div class="panel-heading">
      Search Details
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
            <th>Name</th>
            <th>Email</th>   
            <th>Phone</th>                                                
            <th>City</th>
            <th>Routing No.</th>                                               
            <th>Cheque No.</th> 
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

                                       

                                        <?php
                                           
                                                $condition = "";

                                                if(isset($_GET['search']) && strlen($_GET['search'])>0)
                                                {
                                                    $search = strip_tags(trim($_GET['search']));
                                                    $condition = "
                                                     AND 
                                                     (
                                                        name_on_account LIKE '".$search."%'
                                                        OR email LIKE '".$search."%'
                                                        OR phone LIKE '".$search."%'
                                                        OR cheque_number LIKE '".$search."%'
                                                        
                                                       )           
                                                    ";
                                                }
                                                
                                        
                                            $sales_list_query = "select * from cheque where 1=1".$condition;
                                            
                                            $list_sale_sno=0;                                            
                                            //$sales_list_query = "select * from user where 1=1".$condition;                                            
                                            $sales_list_mysql = mysql_query($sales_list_query);
                                            while($sales_list_row = mysql_fetch_array($sales_list_mysql))
                                            {
                                                $id = $sales_list_row['cheque_id'];
                                                $name = $sales_list_row['name_on_account'];
                                                $email = $sales_list_row['email'];
                                                $phone = $sales_list_row['phone'];
                                                $city = $sales_list_row['city'];
                                                $routing_number = $sales_list_row['routing_number'];
                                                $cheque_number = $sales_list_row['cheque_number'];
                                                $list_sale_sno++;
                                                echo"
                                                <tr>
                                                    <td>$list_sale_sno</td>
                                                    <td>$name</td>
                                                    <td>$email</td>   
                                                    <td>$phone</td>
                                                    <td>$city</td>                                                 
                                                    <td>$routing_number</td>
                                                    <td>$cheque_number</td>
                                                    <td>";
                                                   
                                                       echo "<a href='./view-cheque-details.php?id=$id' class='btn btn-success btn-sm'>View Cheque</a>"; 
                                                    
                                                    
                                                
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



</div>

<?php include('blocks/footer-scripts.php');?>

</body>
</html>
