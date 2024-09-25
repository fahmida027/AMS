
<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "amstest";

$conn=mysqli_connect("$host", "$username", "$password", "$database");

if($conn == false){
    die("ERROR: could not connect." . mysqli_connect_error());
}
?>