<?php
require('fpdfGenerator/fpdf.php');
require_once("config.php");
session_start();

function times()
{
    $time = array();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['month'])) {
            $time[0] = $_POST['month'];
        }
        if (isset($_POST['year'])) {
            $time[1] = $_POST['year'];
        }
    }

    if (!empty($time) && isset($time[0])) { 
        if ($time[0] == 1) 
        {
            $time[0] = "January";
        }
        else if ($time[0] == 2) 
        {
            $time[0] = "February";
        }
        else if ($time[0] == 3) 
        {
            $time[0] = "March";
        }
        else if ($time[0] == 4) 
        {
            $time[0] = "April";
        }
        else if ($time[0] == 5) 
        {
            $time[0] = "May";
        }
        else if ($time[0] == 6) 
        {
            $time[0] = "June";
        }
        else if ($time[0] == 7) 
        {
            $time[0] = "July";
        }
        else if ($time[0] == 8) 
        {
            $time[0] = "August";
        }
        else if ($time[0] == 9) 
        {
            $time[0] = "September";
        }
        else if ($time[0] == 10) 
        {
            $time[0] = "October";
        }
        else if ($time[0] == 11) 
        {
            $time[0] = "November";
        }
        else 
        {
            $time[0] = "December";
        }
    }

    return $time;
} 
$time = times();

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    
    global $month;
    global $year;
    global $conn;

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    global $userID;
    if (!isset($_SESSION['userID'])) {
        header("location:login.php");
        die();
    } else {
        $userID = $_SESSION["userID"];
    }

    $query_U = "SELECT name from user
    WHERE userID = '$userID';";
    $result = mysqli_query($conn, $query_U);
    $res_U = mysqli_fetch_assoc($result);
    $username = $res_U['name'];
  
    $query_E = "SELECT email from user
    WHERE userID = '$userID';";
    $result = mysqli_query($conn, $query_E);
    $res_E = mysqli_fetch_assoc($result);
    $email = $res_E['email'];

    
    $month = $_POST['month'];
    $year = $_POST['year'];


    $query = "SELECT 
        T.tDate , 
        A1.accName AS tAccCode, 
        A2.accName AS dAccCode, 
        T.tType, 
        D.amount, 
        D.description
        FROM 
            transactions T
        INNER JOIN 
            details D ON T.tNo = D.dTNo
        INNER JOIN 
            accountsname A1 ON T.tAccCode = A1.accCode
        INNER JOIN 
            accountsname A2 ON D.dAccCode = A2.accCode
        WHERE 
            YEAR(T.Tdate) = '$year'
            AND MONTH(T.Tdate) = '$month'
            AND T.tuID = '$userID'
        ORDER BY 
            T.tDate;";
    $result = $conn->query($query);

    $t_sum = 0;
        while ($row = $result->fetch_assoc())
            {
                if ($row['amount'] < 0) {
                    $row['amount'] *= -1;
                } 
                $t_sum += $row['amount'];
            }
   
    
    if ($result->num_rows > 0) 
    {
        
        mysqli_data_seek($result, 0);
        
        $pdf = new FPDF(); 
        $pdf->AliasNbPages(); 
        $pdf->AddPage();
        

        $pdf->SetFont('Arial', 'B', 23);

        $pdf->SetXY(14, 17);
        $pdf->SetTextColor(81, 101, 138);
        $pdf->Cell(0, 12, $username, 0, 1);
        $pdf->SetFont('Arial', '', 15);
        $pdf->SetXY(14, 30);
        $pdf->Cell(0, 10, $email, 0, 1);
        $pdf->SetXY(14, 40);
        $currentDate = date('d-m-Y');
        $pdf->Cell(0, 8, 'Date: ' . $currentDate, 0, 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetLineWidth(0.5); 
        $pdf->SetDrawColor(81, 101, 138); 
        $pdf->Line(15, 50, 195, 50);


        $pageWidth = $pdf->GetPageWidth();
        $tableWidth = 180; 
        $tableX = ($pageWidth - $tableWidth) / 2;
        $pdf->SetX($tableX);
        $currentY = $pdf->GetY();
        $tableY = $currentY + 8; 
        $pdf->SetY($tableY);
        $pdf->SetX($tableX);

        $pdf->SetFont('Arial', 'B', 18);
        $pdf->SetFillColor(81, 101, 138);
        $pdf->SetDrawColor(81, 101, 138, 255);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(135, 14, 'General Journal', 1 ,0, 'L',true);
        $pdf->Cell(45, 14, $time[0].' '.$time[1], 1 ,1, 'R',true);

        $pdf->SetX($tableX);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(102, 127, 174);
        $pdf->SetDrawColor(102, 127, 174, 255);
        $pdf->Cell(27, 10, 'Date', 1 ,0, 'C',true);
        $pdf->Cell(83, 10, 'Particulars', 1 , 0,'C',true);
        $pdf->Cell(20, 10, 'Ref', 1 , 0,'C',true);
        $pdf->Cell(25, 10, 'Debit', 1 , 0,'C',true);
        $pdf->Cell(25, 10, 'Credit', 1,1,'C',true);

        
        $pdf->SetFont('Arial','',12);
        $pdf->SetTextColor(0, 0, 0); 

        $y=80;
        while ($row = $result->fetch_assoc()) {
            if ($row['tType'] == 'D') {

                $pdf->SetFillColor(238, 243, 246); 
                $pdf->SetDrawColor(255, 255, 255, 255);
                $pdf->SetX($tableX);
            
                $pdf->Cell(27, 10,'',1,0,'L', true);
                $pdf->Cell(83, 10, $row['tAccCode']. ' a/c (Dr.)', 1,0,'L', true);
                $pdf->Cell(20, 10,'',1,0,'L', true);
                $pdf->Cell(25, 10, ($row['amount'] < 0 ? ($row['amount'] * -1) : $row['amount']), 1,0,'C', true);
                $pdf->Cell(25, 10,'',1,1,'L', true);
                
                $pdf->SetX($tableX);
                $pdf->Cell(27, 10,$row['tDate'],1,0,'C', true);
                $pdf->Cell(83, 10, '(' . $row['description'] . ')', 1,0,'L', true);
                $pdf->Cell(20, 10,'',1,0,'L', true);
                $pdf->Cell(25, 10,'',1,0,'L', true);
                $pdf->Cell(25, 10,'',1,1,'L', true);
    
                $pdf->SetX($tableX);
                $pdf->Cell(27, 10,'',1,0,'L', true);
                $pdf->Cell(83, 10, $row['dAccCode']. ' a/c (Cr.)', 1,0,'L', true);
                $pdf->Cell(20, 10,'',1,0,'L', true);
                $pdf->Cell(25, 10,'',1,0,'L', true);
                $pdf->Cell(25, 10, ($row['amount'] < 0 ? ($row['amount'] * -1) : $row['amount']), 1,1,'C', true);
                
                $pdf->SetX($tableX);
                $pdf->SetFillColor(81, 101, 138); 
                $pdf->SetDrawColor(81, 101, 138, 255);
                $pdf->Cell(180,0.5,'',1,1,'L', true); 
                
            } else {
                $pdf->SetFillColor(238, 243, 246); 
                $pdf->SetDrawColor(255, 255, 255, 255);
                $pdf->SetX($tableX);

                $pdf->Cell(27, 10,'',1,0,'L', true);
                $pdf->Cell(83, 10, $row['dAccCode']. ' a/c (Dr.)', 1,0,'L', true);
                $pdf->Cell(20, 10,'',1,0,'L', true);
                $pdf->Cell(25, 10, ($row['amount'] < 0 ? ($row['amount'] * -1) : $row['amount']), 1,0,'C', true);
                $pdf->Cell(25, 10,'',1,1,'L', true);
    
                $pdf->SetX($tableX);
                $pdf->Cell(27, 10,$row['tDate'],1,0,'C', true);
                $pdf->Cell(83, 10, '(' . $row['description'] . ')', 1,0,'L', true);
                $pdf->Cell(20, 10,'',1,0,'L', true);
                $pdf->Cell(25, 10,'',1,0,'L', true);
                $pdf->Cell(25, 10,'',1,1,'L', true);
    
                $pdf->SetX($tableX);
                $pdf->Cell(27, 10,'',1,0,'L', true);
                $pdf->Cell(83, 10, $row['tAccCode']. ' a/c (Cr.)', 1,0,'L', true);
                $pdf->Cell(20, 10,'',1,0,'L', true);
                $pdf->Cell(25, 10,'',1,0,'L', true);
                $pdf->Cell(25, 10, ($row['amount'] < 0 ? ($row['amount'] * -1) : $row['amount']), 1,1,'C', true);

                $pdf->SetX($tableX);
                $pdf->SetFillColor(81, 101, 138); 
                $pdf->SetDrawColor(81, 101, 138, 255);
                $pdf->Cell(180,0.5,'',1,1,'L', true); 
            } 
        }


        $pdf->SetX($tableX);
        $pdf->SetLineWidth(0.2); 
        $pdf->SetFillColor(102, 127, 174);
        $pdf->SetDrawColor(102, 127, 174, 255);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(27, 10, '', 1,0,'C',True);
        $pdf->Cell(83, 10, 'Total:',1,0,'C',True);
        $pdf->Cell(20, 10, '', 1,0,'C',True);
        $pdf->Cell(25, 10, $t_sum, 1,0,'C',True);
        $pdf->Cell(25, 10, $t_sum, 1,0,'C',True);

        $current_Y = $pdf->GetY();           
        $cellX = $tableX; 
        $cellY = $current_Y + 15; 
        $cellWidth = $tableWidth; 
        $cellHeight = 30; 

        $pdf->SetFillColor(238, 243, 246); 
        $pdf->SetDrawColor(145, 156, 161, 255); 

        $pdf->Rect($cellX, $cellY, $cellWidth, $cellHeight, 'F');

        $iconX = $cellX + 5; 
        $iconY = $cellY + 5;
        $iconWidth = 15; 
        $iconHeight = 15; 
        $pdf->Image('icon.png', $iconX, $iconY, $iconWidth, $iconHeight);

        $pdf->SetFont('Arial', 'B', 25);
        
        $nameX = $iconX + $iconWidth + 2; 
        $nameY = $iconY + 4; 
        $pdf->SetXY($nameX, $nameY);

        $pdf->SetTextColor(81, 101, 138);
        $pdf->Cell(0, $iconHeight, 'AMS', 0, 0, 'L', false);


        $pdf->SetFont('Arial', 'I', 12);
        $pdf->SetTextColor(73, 90, 121);
        $additionalTextX = $nameX + 22; 
        $additionalTextY = $nameY + 3; 
        $pdf->SetXY($additionalTextX, $additionalTextY);
        
        $pdf->Cell(0, 10, 'Make your bookkepping easier.', 0, 1, 'L', false);

        $pdf->Output('filename.pdf', 'I');
    } 
    else 
    {
        echo '<p style="color: red; padding:25px"><b>No data available for the selected month and year. </b></p>';
    }
    $conn->close();
}
?>


<?php
include("security.php");
include("header.php");
include("footer.php");
?>
<section class="home">
    <div class="container">
        <header class="running-underline">General Journal</header>
    </div>
<div class="form">
    <form method="post" action="">
            <div class="form first">
                <div class="fields">
                    <div class="input-field">
                        <label for="month">Month :</label>
                        <select id="month" name="month">
                            <option value="" disabled selected>Select a month</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    <div id="year">
                        <label for="year">Year :<br></label>
                        <input type="number" name="year" placeholder="Enter the year" min="1900" max="3000" required>
                    </div>
                    </div>
                    <button type="submit">Generate PDF</button>
                </div>
            </div>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            if ($result->num_rows > 0) {
                // Data is available
            } else {
                echo '<p style="color: red; padding:25px"><b>No data available for the selected month and year. </b></p>';
            }
        }
        ?>
    </div>
</section>

