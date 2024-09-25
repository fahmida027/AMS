<?php
session_start(); 

if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_SESSION['userID']))
{
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $desc = $_POST['desc'];
    $userID = $_SESSION['userID'];
    $sector = $_POST['sector'];
}
$con = new mysqli('localhost','root','','amstest','3307');
if($con)
{
    if ($sector =='EQ') 
    {
        $sql = "insert into transactions(tDate,tAccCode,tType,tUID) values('$date','A002','D',$userID)";
        $result = mysqli_query($con, $sql);
        if ($result){
            $serial_number = mysqli_insert_id($con);
            $amount = -1* $amount;
            $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$amount','$desc')";
            $result = mysqli_query($con, $sql);
        }
    }
    else if ($sector == "SP")
    {
        $sql = "insert into transactions(tDate,tAccCode,tType,tUID) values('$date','A003','D',$userID)";
        $result = mysqli_query($con, $sql);
        if ($result){
            $serial_number = mysqli_insert_id($con);
            $amount = -1* $amount;
            $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$amount','$desc')";
            $result = mysqli_query($con, $sql);
        }
    }
    else
    {
        $sql = "insert into transactions(tDate,tAccCode,tType,tUID) values('$date','OE003','D',$userID)";
        $result = mysqli_query($con, $sql);
        if ($result){
            $serial_number = mysqli_insert_id($con);
            $amount = -1* $amount;
            $sql = "insert into details(dTNo,dAccCode,amount,description) values('$serial_number','A001','$amount','$desc')";
            $result = mysqli_query($con, $sql);
        }
    }
    header("location: Oexpenses.php");
}
else
{
    die(mysqli_error($con));
}
?>