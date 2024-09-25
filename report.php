<?php
include("security.php");
include("header.php");
include("footer.php");
?>

<section class="home">
  <div class="container">
    <header class="running-underline">Financial Reports</header>
  </div>

  <section class="hellos">
    <div class="op">
      <div class="boxes">
        <div class="icons">01</div>
          <div class="contents">
            <h3>General Journal</h3>
            <p>A general journal is a journal recording all of the transactions of a business.</p>
            <a class="go" href="journal.php" >Generate Journal</a>
          </div>
      </div>

      <div class="boxes">
        <div class="icons">02</div>
          <div class="contents">
          <h3>Income Statement</h3>
          <p>Estimate your financial statements</p>
          <a class="go" href="instatement.php" >Generate Income Statement</a>
          </div>
      </div>

      <div class="boxes">
        <div class="icons">03</div>
          <div class="contents">
          <h3>Ledger Sheet</h3>
          <p>Record of your business's financial transactions</p>
          <a class="go" href="ledger.php" >Generate Ledger</a>
          </div>
      </div>

      <div class="boxes">
        <div class="icons">04</div>
          <div class="contents">
          <h3>Balance sheet</h3>
          <p>A sheet containing details of your assets or liabilities </p>
          <a class="go" href="balance.php" >Generate Balance Sheet </a>
          </div>
      </div>
    </div>
  </section> 
</section>
