<?php
include("security.php");
include("header.php");
include("footer.php");
?>

<section class="home">
  <div class="container">
    <header class = "running-underline">Owner's Drawings</header>
  </div>
  <div class="form">
    <form action="OwnDrawCon.php" method = "post">
      <div class="form first">
        <div class="fields">
          <div class="input-field">
            <label>Date : </label>
            <input type="date" name = "date" placeholder="Enter the date" required>
          </div>

          <div class="input-field">
            <label for="drawings">Amount:</label>
            <input type="number" name="amount" step="0.01" min="1" placeholder="Enter amount" required>
          </div>

          <div class="input-field">
            <label for="desc">Description:</label>
            <input type="text" name="desc" placeholder="Enter a short description" required>
          </div>
  
          <button type="submit">Submit</button>
        </div>
      </div>
    </form>
  </div>
</section>
