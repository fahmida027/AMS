<?php
session_start(); 
require_once("config.php");
global $conn;

if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_SESSION['userID']))
{
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $desc = $_POST['desc'];
    $userID = $_SESSION['userID'];
}
if($conn)
{
    
    $sql = "insert into transactions(tDate,tAccCode,tType,tUID) values('$date','OE001','C','$userID')";
    $result = mysqli_query($conn, $sql);

    if ($result) 
    {
        // Get the serial number of the last inserted row
        $serial_number = mysqli_insert_id($conn);
        $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$amount','$desc')";
        $result = mysqli_query($conn, $sql);
    }
    header("location: income.php");
}
else
{
    die(mysqli_error($conn));
}
?>