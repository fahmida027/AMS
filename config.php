<?php
session_start();
$conn=mysqli_connect("localhost","root","","amstest","3307");
if($conn == false){
    die("ERROR: could not connect." . mysqli_connect_error());
}
?>
