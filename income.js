const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle"),
      searchBtn = body.querySelector(".search-box"),
      modeSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text");
    toggle.addEventListener("click", () => {
      sidebar.classList.toggle("close");
    })
    searchBtn.addEventListener("click", () => {
      sidebar.classList.remove("close");
    })
    modeSwitch.addEventListener("click", () => {
      body.classList.toggle("dark");
      if (body.classList.contains("dark")) {
        modeText.innerText = "Light mode";
      } else {
        modeText.innerText = "Dark mode";
      }
    });
    document.addEventListener("DOMContentLoaded", function() {
      // Toggle fields based on payment status
      toggleFields();
    
      // Add event listeners for input fields
      document.getElementById("amount").addEventListener("input", restrictToNumbers);
      document.getElementById("paidAmount").addEventListener("input", restrictToNumbers);
    
      // Add event listener for "Amount" field blur
      document.getElementById("amount").addEventListener("blur", checkPaymentStatus);
    });
    
    function toggleFields() {
      var paymentStatus = document.getElementById("paymentStatus").value;
      var amountField = document.getElementById("amountField");
      var otherFields = document.getElementById("otherFields");
    
      if (paymentStatus === "FP" || paymentStatus === "PL" || paymentStatus === "OA") {
        amountField.style.display = "block";
      } else {
        amountField.style.display = "none";
      }
    
      if (paymentStatus === "OA") {
        otherFields.style.display = "block";
      } else {
        otherFields.style.display = "none";
      }
    }
    
    function restrictToNumbers(event) {
      var input = event.target.value;
      event.target.value = input.replace(/[^0-9.]/g, ''); 
    }
    
    function checkPaymentStatus() {
      var paymentStatus = document.getElementById("paymentStatus").value;
      var amountField = document.getElementById("amountField");
      var amountError = document.getElementById("amountError");
    
      if (paymentStatus === "") {
        amountError.style.display = "inline";
        amountField.classList.add("error");
      } else {
        amountError.style.display = "none";
        amountField.classList.remove("error");
      }
    }
    function autofillWithZero(paidAmount) {
      if (paidAmount.value === '') {
          paidAmount.value = '0';
      }
  }

$('input[type=number]').on('mousewheel', function(e) {
  $(e.target).blur();
});

   
    