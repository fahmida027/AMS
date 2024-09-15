<?php
session_start(); 

if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_SESSION['userID']))
{ 
    $userID = $_SESSION['userID'];
    $date = $_POST['date'];
    $paymentStatus = $_POST['paymentStatus'];
    $amount = $_POST['amount'];
    $paidAmount = $_POST['paidAmount'];
    $desc = $_POST['desc'];
}
$con = new mysqli('localhost','root','','amstest','3307');
if($con)
{
    if($paymentStatus === 'PB')
    {
        $amount = (-1* $amount);
        $sql = "insert into transactions(tDate,tAccCode,tType,tUID) values('$date','A004','C','$userID')";
        $result = mysqli_query($con, $sql);

        if ($result) {
        // Get the serial number of the last inserted row
        $serial_number = mysqli_insert_id($con);
        $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$amount','$desc')";
        $result = mysqli_query($con, $sql);
        }
    }
    else if($paymentStatus === 'AR')
    {
        $sql = "insert into transactions(tDate,tAccCode,tType,tUID) values('$date','A004','D','$userID')";
        $result = mysqli_query($con, $sql);

        if ($result) 
        {
            // Get the serial number of the last inserted row
            $serial_number = mysqli_insert_id($con);
            $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','OE001','$amount','$desc')";
            $result = mysqli_query($con, $sql);
        }


        if ($paidAmount > 0)
        {
            $sql = "insert into transactions(tDate,tAccCode,tType,tUID) values('$date','A004','C','$userID')";
            $result = mysqli_query($con, $sql);

            if ($result){

                $paidAmount = (-1* $paidAmount);
                $serial_number = mysqli_insert_id($con);
                $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$paidAmount','$desc')";
                $result = mysqli_query($con, $sql);
            }

           
        }

    }
    header("location: AR.php");
}
else
{
    die(mysqli_error($con));
}
?>