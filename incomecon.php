<?php
$con = new mysqli('localhost','root','MyNewPass','AMS');
if($con)
{
    echo "Connection Successfull";
}
else
{
    die(mysqli_error($con));
}
?>