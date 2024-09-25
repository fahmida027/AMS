<?php
session_start(); 
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_SESSION['userID']))
{
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $desc = $_POST['desc'];
    $userID = $_SESSION['userID'];
}
$con = new mysqli('localhost','root','','amstest','3307');
if($con)
{
    $sql = "insert into transactions(tDate,tAccCode,tType,tuID) values('$date','OE004','D','$userID')";
    $result = mysqli_query($con, $sql);

    if ($result) 
    {
        // Get the serial number of the last inserted row
        $serial_number = mysqli_insert_id($con);
        $amount = -1* $amount;
        $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$amount','$desc')";
        $result = mysqli_query($con, $sql);
    }
    header("location: OwnDrawings.php");
}
else
{
    die(mysqli_error($con));
}
?>