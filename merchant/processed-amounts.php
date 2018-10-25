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
  <h1 class="m-n font-thin h3" style="text-align: center;">Pending Cheques</h1>
</div>
<div class="wrapper-md">
  <div class="panel panel-default">
    <div class="panel-heading">
      Pending Cheques
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
            <th  style="">Sno</th>
            <th  style="">User ID</th>
            <th  style="">Name</th>
            <th  style="">Phone</th>
            <th  style="">Amount</th>
            <th  style="">Cheque Number</th>
            <th  style="">Cheque Status</th>
            <th  style="">Action</th>
          </tr>
        </thead>
        <tbody>
                                        <?php
                                            $list_sale_sno=0;                                            
                                            $sales_list_query = "select * from cheque where cheque_status='Processed' AND user_id = '".$_SESSION['logid']."' order by cheque_id desc ";                                            
                                            $sales_list_mysql = mysql_query($sales_list_query);
                                            while($sales_list_row = mysql_fetch_array($sales_list_mysql))
                                            {
                                                $id = $sales_list_row['cheque_id'];
                                                $user_id = $sales_list_row['user_id'];
                                                $name = $sales_list_row['name_on_account'];
                                                $phone = $sales_list_row['phone'];
                                                $email = $sales_list_row['email'];
                                                $bank_name = $sales_list_row['bank_name'];
                                                $city = $sales_list_row['city'];
                                                $amount = $sales_list_row['amount'];
                                                $cheque_number = $sales_list_row['cheque_number'];
                                                $date = $sales_list_row['date'];
                                                $cheque_status = $sales_list_row['cheque_status'];
                                                $list_sale_sno++;
                                                echo"
                                                <tr>
                                                    <td>$list_sale_sno</td>
                                                    <td>$user_id</td>
                                                    <td>$name</td>
                                                    <td>$phone</td>
                                                    <td>$amount</td>
                                                    <td>$cheque_number</td>
                                                    <td>$cheque_status</td> 
                                                    ";
                                                            echo"<td><a href='view-cheque-detail.php?id=$id' class='btn btn-success btn-sm'>View Cheque Details</a></td></tr>";
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
    //alert(id);
    //alert(tid);
    var cheque_status = document.getElementById(id).value;
    //var id = document.getElementById('id').value;
    //alert(cheque_status);
    //alert(id);
    document.getElementById('cheque').value = cheque_status;
    document.getElementById('cheque_id').value =tid;
    document.frm_pay.submit();
}
</script>
</div>
<?php include('blocks/footer-scripts.php');?>
</body>
</html>