
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="home.css">

  <!----===== Boxicons CSS ===== -->
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
</head>

<body onload="toggleFields()">


  <nav class="sidebar close">
    <header>
    
        <div class="text logo-text">
          <h1 style="color: #667fae;"><img src="icon.png" style="height: 50px;" ></i><span class="name">&nbsp;AMS</h1>
        </div>
      <i class='bx bx-chevron-right toggle'></i>
    </header>

    <div class="menu-bar">
      <div class="menu">

        <!--<li class="search-box">
          <i class='bx bx-search icon'></i>
          <input type="text" placeholder="Search ...">
        </li>-->

        <ul class="menu-links">
          <li class="nav-link">
            <a href="home.php">
              <i class='bx bx-home-alt icon'></i>
              <span class="text nav-text">Home</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="entries.php">
              <i class='bx bx-bar-chart-alt-2 icon'></i>
              <span class="text nav-text">Entries</span>
            </a>
          </li>

         <!-- <li class="nav-link">
            <a href="#">
              <i class='bx bx-bell icon'></i>
              <span class="text nav-text">Notifications</span>
            </a>
          </li> -->
          
          <li class="nav-link">
            <a class="g" href="report.php">
                <i  class='bx bxs-report icon'></i>
              <span class="text nav-text">Report</span>
            </a>
          </li>

          
          <li class="nav-link">
            <a   href="dashboard.php">
                 <i class='bx bxs-dashboard icon' ></i>
              <span class="text nav-text">Dashboard</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="profile.php">
              <i class='bx bx-user icon' ></i>
              <span class="text nav-text">Profile</span>
            </a>
          </li>

          
        </ul>
      </div>

      <div class="bottom-content">
        <li class="">
          <a href="#" onclick="showLogoutPopup()">
            <i class='bx bx-log-out icon'></i>
            <span class="text nav-text">Logout</span>
          </a>
        </li>

      </div>
    </div>
  </nav>
