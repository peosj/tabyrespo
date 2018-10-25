<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
if(isset($_POST['tag']) && $_POST['tag'] != ""){
    $tag = $_POST['tag'];    
    require_once 'include/DBFunctions.php';
    $db = new DBFunctions();
    $response = array("tag" => $tag, "error" => FALSE);
    if($tag == "qyk_login"){
        $username = strip_tags(trim( $_POST['username']));
        $password = strip_tags(trim( $_POST['password']));
        $gcm_id = strip_tags(trim( $_POST['gcm_id']));
        $user = $db->getLogin($username, $password, $gcm_id);
		if($user != FALSE){
            $response['error'] = FALSE;
			$response['uid'] = $user['uid'];   		
            $response['user']['firstname'] = $user['firstname'];
			$response['user']['lastname'] = $user['lastname'];
            $response['user']['email'] = $user['email'];
            $response['user']['phone'] = $user['phone'];            
            echo json_encode($response);             
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Incorrect email or password";    
            echo json_encode($response);
        }
    }
       
    else if($tag == "qyk_reload"){ 		        
        $reload_amount = strip_tags( trim( $_POST['reload_amount']));
        $reload_operator = strip_tags( trim( $_POST['reload_operator']));
        $reload_data = $db->getReload($reload_amount, $reload_operator);
		if($reload_data != FALSE){
            $response['error'] = FALSE;
			$response['tid'] = 'success';            
            echo json_encode($response);             
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Try again.";    
            echo json_encode($response);
        }
    } 
    
   
    else if($tag == "payNow"){ 		        
        $reload_amount = strip_tags( trim( $_POST['reload_amount']));
        $merchant_name = strip_tags( trim( $_POST['merchant_name']));
        $merchant_id = strip_tags(trim($_POST['merchant_id']));
        $first_name = strip_tags(trim($_POST['first_name']));
        $last_name = strip_tags(trim($_POST['last_name']));
        $email = strip_tags(trim($_POST['email']));
        $phone = strip_tags(trim($_POST['phone']));
        $user_id = strip_tags(trim($_POST['user_id']));
        $prod_desc = strip_tags(trim($_POST['prod_desc']));
        
        $reload_data = $db->getReload($reload_amount, $merchant_name, $merchant_id, $first_name, $last_name, $email,$phone, $user_id,$prod_desc);
		if($reload_data != FALSE){
            $response['error'] = FALSE;
			$response['successmsg'] = 'success';
            $response['user_id'] = $reload_data;            
            echo json_encode($response);             
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Try again.";    
            echo json_encode($response);
        }
    } 
    else if($tag == "qyk_transactions"){ 
        $transaction_data = $db->getTransactions();
		if($transaction_data != FALSE){
            $response['error'] = FALSE;
			$response['txn'] = $transaction_data['txn'];
            $response['total'] = $transaction_data['total'];            
            echo json_encode($response);             
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Try again.";    
            echo json_encode($response);
        }
    } 
    
    else if($tag == "getCurrentCycle"){ 
        $user_id = $_POST['user_id'];
        $transaction_data = $db->getCurrentCycle($user_id);
		if($transaction_data != FALSE){
            $response['error'] = FALSE;
			$response['successmsg'] = $transaction_data;           
            echo json_encode($response);             
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Try again.";    
            echo json_encode($response);
        }
    }
    
    else if($tag == "getTransactionHistory"){ 
        $user_id = $_POST['user_id'];
        $transaction_data = $db->getTransactionHistory($user_id);
		if($transaction_data != FALSE){
            $response['error'] = FALSE;
			$response['successmsg'] = $transaction_data;           
            echo json_encode($response);             
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Try again.";    
            echo json_encode($response);
        }
    }
    
    else if($tag == "showTransactionHistory"){ 
        $user_id = $_POST['id'];
        $from_till_date = $_POST['from_till_date'];
        $from_till_dates = $_POST['from_till_dates'];
        $transaction_data = $db->showTransactionHistory($user_id,$from_till_date,$from_till_dates);
        $transaction_data_array = explode("qykpay11",$transaction_data);
		if($transaction_data != FALSE){
            $response['error'] = FALSE;
			$response['successmsg'] = $transaction_data_array[0];
            $response['lower_date'] = $transaction_data_array[1];
            $response['upper_date'] = $transaction_data_array[2];
            $response['batch_amount'] = $transaction_data_array[3];
            $response['batch_due_amount'] = $transaction_data_array[4];           
            echo json_encode($response);             
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Try again.";    
            echo json_encode($response);
        }
    }
    
    else if($tag == "getCurrentBillCycle"){ 
        $user_id = $_POST['user_id'];
        $transaction_data = $db->getCurrentBillCycle($user_id);
		if($transaction_data != FALSE){
            $response['error'] = FALSE;
			$response['successmsg'] = $transaction_data;           
            echo json_encode($response);             
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Try again.";    
            echo json_encode($response);
        }
    }
    
    else if($tag == "qyk_signup"){ 		        
        $firstname = strip_tags( trim( $_POST['firstname']) );
        $lastname = strip_tags( trim( $_POST['lastname']) );
        $email = strip_tags( trim( $_POST['email']) );
        $phone = strip_tags( trim( $_POST['phone']) );
        $password = strip_tags( trim( $_POST['password']) );
        require_once 'include/signup.php';
        $signup_db = new signup();
        $user = $signup_db->setSignup($firstname, $lastname, $email, $phone, $password);
		if($user == "already exists")
        {
            $response['error'] = TRUE;
            $response['error_msg'] = "User with Phone/Email already exists.";    
            echo json_encode($response);
        }
        else if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['password']) && $user != FALSE)
        {
            $response['error'] = FALSE;
			$response['uid'] = $user;            
            echo json_encode($response);             
        }
        else
        {
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }
    else if($tag == "qyk_otp"){ 		        
        $otp_uid = strip_tags( trim( $_POST['otp_uid']) );
        $otp = strip_tags( trim( $_POST['otp']) );
        $user = $db->verifyOTP($otp_uid, $otp);
		if($user == "invalid otp"){
		      $response['error'] = TRUE;
            $response['error_msg'] = "Incorrect OTP, Please try again !";    
            echo json_encode($response);
		  }
        else if(isset($_POST['otp_uid']) && isset($_POST['otp']) && $user != FALSE){
            $response['error'] = FALSE;
			$response['uid'] = $user['uid'];   		
            $response['user']['firstname'] = $user['firstname'];
			$response['user']['lastname'] = $user['lastname'];
            $response['user']['email'] = $user['email'];
            $response['user']['phone'] = $user['phone'];            
            echo json_encode($response);              
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }    
    else if($tag == "qyk_resetpwd"){ 		        
        $phone = strip_tags( trim( $_POST['phone']) );        
        require_once 'include/password_reset.php';
        $pwd_db = new resetPassword();
        $user = $pwd_db->resetPassword($phone);
		if($user == "invalid phone"){
		      $response['error'] = TRUE;
            $response['error_msg'] = "Phone number not found.";    
            echo json_encode($response);
		  }
        else if(isset($_POST['phone']) && $user != FALSE){
            $response['error'] = FALSE;
			$response['phone'] = $phone;   		    
            echo json_encode($response);              
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }            
    else if($tag == "qyk_timings"){ 		        
        $route_id = strip_tags( trim( $_POST['route_id']) );
        $start_point = strip_tags( trim( $_POST['start_point']) );
        $end_point = strip_tags( trim( $_POST['end_point']) ); 
        $ride_date_meridiem = strip_tags( trim( $_POST['ride_date_meridiem']) );
        $ride_date = strip_tags( trim( $_POST['ride_date']) );
        $ride_date_month = strip_tags( trim( $_POST['ride_date_month']) );
        $ride_date_year = strip_tags( trim( $_POST['ride_date_year']) );       
        $data = $db->getRouteAndStopName($route_id, $start_point, $end_point, $ride_date, $ride_date_month, $ride_date_year, $ride_date_meridiem);
		if(isset($_POST['route_id']) && isset($_POST['start_point']) && isset($_POST['end_point']) && $data != FALSE){
            $response['error'] = FALSE;
			$response['rides'] = $data;   		    
            echo json_encode($response);              
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }        
    else if($tag == "qyk_routes_list"){ 		                
        $response = array();
        $routes = $db->routesListing();
		if($routes == "empty"){
		      $response['error'] = TRUE;
            $response['error_msg'] = "No routes found !";    
            echo json_encode($response);
		  }
        else if($routes != FALSE){                       
  		    $response['routes'] = $routes;
            echo json_encode($response);              
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }        
    else if($tag == "qyk_available_seats"){ 		                
        $ride_id = $_POST['ride_id'];
        $ride_date = $_POST['ride_date'];
        $ride_date_month = $_POST['ride_date_month'];
        $ride_date_year = $_POST['ride_date_year'];
        $start_stop = $_POST['start_stop'];
        $end_stop = $_POST['end_stop'];
        $route = $_POST['route'];
        $seats = $db->getAvailableSeats($ride_id, $ride_date, $ride_date_month, $ride_date_year, $start_stop, $end_stop, $route);
        if($seats != FALSE){   
            $response['error'] = FALSE;
  		    $response['seats'] = $seats;
            echo json_encode($response);              
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }    
    else if($tag == "qyk_booking"){ 		                
            $route_id= $_POST['route_id'];
            $ride_no= $_POST['ride_no'];
            $ride_id= $_POST['ride_id'];
            $ride_fare= $_POST['ride_fare'];
            $discount= $_POST['discount'];
            $ride_fare_total= $_POST['ride_fare_total'];
            $user_id= $_POST['user_id'];
            $from_stop_id= $_POST['from_stop_id'];
            $from_stop_name= $_POST['from_stop_name'];
            $from_time= $_POST['from_time'];
            $from_time_meridiem= $_POST['from_time_meridiem'];
            $to_stop_id= $_POST['to_stop_id'];
            $to_stop_name= $_POST['to_stop_name'];
            $to_time= $_POST['to_time'];
            $to_time_meridiem= $_POST['to_time_meridiem'];
            $date_day= $_POST['date_day'];
            $date_month= $_POST['date_month'];
            $date_year= $_POST['date_year'];
            $seats = json_decode(stripslashes($_POST['seats']));
        $booking_data = $db->seatBooking($route_id, $ride_no, $ride_id, $ride_fare, $discount, $ride_fare_total, $user_id, $from_stop_id, $from_stop_name, $from_time, $from_time_meridiem, $to_stop_id, $to_stop_name, $to_time, $to_time_meridiem, $date_day, $date_month, $date_year, $seats);
        $booking_data_arr = explode("_", $booking_data);
        $booking_id = $booking_data_arr[0];
        $booking_ref_id = $booking_data_arr[1];
        if($booking_data != FALSE){   
            $response['error'] = FALSE;
  		    $response['booking_id'] = $booking_id;
            $response['booking_ref_id'] = $booking_ref_id;
            echo json_encode($response);              
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }            
    else if($tag == "qyk_my_bookings"){ 		        
        $uid = strip_tags( trim( $_POST['uid']) );        
        $data = $db->getMyBookings($uid);
		if(isset($_POST['uid']) && $data != FALSE){
            $response['error'] = FALSE;
			$response['bookings'] = $data;   		    
            echo json_encode($response);              
        }
        else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }            
    else if($tag == "qyk_all_routes_list"){ 		        
         $response = array();
        $routes = $db->allRoutesListing();
		if($routes == "empty"){
		      $response['error'] = TRUE;
            $response['error_msg'] = "No routes found !";    
            echo json_encode($response);
		  }
        else if($routes != FALSE){                       
  		    $response['all_routes'] = $routes;
            echo json_encode($response);              
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }             
    else if($tag == "qyk_get_route"){ 		        
        $route_id = strip_tags( trim( $_POST['route_id']) );        
        $data = $db->getRouteMap($route_id);
        $data_array = explode("/:", $data);
        //print_r($data);
		if(isset($_POST['route_id']) && $data != FALSE){
            $response['error'] = FALSE;
			$response['start_lat'] = $data_array[0];
            $response['start_long'] = $data_array[1];
            $response['end_lat'] = $data_array[2];
            $response['end_long'] = $data_array[3];
            $response['stops_lat'] = $data_array[4];
            $response['stops_long'] = $data_array[5];
            $response['stops_name'] = $data_array[6];
            $response['stops_description'] = $data_array[7];
            $response['waypoints_lat'] = $data_array[8];
            $response['waypoints_long'] = $data_array[9];
            echo json_encode($response);              
        }
        else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }              
    else if($tag == "qyk_track_ride"){ 		        
        $track_ride_booking_id = strip_tags( trim( $_POST['track_ride_booking_id']) );
        $data = $db->getRideMap($track_ride_booking_id);
        //echo $data;
        $data_array = explode("/:", $data);
        //print_r($data);
		if(isset($_POST['track_ride_booking_id']) && $data != FALSE){
            $response['error'] = FALSE;
			$response['start_lat'] = $data_array[0];
            $response['start_long'] = $data_array[1];
            $response['end_lat'] = $data_array[2];
            $response['end_long'] = $data_array[3];
            $response['stops_lat'] = $data_array[4];
            $response['stops_long'] = $data_array[5];
            $response['stops_name'] = $data_array[6];
            $response['stops_description'] = $data_array[7];
            $response['waypoints_lat'] = $data_array[8];
            $response['waypoints_long'] = $data_array[9];
            echo json_encode($response);              
        }
        else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }            
    else if($tag == "qyk_upcoming_rides"){ 		        
        $uid = strip_tags( trim( $_POST['uid']) );        
        $data = $db->getUpcomingRides($uid);
		if(isset($_POST['uid']) && $data != FALSE){
            $response['error'] = FALSE;
			$response['bookings'] = $data;   		    
            echo json_encode($response);              
        }
        else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }              
    else if($tag == "qyk_track_live_ride"){ 		        
        $track_ride_booking_id = strip_tags( trim( $_POST['track_ride_booking_id']) );
        $data = $db->getLiveRideMap($track_ride_booking_id);
        //echo $data;
        $data_array = explode("/:", $data);
        //print_r($data);
        if(isset($_POST['track_ride_booking_id']) && $data == "over")
        {
            $response['error'] = TRUE;
            $response['error_msg'] = "over";    
            echo json_encode($response);
        }        
		else if(isset($_POST['track_ride_booking_id']) && $data != FALSE){
            $response['error'] = FALSE;
			$response['start_lat'] = $data_array[0];
            $response['start_long'] = $data_array[1];
            $response['end_lat'] = $data_array[2];
            $response['end_long'] = $data_array[3];
            $response['stops_lat'] = $data_array[4];
            $response['stops_long'] = $data_array[5];
            $response['stops_name'] = $data_array[6];
            $response['stops_description'] = $data_array[7];
            $response['waypoints_lat'] = $data_array[8];
            $response['waypoints_long'] = $data_array[9];
            $response['position_latitude'] = $data_array[10];
            $response['position_longitude'] = $data_array[11];
            $response['ride_position_id'] = $data_array[12];
            echo json_encode($response);              
        }
        else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }              
    else if($tag == "qyk_track_live_ride_update_marker"){ 		        
        $ride_position_id = strip_tags( trim( $_POST['ride_position_id']) );
        $data = $db->updateLiveRideMapPosition($ride_position_id);
        //echo $data;
        $data_array = explode("/:", $data);
        //print_r($data);
        //echo $data_array[0];
        if(isset($_POST['ride_position_id']) && $data == "over")
        {
            $response['error'] = TRUE;
            $response['error_msg'] = "over";    
            echo json_encode($response);
        }        
		else if(isset($_POST['ride_position_id']) && $data != FALSE){
            $response['error'] = FALSE;
			$response['position_latitude'] = $data_array[0];
            $response['position_longitude'] = $data_array[1];
            echo json_encode($response);              
        }
        else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }
    else if($tag == "qyk_get_boarding_pass"){ 		        
        $booking_id = strip_tags( trim( $_POST['booking_id']) );
        $pass_data = $db->getBoardingPass($booking_id);
        if(isset($_POST['booking_id']) && $pass_data == "empty")
        {
            $response['error'] = TRUE;
            $response['error_msg'] = "empty";    
            echo json_encode($response);
        }        
		else if(isset($_POST['booking_id']) && $pass_data != FALSE){
            $response['error'] = FALSE;
			$response['booking_ref_id'] = $pass_data['booking_ref_id'];
            $response['route_id'] = $pass_data['route_id'];
            $response['ride_no'] = $pass_data['ride_no'];
            $response['ride_id'] = $pass_data['ride_id'];
            $response['ride_fare'] = $pass_data['ride_fare'];
            $response['discount'] = $pass_data['discount'];
            $response['ride_fare_total'] = $pass_data['ride_fare_total'];
            $response['from_stop_id'] = $pass_data['from_stop_id'];
            $response['from_stop_name'] = $pass_data['from_stop_name'];
            $response['from_time'] = $pass_data['from_time'];
            $response['from_time_meridiem'] = $pass_data['from_time_meridiem'];
            $response['to_stop_id'] = $pass_data['to_stop_id'];
            $response['to_stop_name'] = $pass_data['to_stop_name'];
            $response['to_time'] = $pass_data['to_time'];
            $response['to_time_meridiem'] = $pass_data['to_time_meridiem'];
            $response['date_day'] = $pass_data['date_day'];
            $response['date_month'] = $pass_data['date_month'];
            $response['date_year'] = $pass_data['date_year'];
            $response['driver_licence'] = $pass_data['driver_licence'];
            $response['driver_name'] = $pass_data['driver_name'];
            $response['driver_phone'] = $pass_data['driver_phone'];
            echo json_encode($response);              
        }
        else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }               
    else if($tag == "qyk_faq"){ 		        
        $faq_data = $db->getFAQs();    
        if($faq_data != FALSE){
            $response['error'] = FALSE;
			$response['faq'] = $faq_data;	    
            echo json_encode($response);              
        }
        else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }              
    else if($tag == "qyk_suggest_route"){ 		        
        $uid = strip_tags( trim( $_POST['uid']) );
        $from_lat = strip_tags( trim( $_POST['from_lat']) );
        $from_long = strip_tags( trim( $_POST['from_long']) );
        $from_desc = strip_tags( trim( $_POST['from_desc']) );
        $to_lat = strip_tags( trim( $_POST['to_lat']) );
        $to_long = strip_tags( trim( $_POST['to_long']) );
        $to_desc = strip_tags( trim( $_POST['to_desc']) );
        $res = $db->suggestRoute($uid, $from_lat, $from_long, $from_desc, $to_lat, $to_long, $to_desc);
       if(isset($_POST['uid']) && $res != FALSE){
            $response['error'] = FALSE;
            echo json_encode($response);              
        }
        else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }  
    else if($tag == "qyk_feedback"){ 		        
        $uid = strip_tags( trim( $_POST['uid']) );
        $star = strip_tags( trim( $_POST['star']) );
        $app_issue = strip_tags( trim( $_POST['app_issue']) );
        $arrival_time = strip_tags( trim( $_POST['arrival_time']) );
        $bus_quality = strip_tags( trim( $_POST['bus_quality']) );
        $bus_route = strip_tags( trim( $_POST['bus_route']) );
        $driving = strip_tags( trim( $_POST['driving']) );
        $other = strip_tags( trim( $_POST['other']) );
        $comment = strip_tags( trim( $_POST['comment']) );
        $res = $db->submitFeedback($uid, $star, $app_issue, $arrival_time, $bus_quality, $bus_route, $driving, $other, $comment);
       if(isset($_POST['uid']) && $res != FALSE){
            $response['error'] = FALSE;
            echo json_encode($response);              
        }
        else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }                 
    else if($tag == "qyk_notification"){
        $uid = strip_tags( trim( $_POST['uid']) );
        $faq_data = $db->getNotification($uid);    
        if($faq_data != FALSE){
            $response['error'] = FALSE;
			$response['notification'] = $faq_data;	    
            echo json_encode($response);              
        }
        else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }
    else if($tag == "qyk_profile"){ 		        
        $uid = strip_tags( trim( $_POST['uid']) );
        $user = $db->getProfile($uid);
		if(isset($_POST['uid']) && $user != FALSE){
            $response['error'] = FALSE;
			$response['uid'] = $user['uid'];   		
            $response['firstname'] = $user['firstname'];
			$response['lastname'] = $user['lastname'];
            $response['email'] = $user['email'];
            $response['phone'] = $user['phone'];
            $response['password'] = $user['password']; 
            $response['balance'] = $user['balance'];              
            $response['free_rides'] = $user['free_rides']; 
            $response['refer_id'] = $user['refer_id'];            
            echo json_encode($response);              
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    } 
    else if($tag == "qyk_change_password"){ 		        
        $uid = strip_tags( trim( $_POST['uid']) );
        $new_password = strip_tags( trim( $_POST['new_password']) );
        $change_password = $db->changePassword($uid, $new_password);
		if(isset($_POST['uid']) && isset($_POST['new_password']) && $change_password != FALSE){
            $response['error'] = FALSE;
			$response['change_password'] = "success";            
            echo json_encode($response);              
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }   
    else if($tag == "qyk_update_profile"){ 		        
        $uid = strip_tags( trim( $_POST['uid']) );
        $firstname = strip_tags( trim( $_POST['firstname']) );
        $lastname = strip_tags( trim( $_POST['lastname']) );
        $email = strip_tags( trim( $_POST['email']) );
        $phone = strip_tags( trim( $_POST['phone']) );
        $update_profile = $db->updateProfile($uid, $firstname, $lastname, $email, $phone);
		if(isset($_POST['uid']) && $update_profile != FALSE){
            $response['error'] = FALSE;
			$response['update_profile'] = "success";            
            echo json_encode($response);              
        }else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }    
    else if($tag == "qyk_transfer"){ 		        
        $uid = strip_tags( trim( $_POST['uid']) );
        $mobile = strip_tags( trim( $_POST['mobile']) );
        $amount = strip_tags( trim( $_POST['amount']) );
        $transfer = $db->requestTransfer($uid, $mobile, $amount);
		if(isset($_POST['uid']) && $transfer == "mobile not found"){
            $response['error'] = TRUE;
            $response['error_msg'] = "Sorry, Mobile number not found. Please try again.";             
            echo json_encode($response);              
        }
        else if(isset($_POST['uid']) && $transfer != FALSE){
            $response['error'] = FALSE;
			$response['update_profile'] = "success";            
            echo json_encode($response);              
        }
        else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }    
    else if($tag == "getMobileOperators"){ 		        
        
        $transfer = $db->getMobileOperators();
        
		if($transfer != FALSE){
            $response['error'] = FALSE;
			$response['operators'] = $transfer;            
            echo json_encode($response);              
        }
        else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }         
    else if($tag == "getMobileReloads"){ 		        
        
        $operator = $_POST['operator'];
        $transfer = $db->getMobileReloads($operator);
        
		if($transfer != FALSE){
            $response['error'] = FALSE;
			$response['reloads'] = $transfer;            
            echo json_encode($response);              
        }
        else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }      
    else if($tag == "reloadEpay"){ 		        
            
         $user_id = $_POST['user_id'];
         $reloadNumber = $_POST['reloadNumber'];
         $reloadAmountPayable = $_POST['reloadAmountPayable'];
         $reloadAmount = $_POST['reloadAmount'];
         $reloadAmountGST = $_POST['reloadAmountGST'];
         $reloadOperatorID = $_POST['reloadOperatorID'];
         $reloadOperator = $_POST['reloadOperator'];
        
        include("include/reload_epay.php");
        $ob_epay = new ReloadEpay();        
        $reload_epay_data = $ob_epay->reloadEpay($user_id,$reloadNumber,$reloadAmountPayable,$reloadAmount,$reloadAmountGST,$reloadOperatorID,$reloadOperator);
        
		if($reload_epay_data != FALSE){
            $response['error'] = FALSE;
			$response['response'] = $reload_epay_data;            
            echo json_encode($response);              
        }
        else{
            $response['error'] = TRUE;
            $response['error_msg'] = "Something went wrong, Pleae try again !";    
            echo json_encode($response);
        }
    }     
	else{
        $response['error'] = TRUE;
        $response['error_msg'] = "Unknown action attempt.";    
        echo json_encode($response);
    }    
}else{
    $response['error'] = TRUE;
    $response['error_msg'] = "Required parameter is missing";    
    echo json_encode($response);
}
?>
