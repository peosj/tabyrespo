<?php include('./../config/config.php');?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8" />
  <title>Qyk Pay | Support Form</title>
  <meta name="description" content="app, web app, responsive, responsive layout, admin, admin panel, admin dashboard, flat, flat ui, ui kit, AngularJS, ui route, charts, widgets, components" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<?php include('blocks/head.php');?>
<script src="app/js/support_form.js" type="text/javascript"></script>
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
    <div class="row">
    <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <div style="color:#ff0000; display: none;" id="errormsg">Please fill all mendatory fields.</div>
        </div>
        <div class="col-sm-4"></div>
    </div>
      <div class="panel panel-default">
        <div class="panel-heading font-bold">Support Form</div>
        <div class="panel-body">
        <div class="row" id="error" style="display: none;width: 99%; margin: 0 auto;">
            <div class="col-sm-12" style="background: #ffe7fe; padding:10px; text-align: center;">
                Please fill all mendatory fields !
            </div>
        </div>
          <form id="frm" name="frm" action="app/action/support.php" method="post" enctype="multipart/form-data" role="form" onsubmit="return tab1ContactTypeSubmit()">
            <div class="form-group col-sm-3">
              <label>Registered Email ID</label>
              <input type="text" name="registered_email" id="registered_email" value="<?php echo $_SESSION['logemail']; ?>" class="form-control" placeholder="Enter Registered Email ID" />
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
              <textarea name="comment" id="comment" class="form-control"></textarea>
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
<div class="wrapper-md">
  <div class="panel panel-default">
    <div class="panel-heading">
      All Tickets
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
            <th  style="">Transaction Id</th>
            <th  style="">Registered Email Id</th>
            <th  style="">Business Type</th>
            <th  style="">Date</th>
            <th  style="">Action</th>
          </tr>
        </thead>
        <tbody>
                                        <?php
                                            $list_sale_sno=0;                                            
                                            $sales_list_query = "select * from support order by support_id desc ";                                            
                                            $sales_list_mysql = mysql_query($sales_list_query);
                                            while($sales_list_row = mysql_fetch_array($sales_list_mysql))
                                            {
                                                $id = $sales_list_row['support_id'];
                                                $registered_email = $sales_list_row['registered_email'];
                                                $transaction_id = $sales_list_row['transaction_id'];
                                                $support_type = $sales_list_row['support_type'];
                                                $date = $sales_list_row['date'];
                                                $list_sale_sno++;
                                                $cmt = mysql_query("select * from comment order by comment_id desc");
                                                $cmt_row = mysql_fetch_array($cmt);
                                                $cmmt = $cmt_row['comment'];
                                                echo"
                                                <tr>
                                                    <td>$list_sale_sno</td>
                                                    <td>$transaction_id</td>
                                                    <td>$registered_email</td>
                                                    <td>$support_type</td>
                                                    <td>$date</td>  
                                                    ";
                                                    echo"<td><a href='view-ticket.php?id=$id' class='btn btn-success btn-sm'>View Ticket</a></td></tr>";
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