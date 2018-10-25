<?php

class DBFunctions{
    private $db;
    public $base_url = "http://www.qykshuttle.com/app/services/";
    function __Construct(){
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        date_default_timezone_set("Asia/Kuala_Lumpur");
        require_once 'DBConnect.php';
        $this->db = new DBConnect();
        $this->db->connect();
    }
    function __Destruct(){
    }
    public function getLogin($username, $password, $gcm_id){
        $query = "SELECT * FROM users WHERE phone = '".$username."' AND password = '".$password."' AND status = '1'";
        //echo $query;exit;
        $result = mysql_query($query) or die(mysql_error());
        $no_of_rows = mysql_num_rows($result);
        if($no_of_rows == 1){
            mysql_query("update users set gcm_id = '".$gcm_id."' where phone = '".$username."' AND password = '".$password."' AND status = '1'");
            $result = mysql_fetch_array($result);
            return $result;
        }
		//$query = "SELECT * FROM users WHERE phone = '".$username."' AND password = '".$password."' AND status = '1'";
        //$result = mysql_query($query) or die(mysql_error());
        //$no_of_rows = mysql_num_rows($result);
        //if($no_of_rows == 1){
            //$result = mysql_fetch_array($result);
            //return $result;
        //}
    }
    public function getReload($reload_amount, $operator, $merchant_id, $first_name, $last_name, $email,$phone, $user_id)
    {
        $txn_id = date(ymdhis);
        $date = date("Y-m-d");
        $user_name = $first_name." ".$last_name;
        $qq = mysql_query("select * from users where phone = '".$phone."'");
        $row = mysql_fetch_array($qq);
        $user_id = $row['user_id'];
        $order_desc = "Recharge of ".$operator." GSM Mobile ".$phone."";
        $query = "insert into transaction(merchant_id, merchant_name, user_id, user_name, user_phone, user_email, transaction_id, order_id, order_desc, status, amount,date,source) values('".$merchant_id."', '".$operator."', '".$user_id."', '".$user_name."', '".$phone."', '".$email."', '".$txn_id."', '".$txn_id."', '".$order_desc."', 'successfull', '".$reload_amount."', '".$date."','App')";
        
        //echo $query;exit;
        $q = mysql_query($query);
        if($q)
        {
            return $user_id;
        }
        else
        {
            return false;
        }
    }
    
    public function getTransactions()
    {
        $txn = "";
        $total = 0;
        $query = "select * from transaction ORDER BY sno DESC";
        $data = mysql_query($query);
        if($data)
        {
            while($row = mysql_fetch_array($data))
            {
                $txn .= "
                        <div class='item' style='border: none; padding: 10px;'>
                            <div class='row' style='font-size: 11px; font-weight: bold;border-bottom:1px solid #dbdbdb; '>
                                <div class='col'>
                                    ".$row['date']."
                                </div>
                                <div class='col'>
                                    ".$row['merchant_name']."
                                </div>
                                <div class='col' style='text-align: right;'>
                                    RM ".$row['amount']."<br />
                                    <span style='color: #3cbf3f;'>".$row['status']."</span>
                                </div>
                            </div>
                        </div>
                " ;
                $total = $total+$row['amount'];
            }
            
            $dt=array();
            $dt['txn'] = $txn;
            $dt['total'] = $total;
            return $dt;
        }
        else
        {
            return $data;
        }
    }
    
    public function getCurrentCycle($user_id)
    {
        
        //$dt = date("Y-m-d");
//echo date( "Y-m-d", strtotime( "$dt +1 day" ) ); // PHP:  2009-03-04
//echo date( "Y-m-d", strtotime( "2009-01-31 +2 month" ) );
//exit;
        $qq = mysql_query("select * from users where phone = '".$user_id."'");
        $qqq = mysql_fetch_array($qq);
        $user_id = $qqq['user_id'];
        $create_date = $qqq['date'];
        $date = date('Y-m-d');
        $first_day = date('Y-m-01');
        $till_15 = date( "Y-m-d", strtotime( "$date +15 day" ) );
        $lastDay=date('Y-m-d',strtotime("last day of this month"));
        
        $query = "select * from transaction where user_id = '".$user_id."' AND date BETWEEN '".$date."' AND '".$till_15."' ORDER BY sno DESC";
        
        
        
        //echo $query;exit;
        $d = new DateTime('first day of this month');
        $curr_date = $d->format('jS, M Y');
        
        $querys = mysql_query($query);
        $no_of_rows = mysql_num_rows($querys);
        if($no_of_rows>0){
            while($row = mysql_fetch_array($querys))
            {
                $txn .= '
                        <div class="item" style="padding-bottom: 0px;">
						<div class="row">
                          <div class="col item-body" style="padding-top: 11px; color: #8b8a8a;text-align: center; font-size: 13px;">
                            BILL CYCLE: '.$curr_date.' to 30th NOV, 2016
                          </div>                          
                        </div>
                        
						<div class="row" style="margin-top: 0px;">
                          <div class="col" style="text-align: center;width: 100%;">                           
                            <div style="width: 180px;font-size: 14px;color: #8b8a8a;font-weight: bold; margin: 0 auto;">
                                <div style="position: absolute;margin-left: 45px;margin-top: 74px;z-index: 10000;">
                                Amount Spent
                                <br />
                                <span style="color: #222222;">RM '.$row['amount'].'</span>
                                </div>                                 
                                 <ring class="c50"></ring>                                 
                            </div>
                          </div>                          
                        </div>
                        
                        <div class="row">
                          <div class="col col-50" style="text-align: left;font-size:12px; font-weight: bold;color:#b4b2b2;">
                            DUE BY<br />
                            <span style="color: #555555;">'.$row['date'].'</span>                                                        	
                          </div>                
                          
                          <div class="col col-50" style="text-align: right;font-size:12px; font-weight: bold;color:#b4b2b2;"> 
                            AVAILABLE CREDIT<br />
                            <span style="color: #555555;">RM '.$row['amount'].'</span>                            	
                          </div>                          
                        </div>
                        
						<div class="row">
                          <div class="col" style="text-align: center;">
                            <button ng-click="paymentSuccess();" class="button button-balanced" style="width: 100%;">
								<span class="font-family-default" style="font-size: 12px; font-weight: 600 !important;">PAY NOW</span>
							</button>	
                          </div>                          
                        </div>
                        <br />
					</div>
                ' ;
                //$total = $total+$row['amount'];
            }
            
            return $txn;
        }
        
        return "Data Not Found";
        
    }
    
    public function getTransactionHistory($user_id)
    {
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
        
        while($date >= $lower_date || $date == $lower_date)
        {
           
         //return $date." ".$upper_date; 
        
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
        
        
        //$txn .= $lower_date.'--'.$upper_date."------".$date.'<br>';
     }
     
     //$ar = json_encode($range_array);
     //$txn .= $ar;
     
     $cnt = 0;
     $size= sizeof($amount_array)-1;
     for($i=$size;$i>=0;$i--)
     {
            
            $range_array_dates = explode("$$",$range_array[$i]);
            $from_to_till_date = $range_array_dates[0].' to '.$range_array_dates[1];
            
            $from_to_till_dates = $range_array_dates[0].'||'.$range_array_dates[1];
            
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
                                <button ng-click="paymentSuccess();" class="button button-balanced" style="width: 100%;min-height: 34px; line-height: 34px;">
    								<span class="font-family-default" style="font-size: 12px; font-weight: 600 !important;">PAY NOW</span>
    							</button>                      	
                          </div>                          
                        </div>
					</div>
                </div>
                <div class="list" style="background: #ffffff;margin: -10px 10px 0px;border-top:2px solid #dbdbdb;">
                    <button ng-click="showTransactions(\''.$userid.'\',\''.$from_to_till_date.'\',\''.$from_to_till_dates.'\');" class="button button-light icon-right ion-chevron-right" style="width: 100%; color: #48a79c;font-size: 13px; text-align: left; border:none;">
                        &nbsp;&nbsp;&nbsp;SHOW TRANSACTIONS
			       </button>
                </div>
                ' ;
     }
     
     
     
     
     
     
     
     return $txn;
        //return "Data Not Found";
        
    
        
    }
    
    
    public function  showTransactionHistory($user_id,$from_till_date,$from_till_dates){
        
        $dates = explode("||",$from_till_dates);
        //var_dump($date);exit;
        $query = "select * from transaction where user_id = '".$user_id."' AND (date between '".$dates[0]."' AND '".$dates[1]."') ORDER BY sno DESC";
        
        //echo $query;exit;
        $result1 = mysql_query($query) or die(mysql_error());
        
        $no_of_rows = mysql_num_rows($result1);
        $temp_data1 = "";
        $temp_data1_1 = "";
        $temp_data2 = "";
        $temp_data3 = "";
        $temp_data4 = "";
        $temp_amount = 0;
        $cnt = 0;
        if($no_of_rows>0){
            
            $temp_data1='<div class="list" style="margin: 10px;margin-top: 15px; background: #48a79c;">
                    <div class="item" style="background: #48a79c;padding: 0px;font-size: 13px; color: #ffffff; border: none;">
                        CURRENT BILL
                    </div>
                </div>
				<div class="list" style="background: #ffffff;margin-top: 6px;margin: 10px;margin-top: 10px;">
                    <div class="item" style="padding-bottom: 0px;">
						<div class="row">
                          <div class="col item-body" style="padding-top: 11px; color: #8b8a8a;text-align: center; font-size: 14px; font-weight: bold;">
                            '.$from_till_date.'
                          </div>                          
                        </div>                        
                        
                        <div class="row" style=" margin-top: 15px;">
                          <div class="col col-50" style="text-align: center;font-size:12px; font-weight: bold;color:#b4b2b2;">
                            Amount Spent<br />
                            <span style="color: #555555;">RM ';
                            $temp_data1_1='</span>                                                        	
                          </div>                
                          
                          <div class="col col-50" style="text-align: right;font-size:12px; font-weight: bold;color:#b4b2b2; margin-bottom: 15px;"> 
                                <button ng-click="open_google();" class="button button-balanced" style="width: 100%;min-height: 34px; line-height: 34px;">
    								<span class="font-family-default" style="font-size: 12px; font-weight: 600 !important;">PAY NOW</span>
    							</button>                      	
                          </div>                          
                        </div>
					</div>
                </div>
                <div class="list" style="background: #ffffff;margin: -10px 10px 0px;border-top:2px solid #dbdbdb;">';
                
                
             while($result = mysql_fetch_array($result1))
             {
                $cnt++;
                
                  $temp_data2.='                      
                    <div class="item" style="border: none; padding: 10px;">
                        <div class="row" style="font-size: 11px; font-weight: bold;border-bottom:1px solid #dbdbdb; ">
                            <div class="col">
                                '.$result['date'].'
                            </div>
                            <div class="col">
                                '.$result['merchant_name'].'
                            </div>
                            <div class="col" style="text-align: right;">
                                RM '.$result['amount'].'<br />
                                <span style="color: #3cbf3f;">Paid</span>
                            </div>
                        </div>
                    </div>';
                    
                    
                    $temp_amount = $temp_amount + $result['amount'];
                
                
             }
             
              $temp_data3='</div>';
            
        }
        else
        {
            $temp_data4='<div class="list card customcard">
                    <div class="row col col-100" style="text-align: center;text-transform: uppercase;font-weight: bold;">                           <span>Data Not Found !</span>
                    </div>
                    </div>';
        } 
        
        $data = $temp_data1.$temp_amount.$temp_data1_1.$temp_data2.$temp_data3.$temp_data4.'qykpay11'.$dates[0].'qykpay11'.$dates[1].'qykpay11'.$temp_amount;
        
        return $data;
	}
    
    public function verifyOTP($otp_uid, $otp){
        $otp_timestamp = date('Y-m-d h:i:s', strtotime("-1 min"));           
		$query = "SELECT * FROM users WHERE otp = '".$otp."' AND uid = '".$otp_uid."' AND status = '0' AND timestamp >= '".$otp_timestamp."'";
        $result = mysql_query($query) or die(mysql_error());
        $no_of_rows = mysql_num_rows($result);
        if($no_of_rows == 1){
            mysql_query("update users set status = '1' where uid = '".$otp_uid."'");
            $result = mysql_fetch_array($result);
            return $result;
        }
        else
        {
            return "invalid otp";
        }
    }
    public function getRouteAndStopName($route_id, $start_point, $end_point, $ride_date, $ride_date_month, $ride_date_year, $ride_date_meridiem)
    {
                $months_array = array("Jan"=>"01", "Feb"=>"02", "Mar"=>"03", "Apr"=>"04", "May"=>"05", "Jun"=>"06", "Jul"=>"07", "Aug"=>"08", "Sep"=>"09", "Oct"=>"10", "Nov"=>"11", "Dec"=>"12");
                $msg = "";
                $date = date("d M");           
                $ride_query = "select * from rides where route_id = '".$route_id."' AND status = '1' AND start_time_meridiem = '".$ride_date_meridiem."'";
                //echo $ride_query;exit;
                $ride_sql = mysql_query($ride_query);
                while($ride_row = mysql_fetch_array($ride_sql))
                {
                    $ride_id = $ride_row['ride_id'];
                    $bus_no = $ride_row['bus_no'];
                    $r1_query = "select ride_stops.arrival_time, ride_stops.arrival_meridiem, stops.stop_name from ride_stops JOIN stops ON ride_stops.stop_id = stops.stop_id where ride_stops.stop_id = '".$start_point."' AND ride_stops.status = '1' AND ride_id = '".$ride_id."'";
                    //echo $r1_query;
                    $r1 = mysql_query($r1_query);
                    $r1_data = mysql_fetch_array($r1);
                    $start_stop_name = $r1_data['stop_name'];
                    $start_time = $r1_data['arrival_time'];
                    $start_time_meridiem = $r1_data['arrival_meridiem'];
                    $r2_query = "select ride_stops.arrival_time, ride_stops.arrival_meridiem, stops.stop_name from ride_stops JOIN stops ON ride_stops.stop_id = stops.stop_id where ride_stops.stop_id = '".$end_point."' AND ride_stops.status = '1' AND ride_id = '".$ride_id."'";
                    //echo $r2_query;
                    $r2 = mysql_query($r2_query);
                    $r2_data = mysql_fetch_array($r2);                    
                    $end_stop_name = $r2_data['stop_name'];
                    $end_time = $r2_data['arrival_time'];
                    $end_time_meridiem = $r2_data['arrival_meridiem'];
                    $ride_date = $ride_date_year."-".$months_array[$ride_date_month]."-".$ride_date;
                    //echo $ride_date;
                    $ride_date = date('Y-m-d', strtotime($ride_date));
                    //echo $ride_date;
                    //////condition if today bus already pased from desired stop
                    $current_timestamp = date('Y-m-d H:i:s');        
                    $today_date = date('Y-m-d');
                    if($start_time_meridiem == "PM")
                    {
                        $from_time_meridiem_arry = explode(":",$start_time);
                        $from_time_meridiem_arry[0] = $from_time_meridiem_arry[0]+12;
                        $timestamp_journey_from_time = $ride_date." ".$from_time_meridiem_arry[0].":".$from_time_meridiem_arry[1].":00";
                    }
                    else
                    {
                        $timestamp_journey_from_time = $ride_date." ".$start_time.":00";
                    }
                    //echo $timestamp_journey_from_time; echo $current_timestamp;
                    if(($timestamp_journey_from_time>$current_timestamp) || ($ride_date != $today_date))
                    {
                    //////condition if today bus already pased from desired stop
                            $msg .= "
                                    <div class='col-lg-33' ng-click=\"selectRide('".$ride_id."', '".$bus_no."', '".$start_time."', '".$start_time_meridiem."', '".$end_time."', '".$end_time_meridiem."')\" style='cursor:pointer;'>
                            			<div class='card'>
                            				<div class='item item-avatar' style='padding-top: 3px;padding-bottom: 5px;'>
                            					<span style='' class='timing'>
                                                    <span class='timing_seat_no' style='font-size:12px;'>Route No</span><br />
                                                    <span class='timing_seat_no'>".$bus_no."</span><br />
                                                    <span class='timing_date' id='ride_date'>{{ride_date}} {{ride_date_month}}</span>
                                                </span>
                            					<p><strong>".$start_time." ".$start_time_meridiem."</strong> ".$start_stop_name."</p>
                            					<p><strong>".$end_time." ".$end_time_meridiem."</strong> ".$end_stop_name."</p>
                                                <p>
                                                    <span class='mybalanced' style='float: left; padding: 0px 10px 0px 10px; font-size:12px; border-radius:4px; color:#ffffff;'>Seat Available</span>
                                                </p>
                            				</div>					
                            			</div>
                            		</div>";
                    }                    
                }                
                if(strlen($msg)==0)
                {
                    return FALSE;
                }
                else
                {
                    return $msg;   
                }                
    }
    public function routesListing(){
		$query = "select route_id, route_name from routes where status = '1' ORDER BY route_id DESC";
        $result = mysql_query($query) or die(mysql_error());
        $no_of_rows = mysql_num_rows($result);
        if($no_of_rows >0){  
            $msg = "";
            $route_cnt = 1;
            while($row = mysql_fetch_array($result))
            {
                $route_id = $row['route_id'];
                $route_name = $row['route_name'];
                $msg .= "<div class='col-lg-50 padding-horizontal' style='margin-bottom: 10px;'>
            				<div class='item item-icon-left route-list' ng-click='toggleRouteStops(\"".$route_id."\")'>
            					<i class='icon ion-record balanced' ng-class='device.icon'><span class='list-icons'>".$route_cnt."</span></i>
            					".$route_name."
                                <span class='list-icons-drop-down' style='right: 46px;'><i class='icon ion-chevron-down'></i></span>
            				</div>
                            <div style='width: 100%; background: #f9f9f9; border:1px solid #eee;' id='".$route_id."_route_stop_list' class='route_stop_list'>
                                <div style='text-align: center; font-size: 16px; font-weight: 400; padding: 10px 0px; color:#666'>Select Start and End Stops</div>
                                <ul class='route-points'>";
                                $stop_query = "select stop_id, stop_name, distance from stops where status = '1' AND route_id = '".$route_id."'";
                                $stop_sql = mysql_query($stop_query);
                                $stop_cnt = 1;
                                while($stop_row = mysql_fetch_array($stop_sql))
                                {
                                    $stop_id = $stop_row['stop_id'];
                                    $stop_name = $stop_row['stop_name'];
                                    $distance = $stop_row['distance'];
                                    $msg .="<li ng-click='selectStop(".$stop_id.",".$distance.")' id='".$stop_id."_list'><span class='route-list-connect'></span> <span class='route-list-icon-span'><i class='icon ion-record' id='".$stop_id."_icon'></i></span> <span class='route-list-text' id='".$stop_id."_stop_name'>".$stop_name."</span></li>";
                                    $stop_cnt++;
                                }                                                                                                     
                        $msg .="</ul>
                                <div class='text-center col'>
                                <div class='padding-bottom'>
            						<button ng-click='showDates(".$route_id.")' class='button button-balanced icon-right ion-ios7-arrow-right' style='width: 100%;'>
            							<span class='font-family-default'>Show Dates</span>
            						</button>							
            					</div>
                                </div>
                            </div>
            			</div>";
                        $route_cnt++;
            }
            return $msg;
        }
        else
        {
            return "empty";
        }
    }
    public function getAvailableSeats($ride_id, $ride_date, $ride_date_month, $ride_date_year, $start_stop, $end_stop, $route)
    {        
        $seats = "";
        $date_of_journey = $ride_date_year."-".$ride_date_month."-".$ride_date;
        $seats_query = "select * from ride_seats where ride_id = '".$ride_id."' ORDER BY ride_seat_id ASC";
        $seats_sql = mysql_query($seats_query);
        $num_rows = mysql_num_rows($seats_sql);
        if($num_rows == 0)
        {
            $seats .= "<li class='balanced' style=' padding: 0px 10px 10xp 10px; position: inline-block;'>No seats found !</li>";
        }
        while($seat_row = mysql_fetch_array($seats_sql))
        {
                $seat_no = $seat_row['seat_no'];
                $status = $seat_row['status'];
                if($status == 1)
                {
                    ///checking if seat already booked
                    $query_chk_booking = "select * from booking_seats where seat_no = '".$seat_no."' AND ride_id = '".$ride_id."' AND date_of_journey = '".$date_of_journey."'";
                    //echo $query_chk_booking;
                    $sql_chk_booking = mysql_query($query_chk_booking);
                    $cnt_chk_booking = mysql_num_rows($sql_chk_booking);
                    if($cnt_chk_booking!=0)
                    {
                        $seats .= "<li class='balanced' style=' padding: 0px 10px 10xp 10px; position: inline-block;width:12%; float:left;font-weight:bold; background:#f64747; color:#ffffff;'>".$seat_no."</li>";                        
                    }
                    else
                    {
                        $seats .= "<li class='balanced' ng-click='selectSeat(".$seat_no.");' id='seat_no_".$seat_no."' style='padding: 0px 10px 10xp 10px; position: inline-block;width:12%; float:left; background:#95c5fb; color:#fff; font-weight:bold;' class='available-seat'>".$seat_no."</li>";
                    }
                }
                else
                {
                    $seats .= "<li class='balanced' style=' padding: 0px 10px 10xp 10px; position: inline-block;width:12%; float:left;font-weight:bold;'>&nbsp;</li>";
                }
        }
        return $seats;
    }
    public function seatBooking($route_id, $ride_no, $ride_id, $ride_fare, $discount, $ride_fare_total, $user_id, $from_stop_id, $from_stop_name, $from_time, $from_time_meridiem, $to_stop_id, $to_stop_name, $to_time, $to_time_meridiem, $date_day, $date_month, $date_year, $seats)
    {
        $months_array = array("Jan"=>"01", "Feb"=>"02", "Mar"=>"03", "Apr"=>"04", "May"=>"05", "Jun"=>"06", "Jul"=>"07", "Aug"=>"08", "Sep"=>"09", "Oct"=>"10", "Nov"=>"11", "Dec"=>"12");
        $booking_date = date('Y-m-d');        
        $date_of_journey = $date_year."-".$months_array[$date_month]."-".$date_day;        
        $date_of_journey = strtotime($date_of_journey); 
        $date_of_journey = date('Y-m-d', $date_of_journey);
        if($to_time_meridiem == "PM")
        {
            $to_time_meridiem_arry = explode(":",$to_time);
            $to_time_meridiem_arry[0] = $to_time_meridiem_arry[0]+12;
            $timestamp_journey_to_time = $date_of_journey." ".$to_time_meridiem_arry[0].":".$to_time_meridiem_arry[1].":00";
        }
        else
        {
            $timestamp_journey_to_time = $date_of_journey." ".$to_time.":00";
        }
        if($from_time_meridiem == "PM")
        {
            $from_time_meridiem_arry = explode(":",$from_time);
            $from_time_meridiem_arry[0] = $from_time_meridiem_arry[0]+12;
            $timestamp_journey_from_time = $date_of_journey." ".$from_time_meridiem_arry[0].":".$from_time_meridiem_arry[1].":00";
        }
        else
        {
            $timestamp_journey_from_time = $date_of_journey." ".$from_time.":00";
        }
        ///////////////////ride start time /////////////////
        $ride_start_time_query = "select start_time, start_time_meridiem from rides where ride_id = '".$ride_id."'";
        $ride_start_time_sql = mysql_query($ride_start_time_query);
        $ride_start_time_data = mysql_fetch_array($ride_start_time_sql);
        $ride_start_time = $ride_start_time_data['start_time'];
        $ride_start_time_meridiem = $ride_start_time_data['start_time_meridiem'];
        if($ride_start_time_meridiem == "PM")
        {
            $ride_start_time_arry = explode(":",$ride_start_time);
            $ride_start_time_arry[0] = $ride_start_time_arry[0]+12;
            $timestamp_ride_start_time = $date_of_journey." ".$ride_start_time_arry[0].":".$ride_start_time_arry[1].":00";
        }
        else
        {
            $timestamp_ride_start_time = $date_of_journey." ".$ride_start_time.":00";
        }
        ///////////////////end ride start time/////////////
        ///////////////////ride end time /////////////////
        $ride_end_time_query = "select end_time, end_time_meridiem from rides where ride_id = '".$ride_id."'";
        $ride_end_time_sql = mysql_query($ride_end_time_query);
        $ride_end_time_data = mysql_fetch_array($ride_end_time_sql);
        $ride_end_time = $ride_end_time_data['end_time'];
        $ride_end_time_meridiem = $ride_end_time_data['end_time_meridiem'];
        if($ride_end_time_meridiem == "PM")
        {
            $ride_end_time_arry = explode(":",$ride_end_time);
            $ride_end_time_arry[0] = $ride_end_time_arry[0]+12;
            $timestamp_ride_end_time = $date_of_journey." ".$ride_end_time_arry[0].":".$ride_end_time_arry[1].":00";
        }
        else
        {
            $timestamp_ride_end_time = $date_of_journey." ".$ride_end_time.":00";
        }
        ///////////////////end ride end time/////////////
        $query = "insert into bookings (route_id, ride_no, ride_id, ride_fare, discount, ride_fare_total, user_id, from_stop_id, from_stop_name, from_time, from_time_meridiem, to_stop_id, to_stop_name, to_time, to_time_meridiem, date_day, date_month, date_year, date_of_journey, booking_date, timestamp_journey_from_time, timestamp_journey_to_time, timestamp_ride_start, timestamp_ride_end) values ('".$route_id."', '".$ride_no."', '".$ride_id."', '".$ride_fare."', '".$discount."', '".$ride_fare_total."', '".$user_id."', '".$from_stop_id."', '".$from_stop_name."', '".$from_time."', '".$from_time_meridiem."', '".$to_stop_id."', '".$to_stop_name."', '".$to_time."', '".$to_time_meridiem."', '".$date_day."', '".$date_month."', '".$date_year."', '".$date_of_journey."', '".$booking_date."', '".$timestamp_journey_from_time."', '".$timestamp_journey_to_time."', '".$timestamp_ride_start_time."', '".$timestamp_ride_end_time."')";
        $booking_sql = mysql_query($query);
        $booking_id = mysql_insert_id();
        if($booking_sql)
        {
            $booking_ref_id = "QYK".date('Ymd').$booking_id;
            mysql_query("update bookings set booking_ref_id = '".$booking_ref_id."' where booking_id = '".$booking_id."'");
            foreach($seats as $seat_no){
               $query_seats = "insert into booking_seats (booking_id, route_id, ride_id, seat_no, date_of_journey) values ('".$booking_id."', '".$route_id."', '".$ride_id."', '".$seat_no."', '".$date_of_journey."')";  
               $booking_seat_sql = mysql_query($query_seats);
              }
            return $booking_id."_".$booking_ref_id;
        }
        else
        {
            return false;
        }
    }
    public function getMyBookings($uid)
    {
                $msg = "";
                $date = date("d M");           
                $ride_query = "select * from bookings where user_id = '".$uid."' ORDER BY booking_id DESC";
                //echo $ride_query;
                $ride_sql = mysql_query($ride_query);
                while($ride_row = mysql_fetch_array($ride_sql))
                {
                    $ride_id = $ride_row['ride_id'];
                    $bus_no = $ride_row['ride_no'];
                    $start_point = $ride_row['from_stop_id'];
                    $end_point = $ride_row['to_stop_id'];
                    $booking_id = $ride_row['booking_id'];
                    $booking_ref_id = $ride_row['booking_ref_id'];                    
                    $date_day = $ride_row['date_day'];
                    $date_month = $ride_row['date_month'];
                    $r1_query = "select ride_stops.arrival_time, ride_stops.arrival_meridiem, stops.stop_name from ride_stops JOIN stops ON ride_stops.stop_id = stops.stop_id where ride_stops.stop_id = '".$start_point."' AND ride_stops.status = '1' AND ride_id = '".$ride_id."'";
                    //echo $r1_query;
                    $r1 = mysql_query($r1_query);
                    $r1_data = mysql_fetch_array($r1);
                    $start_stop_name = $r1_data['stop_name'];
                    $start_time = $r1_data['arrival_time'];
                    $start_time_meridiem = $r1_data['arrival_meridiem'];
                    $r2_query = "select ride_stops.arrival_time, ride_stops.arrival_meridiem, stops.stop_name from ride_stops JOIN stops ON ride_stops.stop_id = stops.stop_id where ride_stops.stop_id = '".$end_point."' AND ride_stops.status = '1' AND ride_id = '".$ride_id."'";
                    //echo $r2_query;
                    $r2 = mysql_query($r2_query);
                    $r2_data = mysql_fetch_array($r2);                    
                    $end_stop_name = $r2_data['stop_name'];
                    $end_time = $r2_data['arrival_time'];
                    $end_time_meridiem = $r2_data['arrival_meridiem'];
                    $msg .= "
                            <div class='col-lg-33' style='cursor:pointer;'>
                    			<div class='card'>
                    				<div class='item item-avatar' style='padding-top: 3px;padding-bottom: 5px;'>
                    					<span style='' class='timing'>
                                            <span class='timing_seat_no' style='font-size:12px;'>Route No</span><br />
                                            <span class='timing_seat_no'>".$bus_no."</span><br />
                                            <span class='timing_date' id='ride_date'>".$date_day." ".$date_month."</span>
                                        </span>
                    					<p><strong>".$start_time." ".$start_time_meridiem."</strong> ".$start_stop_name."</p>
                    					<p><strong>".$end_time." ".$end_time_meridiem."</strong> ".$end_stop_name."</p>
                                            <div class='button-bar bar-stable track-button-bar'>
                                                  <a class='button' id='morning' ng-click=\"trackRide('".$booking_ref_id."','".$booking_id."','".$bus_no."','".$date_day."','".$date_month."','".$start_time."','".$start_time_meridiem."','".$start_stop_name."','".$end_time."','".$end_time_meridiem."','".$end_stop_name."')\">
                                                    <span class='tab-title ng-binding text-balanced'>Track Ride</span>
                                                  </a>
                                                  <a class='button' id='evening' ng-click=\"showDirection('".$booking_id."')\">
                                                    <span class='tab-title ng-binding text-balanced' >Direction</span>
                                                  </a>
                                                  <a class='button' id='evening' ng-click=\"showPass('".$booking_id."')\">
                                                    <span class='tab-title ng-binding text-balanced' >Pass</span>
                                                  </a>
                                            </div>
                                            <!--<span class='mybalanced' style='float: left; padding: 5px 10px 5px 10px; font-size:12px; border-radius:0px; color:#ffffff;'>Booking Id <b>".$booking_ref_id."</b></span>-->
                    				</div>					
                    			</div>
                    		</div>";
                }                
                if(strlen($msg)==0)
                {
                    return FALSE;
                }
                else
                {
                    return $msg;   
                }                
    }
    public function allRoutesListing(){
		$query = "select route_id, route_name from routes where status = '1'";
        $result = mysql_query($query) or die(mysql_error());
        $no_of_rows = mysql_num_rows($result);
        if($no_of_rows >0){  
            $msg = "";
            $route_cnt = 1;
            while($row = mysql_fetch_array($result))
            {
                $route_id = $row['route_id'];
                $route_name = $row['route_name'];
                $from_stop_query = "select stop_name from stops where route_id = '".$route_id."' AND status = '1' ORDER BY distance ASC LIMIT 1";
                $from_stop_result = mysql_query($from_stop_query) or die(mysql_error());
                $from_stop_data = mysql_fetch_array($from_stop_result);
                $from_stop_name = $from_stop_data['stop_name'];
                $to_stop_query = "select stop_name from stops where route_id = '".$route_id."' AND status = '1' ORDER BY distance DESC LIMIT 1";
                $to_stop_result = mysql_query($to_stop_query) or die(mysql_error());
                $to_stop_data = mysql_fetch_array($to_stop_result);
                $to_stop_name = $to_stop_data['stop_name'];
                $msg .= "<div class='col-lg-50 padding-horizontal' style='margin-bottom: 10px;'>
            				<div class='item item-icon-left route-list' ng-click='trackRoute(\"".$route_id."\",\"".$from_stop_name."\",\"".$to_stop_name."\")'>
            					<i class='icon ion-record text-balanced' ng-class='device.icon'><span class='list-icons'>".$route_cnt."</span></i>
            					".$route_name."
                                <span class='list-icons-drop-down' style='right: 46px;'><i class='icon ion-ios7-arrow-right'></i></span>
            				</div>
            			</div>";
                        $route_cnt++;
            }
            return $msg;
        }
        else
        {
            return "empty";
        }
    }
    public function getRouteMap($route_id)
    {
                $start_lat = $start_long = $end_lat = $end_long = 0;
                $stops_lat = "";
                $stops_long = "";
                $stops_name = "";
                $stops_description = "";
                $waypoints_lat = "";;
                $waypoints_long = "";
                $cnt1 = 0;
                $stops_query = "select * from stops where route_id = '".$route_id."' AND status = '1' ORDER BY distance ASC";
                $stops_sql = mysql_query($stops_query);
                while($stops_data = mysql_fetch_array($stops_sql))
                {
                    if($cnt1==0)
                    {
                        $stops_lat .= $stops_data['stop_latitude'];
                        $stops_long .= $stops_data['stop_longitude'];
                        $stops_name .= $stops_data['stop_name'];
                        $stops_description .= $stops_data['stop_description'];
                    }
                    else
                    {
                        $stops_lat .= "~".$stops_data['stop_latitude'];
                        $stops_long .= "~".$stops_data['stop_longitude'];
                        $stops_name .= "~".$stops_data['stop_name'];
                        $stops_description .= "~".$stops_data['stop_description'];
                    }
                    $cnt1++;
                }
                $cnt = 0;
                $waypoints_query = "select * from waypoints where route_id = '".$route_id."' ORDER BY sequence ASC";
                $waypoints_sql = mysql_query($waypoints_query);
                while($waypoints_data = mysql_fetch_array($waypoints_sql))
                {
                    if($cnt == 0)
                    {
                       $start_lat =  $waypoints_data['latitude'];
                       $start_long =  $waypoints_data['longitude'];
                       $waypoints_lat .= $waypoints_data['latitude'];
                       $waypoints_long .= $waypoints_data['longitude'];
                    }
                    else
                    {
                       $waypoints_lat .= "~".$waypoints_data['latitude'];
                        $waypoints_long .= "~".$waypoints_data['longitude']; 
                    }
                    $end_lat =  $waypoints_data['latitude'];
                    $end_long =  $waypoints_data['longitude'];
                    $cnt++;
                }
                return $start_lat."/:".$start_long."/:".$end_lat."/:".$end_long."/:".$stops_lat."/:".$stops_long."/:".$stops_name."/:".$stops_description."/:".$waypoints_lat."/:".$waypoints_long;
    }
    function getRideMap($track_ride_booking_id)
    {
                $bookings_query = "select * from bookings where booking_id = '".$track_ride_booking_id."'";
                $bookings_sql = mysql_query($bookings_query);
                while($bookings_data = mysql_fetch_array($bookings_sql))
                {
                    $bookings_route_id = $bookings_data['route_id'];
                    $bookings_ride_id = $bookings_data['ride_id'];
                    $bookings_from_stop_id = $bookings_data['from_stop_id'];
                    $bookings_to_stop_id = $bookings_data['to_stop_id'];
                }
                $bookings_query = "select * from stops where stop_id = '".$bookings_from_stop_id."'";
                $bookings_sql = mysql_query($bookings_query);
                while($bookings_data = mysql_fetch_array($bookings_sql))
                {
                    $bookings_from_distance = $bookings_data['distance'];
                    $bookings_from_latitude = $bookings_data['stop_latitude'];
                    $bookings_from_longitude = $bookings_data['stop_longitude'];
                }
                $bookings_query = "select * from stops where stop_id = '".$bookings_to_stop_id."'";
                $bookings_sql = mysql_query($bookings_query);
                while($bookings_data = mysql_fetch_array($bookings_sql))
                {
                    $bookings_to_distance = $bookings_data['distance'];
                    $bookings_to_latitude = $bookings_data['stop_latitude'];
                    $bookings_to_longitude = $bookings_data['stop_longitude'];
                }
                $start_lat = $start_long = $end_lat = $end_long = 0;
                $stops_lat = "";
                $stops_long = "";
                $stops_name = "";
                $stops_description = "";
                $waypoints_lat = "";;
                $waypoints_long = "";
                $cnt1 = 0;
                $stops_query = "select * from stops where route_id = '".$bookings_route_id."' AND status = '1' AND distance >= '".$bookings_from_distance."' AND distance <= '".$bookings_to_distance."' ORDER BY distance ASC";
                $stops_sql = mysql_query($stops_query);
                while($stops_data = mysql_fetch_array($stops_sql))
                {
                    if($cnt1==0)
                    {
                        $stops_lat .= $stops_data['stop_latitude'];
                        $stops_long .= $stops_data['stop_longitude'];
                        $stops_name .= $stops_data['stop_name'];
                        $stops_description .= $stops_data['stop_description'];
                    }
                    else
                    {
                        $stops_lat .= "~".$stops_data['stop_latitude'];
                        $stops_long .= "~".$stops_data['stop_longitude'];
                        $stops_name .= "~".$stops_data['stop_name'];
                        $stops_description .= "~".$stops_data['stop_description'];
                    }
                    $cnt1++;
                }
                $cnt = 0;
                $waypoints_query = "select * from waypoints where route_id = '".$bookings_route_id."' AND waypoint_id>=(select waypoint_id from waypoints where latitude = '".$bookings_from_latitude."' AND longitude = '".$bookings_from_longitude."') AND waypoint_id<=(select waypoint_id from waypoints where latitude = '".$bookings_to_latitude."' AND longitude = '".$bookings_to_longitude."') ORDER BY sequence ASC";
                //echo $waypoints_query;
                $waypoints_sql = mysql_query($waypoints_query);
                while($waypoints_data = mysql_fetch_array($waypoints_sql))
                {
                    if($cnt == 0)
                    {
                       $start_lat =  $waypoints_data['latitude'];
                       $start_long =  $waypoints_data['longitude'];
                       $waypoints_lat .= $waypoints_data['latitude'];
                       $waypoints_long .= $waypoints_data['longitude'];
                    }
                    else
                    {
                       $waypoints_lat .= "~".$waypoints_data['latitude'];
                        $waypoints_long .= "~".$waypoints_data['longitude']; 
                    }
                    $end_lat =  $waypoints_data['latitude'];
                    $end_long =  $waypoints_data['longitude'];
                    $cnt++;
                }
                return $start_lat."/:".$start_long."/:".$end_lat."/:".$end_long."/:".$stops_lat."/:".$stops_long."/:".$stops_name."/:".$stops_description."/:".$waypoints_lat."/:".$waypoints_long;
    }
    public function getUpcomingRides($uid)
    {
                $msg = "";
                $date = date("d M");           
                //$ride_query_timestamp = "select * from bookings where user_id = '".$uid."' ORDER BY booking_id DESC";
                //$ride_query_timestamp_sql = mysql_query($ride_query_timestamp);
                //$ride_query_timestamp_data = mysql_fetch_array($ride_query_timestamp_sql);
                //$timestamp_journey_from_time = $ride_query_timestamp_data['timestamp_journey_from_time'];
                //$timestamp_journey_to_time = $ride_query_timestamp_data['timestamp_journey_to_time'];
                $current_timestamp = date('Y-m-d H:i:s');
                //echo $ride_query_journey_timestamp;
                $ride_query = "select * from bookings where user_id = '".$uid."' AND timestamp_journey_to_time >= '".$current_timestamp."' ORDER BY timestamp_journey_from_time ASC";
                //echo $ride_query;
                $ride_sql = mysql_query($ride_query);
                while($ride_row = mysql_fetch_array($ride_sql))
                {
                    $ride_id = $ride_row['ride_id'];
                    $bus_no = $ride_row['ride_no'];
                    $start_point = $ride_row['from_stop_id'];
                    $end_point = $ride_row['to_stop_id'];
                    $booking_id = $ride_row['booking_id'];
                    $booking_ref_id = $ride_row['booking_ref_id'];                    
                    $date_day = $ride_row['date_day'];
                    $date_month = $ride_row['date_month'];
                    $timestamp_ride_start = $ride_row['timestamp_ride_start'];
                    $r1_query = "select ride_stops.arrival_time, ride_stops.arrival_meridiem, stops.stop_name from ride_stops JOIN stops ON ride_stops.stop_id = stops.stop_id where ride_stops.stop_id = '".$start_point."' AND ride_stops.status = '1' AND ride_id = '".$ride_id."'";
                    //echo $r1_query;
                    $r1 = mysql_query($r1_query);
                    $r1_data = mysql_fetch_array($r1);
                    $start_stop_name = $r1_data['stop_name'];
                    $start_time = $r1_data['arrival_time'];
                    $start_time_meridiem = $r1_data['arrival_meridiem'];
                    $r2_query = "select ride_stops.arrival_time, ride_stops.arrival_meridiem, stops.stop_name from ride_stops JOIN stops ON ride_stops.stop_id = stops.stop_id where ride_stops.stop_id = '".$end_point."' AND ride_stops.status = '1' AND ride_id = '".$ride_id."'";
                    //echo $r2_query;
                    $r2 = mysql_query($r2_query);
                    $r2_data = mysql_fetch_array($r2);                    
                    $end_stop_name = $r2_data['stop_name'];
                    $end_time = $r2_data['arrival_time'];
                    $end_time_meridiem = $r2_data['arrival_meridiem'];
                    ///echo $current_timestamp.", ".$timestamp_journey_from_time;
                    if($current_timestamp>=$timestamp_ride_start)
                    {
                        $msg .= "
                            <div class='col-lg-33' style='cursor:pointer;'>
                    			<div class='card'>
                    				<div class='item item-avatar' style='padding-top: 3px;padding-bottom: 5px;'>
                    					<span style='' class='timing'>
                                            <span class='timing_seat_no' style='font-size:12px;'>Rout No</span><br />
                                            <span class='timing_seat_no'>".$bus_no."</span><br />
                                            <span class='timing_date' id='ride_date'>".$date_day." ".$date_month."</span>
                                            <div class='timing_date' id='ride_date' style='font-size:12px;'>Running</div>
                                        </span>
                    					<p><strong>".$start_time." ".$start_time_meridiem."</strong> ".$start_stop_name."</p>
                    					<p><strong>".$end_time." ".$end_time_meridiem."</strong> ".$end_stop_name."</p>
                                        <div class='button-bar bar-stable track-button-bar'>
                                                  <a class='button' id='morning' ng-click=\"trackLiveRide('".$booking_ref_id."','".$booking_id."','".$bus_no."','".$date_day."','".$date_month."','".$start_time."','".$start_time_meridiem."','".$start_stop_name."','".$end_time."','".$end_time_meridiem."','".$end_stop_name."')\">
                                                    <span class='tab-title ng-binding text-balanced'>Track Ride</span>
                                                  </a>
                                                  <a class='button' id='evening' ng-click=\"showDirection('".$booking_id."')\">
                                                    <span class='tab-title ng-binding text-balanced' >Direction</span>
                                                  </a>
                                                  <a class='button' id='evening' ng-click=\"showPass('".$booking_id."')\">
                                                    <span class='tab-title ng-binding text-balanced' >Pass</span>
                                                  </a>
                                        </div>
                    				</div>					
                    			</div>
                    		</div>";
                    }
                    else
                    {
                        $msg .= "
                            <div class='col-lg-33' style='cursor:pointer;'>
                    			<div class='card'>
                    				<div class='item item-avatar' style='padding-top: 3px;padding-bottom: 5px;'>
                    					<span style='' class='timing'>
                                            <span class='timing_seat_no' style='font-size:12px;'>Rout No</span><br />
                                            <span class='timing_seat_no'>".$bus_no."</span><br />
                                            <span class='timing_date' id='ride_date'>".$date_day." ".$date_month."</span>
                                        </span>
                    					<p><strong>".$start_time." ".$start_time_meridiem."</strong> ".$start_stop_name."</p>
                    					<p><strong>".$end_time." ".$end_time_meridiem."</strong> ".$end_stop_name."</p>
                                        <div class='button-bar bar-stable track-button-bar'>
                                                  <a class='button' id='morning' ng-click=\"trackRide('".$booking_ref_id."','".$booking_id."','".$bus_no."','".$date_day."','".$date_month."','".$start_time."','".$start_time_meridiem."','".$start_stop_name."','".$end_time."','".$end_time_meridiem."','".$end_stop_name."')\">
                                                    <span class='tab-title ng-binding text-balanced'>Track Ride</span>
                                                  </a>
                                                  <a class='button' id='evening' ng-click=\"showDirection('".$booking_id."')\">
                                                    <span class='tab-title ng-binding text-balanced' >Direction</span>
                                                  </a>
                                                  <a class='button' id='evening' ng-click=\"showPass('".$booking_id."')\">
                                                    <span class='tab-title ng-binding text-balanced' >Pass</span>
                                                  </a>
                                        </div>
                    				</div>					
                    			</div>
                    		</div>";
                    }
                }                
                if(strlen($msg)==0)
                {
                    return FALSE;
                }
                else
                {
                    return $msg;   
                }                
    }
    function getLiveRideMap($track_ride_booking_id)
    {
                $bookings_query = "select * from bookings where booking_id = '".$track_ride_booking_id."'";
                $bookings_sql = mysql_query($bookings_query);
                while($bookings_data = mysql_fetch_array($bookings_sql))
                {
                    $bookings_route_id = $bookings_data['route_id'];
                    $bookings_ride_id = $bookings_data['ride_id'];
                    $bookings_from_stop_id = $bookings_data['from_stop_id'];
                    $bookings_to_stop_id = $bookings_data['to_stop_id'];
                    $timestamp_journey_from_time = $bookings_data['timestamp_journey_from_time'];
                    $timestamp_journey_to_time = $bookings_data['timestamp_journey_to_time'];
                }
                $current_timestamp = date('Y-m-d H:i:s');
                if($current_timestamp > $timestamp_journey_to_time)
                {
                    return "over";
                    exit;
                }
                else
                {
                    $ride_query_postion = "select * from ride_position where ride_id = '".$bookings_ride_id."' AND ride_journey_from_timestamp = '".$timestamp_journey_from_time."' AND ride_journey_to_timestamp = '".$timestamp_journey_to_time."'";
                    //echo $ride_query_postion;
                    $ride_query_postion_sql = mysql_query($ride_query_postion);
                    $ride_query_postion_data = mysql_fetch_array($ride_query_postion_sql);
                    $position_latitude = $ride_query_postion_data['latitude'];
                    $position_longitude = $ride_query_postion_data['longitude'];
                    $ride_position_id = $ride_query_postion_data['ride_position_id'];
                }
                $bookings_query = "select * from stops where stop_id = '".$bookings_from_stop_id."'";
                $bookings_sql = mysql_query($bookings_query);
                while($bookings_data = mysql_fetch_array($bookings_sql))
                {
                    $bookings_from_distance = $bookings_data['distance'];
                    $bookings_from_latitude = $bookings_data['stop_latitude'];
                    $bookings_from_longitude = $bookings_data['stop_longitude'];
                }
                $bookings_query = "select * from stops where stop_id = '".$bookings_to_stop_id."'";
                $bookings_sql = mysql_query($bookings_query);
                while($bookings_data = mysql_fetch_array($bookings_sql))
                {
                    $bookings_to_distance = $bookings_data['distance'];
                    $bookings_to_latitude = $bookings_data['stop_latitude'];
                    $bookings_to_longitude = $bookings_data['stop_longitude'];
                }
                $start_lat = $start_long = $end_lat = $end_long = 0;
                $stops_lat = "";
                $stops_long = "";
                $stops_name = "";
                $stops_description = "";
                $waypoints_lat = "";;
                $waypoints_long = "";
                $cnt1 = 0;
                $stops_query = "select * from stops where route_id = '".$bookings_route_id."' AND status = '1' AND distance >= '".$bookings_from_distance."' AND distance <= '".$bookings_to_distance."' ORDER BY distance ASC";
                $stops_sql = mysql_query($stops_query);
                while($stops_data = mysql_fetch_array($stops_sql))
                {
                    if($cnt1==0)
                    {
                        $stops_lat .= $stops_data['stop_latitude'];
                        $stops_long .= $stops_data['stop_longitude'];
                        $stops_name .= $stops_data['stop_name'];
                        $stops_description .= $stops_data['stop_description'];
                    }
                    else
                    {
                        $stops_lat .= "~".$stops_data['stop_latitude'];
                        $stops_long .= "~".$stops_data['stop_longitude'];
                        $stops_name .= "~".$stops_data['stop_name'];
                        $stops_description .= "~".$stops_data['stop_description'];
                    }
                    $cnt1++;
                }
                $cnt = 0;
                $waypoints_query = "select * from waypoints where route_id = '".$bookings_route_id."' AND waypoint_id>=(select waypoint_id from waypoints where latitude = '".$bookings_from_latitude."' AND longitude = '".$bookings_from_longitude."') AND waypoint_id<=(select waypoint_id from waypoints where latitude = '".$bookings_to_latitude."' AND longitude = '".$bookings_to_longitude."') ORDER BY sequence ASC";
                //echo $waypoints_query;
                $waypoints_sql = mysql_query($waypoints_query);
                while($waypoints_data = mysql_fetch_array($waypoints_sql))
                {
                    if($cnt == 0)
                    {
                       $start_lat =  $waypoints_data['latitude'];
                       $start_long =  $waypoints_data['longitude'];
                       $waypoints_lat .= $waypoints_data['latitude'];
                       $waypoints_long .= $waypoints_data['longitude'];
                    }
                    else
                    {
                       $waypoints_lat .= "~".$waypoints_data['latitude'];
                        $waypoints_long .= "~".$waypoints_data['longitude']; 
                    }
                    $end_lat =  $waypoints_data['latitude'];
                    $end_long =  $waypoints_data['longitude'];
                    $cnt++;
                }
                return $start_lat."/:".$start_long."/:".$end_lat."/:".$end_long."/:".$stops_lat."/:".$stops_long."/:".$stops_name."/:".$stops_description."/:".$waypoints_lat."/:".$waypoints_long."/:".$position_latitude."/:".$position_longitude."/:".$ride_position_id;
    }
    function updateLiveRideMapPosition($ride_position_id)
    {
                    $ride_query_postion = "select * from ride_position where ride_position_id = '".$ride_position_id."'";
                    //echo $ride_query_postion;
                    $ride_query_postion_sql = mysql_query($ride_query_postion);
                    $ride_query_postion_data = mysql_fetch_array($ride_query_postion_sql);
                    $position_latitude = $ride_query_postion_data['latitude'];
                    $position_longitude = $ride_query_postion_data['longitude'];
                    $ride_position_id = $ride_query_postion_data['ride_position_id'];
                    $timestamp_journey_to_time = $ride_query_postion_data['ride_journey_to_timestamp'];
                    $current_timestamp = date('Y-m-d H:i:s');
                    if($current_timestamp > $timestamp_journey_to_time)
                    {
                        return "over";
                        exit;
                    }
                    else
                    {
                        return $position_latitude."/:".$position_longitude;
                    }
    }
    function getBoardingPass($booking_id)
    {
            $pass_query = "select bookings.*, rides.* from bookings JOIN rides ON bookings.ride_id = rides.ride_id where bookings.booking_id = '".$booking_id."'";
            //echo $pass_query;
            $pass_sql = mysql_query($pass_query);
            $pass_data = mysql_fetch_array($pass_sql);
            $pass_data_cnt = mysql_num_rows($pass_sql);
            if($pass_data_cnt==0)
            {
                return "empty";
                exit;
            }
            else
            {
                return $pass_data;
            }
    }
    public function getFAQs(){
		$query = "select * from faq where status = '1' ORDER BY faq_id DESC";
        $result = mysql_query($query) or die(mysql_error());
        $no_of_rows = mysql_num_rows($result);
        if($no_of_rows >0){  
            $msg = "";
            $route_cnt = 1;
            while($row = mysql_fetch_array($result))
            {
                $faq_id = $row['faq_id'];
                $question = $row['question'];
                $answer = $row['answer'];
                $msg .= "<div class='col-lg-50 padding-horizontal' style='margin-bottom: 10px;'>
            				<div class='item item-icon-left route-list' ng-click='toggleFAQs(\"".$faq_id."\")'>
            					<i class='icon ion-record balanced' ng-class='device.icon'><span class='list-icons' style='color:#ffffff;'>".$route_cnt."</span></i>
            					".$question."
                                <span class='list-icons-drop-down' style='right: 46px;'><i class='icon ion-chevron-down'></i></span>
            				</div>
                            <div style='width: 100%; background: #f9f9f9; border:1px solid #eee;' id='".$faq_id."_route_stop_list' class='route_stop_list'>
                                <div style='font-weight: 400; color:#666; padding: 10px;font-size: 13px;text-align: justify;'>
                                    ".$answer."
                                </div>  
                            </div>
            			</div>";
                        $route_cnt++;
            }
            return $msg;
        }
        else
        {
            return "false";
        }
    }
    public function suggestRoute($uid, $from_lat, $from_long, $from_desc, $to_lat, $to_long, $to_desc)
    {
        $query = "select * from users where uid = '".$uid."'";
        $sql = mysql_query($query);
        $data = mysql_fetch_array($sql);
        $user_name = $data['firstname']." ".$data['lastname'];
        $date = date("Y-m-d");
        $res = mysql_query("insert into suggested_routes (uid, user_name, user_phone, user_email, from_lat, from_long, from_desc, to_lat, to_long, to_desc, date) values('".$uid."', '".$user_name."', '".$data['phone']."', '".$data['email']."', '".$from_lat."', '".$from_long."', '".$from_desc."', '".$to_lat."', '".$to_long."', '".$to_desc."', '".$date."')");        
        if($res)
        {
            return true;
        }
        else
        {
            return false;
        }        
    }
    public function submitFeedback($uid, $star, $app_issue, $arrival_time, $bus_quality, $bus_route, $driving, $other, $comment)
    {
        $query = "select * from users where uid = '".$uid."'";
        $sql = mysql_query($query);
        $data = mysql_fetch_array($sql);
        $user_name = $data['firstname']." ".$data['lastname'];
        $date = date("Y-m-d");
        $res = mysql_query("insert into feedbacks (uid, user_name, user_phone, user_email, rating, app_issue, arrival_time, bus_quality, bus_route, driving, other, comment, date) values('".$uid."', '".$user_name."', '".$data['phone']."', '".$data['email']."', '".$star."', '".$app_issue."', '".$arrival_time."', '".$bus_quality."', '".$bus_route."', '".$driving."', '".$other."', '".$comment."', '".$date."')");        
        if($res)
        {
            return true;
        }
        else
        {
            return false;
        } 
    }
    public function getNotification($uid){
		$query = "select * from notifications where status = '1' AND uid = '".$uid."' ORDER BY notification_id DESC";
        $result = mysql_query($query) or die(mysql_error());
        $no_of_rows = mysql_num_rows($result);
        if($no_of_rows >0){  
            $msg = "";
            $route_cnt = 1;
            while($row = mysql_fetch_array($result))
            {
                $date = $row['date'];
                $notification = $row['notification'];
                $title = $row['title'];
                $time = $row['time'];
                $meridiem = $row['meridiem'];
                $msg .= "<div class='card'>
                          <div class='item item-divider' style='color:#1277d6;'>
                            ".$title."
                          </div>
                          <div class='item item-text-wrap'>
                            ".$notification."
                          </div>
                          <div class='item item-divider' style='font-weight:normal;'>
                            ".$date." ".$time." ".$meridiem."
                          </div>
                        </div>";
                        $route_cnt++;
            }
            return $msg;
        }
        else
        {
            return "false";
        }
    }
    public function getProfile($uid){       
		$query = "SELECT * FROM users WHERE uid = '".$uid."' AND status = '1'";
        $result = mysql_query($query) or die(mysql_error());
        $no_of_rows = mysql_num_rows($result);
        if($no_of_rows == 1){
            $result = mysql_fetch_array($result);
            return $result;
        }
        else
        {
            return false;
        }
    }
    public function changePassword($uid, $new_password)
    {
        $query = "SELECT * FROM users WHERE uid = '".$uid."' AND status = '1'";
        $result = mysql_query($query) or die(mysql_error());
        $no_of_rows = mysql_num_rows($result);
        if($no_of_rows == 1){
                $res = mysql_query("update users set password = '".$new_password."' where status = '1' AND uid = '".$uid."'");
                if($res)
                {
                    return true;
                }
                else
                {
                    return false;
                }
        }
        else
        {
            return false;
        }
    }
    public function updateProfile($uid, $firstname, $lastname, $email, $phone)
    {
        $query = "SELECT * FROM users WHERE uid = '".$uid."' AND status = '1'";
        $result = mysql_query($query) or die(mysql_error());
        $no_of_rows = mysql_num_rows($result);
        if($no_of_rows == 1){
                $res = mysql_query("update users set firstname = '".$firstname."', lastname = '".$lastname."', email = '".$email."', phone = '".$phone."' where status = '1' AND uid = '".$uid."'");
                if($res)
                {
                    return true;
                }
                else
                {
                    return false;
                }
        }
        else
        {
            return false;
        }
    }
    public function requestTransfer($uid, $mobile, $amount)
    {
        $query = "SELECT * FROM users WHERE uid = '".$uid."' AND status = '1'";
        $result = mysql_query($query) or die(mysql_error());
        $result_data = mysql_fetch_array($result);
        $no_of_rows = mysql_num_rows($result);
        $query_transfree = "SELECT * FROM users WHERE phone = '".$mobile."' AND status = '1'";
        $result_transfree = mysql_query($query_transfree) or die(mysql_error());
        $result_transfree_data = mysql_fetch_array($result_transfree);
        $no_of_rows_transfree = mysql_num_rows($result_transfree);
        if($no_of_rows == 1 && $no_of_rows_transfree == 1){
                $user_remaining_balance = $result_data['balance'] - $amount;
                $user_transfree_added_balance = $result_transfree_data['balance'] + $amount;
                $res = mysql_query("update users set balance = '".$user_remaining_balance."' where status = '1' AND uid = '".$uid."'");
                $res1 = mysql_query("update users set balance = '".$user_transfree_added_balance."' where status = '1' AND phone = '".$mobile."'");
                if($res && $res1)
                {
                    return true;
                }
                else
                {
                    return false;
                }
        }
        else
        {
            return "mobile not found";
        }
    }
}
?>

