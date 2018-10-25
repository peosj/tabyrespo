<?php
mysql_connect('localhost', 'qykpay11_qykpay', 'Qykpay@11') or die(mysql_error());
mysql_select_db('qykpay11_qykpay')or die(mysql_error());
        
        
  $user_id = '9871801654';
        //echo "ok";exit;
        $qq = mysql_query("select * from users where phone = '".$user_id."'");
        $qqq = mysql_fetch_array($qq);
        $userid = $qqq['user_id'];
        
        //echo $userid;
        
        
        $create_date = $qqq['date'];
        $date = date('Y-m-d');
        //$first_day = date('Y-m-01');
        //$till_15 = date( "Y-m-d", strtotime( "$date +15 day" ) );
        //$lastDay=date('Y-m-d',strtotime("last day of this month"));
        
        
        $create_day = date("d",strtotime($create_date));
        $create_month = date("m",strtotime($create_date));
        $create_year = date("Y",strtotime($create_date));
        
        $lower_date = $create_date;
        
        //echo $lower_date."<br>";
        
        if($create_day<=15)
        {            
            $upper_date = date( "Y-m-d", strtotime( $create_year."-".$create_month."-15" ));
        }
        else
        {           
            
            $no_of_days = date('t',strtotime($create_date));
            $upper_date = date( "Y-m-d", strtotime( $create_year."-".$create_month."-".$no_of_days )); 
        }
        
        
        //return $date." ".$upper_date;
        //exit;
        $txn = "";
        $amount_array = array();
        $range_array = array();
        $userid_array = array();
        while($date >= $upper_date || $date == $lower_date)
        {
           
         //return $date." ".$upper_date; exit;
        
        $query = "select COALESCE(sum(amount),0) from transaction where user_id = '".$userid."' AND (date between '".$lower_date."' and '".$upper_date."') ORDER BY sno DESC";
        $data = mysql_fetch_array(mysql_query($query));
        array_push($amount_array,$data['COALESCE(sum(amount),0)']);
        array_push($range_array,$lower_date.'$$'.$upper_date);
        array_push($userid_array,$userid);
        
        
                
                //$total = $total+$row['amount'];
           
        
        $lower_day = date("d",strtotime($lower_date));        
        $lower_month = date("m",strtotime($lower_date));
        $lower_year = date("Y",strtotime($lower_date));
        $no_of_days = date('t',strtotime($lower_date));
        
        if($lower_day < 15)
        {
            
            $lower_date = date( "Y-m-d", strtotime( $lower_year."-".$lower_month."-16" ));
            $upper_date = date( "Y-m-d", strtotime( $lower_year."-".$lower_month."-".$no_of_days ));
            
        }
        else
        {
            if($lower_month == 12)
            {
                $lower_year = $lower_year+1;
                $lower_date = date( "Y-m-d", strtotime( $lower_year."-01-01" ));
                $upper_date = date( "Y-m-d", strtotime( $lower_year."-01-15" ));
            }
            else
            {
                $lower_month = $lower_month+1;
                $lower_date = date( "Y-m-d", strtotime( $lower_year."-".$lower_month."-01" ));
                $upper_date = date( "Y-m-d", strtotime( $lower_year."-".$lower_month."-15" ));
            }
            
        }
        
        
        
     }
     
     //$disabled = "";
     
     $size= sizeof($amount_array)-1;
     for($i=$size;$i>=0;$i--)
     {
            //echo $amount_array[$i];
            if($amount_array[$i] == "0")
            {
               $disabled = "disabled"; 
            }
           $range_array_dates = explode("$$",$range_array[$i]);
        
            $txn .= '
                <div class="list" style="margin: 10px;margin-top: 15px; background: #48a79c;">
                    <div class="item" style="background: #48a79c;padding: 0px;font-size: 13px; color: #ffffff; border: none;">
                        CURRENT BILL
                    </div>
                </div>
				<div class="list" style="background: #ffffff;margin-top: 6px;margin: 10px;margin-top: 10px;">
                    <div class="item" style="padding-bottom: 0px;">
						<div class="row">
                          <div class="col item-body" style="padding-top: 11px; color: #8b8a8a;text-align: center; font-size: 14px; font-weight: bold;">
                            '.$range_array_dates[0].' to '.$range_array_dates[1].'
                          </div>                          
                        </div>                        
                        
                        <div class="row" style=" margin-top: 15px;">
                          <div class="col col-50" style="text-align: center;font-size:12px; font-weight: bold;color:#b4b2b2;">
                            Amount Spent<br />
                            <span style="color: #555555;">RM '.$amount_array[$i].'</span>                                                        	
                          </div>                
                          
                          <div class="col col-50" style="text-align: right;font-size:12px; font-weight: bold;color:#b4b2b2; margin-bottom: 15px;"> 
                                <button ng-click="paymentSuccess();" class="button button-balanced" style="width: 100%;min-height: 34px; line-height: 34px;disabled='.$disabled.'">
    								<span class="font-family-default" style="font-size: 12px; font-weight: 600 !important;">PAY NOW</span>
    							</button>                      	
                          </div>                          
                        </div>
					</div>
                </div>
                <div class="list" style="background: #ffffff;margin: -10px 10px 0px;border-top:2px solid #dbdbdb;">
                    <button ng-click="showTransactions();" class="button button-light icon-right ion-chevron-right" style="width: 100%; color: #48a79c;font-size: 13px; text-align: left; border:none;">
                        &nbsp;&nbsp;&nbsp;SHOW TRANSACTIONS
			       </button>
                </div>
                ' ;
     }
     
     
     
     
     
     
     
     echo $txn;
        //return "Data Not Found";
        
    
?>