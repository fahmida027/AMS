/*Navigation Bar*/

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

/*Logout popup*/

function showLogoutPopup() {
  // Show the pop-up dialog
  var popup = document.getElementById("popup");
  popup.style.visibility = "visible";
  popup.style.opacity = "1";
      
  // Blur the background content
  var content = document.querySelector(".home");
  content.style.filter = "blur(5px)";
}
function closePopup() {
  // Hide the pop-up dialog
  var popup = document.getElementById("popup");
  popup.style.visibility = "hidden";
  popup.style.opacity = "0";
  
  // Remove the blur effect from the background content
  var content = document.querySelector(".home");
  content.style.filter = "none";
}

/*Account Receivable*/

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

  if (paymentStatus === "CP" || paymentStatus === "FR" || paymentStatus === "PB" || paymentStatus === "AR") {
    amountField.style.display = "block";
  } 
  else {
    amountField.style.display = "none";
  }

  if (paymentStatus === "AR") {
    otherFields.style.display = "block";
  } 
  else {
    otherFields.style.display = "none";
  }
}


/*On Account*/

document.addEventListener("DOMContentLoaded", function() {
  // Toggle fields based on payment status
  ToggleFields();

  // Add event listeners for input fields
  document.getElementById("amount").addEventListener("input", restrictToNumbers);
  document.getElementById("paidAmount").addEventListener("input", restrictToNumbers);

  // Add event listener for "Amount" field blur
  document.getElementById("amount").addEventListener("blur", checkPaymentStatus);
});

function ToggleFields() {
  var paymentStatus = document.getElementById("paymentStatus").value;
  var amountField = document.getElementById("amountField");
  var otherFields = document.getElementById("otherFields");

  if (paymentStatus === "OA" || paymentStatus === "PL") {
    amountField.style.display = "block";
  } 
  else {
    amountField.style.display = "none";
  }

  if (paymentStatus === "OA") {
    otherFields.style.display = "block";
  } 
  else {
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



/*Entries*/

document.getElementById("search").addEventListener("click", function() {
  search();
});

document.getElementById("searchInput").addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
    search();
  }
});

function search() {
  var searchTerm = document.getElementById("searchInput").value;
  // Perform search operation with searchTerm
  console.log("Searching for:", searchTerm);
  // You can add your search logic here
}

$(document).ready(function() {
  $("#type").on('keyup', function() {
      var value = $(this).val();
      $.ajax({
          url: "entrycon.php",
          type: "POST",
          data: { search: value },
          success: function(data) {
              $("#table-row").html(data);
          }
      });
  });
});






