<?php
    require '../config.php';
    
    $points = $_POST['points'];
    $bid = $_GET['bid'];
    $cid = $_GET['cid'];
//get current balance rewards of customer
    $query = "Select balance from customerbusiness
     		where userid = ".$cid;
    $result = $mysqli->query($query);
    while($row = $result->fetch_assoc()){ 
        $bal = $row['balance'] . '<br />';
    }
    $balance = $bal - $points;

//redeem rewards from customer account                  
    $qry  = "INSERT INTO customerbusiness(userid, businessid,
            earnedpoints, redeemedpoints, balance, isactive, modified, created)
            VALUES (\"" . $cid . "\",\"" . $bid . "\", 0, \"" . $points . "\",\"" . $balance . "\", 1, sysdate(), sysdate())";
    $res = $mysqli->query($qry);
    if ($res) {
        
        //send text message to customer
            $queryPhone = "Select phonenumber from userdetail
                    where userid = ".$cid;
            $resultPhone = $mysqli->query($queryPhone);
            while($rowPhone = $resultPhone->fetch_assoc()){ 
                $phone = $rowPhone['phonenumber'];
                $text = $points. " rewards redeemed from your treaty account. \nYour current Treaty Rewards are - ".$balance."\n\n\n";
                
                //echo '<script>window.location.href = "send_sms.php?flag=redeem&phone='.$phone.'&points='.$points.'&balance='.$balance.'";</script>'; 

                //actual code to send text msg
                $url = 'https://rest.nexmo.com/sms/json?' . http_build_query([
                    'api_key' => d0fbd93d,
                    'api_secret' => bcaca354e0887dd9,
                    'to' => $phone,
                    'from' => 12034089447,
                    'text' => $text
                ]);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                //Code end 

                echo '<script>window.location.href = "business.php?flag=redeem";</script>';
            }
    } else {
        echo "Failed to redeem rewards.";
    }
?>