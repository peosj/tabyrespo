<!DOCTYPE HTML>

<html>

<head>

	<meta http-equiv="content-type" content="text/html" />

	<meta name="author" content="lolkittens" />



	<title>TabyPay - Zalora.com</title>

    

<style>

#bg{

    background-image: url('success.png');

    width:100%;

    height:2737px !important;

    background-position: center top;

    

}

.button{

    

    height: 426px;

    z-index: 100000;

    width: 1024px;

    top: 0px;

    margin: 0px auto;

    opacity: 0.9;

    position: relative;

    

}

div.button .checkout{        

    height: 33px;

    width: 168px;

    position: absolute;

    right: 0px;

    bottom: 0px;

    margin-right: 426px;

}

.checkout_button{

  height: 38px;

    width: 163px;

    display: inline-block;  

}

</style>

    <script>

        

        

        function generateinvoice()

        {

                            var phone = "<?php echo $_GET['number']; ?>";                            

                            var amount = "60";

                            merchant = "zalora";                  

                            $("#divLoading").show();                            

                            var datastring = "tag=generate_invoice&phone="+phone+"&amount="+amount+"&merchant="+merchant;

                            $.ajax

                                ({

                                    type: "POST",                                                                                                                                                    

                                    url: "http://tabypay.com/app/services/index.php",                                                                                                          

                                    data: datastring,                                                                                                                                                                    

                                    success: function(msg)

                                        {                                                               

                                                                                        

                                            var arr = $.parseJSON(msg);                                                                                                                                                                                                                                                                                                                         

                                            if(!arr['error'] && !arr['empty']) 

                                            {                                                                                                                                                                                                

                                                var trHTML = '';

                                                

                                                document.getElementById('invoices_list').innerHTML = "";

                                                

                                                $.each(arr, function (i, item) 

                                                    {                                                        

                                                        if(item.phone){

                                                            trHTML += '<li style="border: 1px solid #A1A1A1;border-radius: 10px;margin-bottom: 10px;"><a href="javascript:document.void(0);" onclick="next('+item.sno+');"  rel="external" data-ajax="false" data-role="button" style="margin: 5px !important;border-radius: 0px !important;display: block;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;position: relative;box-shadow: none !important;font-size: 13px !important;padding: 5px !important;text-align: left;text-decoration: none;"><img src="images/taby.jpg" title="sample" style="position: absolute;margin-top: 11px;left: 0px;top: 0px;max-height: 5em;max-width: 5em;"/><h3 style="padding-left: 25% !important;padding-top: 8px;font-weight: 700;display: block;margin: 0.45em 0px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;margin-top: -10px;color: #F26822;font-family: kalinga !important;">TabyPay</h3><p style="padding-left: 25% !important;font-weight: 400;display: block;margin: 0.6em 0px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;color: #4D4D4C;margin-top: -4px;font-family: kalinga !important;">RM '+item.amount+'</p><p class="date" style="padding-left: 25% !important;font-weight: 400;display: block;margin: 0.6em 0px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;color: #FF2015;margin-top: -4px;font-family: kalinga !important;">'+item.date+'</p></a><span style="position: absolute;background-color: rgba(0, 0, 0, 0.3);background-position: center center;background-repeat: no-repeat;border-radius: 1em;display: block;width: 22px;height: 22px;top: 36px;right: 11px; background-image: url(images/arw.png);"></span></li>';                                                                                                                           

                                                        }                                                        

                                                    });

                                                    

                                                 document.getElementById('invoices_list').innerHTML = trHTML;                                                                                                                                                        

                                                                                                                                                                                                                                                       

                                                 $("#divLoading").hide();                                                

                                            }

                                            else

                                            {      

                                                

                                                document.getElementById('invoices_list').innerHTML = "<li>No more pending invoices.</li>";                                                                                                

                                                $("#divLoading").hide();                                                    

                                            }                                                                                                                                                                                

                                        },

                                    error: function(result)

                                        {

                                            //alert("error");

                                        }

                                });

    

                        

        }

    </script>

    <script src="jquery-1.11.1.min.js"></script>

	<script src="jquery.mobile-1.4.5.min.js"></script>

    

</head>





<body onload="generateinvoice();">



<div id="bg">

<div class="button">



    <div class="checkout">

        <a class="checkout_button" href="index.html" target="_self"></a>

    </div>    



</div>

</div>



</body>

</html>