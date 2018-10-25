<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="lolkittens" />
	<title>TabyPay - Zalora.com</title>
</head>
<style>
#bg{
    background-image: url('checkout.png');
    width:100%;
    height:926px !important;
    background-position: center top;
}
.button{
    height: 286px;    
    z-index: 100000;
    width:1024px;
    top:0;
    margin: 0 auto;
    opacity:0.9;
    position: relative;
}
div.button .checkout{    
    height: 37px;
    width: 149px;   
    position: absolute;
    right:    0;
    bottom:   0;
    margin-right: 47px; 
}
.checkout_button{
    height: 37px;
    width: 130px;
    display: inline-block;  
}
div.button .checkout1{    
    height: 36px;
    width: 147px;   
    position: absolute;
    right:    0;
    bottom:   0;
    margin-right: 192px; 
}
.checkout1_number{    
    height: 33px;
    width: 112px;
    display: inline-block;  
    padding: 0px 10px;
    border:none;
}
</style>
<script>
function isNumberKey(evt)
{
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 46 || charCode > 57))
            return false;
         return true;
}
</script>
<script>
        function sbmt()
        {
            var number = document.getElementById('number').value;
            if(number=='')
            {
                document.getElementById('number').style.backgroundColor = "#ffe8e8 !important";                
            }            
            else
            {
                document.getElementById('number').style.backgroundColor = "#ffffff !important";                                
                document.frm.submit();
            }
        }
    </script>
<body>
<?php
function printQRCode($url, $size = 200) {
    return '<img src="http://chart.apis.google.com/chart?chs=' . $size . 'x' . $size . '&cht=qr&chl=' . urlencode($url) . '" />';
}
?>
<div id="bg">
<div class="button">
<form name="frm" method="get" action="success.php">
    <div class="checkout">        
        <a  class="checkout_button" href="javascript:document.void();" onclick="sbmt();"></a>
    </div>  
    <div class="checkout1">        
        <input type="text" name="number" id="number" class="checkout1_number" onkeypress="return isNumberKey(event);" maxlength="10" placeholder="Enter Phone Number" class="number" />
        
        <div style="margin-top: 50px;">
        <?php 
        $url = "http://www.qykpay.com?a=a&merchant=Zalora&merchantid=1001&price=100&size=l&prod_desc=LEVIS Men Crew T-shirts in Cotton";
        //$url = urlencode ( $url );
        echo printQRCode($url); ?>
        </div>
                   
    </div>    
</form> 
</div>
</div>
</body>
</html>