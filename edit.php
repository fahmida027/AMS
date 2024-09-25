<?php
include("header.php");
include("footer.php");
include("config.php");
require_once("entrycon.php");
$user = userID();
?>

<section class="home">
  <div class="container">
    <header class="running-underline">Edit Information</header>
  </div>
  <div class="form">
    <?php 
      if(isset($_GET["editid"]))  
      {
        $id = $_GET["editid"];
      } 
      else
      { 
        echo'<div class="error"> '.$error_message.' </div>'; 
      } 
    ?>
    <form action="entrycon.php" method="post">
      <div class="form first">
        <div class="fields">
          <div class="input-field">
            <label for="date">Date : </label>
            <input type="date" id="dates" name="dates" placeholder="Enter the date" required>
          </div>
          <div class="input-field">
            <label for="amount">Amount :</label>
            <input type="number" id="amounts" name="amounts" placeholder="Enter the amount" min="1" required>
          </div>
          <div class="input-field">
            <label for="desc">Description :</label>
            <input type="text" id="descr" name="descr" placeholder="Enter a short description" required>
          </div>
        </div>
        <input type="hidden" name="id" value='<?php echo $id ?>'>
        <button type="submit" name="save">Save</button>
      </div>
    </form>
  </div>
</section>
