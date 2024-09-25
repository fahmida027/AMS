<?php
include("security.php");
include("header.php");
include("footer.php");
?>

<section class="home">
  <div class="container">
    <header class="running-underline">Investment</header>
  </div>
  <div class="form">
    <form action="capCon.php" method="post">
      <div class="form first">
        <div class="fields">
          <div class="input-field">
            <label>Date : </label>
            <input type="date" name="date" placeholder="Enter the date" required>
          </div>
          <div class="input-field">
            <div id="amount">
                <label for="amount">Amount :<br></label>
                <input type="number" id="amount" name="amount" value="Enter the amount" min="1" required>
            </div>
            <div id="desc">
                <label for="desc">Description :<br></label>
                <input type="text" id="desc" name="desc" placeholder="Enter a short description" required>
            </div>

          </div>
        </div>
          
        <button type="submit">Submit</button>
      </div>
    </form>
  </div>

</section>
