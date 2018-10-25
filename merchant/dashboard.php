<?php 
session_start();
include('config/config.php');?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8" />
  <title>Dashboard | QykPay</title>
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


<div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="
    app.settings.asideFolded = false; 
    app.settings.asideDock = false;
  ">
  <!-- main -->
  <div class="col">
    <!-- main header -->
    <div class="bg-light lter b-b wrapper-md">
      <div class="row">
        <div class="col-sm-6 col-xs-12">
          <h1 class="m-n font-thin h3 text-black">Dashboard</h1>
          <small class="text-muted">Welcome <?php echo $_SESSION['logname']; ?></small>
        </div>
       
      </div>
    </div>
    <!-- / main header -->
    <div class="wrapper-md" ng-controller="FlotChartDemoCtrl">
      <!-- stats -->
      <div class="row">
<?php
$billing_query = "select SUM(amount) from transaction where user_id = '".$_SESSION['logid']."'";
$billing_sql = mysql_query($billing_query);
$balance_data = mysql_fetch_array($billing_sql);
?>      
         <div class="col-lg-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="clearfix text-center m-t">
            <div class="inline">
              <div style="width: 134px; height: 134px; line-height: 134px;" class="easyPieChart" ui-jq="easyPieChart" ui-options="{
                    percent: 75,
                    lineWidth: 5,
                    trackColor: '#e8eff0',
                    barColor: '#23b7e5',
                    scaleColor: false,
                    color: '#3a3f51',
                    size: 134,
                    lineCap: 'butt',
                    rotate: -90,
                    animate: 1000
                  }">
                <div class="thumb-xl">
                  <img src="
                  <?php

                        if(file_exists("admin/app/ajax/profile/user/profile_pic_".$_SESSION['logid'].".png"))

                        {

                            echo"admin/app/ajax/profile/user/profile_pic_".$_SESSION['logid'].".png";

                        }                       

                        else

                        {

                            echo"app/ajax/profile/avatar5.png";

                        }

                    ?>
                  " class="img-circle" style="width: 125px;height: 125px;" alt="...">
                </div>
              <canvas width="134" height="134"></canvas></div>
              <div class="h4 m-t m-b-xs"><?php echo $_SESSION['logname']; ?></div>
            </div>                      
          </div>
        </div>
        <footer class="panel-footer bg-info text-center no-padder">
          <div class="row no-gutter">
            <div class="col-xs-4">
              <div class="wrapper">
                <span class="m-b-xs h3 block text-white">RM<?php echo $balance_data['SUM(amount)']; ?></span>
                <small class="text-muted">Main Balance</small>
              </div>
            </div>
            <div class="col-xs-4 dk">
              <div class="wrapper">
                <span class="m-b-xs h3 block text-white">RM0</span>
                <small class="text-muted">Disbursement</small>
              </div>
            </div>
            <div class="col-xs-4">
              <div class="wrapper">
                <span class="m-b-xs h3 block text-white">RM<?php echo $balance_data['SUM(amount)']; ?></span>
                <small class="text-muted">Grand Total</small>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    
    <?php
            //echo "select cheque_status,amount,user_id from cheque where cheque_status='Pending' AND user_id = '".$_SESSION['logid']."'"; 
            $query = mysql_query("select status from transaction where status='successfull' AND user_id = '".$_SESSION['logid']."'");
            $successfull_row = mysql_num_rows($query);
            $query1 = mysql_query("select status from transaction where status='cancelled' AND user_id = '".$_SESSION['logid']."'");
            $cancelled_row = mysql_num_rows($query1);
            $query2 = mysql_query("select status from transaction where status='refund' AND user_id = '".$_SESSION['logid']."'");
            $refund_row = mysql_num_rows($query2);
            $ticket_open = mysql_query("select status from transaction where status='successfull' AND user_id = '".$_SESSION['logid']."'");
            $ticket_open_cnt = mysql_num_rows($ticket_open);
            $ticket_closed = mysql_query("select status from transaction where status='successfull' AND user_id = '".$_SESSION['logid']."'");
            $ticket_closed_cnt = mysql_num_rows($ticket_closed);
            $users = mysql_query("select user_id from users");
            $user_cnt = mysql_num_rows($users);
            //echo "select amount transaction where status='successfull' AND user_id = '".$_SESSION['logid']."'";
            //echo $_SESSION['logid'];
            $amount_query = mysql_query("select amount from transaction where status='successfull' AND user_id = '".$_SESSION['logid']."'");
            $successfull_amt = 0;
            while($successfull_amount = mysql_fetch_array($amount_query))
            {
                
               $successfull_amt = $successfull_amount['amount']+$successfull_amt;
            }
            $cancelled_query = mysql_query("select amount from transaction where status='cancelled' AND user_id = '".$_SESSION['logid']."'");
            $cancelled_cnt = mysql_num_rows($cancelled_query);
            $cancelled_amt = 0;
            while($cancelled_amount = mysql_fetch_array($cancelled_query))
            {
                
               $cancelled_amt = $cancelled_amount['amount']+$cancelled_amt;
            }
            $refund_query = mysql_query("select amount from transaction where status='refund' AND user_id = '".$_SESSION['logid']."'");
            $refund_amt = 0;
            while($refund_amount = mysql_fetch_array($refund_query))
            {
                
               $refund_amt = $refund_amount['amount']+$refund_amt;
            }
            $configuration_query = mysql_query("select * from configuration");
            $configuration_row = mysql_fetch_array($configuration_query);
            $configuration_value = $configuration_row['value'];
            $total_payout = $processed_amt-($configuration_value * $declined_cnt);
        ?> 
    
        <div class="col-md-6">
          <div class="row row-sm text-center">
            <div class="col-xs-6">
            <a href="#" target="_blank">
              <div class="panel padder-v item">
                <div class="h1 text-info font-thin h1">5<?php //echo $successfull_row;?></div>
                <span class="text-muted text-xs">Total Users</span>
                <div class="top text-right w-full">
                  <i class="fa fa-caret-down text-warning m-r-sm"></i>
                </div>
              </div>
              </a>
            </div>
            <div class="col-xs-6">
              <a href="#" class="block panel padder-v bg-primary item" target="_blank">
                <span class="text-white font-thin h1 block">2<?php //echo $declined_amt;?></span>
                <span class="text-muted text-xs">Returned Users</span>
                <span class="bottom text-right w-full">
                  <i class="fa fa-cloud-upload text-muted m-r-sm"></i>
                </span>
              </a>
            </div>
            <div class="col-xs-6">
              <a href="#" class="block panel padder-v bg-info item" target="_blank">
                <span class="text-white font-thin h1 block">RM<?php echo $cancelled_amt;?></span>
                <span class="text-muted text-xs">Canclled Amount</span>
                <span class="top">
                  <i class="fa fa-caret-up text-warning m-l-sm m-r-sm"></i>
                </span>
              </a>
            </div>
            <div class="col-xs-6">
            <a href="#" target="_blank">
              <div class="panel padder-v item">
                <div class="font-thin h1">RM<?php echo $refund_amt;?></div>
                <span class="text-muted text-xs">Refund Amount</span>
                <div class="bottom">
                  <i class="fa fa-caret-up text-warning m-l-sm m-r-sm"></i>
                </div>
              </div>
              </a>
            </div>
            <div class="col-xs-12 m-b-md">
              <div class="r bg-light dker item hbox no-border">
                <div class="col w-xs v-middle hidden-md">
                  <div ng-init="d3_3=[60,40]" ui-jq="sparkline" ui-options="[60,40], {type:'pie', height:40, sliceColors:['#fad733','#fff']}" class="sparkline inline"></div>
                </div>
                <div class="col dk padder-v r-r">
                  <div class="text-primary-dk font-thin h1"><span>RM<?php echo $successfull_amt;?></span></div>
                  <span class="text-muted text-xs">Claimed Transaction</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- / stats -->




<?php
$transaction_query = "
SELECT user_id,
           SUM(CASE WHEN status = 'successfull' THEN 1 ELSE 0 END) AS 'successfull_transaction',
           SUM(CASE WHEN status = 'refund' THEN 1 ELSE 0 END) AS 'refund_transaction',
           SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) AS 'cancelled_transaction'
    FROM   transaction where user_id = '".$_SESSION['logid']."'
    GROUP BY user_id
    ORDER BY sno DESC
";
$transaction_sql = mysql_query($transaction_query);
$transaction_data = mysql_fetch_array($transaction_sql); 
//echo $transaction_query;
?>


<div class="row">
    <div class="col-lg-6">
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default">
            <a href="" class="text-muted m-t-sm m-l inline" ng-click="data=[40, 40, 20]"><i class="icon-pie-chart"></i></a>
            <div class="text-center wrapper m-b-sm">              
              <div ui-refresh="data" ui-jq="sparkline" ui-options="
              [<?php echo $successfull_amt; ?>, <?php echo $refund_amt; ?>, <?php echo $cancelled_amt; ?>], 
              {
                type:'pie', 
                height:126, 
                sliceColors:['#7266ba','#23b7e5','#fad733']
              }
              " class="sparkline inline"><canvas height="126" width="126" style="display: inline-block; width: 126px; height: 126px; vertical-align: top;"></canvas></div>
            </div>
            <ul class="list-group no-radius">
              <li class="list-group-item">
                <span class="pull-right"><a href="#" target="_blank">$<?php echo $successfull_amt; ?></a></span>
                <span class="label bg-primary">1</span>
                Successfull Transactions
              </li>
              <li class="list-group-item">
                <span class="pull-right"><a href="#" target="_blank">$<?php echo $cancelled_amt; ?></a></span>
                <span class="label bg-info">2</span>
                Cancelled Transactions
              </li>
              <li class="list-group-item">
                <span class="pull-right"><a href="#" target="_blank">$<?php echo $refund_amt; ?></a></span>
                <span class="label bg-warning">3</span>
                Refund Transactions
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
 
 
 <?php 
    $current_month = date("m");
    $current_month_label = date("M");
    $last_month = date("m",strtotime("-1 month"));
    $last_month_label = date("M",strtotime("-1 month"));
    $last_second_month = date("m",strtotime("-2 month"));
    $last_second_month_label = date("M",strtotime("-2 month"));
    $last_third_month = date("m",strtotime("-3 month"));
    $last_third_month_label = date("M",strtotime("-3 month"));
    $last_fourth_month = date("m",strtotime("-4 month"));
    $last_fourth_month_label = date("M",strtotime("-4 month"));
    $last_fifth_month = date("m",strtotime("-5 month"));
    $last_fifth_month_label = date("M",strtotime("-5 month"));
    
$chart_query = "
SELECT user_id,
           SUM(CASE WHEN MONTH(date) = '".$current_month."' AND status = 'successfull' THEN amount ELSE 0 END) AS 'current_month',
           SUM(CASE WHEN MONTH(date) = '".$last_month."' AND status = 'successfull' THEN amount ELSE 0 END) AS 'last_month',
           SUM(CASE WHEN MONTH(date) = '".$last_second_month."' AND status = 'successfull' THEN amount ELSE 0 END) AS 'last_second_month',
           SUM(CASE WHEN MONTH(date) = '".$last_third_month."' AND status = 'successfull' THEN amount ELSE 0 END) AS 'last_third_month',
           SUM(CASE WHEN MONTH(date) = '".$last_fourth_month."' AND status = 'successfull' THEN amount ELSE 0 END) AS 'last_fourth_month',
           SUM(CASE WHEN MONTH(date) = '".$last_fifth_month."' AND status = 'successfull' THEN amount ELSE 0 END) AS 'last_fifth_month'
    FROM   transaction where user_id = '".$_SESSION['logid']."'
    GROUP BY user_id
    ORDER BY sno DESC
";

//echo $chart_query;
$chart_sql = mysql_query($chart_query);
$chart_data = mysql_fetch_array($chart_sql); 
    
 ?>
 
       <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading font-bold">Successfull Amount</div>
          <div class="panel-body">
            <div ui-jq="plot" ui-options="
              [
                { data: [ [1,<?php echo $chart_data['last_fifth_month']; ?>],[2,<?php echo $chart_data['last_fourth_month']; ?>],[3,<?php echo $chart_data['last_third_month']; ?>],[4,<?php echo $chart_data['last_second_month']; ?>],[5,<?php echo $chart_data['last_month']; ?>],[6,<?php echo $chart_data['current_month']; ?>] ], points: { show: true, radius: 6}, splines: { show: true, tension: 0.45, lineWidth: 5, fill: 0 } }
              ], 
              {
                colors: ['#23b7e5'],
                series: { shadowSize: 3 },
                xaxis:{ 
                  font: { color: '#ccc' },
                  position: 'bottom',
                  ticks: [
                    [ 1, '<?php echo $last_fifth_month_label; ?>' ], [ 2, '<?php echo $last_fourth_month_label; ?>' ], [ 3, '<?php echo $last_third_month_label; ?>' ], [ 4, '<?php echo $last_second_month_label; ?>' ], [ 5, '<?php echo $last_month_label; ?>' ], [ 6, '<?php echo $current_month_label; ?>' ]
                  ]
                },
                yaxis:{ font: { color: '#ccc' } },
                grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#ccc' },
                tooltip: true,
                tooltipOpts: { content: '%x.1 is %y.4',  defaultTheme: false, shifts: { x: 0, y: 20 } }
              }
            " style="height: 240px; padding: 0px; position: relative;">
            <canvas height="240" width="545" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 545px; height: 240px;" class="flot-base"></canvas><div style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);" class="flot-text"><div style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;" class="flot-x-axis flot-x1-axis xAxis x1Axis"><div style="position: absolute; max-width: 45px; top: 227px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 10px; text-align: center;">Jan</div><div style="position: absolute; max-width: 45px; top: 227px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 57px; text-align: center;">Feb</div><div style="position: absolute; max-width: 45px; top: 227px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 102px; text-align: center;">Mar</div><div style="position: absolute; max-width: 45px; top: 227px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 150px; text-align: center;">Apr</div><div style="position: absolute; max-width: 45px; top: 227px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 195px; text-align: center;">May</div><div style="position: absolute; max-width: 45px; top: 227px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 243px; text-align: center;">Jun</div><div style="position: absolute; max-width: 45px; top: 227px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 291px; text-align: center;">Jul</div><div style="position: absolute; max-width: 45px; top: 227px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 335px; text-align: center;">Aug</div><div style="position: absolute; max-width: 45px; top: 227px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 383px; text-align: center;">Sep</div><div style="position: absolute; max-width: 45px; top: 227px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 430px; text-align: center;">Oct</div><div style="position: absolute; max-width: 45px; top: 227px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 475px; text-align: center;">Nov</div><div style="position: absolute; max-width: 45px; top: 227px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 523px; text-align: center;">Dec</div></div><div style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;" class="flot-y-axis flot-y1-axis yAxis y1Axis"><div style="position: absolute; top: 216px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 0px; text-align: right;">6.0</div><div style="position: absolute; top: 174px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 0px; text-align: right;">6.5</div><div style="position: absolute; top: 132px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 0px; text-align: right;">7.0</div><div style="position: absolute; top: 91px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 0px; text-align: right;">7.5</div><div style="position: absolute; top: 49px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 0px; text-align: right;">8.0</div><div style="position: absolute; top: 8px; font: 400 11px/13px &quot;Source Sans Pro&quot;,&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif; color: rgb(204, 204, 204); left: 0px; text-align: right;">8.5</div></div></div><canvas height="240" width="545" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 545px; height: 240px;" class="flot-overlay"></canvas></div>
          </div>
        </div>
      </div>
  </div>
    </div>
  </div>
  <!-- / main -->
  <!-- right col -->
  <!--<div class="col w-md bg-white-only b-l bg-auto no-border-xs">
    <div class="nav-tabs-alt" >
      <ul class="nav nav-tabs" role="tablist">
        <li class="active">
          <a data-target="#tab-1" role="tab" data-toggle="tab">
            <i class="glyphicon glyphicon-check text-md text-muted wrapper-sm"></i>
          </a>
        </li>
        <li>
          <a data-target="#tab-2" role="tab" data-toggle="tab">
            <i class="glyphicon glyphicon-comment text-md text-muted wrapper-sm"></i>
          </a>
        </li>
      </ul>
    </div>
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="tab-1">
        <div class="wrapper-md">
          <!--<div class="m-b-sm text-md"><!--Who to follow</div>-->
          
          
          
              <!--<div class="padder-md">      
                  <!-- streamline -->
                  <!--<div class="m-b text-md">Recent Activity</div><br />
                  <div class="streamline b-l m-b">
                  
                  <?php 
                    $comments1 = "select * from comment where user_id = '".$_SESSION['logid']."' ORDER BY comment_id DESC limit 5";
                    $comments_query1 = mysql_query($comments1);
                    while($comments_rows = mysql_fetch_array($comments_query1))
                    //$time = mysql_query("select time from ");
                    {
                        $user_query = mysql_query("select * from users where user_id = '".$comments_rows['user_id']."'");
                        $user_row = mysql_fetch_array($user_query);
                        
                        if($comments_rows['user_type']=='user')
                                    {                        
                                        $user_querys = "select * from users where user_id = '".$comments_rows['user_id']."'";
                                        $user_sql = mysql_query($user_querys);
                                        $user_data = mysql_fetch_array($user_sql);
                                        //echo $user_data['f_name'];
                                        $user_name = $user_data['f_name']." ". $user_data['l_name'];
                                        
                                        if(file_exists("app/ajax/profile/profile_pic_".$user_data['user_id'].".png"))
                                        {
                                            $src = "app/ajax/profile/profile_pic_".$user_data['user_id'].".png";
                                        }                       
                                        else
                                        {
                                            $src = "app/ajax/profile/avatar5.png";
                                        }
                                    }
                                    
                                    if($comments_rows['user_type']=='admin')
                                    {
                                        $admin_query = "select * from admin where emp_id = '".$comments_rows['user_id']."'";
                                        $admin_sql = mysql_query($admin_query);
                                        $admin_data = mysql_fetch_array($admin_sql);
                                        
                                        $user_name = $admin_data['name'];
                                        
                                        if(file_exists("admin/app/ajax/profile/admin/profile_pic_".$admin_data['emp_id'].".png"))
                                        {
                                            $src = "admin/app/ajax/profile/admin/profile_pic_".$admin_data['emp_id'].".png";
                                        }                       
                                        else
                                        {
                                            $src = "admin/app/ajax/profile/admin/avatar5.png";
                                        }
                                    }
                        
                        
                    ?>
                  
                  
                    <div class="sl-item">
                      <div class="m-l">
                        <div class="text-muted">
                            <?php echo $comments_rows['timestamp'];?>
                           <a href class="avatar thumb-xs m-r-xs" style="width: 45px;">
                                <img src='<?php echo $src; ?>'  class="img-circle" alt="User Image" style="height: 45px;"/>
                                <i class="on b-white left"></i>
                            </a> 
                        </div>
                        <p><a href class="text-info"><?php echo $user_row['f_name']."".$user_row['l_name'];?></a><br /><a href="view-cheque-details.php?id=<?php echo $comments_rows['cheque_id'];?>" class="text-info" target="_blank">Cheque #<?php echo $comments_rows['cheque_id'];?></a><br />  <?php echo $comments_rows['comment'];?></p>
                      </div>
                    </div>
                    
                    <?php } ?>
                    
                   
                  </div>
                  <!-- / streamline -->
               <!-- </div>
          
          
          
          <!--<div class="text-center">
            <!--<a href class="btn btn-sm btn-primary padder-md m-b">More Connections</a>
          <!--</div>
        <!--</div>
      </div>
      <div role="tabpanel" class="tab-pane tab-2" id="tab-2">
        <div class="wrapper-md">
          <!--<div class="m-b-sm text-md"><!--Chat</div>-->
        
        
            <!--<div class="padder-md">      
                  <!-- streamline -->
                  <!--<div class="m-b text-md">Recent Activity</div><br />
                  <div class="streamline b-l m-b">
                  
                  <?php 
                    $comments = "select * from support_comment where user_id = '".$_SESSION['logid']."' order by support_comment_id DESC limit 5";
                    $comments_query = mysql_query($comments);
                    while($comments_row = mysql_fetch_array($comments_query))    
                    {
                                
                                    if($comments_row['user_type']=='user')
                                    {                        
                                        $user_query = "select * from users where user_id = '".$comments_row['user_id']."'";
                                        $user_sql = mysql_query($user_query);
                                        $user_data = mysql_fetch_array($user_sql);
                                        //echo $user_data['f_name'];
                                        $user_name = $user_data['f_name']." ". $user_data['l_name'];
                                        
                                        if(file_exists("app/ajax/profile/profile_pic_".$user_data['user_id'].".png"))
                                        {
                                            $src = "app/ajax/profile/profile_pic_".$user_data['user_id'].".png";
                                        }                       
                                        else
                                        {
                                            $src = "app/ajax/profile/avatar5.png";
                                        }
                                    }
                                    
                                    if($comments_row['user_type']=='admin')
                                    {
                                        $admin_query = "select * from admin where emp_id = '".$comments_row['user_id']."'";
                                        $admin_sql = mysql_query($admin_query);
                                        $admin_data = mysql_fetch_array($admin_sql);
                                        
                                        $user_name = $admin_data['name'];
                                        
                                        if(file_exists("admin/app/ajax/profile/admin/profile_pic_".$admin_data['emp_id'].".png"))
                                        {
                                            $src = "admin/app/ajax/profile/admin/profile_pic_".$admin_data['emp_id'].".png";
                                        }                       
                                        else
                                        {
                                            $src = "admin/app/ajax/profile/admin/avatar5.png";
                                        }
                                    }
                                    
                    ?>
                    <div class="sl-item">
                      <div class="m-l">
                        <div class="text-muted">
                            <a href class="avatar thumb-xs m-r-xs" style="width: 45px;">
                                <img src='<?php echo $src; ?>'  class="img-circle" alt="User Image" style="height: 45px;"/>
                                <i class="on b-white left"></i>
                            </a>
                        </div>
                        <p><a href class="text-info"><?php echo $user_name;?></a> <br /><a href="view-ticket.php?id=<?php echo $comments_row['support_id'];?>" class="text-info" target="_blank">Support #<?php echo $comments_row['support_id'];?></a> <br /><?php echo $comments_row['comment'];?></p>
                      </div>
                    </div>
                    <?php } ?>
                   
                   
                  </div>
                  <!-- / streamline -->
                <!--</div>
        
        </div>
      </div>
    </div>

  </div>-->
  <!-- / right col -->
</div>



	</div>
  </div>
  <!-- /content -->
  <!-- footer -->
<?php include('blocks/footer.php');?>
  <!-- / footer -->
</div>
<?php //include('blocks/footer-scripts.php');?>

<script src="theme/libs/jquery/jquery/dist/jquery.js"></script>
<script src="theme/libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
<script src="theme/html/js/ui-load.js"></script>
<script src="theme/html/js/main-ui-jp.config.js"></script>
<script src="theme/html/js/ui-jp.js"></script>
<script src="theme/html/js/ui-nav.js"></script>
<script src="theme/html/js/ui-toggle.js"></script>
<script src="theme/html/js/ui-client.js"></script>
</body>
</html>