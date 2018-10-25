<?php include('../config/config.php');?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8" />
  <title>Qyk Pay</title>
  <meta name="description" content="app, web app, responsive, responsive layout, admin, admin panel, admin dashboard, flat, flat ui, ui kit, AngularJS, ui route, charts, widgets, components" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<?php include('blocks/head.php');?>
<script src="app/js/withdrawal_request_form.js" type="text/javascript"></script>
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
  <h1 class="m-n font-thin h3" style="text-align: center;">Pending Withdrawal Request</h1>
</div>
<div class="wrapper-md">

<?php if(@$_GET['msg']=='error'){?>
        <div class="alert alert-danger alert-dismissable" id="errormsg" style="display: block; width: 100%;">
            <i class="fa fa-ban"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <b>Alert!</b> &nbsp; <span id="error">Your main balance is not greater than or equal $1000 !</span>
        </div>
        <?php } ?> 
        <?php if(@$_GET['msg']=='success'){?>
        <div class="alert alert-success alert-dismissable" id="errormsg" style="display: block; width: 100%;">
            <i class="fa fa-ban"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <b>Alert!</b> &nbsp; <span id="error">Check processed successfully !</span>
        </div>
        <?php } ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      Pending Withdrawal Request
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
            <th  style="">Date</th>
            <th style="">Withdrawal Status</th>
            <th  style="">Action</th>
          </tr>
        </thead>
        <tbody>
                                        <?php
                                            $list_sale_sno=0;                                            
                                            $sales_list_query = "select * from withdrawal_request where status = 0 order by withdrawal_request_id desc ";                                            
                                            $sales_list_mysql = mysql_query($sales_list_query);
                                            while($sales_list_row = mysql_fetch_array($sales_list_mysql))
                                            {
                                                $id = $sales_list_row['withdrawal_request_id'];
                                                $amount = $sales_list_row['amount'];
                                                $user_id = $sales_list_row['user_id'];
                                                $date = $sales_list_row['date'];
                                                $list_sale_sno++;
                                                echo"
                                                <tr>
                                                    <td>$list_sale_sno</td>
                                                    <td>$amount</td>
                                                    <td>$user_id</td>
                                                    <td>$date</td>
                                                    "; echo "<td>"; ?>
                                                            <form name="frm" action="app/action/update-withdrawal-request.php" method="post">
                                                            <input type="hidden" name="withdrawal_request_id" value="<?php echo $id;?>" />
                                                            <input type="hidden" name="withdrawal_amount" value="<?php echo $amount;?>" />
                                                            <input type="hidden" name="declined_comment" value="<?php echo $list_sale_sno;?>" />
                                                              <!--<label class="col-lg-3 control-label">Withdrawal Status</label>-->
                                                              <div class="col-lg-5">
                                                                  <select name="withdrawal_status" id="withdrawal_status_<?php echo $list_sale_sno;?>" required="required" class="form-control m-b">
                                                                      <option value="Pending" onclick="hideComment('<?php echo $list_sale_sno;?>');">Pending</option>
                                                                      <option value="Approved" onclick="hideComment('<?php echo $list_sale_sno;?>');">Approved</option>
                                                                      <option value="Declined" onclick="showComment('<?php echo $list_sale_sno;?>');">Declined</option>
                                                                  </select>
                                                              </div>
                                                            
                                                            <script>
                                                             function showComment(id)
                                                              {
                                                               
                                                                
                                                                    document.getElementById('cmnt_'+id).style.display = "block";
                                                               
                                                              }
                                                              function hideComment(id)
                                                              {
                                                                    document.getElementById('cmnt_'+id).value = "";
                                                                    document.getElementById('cmnt_'+id).style.display = "block";
                                                                    document.getElementById('cmnt_'+id).style.display = "none";
                                                                
                                                              }
                                                            </script>
                                                            <div class="col-sm-10" id="cmnt_<?php echo $list_sale_sno;?>" style="display: none;" >   
                                                                    <div class="form-group" id="cmt">              
                                                                      <div class="col-lg-12">
                                                                      <!--<label class="control-label">Comment</label>--><br />
                                                                        <textarea class="form-control" name="comment_<?php echo $list_sale_sno;?>" id="comment_<?php echo $list_sale_sno;?>" placeholder="Enter your comment"></textarea>
                                                                      </div>
                                                                    </div>
                                                            </div>
                                                            <?php echo "</td>"; ?>
                                                            <?php echo "<td>"; ?>
                                                            <div class="form-group">
                                                                <button type="submit" name="submit" onclick="confirm('Are you sure !');" class="btn m-b-xs w-xs btn-info btn-rounded" style="padding-left:10px; padding-right: 10px; width: auto;">Submit</button>
                                                              
                                                            </div>
                                                            <?php echo "</td>"; ?>
                                                            </form>
                                      <?php     }
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

<script>
function updateRequest()
{

    document.frm.submit();
}
</script>
</div>
<?php include('blocks/footer-scripts.php');?>
</body>
</html>