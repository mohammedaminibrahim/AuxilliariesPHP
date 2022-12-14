<?php

    //FOR PHPMAILER 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;


    //cleanse user input
    function purify($dirty){
        $cleanse = htmlentities(trim($dirty));
        return $cleanse;
    }


    //send SMS OTP 
    function smsOTP($msg, $sender, $phone){
        $api_url = "https://api.innotechdev.com/sendmessage.php?key=".SMS_API_KEY."&message={$msg}&senderid={$sender}&phone={$phone}";
        $json_data = file_get_contents($api_url);
        $response_data = json_decode($json_data);
        if ($api_url) 
            return 1;
        else
            return 0;
    }


    // Send Email (PHPMailer)
    function sendEmail($name, $to, $subject, $body) {
        $mail = new PHPMailer(true);
        try {
            $fn = $name;
            $to = $to;
            $from = 'castright@namibra.com';
            $from_name = 'Inqoins .io';
            $subject = $subject;
            $body = $body;
    
            
            $mail = new PHPMailer(true);
    
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
    
            $mail->SMTPSecure = 'ssl'; 
            $mail->Host = '';
            $mail->Port = 345; //change this port to yours 
            $mail->Username = '';
            $mail->Password = ''; 
    
            $mail->IsHTML(true);
            $mail->WordWrap = 50;
            $mail->From = "";
            $mail->FromName = $from_name;
            $mail->Sender = $from;
            $mail->AddReplyTo($from, $from_name);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AddAddress($to);
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
            //$message = "Please check your internet connection well...";
        }
    }


    //check if user is Logged In
    function userIsLoggedIn() {
        if (isset($_SESSION['phonenumber']) && $_SESSION['phonenumber'] > 0) {
            return true;
        }
        return false;
    }


    // LOG USER OUT AFTER !% MINS OF IDLENESS
	function automaticallyLogUserOut() {
		// 900 = 15 * 60 
		if ((time() - $_SESSION['last_login_timestamp']) > 900) {  
            $_SESSION['message'] = "User are automatically Log out for staying Idle For 10mins";
			
        } 
	}
   
    // GET USER IP ADDRESS
	function getUserIPAddress() {  
	    //share internet  
	    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  
	        $ip = $_SERVER['HTTP_CLIENT_IP'];  
	    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  // proxy
	       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
	     } else {  //remote address 
	        $ip = $_SERVER['REMOTE_ADDR'];  
	    }  
	    return $ip;  
	}


;?>