<?php
session_start();
require('fpdfGenerator/fpdf.php');
require_once("config.php");

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
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

    //Queries
     $cash_query = "SELECT SUM(amount) AS total_amount
                    FROM (
                        SELECT SUM(d.amount) AS amount
                        FROM details d
                        JOIN transactions t ON t.tNo = d.dTNo
                        JOIN accountsname act ON act.accCode = t.tAccCode
                        JOIN accountsname acd ON acd.accCode = d.dAccCode
                        WHERE (MONTH(t.tDate) = '$month' AND YEAR(t.tDate) = '$year') 
                        AND (act.accName = 'Cash' OR acd.accName='Cash')
                        
                        UNION ALL
                        
                        SELECT SUM(d.amount*-2) AS amount
                        FROM details d
                        JOIN transactions t ON t.tNo = d.dTNo
                        WHERE (MONTH(t.tDate) = '$month' AND YEAR(t.tDate) = '$year') 
                        AND (t.tAccCode = 'A004' AND t.tType ='C')
                        AND t.tuID = '$userID'
                    ) AS combined_results;";
    $result_cash = $conn->query($cash_query);

    $Equipments_query = "SELECT SUM(d.amount) AS total_amount
            From details d
            join transactions t on t.tNo = d.dTNo
            join accountsname act on act.accCode = t.tAccCode
            join accountsname acd on acd.accCode = d.dAccCode
            WHERE (MONTH(t.tDate) = '$month' 
            AND YEAR(t.tDate) = '$year') 
            AND (act.accName = 'Equipments' 
            or acd.accName='Equipments')
            AND t.tuID = '$userID';";
    $result_Equ = $conn->query($Equipments_query);

    $Supplies_query = "SELECT SUM(d.amount) AS total_amount
            From details d
            join transactions t on t.tNo = d.dTNo
            join accountsname act on act.accCode = t.tAccCode
            join accountsname acd on acd.accCode = d.dAccCode
            WHERE (MONTH(t.tDate) = '$month' 
            AND YEAR(t.tDate) = '$year') 
            AND (act.accName = 'Supplies' 
            or acd.accName='Supplies')
            AND t.tuID = '$userID';";
    $result_Sup = $conn->query($Supplies_query);
    

    $AR_query = "SELECT SUM(d.amount) AS total_amount
            From details d
            join transactions t on t.tNo = d.dTNo
            join accountsname act on act.accCode = t.tAccCode
            join accountsname acd on acd.accCode = d.dAccCode
            WHERE (MONTH(t.tDate) = '$month' 
            AND YEAR(t.tDate) = '$year') 
            AND (act.accName = 'Account Receivable' 
            or acd.accName='Account Receivable')
            AND t.tuID = '$userID';";
    $result_AR = $conn->query($AR_query);


    $AP_query = "SELECT SUM(d.amount) AS total_amount
            From details d
            join transactions t on t.tNo = d.dTNo
            join accountsname act on act.accCode = t.tAccCode
            join accountsname acd on acd.accCode = d.dAccCode
            WHERE (MONTH(t.tDate) = '$month' 
            AND YEAR(t.tDate) = '$year') 
            AND (act.accName = 'Accounts Payable' 
            or acd.accName='Accounts Payable')
            AND t.tuID = '$userID';";
    $result_AP = $conn->query($AP_query);

   
    $NP_query = "SELECT SUM(d.amount) AS total_amount
            From details d
            join transactions t on t.tNo = d.dTNo
            join accountsname act on act.accCode = t.tAccCode
            join accountsname acd on acd.accCode = d.dAccCode
            WHERE (MONTH(t.tDate) = '$month' 
            AND YEAR(t.tDate) = '$year') 
            AND (act.accName = 'Notes Payable' 
            or acd.accName='Notes Payable')
            AND t.tuID = '$userID';";
    $result_NP = $conn->query($NP_query);
    
    $Capital_query = "SELECT SUM(d.amount) AS total_amount
            From details d
            join transactions t on t.tNo = d.dTNo
            join accountsname act on act.accCode = t.tAccCode
            join accountsname acd on acd.accCode = d.dAccCode
            WHERE (MONTH(t.tDate) = '$month' 
            AND YEAR(t.tDate) = '$year') 
            AND (act.accName = 'Capital' 
            or acd.accName='Capital')
            AND t.tuID = '$userID';";
    $result_Capital = $conn->query($Capital_query);
    

    $Income_query = "SELECT SUM(d.amount) AS total_amount
            From details d
            join transactions t on t.tNo = d.dTNo
            join accountsname act on act.accCode = t.tAccCode
            join accountsname acd on acd.accCode = d.dAccCode
            WHERE (MONTH(t.tDate) = '$month' 
            AND YEAR(t.tDate) = '$year') 
            AND (act.accName = 'Income' 
            or acd.accName='Income')
            AND t.tuID = '$userID';";
    $result_Income = $conn->query($Income_query);

    $Expenses_query = "SELECT SUM(d.amount) AS total_amount
            From details d
            join transactions t on t.tNo = d.dTNo
            join accountsname act on act.accCode = t.tAccCode
            join accountsname acd on acd.accCode = d.dAccCode
            WHERE (MONTH(t.tDate) = '$month' 
            AND YEAR(t.tDate) = '$year') 
            AND (act.accName = 'Expenses' 
            or acd.accName='Expenses')
            AND t.tuID = '$userID';";
    $result_Expenses = $conn->query($Expenses_query);


    $Drawings_query = "SELECT SUM(d.amount) AS total_amount
            From details d
            join transactions t on t.tNo = d.dTNo
            join accountsname act on act.accCode = t.tAccCode
            join accountsname acd on acd.accCode = d.dAccCode
            WHERE (MONTH(t.tDate) = '$month' 
            AND YEAR(t.tDate) = '$year') 
            AND (act.accName = 'Drawings' 
            or acd.accName='Drawings')
            AND t.tuID = '$userID';";
    $result_Drawings = $conn->query($Drawings_query);

    $Liabilities_query = "SELECT SUM(d.amount) AS total_amount
            from details d 
            JOIN transactions t on t.tNo = d.dTNo
            join accountsname acnameT on acnameT.accCode = t.tAccCode
            join accounttype actyT on acnameT.acatID = actyT.catID
            join accountsname acnameD on acnameD.accCode = d.dAccCode
            join accounttype actyD on acnameD.acatID = actyD.catID 
            WHERE (actyT.catName = 'Liabilities' 
            OR actyD.catName = 'Liabilities')
            AND (MONTH(T.Tdate) = '$month' AND YEAR(T.Tdate) = '$year')
            AND t.tuID = '$userID';";
    $result_Liabilities = $conn->query($Liabilities_query);

    $OE_query = "SELECT SUM(d.amount) AS total_amount
            from details d
            JOIN transactions t on t.tNo = d.dTNo
            join accountsname acnameT on acnameT.accCode = t.tAccCode
            join accounttype actyT on acnameT.acatID = actyT.catID
            join accountsname acnameD on acnameD.accCode = d.dAccCode
            join accounttype actyD on acnameD.acatID = actyD.catID 
            WHERE (actyT.catName = 'Owner Equity' OR actyD.catName = 'Owner Equity')
            AND (MONTH(T.Tdate) = '$month' AND YEAR(T.Tdate) = '$year')
            AND t.tuID = '$userID';";
    $result_OE = $conn->query($OE_query);
   

    $Assets_query = "SELECT SUM(amount) AS total_amount
            FROM (
            SELECT SUM(d.amount) as amount from details d
            JOIN transactions t on t.tNo = d.dTNo
            join accountsname acnameT on acnameT.accCode = t.tAccCode
            join accounttype actyT on acnameT.acatID = actyT.catID
            join accountsname acnameD on acnameD.accCode = d.dAccCode
            join accounttype actyD on acnameD.acatID = actyD.catID 
            WHERE (actyT.catName = 'Assets' OR actyD.catName = 'Assets')
            AND (MONTH(T.Tdate) = '$month' AND YEAR(T.Tdate) = '$year')
        
            UNION ALL
            
            SELECT SUM(d.amount*-1) AS amount
            FROM details d
            JOIN transactions t ON t.tNo = d.dTNo
            WHERE (MONTH(t.tDate) = '$month' AND YEAR(t.tDate) = '$year') 
            AND (t.tAccCode = 'A004' AND t.tType ='C')
            AND t.tuID = '$userID'
            ) AS combined_results;";
    $result_Assets = $conn->query($Assets_query);


    if ($result_cash->num_rows > 0   || $result_Equ->num_rows > 0 || $result_Sup->num_rows > 0
        ||$result_AR->num_rows > 0 || $result_AP->num_rows > 0 || $result_NP->num_rows > 0
        ||$result_Capital->num_rows > 0 || $result_Income->num_rows > 0 || $result_Expenses->num_rows > 0
        ||$result_Drawings->num_rows > 0 || $result_Liabilities->num_rows > 0 || $result_OE->num_rows > 0
        ||$result_Assets->num_rows > 0) 
    {
        $cash = mysqli_fetch_assoc($result_cash);
        $Equipments = mysqli_fetch_assoc($result_Equ);
        $Supplies = mysqli_fetch_assoc($result_Sup);
        $AR = mysqli_fetch_assoc($result_AR);
        $AP = mysqli_fetch_assoc($result_AP);
        $NP = mysqli_fetch_assoc($result_NP);
        $Capital = mysqli_fetch_assoc($result_Capital);
        $Income = mysqli_fetch_assoc($result_Income);
        $Expenses = mysqli_fetch_assoc($result_Expenses);
        $Drawings = mysqli_fetch_assoc($result_Drawings);
        $Liabilities = mysqli_fetch_assoc($result_Liabilities);
        $t_lia = $Liabilities['total_amount'];
        $OE = mysqli_fetch_assoc($result_OE);
        $t_OE = $OE['total_amount'];
        $Assets = mysqli_fetch_assoc($result_Assets);
        
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
        $pdf->Cell(135, 10, 'Balance Sheet', 1 ,0, 'L',true);
        $pdf->Cell(45, 10, $time[0].' '.$time[1], 1 ,1, 'R',true);

        $pdf->SetX($tableX);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetFillColor(102, 127, 174);
        $pdf->SetDrawColor(102, 127, 174, 255);
        $pdf->Cell(120, 10, '', 1 ,0, 'C',true);
        $pdf->Cell(60, 10, '   Amount', 1 , 1,'C',true);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX($tableX);
        $pdf->SetLineWidth(0.8);
        $pdf->SetFont('Arial', 'BU', 15);
        $pdf->Cell(180,14,'Assets',0,1);
        $pdf->SetFont('Arial', '', 12);


        $pdf->SetFillColor(238, 243, 246); 
        $pdf->SetDrawColor(255, 255, 255, 255); 

        $pdf->SetX($tableX);
        $pdf->Cell(120,10,'Cash',1,0,'L', true);
        if($cash['total_amount']<0) {
            $pdf->Cell(60,10,'('. -1*$cash['total_amount'].')',1,1,'C', true);
        }
        else {
            $pdf->Cell(60,10,$cash['total_amount'],1,1,'C', true);
        } 
        $pdf->SetX($tableX);
        $pdf->Cell(120,10,'Accounts receivale',1,0,'L', true); 
        if($AR['total_amount']<0) {
            $pdf->Cell(60,10,'('. -1*$AR['total_amount'].')',1,1,'C', true);
        }
        else {
            $pdf->Cell(60,10,$AR['total_amount'],1,1,'C', true);
        }
        $pdf->SetX($tableX);
        $pdf->Cell(120,10,'Supplies',1,0,'L', true);
        if($Supplies['total_amount']<0) {
            $pdf->Cell(60,10,'('. -1*$Supplies['total_amount'].')',1,1,'C', true);
        }
        else {
            $pdf->Cell(60,10,$Supplies['total_amount'],1,1,'C', true);
        } 
        $pdf->SetX($tableX);
        $pdf->Cell(120,10,'Equipments',1,0,'L', true); 
        if($Equipments['total_amount']<0) {
            $pdf->Cell(60,10,'('. -1*$Equipments['total_amount'].')',1,1,'C', true);
        }
        else {
            $pdf->Cell(60,10,$Equipments['total_amount'],1,1,'C', true);
        }
         
        $pdf->SetX($tableX);
        $pdf->SetFillColor(255, 255, 255); 
        $pdf->SetDrawColor(255, 255, 255, 255);
        $pdf->Cell(180,2,'',1,1,'L', true); 
       

        $pdf->SetX($tableX);
        $pdf->SetLineWidth(0.2); 
        $pdf->SetFillColor(102, 127, 174);
        $pdf->SetDrawColor(102, 127, 174, 255);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(120, 10, 'Total Assets', 1, 0, 'C',true);
        if($Assets['total_amount']<0) {
            $pdf->Cell(60,10,'('. -1*$Assets['total_amount'].')',1,1,'C', true);
        }
        else {
            $pdf->Cell(60,10,$Assets['total_amount'],1,1,'C', true);
        }
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX($tableX);
        $pdf->SetLineWidth(0.8);
        $pdf->SetFont('Arial', 'BU', 15);
        $pdf->Cell(180,14,'Liabilities and Owner\'s Equity',0,1);
        $pdf->SetFont('Arial', '', 12);


        $pdf->SetFillColor(238, 243, 246); 
        $pdf->SetDrawColor(255, 255, 255, 255);

        $pdf->SetX($tableX);
        $pdf->Cell(120,10,'Accounts Payable',1,0,'L', true);
        if($AP['total_amount']<0) {
            $pdf->Cell(60,10,'('. -1*$AP['total_amount'].')',1,1,'C', true);
        }
        else {
            $pdf->Cell(60,10,$AP['total_amount'],1,1,'C', true);
        } 
        $pdf->SetX($tableX);
        $pdf->Cell(120,10,'Notes Payable',1,0,'L', true); 
        if($NP['total_amount']<0) {
            $pdf->Cell(60,10,'('. -1*$NP['total_amount'].')',1,1,'C', true);
        }
        else {
            $pdf->Cell(60,10,$NP['total_amount'],1,1,'C', true);
        }
        $pdf->SetX($tableX);
        $pdf->Cell(120,10,'Capital',1,0,'L', true); 
        if($Capital['total_amount']<0) {
            $pdf->Cell(60,10,'('. -1*$Capital['total_amount'].')',1,1,'C', true);
        }
        else {
            $pdf->Cell(60,10,$Capital['total_amount'],1,1,'C', true);
        }
        $pdf->SetX($tableX);
        $pdf->Cell(120,10,'Income',1,0,'L', true); 
        if($Income['total_amount']<0) {
            $pdf->Cell(60,10,'('. -1*$Income['total_amount'].')',1,1,'C', true);
        }
        else {
            $pdf->Cell(60,10,$Income['total_amount'],1,1,'C', true);
        }
        $pdf->SetX($tableX);
        $pdf->Cell(120,10,'Expenses',1,0,'L', true); 
        if($Expenses['total_amount']<0) {
            $pdf->Cell(60,10,'('. -1*$Expenses['total_amount'].')',1,1,'C', true);
        }
        else {
            $pdf->Cell(60,10,$Expenses['total_amount'],1,1,'C', true);
        }
        $pdf->SetX($tableX);
        $pdf->Cell(120,10,'Owner\'s Drawings',1,0,'L', true);
        if($Drawings['total_amount']<0) {
            $pdf->Cell(60,10,'('. -1*$Drawings['total_amount'].')',1,1,'C', true);
        }
        else {
            $pdf->Cell(60,10,$Drawings['total_amount'],1,1,'C', true);
        }

        $pdf->SetX($tableX);
        $pdf->SetFillColor(255, 255, 255); 
        $pdf->SetDrawColor(255, 255, 255, 255);
        $pdf->Cell(180,2,'',1,1,'L', true); 
       

        $pdf->SetX($tableX);
        $pdf->SetLineWidth(0.2); 
        $pdf->SetFillColor(102, 127, 174);
        $pdf->SetDrawColor(102, 127, 174, 255);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(120, 10, 'Total Liabilities and OE', 1, 0, 'C',true);
        if(($t_lia+$t_OE)<0) {
            $pdf->Cell(60,10,'('. -1*($t_lia+$t_OE).')',1,1,'C', true);
        }
        else {
            $pdf->Cell(60,10,($t_lia+$t_OE),1,1,'C', true);
        }

        $current_Y = $pdf->GetY();           
        $cellX = $tableX; 
        $cellY = $current_Y + 5; 
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
    } else {
        echo "No results found";
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
        <header class="running-underline">Balance Sheet</header>
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
                    <button type="submit">Genrate PDF</button>
                </div>
            </div>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            if (($Assets != NULL && $Liabilities != NULL && $OE != NULL && 
            $cash != NULL && $Equipments!= NULL && $Supplies != NULL &&  
            $AR != NULL && $AP != NULL && $NP != NULL &&  $Capital != NULL 
            && $Income != NULL && $Expenses != NULL && $Drawings != NULL && ($t_OE != 0 && $t_lia != 0)))
            {         
            }
            else 
            {
                echo '<p style="color: red; padding:25px"><b>No data available for the selected month and year. </b></p>';
            }
        }
        ?>
    </div>
</section>

