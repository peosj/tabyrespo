<?php include('../config/config.php');?>
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
<div class="bg-light lter b-b wrapper-md">
  <h1 class="m-n font-thin h3" style="text-align: center;">Approved Withdrawal Request</h1>
</div>
<div class="wrapper-md">
  <div class="panel panel-default">
    <div class="panel-heading">
      Approved Withdrawal Request
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
            <th  style="">Amount</th>
            <th  style="">User ID</th>
            <th style="">Withdrawal Status</th>
            <th  style="">Date</th>
            <!--<th  style="">Action</th>-->
          </tr>
        </thead>
        <tbody>
                                        <?php
                                            $list_sale_sno=0;                                            
                                            $sales_list_query = "select * from withdrawal_request where status = 1 order by withdrawal_request_id desc ";                                            
                                            $sales_list_mysql = mysql_query($sales_list_query);
                                            while($sales_list_row = mysql_fetch_array($sales_list_mysql))
                                            {
                                                $id = $sales_list_row['withdrawal_request_id'];
                                                $amount = $sales_list_row['amount'];
                                                $user_id = $sales_list_row['user_id'];
                                                $status =  $sales_list_row['status'];
                                                $date = $sales_list_row['date'];
                                                if($status =='1') 
                                                {
                                                    $statuss = 'Approved';
                                                }
                                                $list_sale_sno++;
                                                echo"
                                                <tr>
                                                    <td>$list_sale_sno</td>
                                                    <td>$amount</td>
                                                    <td>$user_id</td>
                                                    <td>$statuss</td>
                                                    <td>$date</td> 
                                                    ";
                                                            //echo"<td><a href='view-cheque-detail.php?id=$id' class='btn btn-success btn-sm'>View Check Details</a></td></tr>";
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