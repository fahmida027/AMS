<?php
include("security.php");
include("header.php");
include("footer.php");
?>
<section class="home">
  <div class="container">
    <header class = "running-underline">On Account</header>
  </div>
  <div class="form">
  <form action="oacon.php" method = "post">
  <div class="form first">
    <div class="fields">
      <div class="input-field">
        <label>Date : </label>
        <input type="date" name = "date" placeholder="Enter the date" required>
      </div>

      <div class="input-field">
        <label for="paymentStatus">Payment Status :<br></label>
        <select id="paymentStatus" name = "paymentStatus" onchange="ToggleFields()">
          <option  value="" disabled selected>Select an option</option>
          <option  value="OA">On Account</option>
          <option  value="PL">Paid to previous lenders</option>
        </select>

        <div id="amountField">
          <label for="sector"><br>Sector :<br></label>
            <select id="sector" name = "sector">
              <option  value="" disabled selected>Select an option</option>
              <option  value="EQ">Equipments</option>
              <option  value="SP">Supplies</option>
              <option  value="LN">Loan</option>
              </select>                        

          <label for="type"><br>Type :<br></label>
            <select id="type" name = "type" required>
              <option  value="" disabled selected>Select an option</option>
              <option value="AP">Account Payable</option>
              <option value="NP">Notes Payable</option>
            </select>

          <label for="amount">Amount :<br></label>
            <input type="number" id="amount" name="amount" value="Enter the amount" min="1" required>
        </div>
                      
        <div id="otherFields" style="display:none;">
          <label for="paidAmount">Paid Amount :<br></label>
          <input type="number" id="paidAmount" name="paidAmount" onblur="autofillWithZero(this)" value="0" min="0">
        </div>

        <div id="description">
          <label for="des">Description : <br></label>
          <input type="text" id="desc" name="desc" placeholder="Enter a short description" required>
        </div>
      </div>
    </div>
      <button type="submit">Submit</button>
  </div>
  </form>
  </div>
</section>
