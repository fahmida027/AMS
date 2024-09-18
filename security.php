<?php
session_start();

if(!isset($_SESSION['userID']))
{
    header('Location:login.php');
}

?>