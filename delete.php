<?php
include("config.php");
if(isset($_GET['del'])){

    global $conn;
    $id = $_GET['del']; // Use 'del' instead of 'id'
    $query1 = "DELETE FROM details WHERE dTNo = $id;";
    $query2 = "DELETE FROM transactions WHERE tNo = $id;";


    $result1 = mysqli_query($conn, $query1);
    $result2 = mysqli_query($conn, $query2);

    if($result1 && $result2){
        header("location:entries.php?delete_success=true"); // Add parameter for successful deletion
    }
    else{
        die("ERROR: could not connect." . mysqli_connect_error());
    }
}
?>
