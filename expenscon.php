<?php
session_start(); 
require_once("config.php");
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_SESSION['userID']))
{
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $desc = $_POST['desc'];
    $userID = $_SESSION['userID'];
    $sector = $_POST['sector'];
}
global $conn;
if($conn)
{
    if ($sector =='EQ') 
    {
        $sql = "insert into transactions(tDate,tAccCode,tType,tUID) values('$date','A002','D',$userID)";
        $result = mysqli_query($conn, $sql);
        if ($result){
            $serial_number = mysqli_insert_id($conn);
            $amount = -1* $amount;
            $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$amount','$desc')";
            $result = mysqli_query($conn, $sql);
        }
    }
    else if ($sector == "SP")
    {
        $sql = "insert into transactions(tDate,tAccCode,tType,tUID) values('$date','A003','D',$userID)";
        $result = mysqli_query($conn, $sql);
        if ($result){
            $serial_number = mysqli_insert_id($conn);
            $amount = -1* $amount;
            $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$amount','$desc')";
            $result = mysqli_query($conn, $sql);
        }
    }
    else
    {
        $sql = "insert into transactions(tDate,tAccCode,tType,tUID) values('$date','OE003','D',$userID)";
        $result = mysqli_query($conn, $sql);
        if ($result){
            $serial_number = mysqli_insert_id($conn);
            $amount = -1* $amount;
            $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$amount','$desc')";
            $result = mysqli_query($conn, $sql);
        }
    }
    header("location: Oexpenses.php");
}
else
{
    die(mysqli_error($conn));
}
?>