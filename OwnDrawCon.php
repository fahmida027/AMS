<?php
require_once("config.php");
session_start(); 
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_SESSION['userID']))
{
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $desc = $_POST['desc'];
    $userID = $_SESSION['userID'];
}
global $conn;
if($conn)
{
    $sql = "insert into transactions(tDate,tAccCode,tType,tuID) values('$date','OE004','D','$userID')";
    $result = mysqli_query($conn, $sql);

    if ($result) 
    {
        // Get the serial number of the last inserted row
        $serial_number = mysqli_insert_id($conn);
        $amount = -1* $amount;
        $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$amount','$desc')";
        $result = mysqli_query($conn, $sql);
    }
    header("location: OwnDrawings.php");
}
else
{
    die(mysqli_error($conn));
}
?>