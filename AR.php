<?php
include("security.php");
include("header.php");
include("footer.php");
?>


  <section class="home">
    <div class="container">
      <header class="running-underline">Receivable Amount</header>
    </div>
    <div class="form">
      <form action="arcon.php" method="post">
          <div class="form first">
            <div class="fields">
              <div class="input-field">
                  <label>Date : </label>
                  <input type="date" name="date" placeholder="Enter the date" required>
              </div>
  

              <div class="input-field">
                  <label for="paymentStatus">Payment Status :<br></label>
                  <select id="paymentStatus" name="paymentStatus" onchange="toggleFields()">
                      <option value="" disabled selected>Select payment status</option>
                      <option value="AR">Receivable Amount</option>
                      <option value="PB">Received from Previous Borrowers</option>
                  </select>

                  <div id="amountField">
                        <label for="amount">Amount :<br></label>
                        <input type="number" id="amount" name="amount" value="Enter the amount" min="1" required>
                        <span id="amountError" style="color:red; display:none;">*Choose a payment status first</span>
                  </div>
                      
                  <div id="otherFields" >
                        <label for="paidAmount">Received Amount :<br></label>
                        <input type="number" id="paidAmount" name="paidAmount" onblur="autofillWithZero(this)" step="0.01" value="0" min="0">
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

