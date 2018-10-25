<?php 
session_start();
    include("config/config.php"); 
?>
<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>QYKPAY</title>
<meta name="description" content="" />
<meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0,user-scalable=no"/>

<link rel="icon" href="" type="<?php echo $base_url;?>image/x-icon">

<script type="text/javascript" src="<?php echo $base_url;?>themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/js/jquery-1.7.min_v1.js"></script>
<link rel="stylesheet" href="<?php echo $base_url;?>themes/s3.ap-south-1.amazonaws.com/reloadv2/assets/css/reloadv1.5.9.css">
    <link href="<?php echo $base_url;?>css/style.css" rel="stylesheet" type="text/css">
	<link href="css/responsive.css" rel="stylesheet" type="text/css">
	<!-- Roboto Font stylesheet -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
	<!-- FontAwesome stylesheet -->
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<!-- LayerSlider stylesheet 
	<link rel="stylesheet" href="layerslider/css/layerslider.css" type="text/css">
    -->
	<link href="<?php echo $base_url;?>css/lightbox.css" rel="stylesheet" />
<meta name="theme-color" content="#0d6ea8">
</head>
<body >

<div class="Scroll">
<?php  include('blocks/header.php');?>

<div class="container" style="height:100%;">
<div class="row"><h1 style="text-align: center; font-size: 35px;padding: 15px;">Order Summary</h1></div>
	<div class="clear"></div>
			<div class="row" style="padding: 20px;">
			
				<div class="twelve-col" style="background-color: #eff2f2;height: 40px;padding-top: 9px;color: #555;">
                    <div class="twelve-col">
    					   <div class="one-col" style="padding-left: 15px;">
            					Sno
            				</div>
                            <div class="four-col" style="padding-left: 15px;">
            					Product Description
            				</div>
                            <div class="two-col" style="padding-left: 15px;">
            					 Status
            				</div>
                            <div class="one-col" style="padding-left: 15px;">
            					Price
            				</div>
                            <div class="two-col" style="padding-left: 15px;">
            					Order No.
            				</div>
                            <div class="two-col last-col" style="padding-left: 15px;">
            					Order Total
            				</div>
                    </div>
				</div>
                
                <?php  
                $cnt=0;
                $query = "select * from orders where user_id = '".$_SESSION['logid']."' ORDER BY transaction_id DESC";
                $query_sql = mysql_query($query);
                while($query_row = mysql_fetch_array($query_sql))
                {
                    if($query_row['seller_txn_status'] == '00')
                    {
                        $status = 'Successfull';
                    }
                    else if($query_row['seller_txn_status'] == '99')
                    {
                        $status = 'Pending';
                    }
                    else
                    {
                        $status = 'Failed';
                    }
                    $cnt++;
                
                ?>
                <div class="nine-col" style="margin-top: 15px;">
                
                    <div class="twelve-col">
    					    <div class="one-col" style="margin-top: 15px;padding-left: 15px;">
            					<?php echo $cnt; ?>
            				</div> 
    					    <div class="four-col" style="margin-top: 15px;padding-left: 15px;">
            					<?php echo $query_row['product_description']; ?>
            				</div> 
                            <div class="two-col" style="margin-top: 15px;padding-left: 15px;">
            					 <?php
                                    if($status == 'Successfull')
                                    {
                                        echo "<label style='font-size:10px;background:#46b43d; padding:5px 10px;color:#ffffff;border-radius:10px;'>$status</label>";
                                    }
                                    if($status == 'Pending')
                                    {
                                        echo "<label style='font-size:10px;background:#ff5f5f; padding:5px 24px;color:#ffffff;border-radius:10px;'>Pending</label>";
                                    }
                                    if($status == 'Failed')
                                    {
                                        echo "<label style='font-size:10px;background:#ff5f5f; padding:5px 24px;color:#ffffff;border-radius:10px;'>$status</label>";
                                    }
                                ?>
            				</div>
                            <div class="one-col" style="margin-top: 15px;padding-left: 15px;">
            					<?php echo $query_row['reload_amt']; ?>
            				</div>
                            <div class="two-col" style="margin-top: 15px;padding-left: 15px;">
            					<?php echo $query_row['order_id']; ?>
            				</div>
                            <div class="two-col last-col" style="margin-top: 15px;padding-left: 15px;">
            					<?php echo $query_row['total']; ?>
            				</div>
                    </div>
                    
				</div>
                <?php } ?>
               
				<div class="clear"></div>
               
               
                
	   		</div>
            </div>
           
   		<?php include('blocks/footer.php');?>
</body>


</html>
