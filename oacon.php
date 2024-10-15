<?php
require_once("config.php");
session_start(); 

if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_SESSION['userID']))
{
    $userID = $_SESSION['userID'];
    $date = $_POST['date'];
    $sector = $_POST['sector'];
    $paymentStatus = $_POST['paymentStatus'];
    $amount = $_POST['amount'];
    $paidAmount = $_POST['paidAmount'];
    $type = $_POST['type'];
    $desc = $_POST['desc'];
}
global $conn;
if($conn)
{
    if($paymentStatus === 'PL')
    {
        $amount = (-1* $amount);
    
            if($type === 'AP'){
                $sql = "insert into transactions(tDate,tAccCode,tType,tuID) values('$date','L001','D','$userID')";
                $result = mysqli_query($conn, $sql);
        
                if ($result) {
                // Get the serial number of the last inserted row
                $serial_number = mysqli_insert_id($conn);
                $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$amount','$desc')";
                $result = mysqli_query($conn, $sql);
                }

            }
            else if($type === 'NP'){
                $sql = "insert into transactions(tDate,tAccCode,tType,tuID) values('$date','L002','D','$userID')";
                $result = mysqli_query($conn, $sql);
        
                if ($result) {
                // Get the serial number of the last inserted row
                $serial_number = mysqli_insert_id($conn);
                $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$amount','$desc')";
                $result = mysqli_query($conn, $sql);
                }

            }
           
        
    }
    else  if($paymentStatus === 'OA')
    {
        //$amount = (-1* $amount);
        if($sector ==='SP')
        {
            $sql = "insert into transactions(tDate,tAccCode,tType,tuID) values('$date','A003','D','$userID')";
            $result = mysqli_query($conn, $sql);

            if(($type === 'AP')&& $result ){
                
                // Get the serial number of the last inserted row
                $serial_number = mysqli_insert_id($conn);
                $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','L001','$amount','$desc')";
                $result = mysqli_query($conn, $sql);

                if ($paidAmount > 0)
                {       
                    $sql = "insert into transactions(tDate,tAccCode,tType,tuID) values('$date','L001','D','$userID')";
                    $result = mysqli_query($conn, $sql);

                    if ($result){

                        $paidAmount = (-1* $paidAmount);
                        $serial_number = mysqli_insert_id($conn);
                        $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$paidAmount','$desc')";
                        $result = mysqli_query($conn, $sql);
                    }
                }

            }
            else if(($type === 'NP')&& $result ){
                
                // Get the serial number of the last inserted row
                $serial_number = mysqli_insert_id($conn);
                $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','L002','$amount','$desc')";
                $result = mysqli_query($conn, $sql);

                if ($paidAmount > 0)
                {       
                    $sql = "insert into transactions(tDate,tAccCode,tType,tuID) values('$date','L002','D','$userID')";
                    $result = mysqli_query($conn, $sql);

                    if ($result){

                        $paidAmount = (-1* $paidAmount);
                        $serial_number = mysqli_insert_id($conn);
                        $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$paidAmount','$desc')";
                        $result = mysqli_query($conn, $sql);
                    }
                }

            }
        } 
        
        else if($sector ==='EQ')
        {

            $sql = "insert into transactions(tDate,tAccCode,tType,tuID) values('$date','A002','D','$userID')";
            $result = mysqli_query($conn, $sql);

            if(($type === 'AP')&& $result ){
                
                // Get the serial number of the last inserted row
                $serial_number = mysqli_insert_id($conn);
                $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','L001','$amount','$desc')";
                $result = mysqli_query($conn, $sql);

                if ($paidAmount > 0)
                {       
                    $sql = "insert into transactions(tDate,tAccCode,tType,tuID) values('$date','L001','D','$userID')";
                    $result = mysqli_query($conn, $sql);

                    if ($result){

                        $paidAmount = (-1* $paidAmount);
                        $serial_number = mysqli_insert_id($conn);
                        $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$paidAmount','$desc')";
                        $result = mysqli_query($conn, $sql);
                    }
                }

            }
            else if(($type === 'NP')&& $result ){
                
                // Get the serial number of the last inserted row
                $serial_number = mysqli_insert_id($conn);
                $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','L002','$amount','$desc')";
                $result = mysqli_query($conn, $sql);

                if ($paidAmount > 0)
                {       
                    $sql = "insert into transactions(tDate,tAccCode,tType,tuID) values('$date','L002','D','$userID')";
                    $result = mysqli_query($conn, $sql);

                    if ($result){

                        $paidAmount = (-1* $paidAmount);
                        $serial_number = mysqli_insert_id($conn);
                        $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$paidAmount','$desc')";
                        $result = mysqli_query($conn, $sql);
                    }
                }

            }
        }

        else
        {
            $sql = "insert into transactions(tDate,tAccCode,tType,tuID) values('$date','A001','D','$userID')";
            $result = mysqli_query($conn, $sql);

            if(($type === 'AP')&& $result ){
                
                // Get the serial number of the last inserted row
                $serial_number = mysqli_insert_id($conn);
                $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','L001','$amount','$desc')";
                $result = mysqli_query($conn, $sql);

                if ($paidAmount > 0)
                {       
                    $sql = "insert into transactions(tDate,tAccCode,tType,tuID) values('$date','L001','D','$userID')";
                    $result = mysqli_query($conn, $sql);

                    if ($result){

                        $paidAmount = (-1* $paidAmount);
                        $serial_number = mysqli_insert_id($conn);
                        $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$paidAmount','$desc')";
                        $result = mysqli_query($conn, $sql);
                    }
                }

            }
            else if(($type === 'NP')&& $result ){
                
                // Get the serial number of the last inserted row
                $serial_number = mysqli_insert_id($conn);
                $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','L002','$amount','$desc')";
                $result = mysqli_query($conn, $sql);

                if ($paidAmount > 0)
                {       
                    $sql = "insert into transactions(tDate,tAccCode,tType,tuID) values('$date','L002','D','$userID')";
                    $result = mysqli_query($conn, $sql);

                    if ($result){

                        $paidAmount = (-1* $paidAmount);
                        $serial_number = mysqli_insert_id($conn);
                        $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$paidAmount','$desc')";
                        $result = mysqli_query($conn, $sql);
                    }
                }

            }
        } 
           
       

        }
        


        
    
    header("location: OnAcc.php");
}
else
{
    die(mysqli_error($conn));
}
?>