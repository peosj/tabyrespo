<?php 
    @session_start();
    include("config/config.php");
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8" />
  <title>Billing - E-Cheque</title>
  <meta name="description" content="app, web app, responsive, responsive layout, admin, admin panel, admin dashboard, flat, flat ui, ui kit, AngularJS, ui route, charts, widgets, components" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<?php include('blocks/head.php');?>
<script src="app/js/amount_form.js" type="text/javascript"></script>
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
<?php
//echo $_SESSION['logid']; 
$query = mysql_query("select * from users where user_id='".$_SESSION['logid']."'");
$queryResult = mysql_fetch_array($query);
?>	    

<div class="bg-light lter b-b wrapper-md hidden-print">
  <!--<a href class="btn btn-sm btn-info pull-right" onClick="window.print();">Print</a>-->
  <h1 class="m-n font-thin h3">Transaction History</h1>
</div>
<div class="wrapper-md">
<?php if(@$_GET['msg']=='success'){?>
        <div class="alert alert-success alert-dismissable" id="errormsg" style="display: block; width: 100%;">
            <i class="fa fa-ban"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <b>Alert!</b> &nbsp; <span id="error">Request done successfully !</span>
        </div>
        <?php } ?>
        <?php if(@$_GET['msg']=='error'){?>
        <div class="alert alert-success alert-dismissable" id="errormsg" style="display: block; width: 100%;">
            <i class="fa fa-ban"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <b>Alert!</b> &nbsp; <span id="error">Requested amount excedded from your main balance !</span>
        </div>
        <?php } ?>
  <div>
    <div class="well m-t bg-light lt">
      <div class="row">
       <?php
       $balance_query = "select balance from balance where user_id = '".$_SESSION['logid']."'";        
        $balance_sql = mysql_query($balance_query);
        $balance_data = mysql_fetch_array($balance_sql);
        
       ?>
        <div class="col-xs-4">
          <strong>Current Balance:</strong>
          <h2>$<?php echo $balance_data['balance']; ?>/-</h2>
          <p>
          <?php
          if($withdrawal_cnt == 0)
            {
             ?>
                Initiate your request for <br/>first withdraw.<br/>
             <?php   
            }
            else
            {
                $withdrawal_data = mysql_fetch_array($withdrawal_sql);
                $last_withdraw = $withdrawal_data['amount'];
                ?>
                Last Payment<br>
                <?php echo $withdrawal_data['timestamp']; ?> For $<?php echo $last_withdraw; ?>/-<br>
                <?php
            }
          ?>
            
            <button class="btn btn-default btn-xs btn-info" data-toggle="modal" data-target="#myModal" style="margin-top: 20px;">Request Payment</button><br>            
          </p>
        </div>
        <div class="col-xs-4">
          <strong>How You Get Paid:</strong>
          <h4>Bank: <?php echo $queryResult['bank_name']; ?></h4>
          <p>
            Account No: ******<?php echo substr($queryResult['account_number'],-4); ?><br>
            IFSC Code: <?php echo $queryResult['ifsc_code']; ?><br>
            Swift Code: <?php echo $queryResult['swift_code']; ?><br>
            <!--<button class="btn btn-default btn-xs btn-info" style="margin-top: 20px;">Update Information</button><br>-->
          </p>
        </div>
        <div class="col-xs-4">
          <strong>Profile:</strong>
          <h4><?php echo $queryResult['f_name']; ?> <?php echo $queryResult['l_name']; ?></h4>
          <p>
            Email: <?php echo $queryResult['email']; ?><br>
            Phone: <?php echo $queryResult['contact_number']; ?><br>
            Address: <?php echo $queryResult['address']; ?><br>            
            <!--<button class="btn btn-default btn-xs btn-info" style="margin-top: 20px;">Update Information</button><br>-->            
          </p>
        </div>
      </div>
    </div>
    <div class="line"></div>
    <table class="table table-striped bg-white b-a">
      <thead>
        <tr>
          <th style="width: 60px">TIMESTAMP</th>
          <th>DESCRIPTION</th>
          <th style="width: 140px">Debits</th>
          <th style="width: 140px">Credits</th>
          <th style="width: 140px">Processing Fee</th>
          <th style="width: 140px">Reserved Credits</th>
          <th style="width: 140px">Reserved Balance</th>
          <th style="width: 90px">Balance</th>
        </tr>
      </thead>
      <tbody>
      <?php 
        $billing_query = "select * from billing where user_id = '".$_SESSION['logid']."' ORDER BY billing_id DESC";
        //echo $billing_query; 
        $billing_sql = mysql_query($billing_query);
        while($billing_data = mysql_fetch_array($billing_sql))
        {
            echo"
                <tr>
                  <td>".$billing_data['timestamp']."</td>
                  <td>".$billing_data['description']."</td>
                  <td>$".$billing_data['debits']."</td>
                  <td>$".$billing_data['credits']."</td>
                  <td>$".$billing_data['processing_fee']."</td>
                  <td>$".$billing_data['reserved_credit']."</td>
                  <td>$".$billing_data['reserved_balance']."</td>
                  <td>$".$billing_data['balance']."</td>
                </tr>
            ";
        }
      ?>
      </tbody>
    </table>              
  </div>
</div>


	</div>
  </div>
  <!-- /content -->
  <!-- footer -->
<?php include('blocks/footer.php');?>
  <!-- / footer -->
  
  
  <div class="container">
  <!-- Trigger the modal with a button -->
  <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>-->

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="text-align: center;">Request Amount</h4>
        </div>
        <div class="modal-body">
        <?php if(@$_GET['msg']=='balance_error'){?>
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
            <b>Alert!</b> &nbsp; <span id="error">Request submited successfully !</span>
        </div>
        <?php } ?>
        <?php if(@$_GET['msg']=='berror'){?>
        <div class="alert alert-success alert-dismissable" id="errormsg" style="display: block; width: 100%;">
            <i class="fa fa-ban"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <b>Alert!</b> &nbsp; <span id="error">Requested amount excedded from your main balance !</span>
        </div>
        <?php } ?>
        <div style="color:#ff0000; display: none;text-align: center;" id="errormsg">Please fill all mendatory fields.</div>
        <br />
          <form id="frm" name="frm" action="app/action/request-amount.php" method="post" class="bs-example form-horizontal" onsubmit="return tab1ContactTypeSubmit()">
          
          <div class="form-group">
              <label class="col-lg-3 control-label">Enter Amount</label>
              <div class="col-lg-8">
                <input type="text" name="amount" id="amount" onkeypress="return isNumberKey(event)" class="form-control" placeholder="Enter Amount" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Disclaimer</label>
              <div class="col-lg-8">
                <p>Note : Your requested amount must be greater than or equal to $1000.</p>
              </div>
            </div>
            
          <div class="form-group" style="text-align: center;">
            <button type="submit" name="submit" class="btn btn-sm btn-info" style="text-align: center;margin-top: 20px;font-size: 18px;">Submit</button>
          </div>
          </form>
        </div>
        <!--<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>-->
      </div>
      
    </div> 
  </div>
  
</div>
  
</div>
<?php include('blocks/footer-scripts.php');?>
</body>
</html>