<?php
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

function data_display() {
    global $conn;
    $user = userID();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        if (!empty($_POST['sector'])) {
            $sector = $_POST['sector'];
            $query = "SELECT t.tNo AS 'tNo',
                             t.tDate AS 'tDate', 
                             d.amount AS 'amount',
                        CASE 
                            WHEN actypeD.catName = ? THEN acd.accName 
                            ELSE act.accName
                        END AS 'accName', 
                             d.description AS 'description'
                        FROM transactions t
                        JOIN details d ON t.tNo = d.dTNo
                        JOIN accountsname act ON act.accCode = t.tAccCode
                        JOIN accounttype actypeT ON act.acatID = actypeT.catID
                        JOIN accountsname acd ON acd.accCode = d.dAccCode
                        JOIN accounttype actypeD ON acd.acatID = actypeD.catID
                        WHERE (actypeT.catName = ? 
                              OR actypeD.catName = ?)
                        AND t.tuID = ?;";
            
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $sector, $sector, $sector, $user);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        } 
        elseif (!empty($_POST['search'])) 
        {
            $search_value = $_POST["search"];

            // Check if the search value matches any part of the date
            $date_search_condition = "t.tDate LIKE CONCAT('%', ?, '%')";
            
            // Check if the search value matches any part of the amount
            $amount_search_condition = "d.amount LIKE CONCAT('%', ?, '%')";
            
            $query = "SELECT t.tNo AS 'tNo', 
                            t.tDate AS 'tDate', 
                            d.amount AS 'amount', 
                            act.accName AS 'accName',
                            d.description AS 'description'
                      FROM details d
                      JOIN transactions t ON t.tNo = d.dTNo
                      JOIN accountsname act ON act.accCode = t.tAccCode
                      JOIN accountsname acd ON acd.accCode = d.dAccCode
                      WHERE (d.description LIKE ? OR " . $date_search_condition . " OR " . $amount_search_condition . ") 
                      AND t.tuID = ?";
            
            $search = "%{$search_value}%";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $search, $search_value, $search_value, $user);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
            

        }
    }
    
    $query = "SELECT t.tNo, t.tDate, d.amount, acnameT.accName, d.description
              FROM transactions t
              INNER JOIN details d ON t.tNo = d.dTNo
              JOIN accountsname acnameT ON acnameT.accCode = t.tAccCode
              WHERE t.tuID = '$user'
              ORDER BY t.tDate";
    $result = mysqli_query($conn, $query);
    return $result;
}


if (isset($_POST['save'])) 
{
    $id = mysqli_real_escape_string($conn,$_POST['id']) ;    
    $date = mysqli_real_escape_string($conn,$_POST['dates']) ;
    $amount = mysqli_real_escape_string($conn,$_POST['amounts']);
    $desc = mysqli_real_escape_string($conn,$_POST['descr']);

    $que1 = "UPDATE transactions SET tDate = '$date' WHERE tNo = '$id'";
        
    $que2 = "UPDATE details
            JOIN transactions ON details.dTNo = transactions.tNo 
            SET amount = CASE 
            WHEN (transactions.tAccCode = 'OE002' AND details.dAccCode = 'A001') OR 
                (transactions.tAccCode = 'A002' AND details.dAccCode = 'L001') OR 
                (transactions.tAccCode = 'A002' AND details.dAccCode = 'L002') OR 
                (transactions.tAccCode = 'A003' AND details.dAccCode = 'L001') OR
                (transactions.tAccCode = 'A003' AND details.dAccCode = 'L002') OR 
                (transactions.tAccCode = 'A004' AND details.dAccCode = 'OE001') OR 
                (transactions.tAccCode = 'OE001' AND details.dAccCode = 'A001') OR 
                (transactions.tAccCode = 'A001' AND details.dAccCode = 'L001') OR 
                (transactions.tAccCode = 'A001' AND details.dAccCode = 'L002')
            THEN $amount
            ELSE -1*$amount
            END,
            description = '$desc'
            WHERE dTNo = $id;"; 
                 
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