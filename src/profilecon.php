<?php
session_start();
require_once("config.php");
global $conn;
function userID() {
    global $userID;
    if (!isset($_SESSION['userID'])) {
        header("location:login.php");
        die();
    } else {
        $userID = $_SESSION["userID"];
    }
    return $userID;
}

function Data_display() 
{
    global $conn;
    $user = userID();

    $query = "SELECT * from user WHERE userID = '$user';";

    $result = mysqli_query($conn, $query);
    return $result;
}


function total_cash()
{
    global $conn;
    $user = userID();

    $query = "SELECT SUM(CASE WHEN t.tAccCode = 'A004' AND d.dAccCode = 'A001' THEN ABS(d.amount) 
                              ELSE d.amount END) as total
              FROM transactions t
              JOIN details d ON t.tNo = d.dTNo
              JOIN accountsname act ON act.accCode = t.tAccCode
              JOIN accountsname acd ON acd.accCode = d.dAccCode
              WHERE (act.accName = 'cash' OR acd.accName = 'cash')
              AND t.tuID = '1';";

    $result = mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_assoc($result))
    {
        $total = $row['total'];
    }
    return $total;
}
function total_receivable()
{
    global $conn;
    $user = userID();

    $query = "SELECT SUM(d.amount) as total
                FROM transactions t
                JOIN details d ON t.tNo = d.dTNo
                JOIN accountsname act ON act.accCode = t.tAccCode
                JOIN accountsname acd ON acd.accCode = d.dAccCode
                WHERE (act.accName = 'account receivable' OR acd.accName = 'account receivable')
                    AND t.tuID = '$user';";

    $result = mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_assoc($result))
    {
        $total = $row['total'];
    }
    return $total;
}

function total_due()
{
    global $conn;
    $user = userID();

    $query = "SELECT SUM(d.amount) as total
                FROM transactions t
                JOIN details d ON t.tNo = d.dTNo
                JOIN accountsname act ON act.accCode = t.tAccCode
                JOIN accountsname acd ON acd.accCode = d.dAccCode
                WHERE (act.accName = 'accounts payable' OR acd.accName = 'accounts payable')
                    OR (act.accName = 'notes payable' OR acd.accName = 'notes payable')
                    AND t.tuID = '$user';";

    $result = mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_assoc($result))
    {
        $total = $row['total'];
    }
    return $total;
}

?>
/*elseif (!empty($_POST['type'])) 
        {
            $type = mysqli_real_escape_string($conn, $_POST['type']);
            $type = ucwords($type);
            $query = "SELECT t.tDate,d.amount AS amount, d.description
                    FROM details d
                    JOIN transactions t ON t.tNo = d.dTNo
                    JOIN accountsname act ON act.accCode = t.tAccCode
                    JOIN accountsname acd ON acd.accCode = d.dAccCode
                    WHERE (act.accName = ? OR acd.accName=?) 
                    AND t.tuID = ?;";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $type, $type, $user);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }*/
if (isset($_POST['save'])) 
    {
        $date =  $_POST['dates'];
        $amount = (int)$_POST['amounts'];
        $desc = $_POST['descr'];

        $que1 = "UPDATE transactions SET tDate = '$date' WHERE tNo = '$id'";
        
        $que2 = "UPDATE details
                  JOIN transactions ON details.dTNo = transactions.tNo 
                  SET amount = CASE 
                        WHEN (transactions.tAccCode = 'OE001' AND details.dAccCode = 'A001') OR 
                             (transactions.tAccCode = 'OE002' AND details.dAccCode = 'A001') 
                             THEN $amount
                        ELSE -1*$amount
                        END,
                     description = '$desc'
                     WHERE dID = $id;"; 
                 
        $result1 = mysqli_query($conn,$que1);
        $result2 = mysqli_query($conn,$que2);

        if($result1 && $result2) 
        {
            header("location:entries.php");
        } 
        else
        {
            $error_message = "ERROR: Could not update data. " . mysqli_error($conn);
        }
    }
else 
{
    $error_message = "Invalid or missing editid parameter.";
}