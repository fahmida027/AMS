<?php
require_once 'profilecon.php';

$cash = total_cash();
$rec = total_receivable();
$due = total_due();
$res = Data_display();

include("security.php");
include("header.php");
include("footer.php");
?>

<section class="home">
    <div class="container">
        <header class="running-underline">My Wallet</header>
    </div>
  
    <?php while($row = mysqli_fetch_assoc($res)){
      $name = $row['name'];
      $email = $row['email'];
    ?>
    <div class="profile-card">
    <div class="data">
      <h1><?php echo $name; ?></h1>
      <span style="font-size: 18px;"><?php echo $email; ?></span>
    </div>
    <?php
    }
    ?>
    <div class="row">
      <div class="info">
        <h4>Total Cash</h4>
        <span style="font-size: 18px;"><?php echo $cash; ?></span>
      </div>
      <div class="info">
        <h4>Reveivable Amount</h4>
        <span style="font-size: 18px;"><?php echo $rec; ?></span>
      </div>
      <div class="info">
        <h4>Due Amount</h4>
        <span style="font-size: 18px;"><?php echo $due; ?></span>
      </div>
    </div>
    <div class="buttons">
      <a href="entries.php" class="btn">View Details</a>
    </div>
  </div>
</section>
