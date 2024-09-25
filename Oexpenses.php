<?php
include("security.php");
include("header.php");
include("footer.php");
?>
<section class="home">
  <div class="container">
    <header class = "running-underline">Expenses</header>
  </div>
  <div class="form">
    <form action="expenscon.php" method = "post">
      <div class="form first">
        <div class="fields">
         <div class="input-field">
          <label for="sector"><br>Sector :<br></label>
            <select id="sector" name = "sector">
              <option  value="" disabled selected>Select an option</option>
              <option  value="EQ">Equipments</option>
              <option  value="SP">Supplies</option>
              <option  value="OT">Others</option>
              </select>  
         </div>
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
